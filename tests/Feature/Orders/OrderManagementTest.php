<?php

namespace Tests\Feature\Orders;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderManagementTest extends TestCase
{
    use RefreshDatabase;

    private function placedOrder(): array
    {
        $this->seedSettings();
        $customer = $this->makeCustomer();
        $product = $this->makeProduct(['stock_quantity' => 10]);
        $address = Address::create([
            'user_id' => $customer->id, 'label' => 'Home', 'name' => 'T',
            'phone' => '9000000000', 'line1' => '1 St', 'city' => 'Mumbai',
            'state' => 'Maharashtra', 'pincode' => '400001',
        ]);

        $this->actingAs($customer)->post(route('cart.add', $product), ['quantity' => 2]);
        $this->actingAs($customer)->post(route('checkout.store'), [
            'address_id' => $address->id,
            'payment_method' => 'cod',
        ]);

        return [$customer, $product, Order::where('user_id', $customer->id)->latest()->first()];
    }

    public function test_customer_can_cancel_pending_order(): void
    {
        [$customer, $product, $order] = $this->placedOrder();

        $this->actingAs($customer)
            ->patch(route('account.orders.cancel', $order))
            ->assertRedirect();

        $this->assertEquals(Order::STATUS_CANCELLED, $order->fresh()->status);
    }

    public function test_cancellation_restores_stock(): void
    {
        [$customer, $product, $order] = $this->placedOrder();
        $beforeCancel = $product->fresh()->stock_quantity;

        $this->actingAs($customer)->patch(route('account.orders.cancel', $order));

        $this->assertEquals($beforeCancel + 2, $product->fresh()->stock_quantity);
    }
}
