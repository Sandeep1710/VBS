<?php

namespace Tests\Feature\Cart;

use App\Models\Coupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_product_to_cart(): void
    {
        $this->seedSettings();
        $customer = $this->makeCustomer();
        $product = $this->makeProduct();

        $this->actingAs($customer)
            ->post(route('cart.add', $product), ['quantity' => 2])
            ->assertRedirect();

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_cart_index_shows_added_items(): void
    {
        $this->seedSettings();
        $customer = $this->makeCustomer();
        $product = $this->makeProduct(['name' => 'Visible Battery']);

        $this->actingAs($customer)->post(route('cart.add', $product), ['quantity' => 1]);

        $this->actingAs($customer)
            ->get(route('cart.index'))
            ->assertOk()
            ->assertSee('Visible Battery');
    }

    public function test_can_update_cart_quantity(): void
    {
        $this->seedSettings();
        $customer = $this->makeCustomer();
        $product = $this->makeProduct();

        $this->actingAs($customer)->post(route('cart.add', $product), ['quantity' => 1]);
        $item = \App\Models\CartItem::where('product_id', $product->id)->first();

        $this->actingAs($customer)
            ->patch(route('cart.update', $item), ['quantity' => 3])
            ->assertRedirect();

        $this->assertEquals(3, $item->fresh()->quantity);
    }

    public function test_can_remove_cart_item(): void
    {
        $this->seedSettings();
        $customer = $this->makeCustomer();
        $product = $this->makeProduct();

        $this->actingAs($customer)->post(route('cart.add', $product), ['quantity' => 1]);
        $item = \App\Models\CartItem::where('product_id', $product->id)->first();

        $this->actingAs($customer)
            ->delete(route('cart.remove', $item))
            ->assertRedirect();

        $this->assertDatabaseMissing('cart_items', ['id' => $item->id]);
    }

    public function test_valid_coupon_can_be_applied(): void
    {
        $this->seedSettings();
        $customer = $this->makeCustomer();
        $product = $this->makeProduct(['offer_price' => 5000]);
        Coupon::create([
            'code' => 'TEST500',
            'name' => 'Test',
            'type' => Coupon::TYPE_FLAT,
            'value' => 500,
            'min_order_amount' => 1000,
            'is_active' => true,
        ]);

        $this->actingAs($customer)->post(route('cart.add', $product), ['quantity' => 1]);

        $this->actingAs($customer)
            ->post(route('cart.coupon.apply'), ['code' => 'TEST500'])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('carts', ['user_id' => $customer->id, 'coupon_code' => 'TEST500']);
    }

    public function test_invalid_coupon_rejected(): void
    {
        $this->seedSettings();
        $customer = $this->makeCustomer();
        $product = $this->makeProduct();
        $this->actingAs($customer)->post(route('cart.add', $product), ['quantity' => 1]);

        $this->actingAs($customer)
            ->post(route('cart.coupon.apply'), ['code' => 'NONEXISTENT'])
            ->assertSessionHas('error');
    }
}
