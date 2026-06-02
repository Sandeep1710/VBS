<?php

namespace Tests\Feature\Payments;

use App\Models\Address;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Payments\Gateways\RazorpayGateway;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RazorpayGatewayTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_mode_creates_fake_intent_when_keys_missing(): void
    {
        $user = $this->makeCustomer();
        $product = $this->makeProduct();

        $order = Order::create([
            'order_number' => 'VBS00099999',
            'user_id' => $user->id,
            'subtotal' => 5000, 'total' => 5000,
            'billing_name' => 'T', 'billing_phone' => '1', 'billing_line1' => 'X',
            'billing_city' => 'X', 'billing_state' => 'X', 'billing_pincode' => '111111',
            'shipping_name' => 'T', 'shipping_phone' => '1', 'shipping_line1' => 'X',
            'shipping_city' => 'X', 'shipping_state' => 'X', 'shipping_pincode' => '111111',
            'payment_method' => 'upi',
        ]);
        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'gateway' => 'razorpay',
            'amount' => 5000, 'currency' => 'INR',
            'status' => Payment::STATUS_INITIATED,
        ]);

        $gateway = $this->app->make(RazorpayGateway::class);
        $intent = $gateway->createIntent($order, $payment);

        $this->assertTrue($intent['demo']);
        $this->assertStringStartsWith('order_demo_', $intent['gateway_order_id']);
        $this->assertEquals(500000, $intent['amount']);
    }

    public function test_demo_verify_accepts_any_signature(): void
    {
        $user = $this->makeCustomer();
        $order = Order::create([
            'order_number' => 'VBS00099998',
            'user_id' => $user->id,
            'subtotal' => 1000, 'total' => 1000,
            'billing_name' => 'T', 'billing_phone' => '1', 'billing_line1' => 'X',
            'billing_city' => 'X', 'billing_state' => 'X', 'billing_pincode' => '111111',
            'shipping_name' => 'T', 'shipping_phone' => '1', 'shipping_line1' => 'X',
            'shipping_city' => 'X', 'shipping_state' => 'X', 'shipping_pincode' => '111111',
            'payment_method' => 'card',
        ]);
        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'gateway' => 'razorpay',
            'gateway_order_id' => 'order_demo_xyz',
            'amount' => 1000, 'currency' => 'INR',
            'status' => Payment::STATUS_INITIATED,
        ]);

        $gateway = $this->app->make(RazorpayGateway::class);
        $result = $gateway->verify($order, $payment, [
            'razorpay_order_id' => 'order_demo_xyz',
            'razorpay_payment_id' => 'pay_demo_abc',
            'razorpay_signature' => 'demo',
        ]);

        $this->assertTrue($result['success']);
        $this->assertEquals('pay_demo_abc', $result['payment_id']);
    }

    public function test_verify_rejects_order_id_mismatch(): void
    {
        $user = $this->makeCustomer();
        $order = Order::create([
            'order_number' => 'VBS00099997',
            'user_id' => $user->id, 'subtotal' => 100, 'total' => 100,
            'billing_name' => 'T', 'billing_phone' => '1', 'billing_line1' => 'X',
            'billing_city' => 'X', 'billing_state' => 'X', 'billing_pincode' => '111111',
            'shipping_name' => 'T', 'shipping_phone' => '1', 'shipping_line1' => 'X',
            'shipping_city' => 'X', 'shipping_state' => 'X', 'shipping_pincode' => '111111',
            'payment_method' => 'upi',
        ]);
        $payment = Payment::create([
            'order_id' => $order->id, 'user_id' => $user->id, 'gateway' => 'razorpay',
            'gateway_order_id' => 'order_demo_correct',
            'amount' => 100, 'currency' => 'INR',
            'status' => Payment::STATUS_INITIATED,
        ]);

        $gateway = $this->app->make(RazorpayGateway::class);
        $result = $gateway->verify($order, $payment, [
            'razorpay_order_id' => 'order_demo_WRONG',
            'razorpay_payment_id' => 'pay_demo',
            'razorpay_signature' => 'demo',
        ]);

        $this->assertFalse($result['success']);
        $this->assertEquals('Order mismatch.', $result['error']);
    }

    public function test_full_upi_checkout_flow_routes_through_payment_page(): void
    {
        $this->seedSettings();
        $user = $this->makeCustomer();
        $product = $this->makeProduct(['stock_quantity' => 5]);
        $address = Address::create([
            'user_id' => $user->id, 'label' => 'Home', 'name' => 'T',
            'phone' => '9000000000', 'line1' => '1 St', 'city' => 'Mumbai',
            'state' => 'Maharashtra', 'pincode' => '400001',
        ]);

        $this->actingAs($user)->post(route('cart.add', $product), ['quantity' => 1]);

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'address_id' => $address->id,
            'payment_method' => 'upi',
        ]);

        $order = Order::latest()->first();
        $response->assertRedirect(route('payment.show', $order));

        // Hit the payment page (renders demo intent)
        $this->actingAs($user)->get(route('payment.show', $order))->assertOk();

        // Submit demo callback
        $payment = $order->payments()->first();
        $this->actingAs($user)->post(route('payment.callback', $order), [
            'razorpay_order_id' => $payment->gateway_order_id,
            'razorpay_payment_id' => 'pay_demo_test',
            'razorpay_signature' => 'demo',
        ])->assertRedirect(route('checkout.success', $order));

        $fresh = $order->fresh();
        $this->assertEquals(Order::PAY_PAID, $fresh->payment_status);
        $this->assertEquals(Order::STATUS_CONFIRMED, $fresh->status);
    }
}
