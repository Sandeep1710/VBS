<?php

namespace App\Services\Checkout;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusLog;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Services\Cart\CartService;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class CheckoutService
{
    public function __construct(
        private readonly CartService $carts,
    ) {
    }

    /**
     * Place an order from the user's current cart.
     *
     * @param  array{address_id:int, payment_method:string, notes?:?string, exchange_pickup_required?:bool}  $data
     */
    public function placeOrder(User $user, Cart $cart, array $data): Order
    {
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            throw new RuntimeException('Your cart is empty.');
        }

        $address = Address::where('user_id', $user->id)->findOrFail($data['address_id']);

        return DB::transaction(function () use ($user, $cart, $data, $address) {
            // Lock products and check stock
            foreach ($cart->items as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);
                if (! $product || ! $product->is_active) {
                    throw new RuntimeException("'{$item->product->name}' is no longer available.");
                }
                if ($product->stock_quantity < $item->quantity) {
                    throw new RuntimeException("Only {$product->stock_quantity} of '{$product->name}' available.");
                }
            }

            // Recalculate to make sure totals are fresh
            $this->carts->recalculate($cart);
            $cart->refresh()->load('items.product');

            $order = new Order();
            $order->order_number = 'TMP-' . now()->format('YmdHis') . '-' . random_int(1000, 9999);
            $order->user_id = $user->id;
            $order->status = Order::STATUS_PENDING;
            $order->payment_status = Order::PAY_PENDING;

            $this->fillBilling($order, $user, $address);
            $this->fillShipping($order, $address);

            $order->subtotal = $cart->subtotal;
            $order->discount = $cart->discount;
            $order->exchange_discount = $cart->exchange_discount;
            $order->delivery_charge = $cart->delivery_charge;
            $order->tax_amount = $cart->tax;
            $order->total = $cart->total;

            if ($cart->coupon_code) {
                $coupon = Coupon::where('code', $cart->coupon_code)->first();
                $order->coupon_id = $coupon?->id;
                $order->coupon_code = $cart->coupon_code;
            }

            $order->payment_method = $data['payment_method'];
            $order->exchange_pickup_required = $cart->items->contains(fn ($i) => (bool) $i->exchange_old_battery);
            $order->notes = $data['notes'] ?? null;

            $order->save();

            $order->update([
                'order_number' => 'VBS' . str_pad((string) $order->id, 8, '0', STR_PAD_LEFT),
            ]);

            // Snapshot items + decrement stock
            foreach ($cart->items as $item) {
                $product = $item->product;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'product_brand' => $product->batteryBrand?->name,
                    'product_image' => $product->primaryImage?->path,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'offer_price' => $item->offer_price,
                    'exchange_old_battery' => $item->exchange_old_battery,
                    'exchange_discount' => $item->exchange_discount,
                    'subtotal' => (float) ($item->offer_price ?? $item->price) * $item->quantity,
                    'total' => $item->line_total,
                    'warranty_months' => (int) $product->warranty_months,
                ]);

                Product::where('id', $product->id)->update([
                    'stock_quantity' => DB::raw('stock_quantity - ' . (int) $item->quantity),
                    'sales_count' => DB::raw('sales_count + ' . (int) $item->quantity),
                ]);
            }

            // Coupon usage
            if (isset($coupon) && $coupon) {
                $coupon->increment('used_count', 1);
                CouponUsage::create([
                    'coupon_id' => $coupon->id,
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'discount_amount' => $cart->discount,
                ]);
            }

            // Initial status log
            OrderStatusLog::create([
                'order_id' => $order->id,
                'from_status' => null,
                'to_status' => Order::STATUS_PENDING,
                'comment' => 'Order placed by customer.',
                'changed_by' => $user->id,
                'source' => 'customer',
            ]);

            // Initial payment record (online gateways recorded as initiated; COD as initiated too — confirmed on delivery)
            Payment::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'gateway' => $data['payment_method'],
                'amount' => $cart->total,
                'currency' => 'INR',
                'status' => Payment::STATUS_INITIATED,
                'method' => $data['payment_method'],
            ]);

            // Empty the cart
            $this->carts->clear($cart);

            return $order->fresh(['items', 'statusLogs']);
        });
    }

    private function fillBilling(Order $order, User $user, Address $address): void
    {
        $order->billing_name = $address->name;
        $order->billing_phone = $address->phone;
        $order->billing_email = $user->email;
        $order->billing_line1 = $address->line1;
        $order->billing_line2 = $address->line2;
        $order->billing_city = $address->city;
        $order->billing_state = $address->state;
        $order->billing_pincode = $address->pincode;
        $order->billing_country = $address->country;
    }

    private function fillShipping(Order $order, Address $address): void
    {
        $order->shipping_name = $address->name;
        $order->shipping_phone = $address->phone;
        $order->shipping_line1 = $address->line1;
        $order->shipping_line2 = $address->line2;
        $order->shipping_landmark = $address->landmark;
        $order->shipping_city = $address->city;
        $order->shipping_state = $address->state;
        $order->shipping_pincode = $address->pincode;
        $order->shipping_country = $address->country;
    }
}
