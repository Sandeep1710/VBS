<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkout\PlaceOrderRequest;
use App\Models\Address;
use App\Models\Order;
use App\Notifications\OrderPlacedNotification;
use App\Services\Cart\CartService;
use App\Services\Checkout\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use RuntimeException;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cart,
        private readonly CheckoutService $checkout,
    ) {
    }

    public function index(Request $request): View|RedirectResponse
    {
        $cart = $this->cart->find();
        if (! $cart || $cart->items()->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cart->load(['items.product.batteryBrand']);
        $this->cart->recalculate($cart);
        $cart->refresh()->load('items.product');

        $addresses = $request->user()->addresses()->latest('is_default')->latest()->get();

        return view('checkout.index', compact('cart', 'addresses'));
    }

    public function store(PlaceOrderRequest $request): RedirectResponse
    {
        $cart = $this->cart->find();
        if (! $cart || $cart->items()->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        try {
            $order = $this->checkout->placeOrder($request->user(), $cart, $request->validated());
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        Notification::send($order->user, new OrderPlacedNotification($order));

        // For non-COD methods, redirect to the payment page first
        if ($order->payment_method !== 'cod') {
            return redirect()->route('payment.show', $order)
                ->with('success', 'Order placed. Complete payment to confirm.');
        }

        return redirect()->route('checkout.success', $order)
            ->with('success', 'Order placed successfully!');
    }

    public function success(Request $request, Order $order): View
    {
        abort_unless($order->user_id === $request->user()->id, 403);
        $order->load('items', 'latestPayment');
        return view('checkout.success', compact('order'));
    }
}
