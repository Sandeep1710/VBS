<?php

namespace Tests\Feature;

use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_add_to_wishlist(): void
    {
        $user = $this->makeCustomer();
        $product = $this->makeProduct();

        $this->actingAs($user)
            ->post(route('account.wishlist.store', $product))
            ->assertRedirect();

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_duplicate_add_does_not_create_extra_row(): void
    {
        $user = $this->makeCustomer();
        $product = $this->makeProduct();

        $this->actingAs($user)->post(route('account.wishlist.store', $product));
        $this->actingAs($user)->post(route('account.wishlist.store', $product));

        $this->assertDatabaseCount('wishlists', 1);
    }

    public function test_customer_can_remove_from_wishlist(): void
    {
        $user = $this->makeCustomer();
        $product = $this->makeProduct();
        Wishlist::create(['user_id' => $user->id, 'product_id' => $product->id]);

        $this->actingAs($user)
            ->delete(route('account.wishlist.destroy', $product))
            ->assertRedirect();

        $this->assertDatabaseCount('wishlists', 0);
    }

    public function test_wishlist_index_shows_saved_items(): void
    {
        $user = $this->makeCustomer();
        $product = $this->makeProduct(['name' => 'Saved Battery']);
        Wishlist::create(['user_id' => $user->id, 'product_id' => $product->id]);

        $this->actingAs($user)
            ->get(route('account.wishlist.index'))
            ->assertOk()
            ->assertSee('Saved Battery');
    }

    public function test_api_wishlist_endpoints(): void
    {
        $user = $this->makeCustomer();
        $product = $this->makeProduct();
        $token = $user->createToken('t')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson("/api/v1/wishlist/{$product->slug}")
            ->assertOk();

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/wishlist')
            ->assertOk()
            ->assertJsonCount(1, 'data');

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson("/api/v1/wishlist/{$product->slug}")
            ->assertOk();

        $this->assertDatabaseCount('wishlists', 0);
    }
}
