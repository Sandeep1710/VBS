<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Services\Cart\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cart)
    {
    }

    public function index(): View
    {
        $cart = $this->cart->find();
        if ($cart) {
            $cart->load(['items.product.batteryBrand', 'items.product.primaryImage']);
            $this->cart->recalculate($cart);
            $cart->refresh()->load(['items.product.batteryBrand', 'items.product.primaryImage']);
        }

        return view('cart.index', [
            'cart' => $cart,
            'itemsCount' => $cart ? (int) $cart->items->sum('quantity') : 0,
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        if (! $product->is_active || $product->stock_quantity <= 0) {
            return back()->with('error', 'Sorry, this product is out of stock.');
        }

        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
            'exchange_old_battery' => ['nullable', 'boolean'],
            'buy_now' => ['nullable', 'boolean'],
        ]);

        $this->cart->add(
            $product,
            (int) ($data['quantity'] ?? 1),
            (bool) ($data['exchange_old_battery'] ?? false),
        );

        if ($request->boolean('buy_now')) {
            return redirect()->route('cart.index')->with('success', 'Item added. Review and place your order.');
        }

        return back()->with('success', 'Added to cart.');
    }

    public function update(Request $request, CartItem $item): RedirectResponse
    {
        $this->authorizeItem($item);

        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
            'exchange_old_battery' => ['nullable', 'boolean'],
        ]);

        if ($request->has('exchange_old_battery')) {
            $this->cart->setExchange($item, $request->boolean('exchange_old_battery'));
            $item = $item->fresh();
        }

        if (array_key_exists('quantity', $data) && $data['quantity'] !== null) {
            $this->cart->updateQuantity($item, (int) $data['quantity']);
        }

        return back()->with('success', 'Cart updated.');
    }

    public function remove(CartItem $item): RedirectResponse
    {
        $this->authorizeItem($item);
        $this->cart->removeItem($item);
        return back()->with('success', 'Item removed.');
    }

    public function applyCoupon(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:40'],
        ]);

        $result = $this->cart->applyCoupon(strtoupper(trim($data['code'])));

        if (! ($result['valid'] ?? false)) {
            return back()->with('error', $result['error'] ?? 'Invalid coupon.');
        }

        return back()->with('success', 'Coupon applied: ' . $result['coupon']->name);
    }

    public function removeCoupon(): RedirectResponse
    {
        $this->cart->removeCoupon();
        return back()->with('success', 'Coupon removed.');
    }

    private function authorizeItem(CartItem $item): void
    {
        $cart = $item->cart;
        if (! $cart) {
            abort(404);
        }
        if ($cart->user_id) {
            abort_unless($cart->user_id === auth()->id(), 403);
        } else {
            $token = request()->cookie(CartService::SESSION_COOKIE);
            abort_unless($cart->session_token === $token, 403);
        }
    }
}
