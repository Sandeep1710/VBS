<?php

namespace Tests;

use App\Models\BatteryBrand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    protected function seedSettings(): void
    {
        Setting::set('default_tax_percent', '18', 'order', 'integer');
        Setting::set('default_delivery_charge', '99', 'order', 'integer');
        Setting::set('free_delivery_above', '2000', 'order', 'integer');
    }

    protected function makeCustomer(array $overrides = [], bool $verified = true): User
    {
        return User::factory()->create(array_merge([
            'name' => 'Test Customer',
            'email' => 'cust' . uniqid() . '@example.test',
            'phone' => '99' . random_int(10000000, 99999999),
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => $verified ? now() : null,
        ], $overrides));
    }

    protected function makeProduct(array $overrides = []): Product
    {
        $brand = BatteryBrand::firstOrCreate(['slug' => 'test-brand'], ['name' => 'Test Brand']);
        $category = Category::firstOrCreate(['slug' => 'car-batteries'], ['name' => 'Car Batteries']);

        return Product::create(array_merge([
            'battery_brand_id' => $brand->id,
            'category_id' => $category->id,
            'name' => 'Test Battery 55Ah',
            'slug' => 'test-battery-' . uniqid(),
            'sku' => 'SKU-' . strtoupper(uniqid()),
            'capacity_ah' => 55,
            'voltage' => 12,
            'warranty_months' => 36,
            'price' => 5000,
            'offer_price' => 4500,
            'stock_quantity' => 20,
            'low_stock_threshold' => 5,
            'is_active' => true,
            'exchange_available' => true,
            'exchange_discount' => 500,
        ], $overrides));
    }
}
