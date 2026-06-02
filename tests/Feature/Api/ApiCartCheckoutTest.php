<?php

namespace Tests\Feature\Api;

use App\Models\Address;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiCartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_add_to_cart_and_view_it(): void
    {
        $this->seedSettings();
        $user = $this->makeCustomer();
        $product = $this->makeProduct();
        $token = $user->createToken('t')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson("/api/v1/cart/items/{$product->slug}", ['quantity' => 2])
            ->assertOk()
            ->assertJsonPath('data.items_count', 2);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/cart')
            ->assertOk()
            ->assertJsonPath('data.items_count', 2)
            ->assertJsonPath('data.items.0.product_id', $product->id);
    }

    public function test_guest_unauthenticated_orders_endpoint_blocked(): void
    {
        $this->getJson('/api/v1/orders')->assertStatus(401);
    }

    public function test_full_checkout_flow_via_api(): void
    {
        $this->seedSettings();
        $user = $this->makeCustomer();
        $product = $this->makeProduct(['stock_quantity' => 10]);
        $token = $user->createToken('t')->plainTextToken;

        $address = Address::create([
            'user_id' => $user->id, 'label' => 'Home', 'name' => 'T',
            'phone' => '9000000000', 'line1' => '1 St', 'city' => 'Mumbai',
            'state' => 'Maharashtra', 'pincode' => '400001',
        ]);

        // Add to cart
        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson("/api/v1/cart/items/{$product->slug}", ['quantity' => 2])
            ->assertOk();

        // Place order
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/orders', [
                'address_id' => $address->id,
                'payment_method' => 'cod',
            ]);

        $response->assertCreated()
            ->assertJsonPath('data.status', Order::STATUS_PENDING)
            ->assertJsonPath('data.payment_method', 'cod');

        $this->assertEquals(8, $product->fresh()->stock_quantity);

        // Cancel order via API
        $orderNumber = $response->json('data.order_number');
        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->patchJson("/api/v1/orders/{$orderNumber}/cancel", ['reason' => 'changed mind'])
            ->assertOk()
            ->assertJsonPath('data.status', Order::STATUS_CANCELLED);

        $this->assertEquals(10, $product->fresh()->stock_quantity);
    }

    public function test_unverified_user_blocked_from_placing_order(): void
    {
        $this->seedSettings();
        $user = $this->makeCustomer(verified: false);
        $token = $user->createToken('t')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/orders', [
                'address_id' => 1,
                'payment_method' => 'cod',
            ])
            ->assertStatus(403);
    }
}
