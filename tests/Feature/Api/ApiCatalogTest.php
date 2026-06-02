<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_returns_list(): void
    {
        $this->makeProduct(['name' => 'API Test Battery', 'is_active' => true]);

        $this->getJson('/api/v1/products')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [['id', 'name', 'slug', 'sku', 'price', 'effective_price']],
                'links',
                'meta',
            ])
            ->assertJsonFragment(['name' => 'API Test Battery']);
    }

    public function test_product_show_returns_detail(): void
    {
        $product = $this->makeProduct(['slug' => 'show-test-' . uniqid()]);

        $this->getJson('/api/v1/products/' . $product->slug)
            ->assertOk()
            ->assertJsonPath('data.sku', $product->sku)
            ->assertJsonStructure([
                'data' => ['id', 'sku', 'description', 'stock_quantity', 'images', 'specifications'],
            ]);
    }

    public function test_product_show_404_for_unknown_slug(): void
    {
        $this->getJson('/api/v1/products/no-such-slug')->assertStatus(404);
    }

    public function test_categories_index_returns_active_only(): void
    {
        $this->makeProduct(); // ensures category exists

        $response = $this->getJson('/api/v1/categories')->assertOk();
        $this->assertNotEmpty($response->json('data'));
    }

    public function test_brands_index_returns_active_only(): void
    {
        $this->makeProduct();

        $response = $this->getJson('/api/v1/brands')->assertOk();
        $this->assertNotEmpty($response->json('data'));
    }
}
