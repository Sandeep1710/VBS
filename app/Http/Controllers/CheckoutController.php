<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkout\PlaceOrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderPlacedNotification;
use App\Services\Cart\CartService;
use App\Services\Checkout\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
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

        // LEAD-GEN MODE: guest lead form, no saved addresses.
        // Original: $addresses = $request->user()->addresses()->latest('is_default')->latest()->get();
        return view('checkout.index', compact('cart'));
    }

    public function store(PlaceOrderRequest $request): RedirectResponse
    {
        $cart = $this->cart->find();
        if (! $cart || $cart->items()->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $data = $request->validated();

        // LEAD-GEN MODE
        // ─────────────
        // Address and payment method are collected by admin on the follow-up phone call.
        // We fill placeholder values here just to satisfy the existing Order columns.
        // Email is optional — if missing we synthesise one from the phone so User's
        // unique-email constraint holds without asking the customer for it.
        $email = $data['email'] ?? 'lead+' . preg_replace('/\D+/', '', $data['phone']) . '@trikutibattery.local';

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $data['name'],
                'phone' => $data['phone'],
                'password' => Hash::make(Str::random(32)),
                'email_verified_at' => now(),
            ],
        );
        // Keep contact details fresh if they submit again
        $user->fill(['name' => $data['name'], 'phone' => $data['phone']])->save();
        Auth::login($user);

        // Placeholder address — admin will confirm full details during the call
        $address = $user->addresses()->create([
            'name'       => $data['name'],
            'phone'      => $data['phone'],
            'label'      => 'Home',
            'line1'      => 'To be confirmed on call',
            'line2'      => null,
            'city'       => 'Mumbai',
            'state'      => 'Maharashtra',
            'pincode'    => $data['pincode'],
            'country'    => 'IN',
            'is_default' => true,
        ]);

        // Pass the fields CheckoutService expects
        $orderData = [
            'address_id'     => $address->id,
            'payment_method' => 'cod', // hardcoded — admin discusses payment on the call
            'notes'          => $data['notes'] ?? null,
        ];

        try {
            $order = $this->checkout->placeOrder($user, $cart, $orderData);
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        Notification::send($order->user, new OrderPlacedNotification($order));

        session(['guest_order_id' => $order->id]);

        return redirect()->route('checkout.success', $order)
            ->with('success', 'Enquiry received! We will call you shortly.');
    }

    public function success(Request $request, Order $order): View
    {
        // LEAD-GEN MODE: allow the guest who just placed the lead (via session) OR the owning user.
        // Original strict check: abort_unless($order->user_id === $request->user()->id, 403);
        $sessionOrderId = session('guest_order_id');
        $ownedByAuth = $request->user() && $order->user_id === $request->user()->id;
        abort_unless($ownedByAuth || $sessionOrderId === $order->id, 403);

        $order->load('items', 'latestPayment');
        return view('checkout.success', compact('order'));
    }
}
