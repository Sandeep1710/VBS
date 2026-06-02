<?php

namespace Tests\Feature\Checkout;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_redirects_with_empty_cart(): void
    {
        $this->seedSettings();
        $customer = $this->makeCustomer();

        $this->actingAs($customer)
            ->get(route('checkout.index'))
            ->assertRedirect(route('cart.index'));
    }

    public function test_can_place_order(): void
    {
        $this->seedSettings();
        $customer = $this->makeCustomer();
        $product = $this->makeProduct(['stock_quantity' => 10]);

        $address = Address::create([
            'user_id' => $customer->id,
            'label' => 'Home',
            'name' => 'Tester',
            'phone' => '9000000000',
            'line1' => '1 Test St',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
            'country' => 'India',
            'is_default' => true,
        ]);

        $this->actingAs($customer)->post(route('cart.add', $product), ['quantity' => 2]);

        $response = $this->actingAs($customer)->post(route('checkout.store'), [
            'address_id' => $address->id,
            'payment_method' => 'cod',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'status' => Order::STATUS_PENDING,
            'payment_method' => 'cod',
        ]);
    }

    public function test_stock_decremented_on_order(): void
    {
        $this->seedSettings();
        $customer = $this->makeCustomer();
        $product = $this->makeProduct(['stock_quantity' => 10]);
        $address = Address::create([
            'user_id' => $customer->id, 'label' => 'Home', 'name' => 'T',
            'phone' => '9000000000', 'line1' => '1 St', 'city' => 'Mumbai',
            'state' => 'Maharashtra', 'pincode' => '400001',
        ]);

        $this->actingAs($customer)->post(route('cart.add', $product), ['quantity' => 3]);
        $this->actingAs($customer)->post(route('checkout.store'), [
            'address_id' => $address->id,
            'payment_method' => 'cod',
        ]);

        $this->assertEquals(7, $product->fresh()->stock_quantity);
        $this->assertEquals(3, $product->fresh()->sales_count);
    }

    public function test_cart_cleared_after_order(): void
    {
        $this->seedSettings();
        $customer = $this->makeCustomer();
        $product = $this->makeProduct();
        $address = Address::create([
            'user_id' => $customer->id, 'label' => 'Home', 'name' => 'T',
            'phone' => '9000000000', 'line1' => '1 St', 'city' => 'Mumbai',
            'state' => 'Maharashtra', 'pincode' => '400001',
        ]);

        $this->actingAs($customer)->post(route('cart.add', $product), ['quantity' => 1]);
        $this->actingAs($customer)->post(route('checkout.store'), [
            'address_id' => $address->id,
            'payment_method' => 'cod',
        ]);

        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_unauthenticated_cant_checkout(): void
    {
        $this->get(route('checkout.index'))
            ->assertRedirect(route('login'));
    }
}
