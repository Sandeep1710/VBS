<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartService
{
    public const SESSION_COOKIE = 'vbs_cart_token';

    public function __construct(private readonly CouponService $coupons)
    {
    }

    public function current(): Cart
    {
        if ($cart = $this->find()) {
            return $cart;
        }

        return $this->create();
    }

    public function find(): ?Cart
    {
        if (auth()->check()) {
            return Cart::where('user_id', auth()->id())->latest()->first();
        }

        $token = request()->cookie(self::SESSION_COOKIE);
        if (! $token) {
            return null;
        }

        return Cart::where('session_token', $token)->latest()->first();
    }

    public function create(): Cart
    {
        $cart = new Cart();
        if (auth()->check()) {
            $cart->user_id = auth()->id();
        } else {
            $token = Str::random(40);
            $cart->session_token = $token;
            Cookie::queue(self::SESSION_COOKIE, $token, 60 * 24 * 30);
        }
        $cart->save();
        return $cart;
    }

    public function add(Product $product, int $quantity = 1, bool $exchangeOldBattery = false): CartItem
    {
        $cart = $this->current();
        $exchangeOldBattery = $exchangeOldBattery && $product->exchange_available;

        return DB::transaction(function () use ($cart, $product, $quantity, $exchangeOldBattery) {
            $item = CartItem::firstOrNew([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'exchange_old_battery' => $exchangeOldBattery,
            ]);

            if ($item->exists) {
                $item->quantity = min($item->quantity + $quantity, $product->stock_quantity ?: 99);
            } else {
                $item->quantity = max(1, min($quantity, $product->stock_quantity ?: 99));
                $item->price = $product->price;
                $item->offer_price = $product->offer_price;
                $item->exchange_discount = $exchangeOldBattery ? $product->exchange_discount : 0;
            }
            $item->save();

            $this->recalculate($cart);

            return $item;
        });
    }

    public function updateQuantity(CartItem $item, int $quantity): void
    {
        $item->loadMissing('product');
        $maxStock = (int) ($item->product?->stock_quantity ?? 0);
        if ($maxStock <= 0) {
            $this->removeItem($item);
            return;
        }

        $item->quantity = max(1, min($quantity, min(10, $maxStock)));
        $item->save();
        $this->recalculate($item->cart);
    }

    public function setExchange(CartItem $item, bool $enabled): void
    {
        $item->loadMissing('product');
        if (! $item->product?->exchange_available) {
            return;
        }

        $item->exchange_old_battery = $enabled;
        $item->exchange_discount = $enabled ? (float) $item->product->exchange_discount : 0;
        $item->save();
        $this->recalculate($item->cart);
    }

    public function removeItem(CartItem $item): void
    {
        $cart = $item->cart;
        $item->delete();
        if ($cart) {
            $this->recalculate($cart);
        }
    }

    public function applyCoupon(string $code): array
    {
        $cart = $this->current();
        $cart->load('items');

        $result = $this->coupons->validate($code, $cart, auth()->user());
        if (! $result['valid']) {
            return $result;
        }

        $cart->coupon_code = $result['coupon']->code;
        $cart->discount = $result['discount'];
        $cart->save();
        $this->recalculate($cart);

        return $result;
    }

    public function removeCoupon(): void
    {
        $cart = $this->current();
        $cart->coupon_code = null;
        $cart->discount = 0;
        $cart->save();
        $this->recalculate($cart);
    }

    public function recalculate(Cart $cart): void
    {
        $cart->load('items.product');

        $subtotal = 0;
        $exchangeDiscount = 0;
        foreach ($cart->items as $item) {
            $unit = (float) ($item->offer_price ?? $item->price);
            $subtotal += $unit * $item->quantity;
            if ($item->exchange_old_battery) {
                $exchangeDiscount += (float) $item->exchange_discount * $item->quantity;
            }
        }

        if ($cart->coupon_code) {
            $couponDiscount = $this->coupons->discountFor($cart->coupon_code, $subtotal - $exchangeDiscount);
            $cart->discount = $couponDiscount;
        } else {
            $cart->discount = 0;
        }

        $afterDiscount = max(0, $subtotal - $exchangeDiscount - (float) $cart->discount);
        $delivery = $this->deliveryCharge($afterDiscount);
        $taxPercent = (int) Setting::get('default_tax_percent', 0, 'order');
        $tax = round($afterDiscount * ($taxPercent / 100), 2);

        $cart->subtotal = $subtotal;
        $cart->exchange_discount = $exchangeDiscount;
        $cart->delivery_charge = $delivery;
        $cart->tax = $tax;
        $cart->total = round($afterDiscount + $delivery + $tax, 2);
        $cart->save();
    }

    public function deliveryCharge(float $subtotal): float
    {
        $freeAbove = (float) Setting::get('free_delivery_above', 0, 'order');
        if ($freeAbove > 0 && $subtotal >= $freeAbove) {
            return 0.0;
        }
        return (float) Setting::get('default_delivery_charge', 0, 'order');
    }

    public function itemsCount(): int
    {
        $cart = $this->find();
        return $cart ? (int) $cart->items()->sum('quantity') : 0;
    }

    public function clear(Cart $cart): void
    {
        $cart->items()->delete();
        $cart->forceFill([
            'subtotal' => 0,
            'discount' => 0,
            'exchange_discount' => 0,
            'delivery_charge' => 0,
            'tax' => 0,
            'total' => 0,
            'coupon_code' => null,
        ])->save();
    }

    public function mergeGuestCartIntoUser(int $userId): void
    {
        $token = request()->cookie(self::SESSION_COOKIE);
        if (! $token) {
            return;
        }

        $guestCart = Cart::where('session_token', $token)->latest()->first();
        if (! $guestCart) {
            return;
        }

        $userCart = Cart::firstOrCreate(['user_id' => $userId]);

        DB::transaction(function () use ($guestCart, $userCart) {
            foreach ($guestCart->items as $guestItem) {
                $existing = CartItem::firstOrNew([
                    'cart_id' => $userCart->id,
                    'product_id' => $guestItem->product_id,
                    'exchange_old_battery' => $guestItem->exchange_old_battery,
                ]);
                if ($existing->exists) {
                    $existing->quantity += $guestItem->quantity;
                } else {
                    $existing->fill($guestItem->only([
                        'quantity', 'price', 'offer_price', 'exchange_discount',
                    ]));
                }
                $existing->save();
            }
            $guestCart->delete();
        });

        $this->recalculate($userCart);
        Cookie::queue(Cookie::forget(self::SESSION_COOKIE));
    }
}
