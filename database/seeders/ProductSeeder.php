<?php

namespace Database\Seeders;

use App\Models\BatteryBrand;
use App\Models\Category;
use App\Models\Fitment;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\VehicleVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $carCat = Category::where('slug', 'car-batteries')->first();
        $bikeCat = Category::where('slug', 'bike-batteries')->first();
        $exide = BatteryBrand::where('slug', 'exide')->first();
        $amaron = BatteryBrand::where('slug', 'amaron')->first();
        $sfSonic = BatteryBrand::where('slug', 'sf-sonic')->first();

        $products = [
            [
                'name' => 'Exide Mileage MLDIN55 55Ah',
                'sku' => 'EX-MLDIN55',
                'brand' => $exide,
                'category' => $carCat,
                'capacity_ah' => 55,
                'voltage' => 12,
                'warranty_months' => 48,
                'price' => 7800,
                'offer_price' => 6499,
                'short_description' => 'High-performance maintenance-free battery for hatchback and sedan cars.',
                'exchange_available' => true,
                'exchange_discount' => 800,
                'stock_quantity' => 50,
                'is_featured' => true,
            ],
            [
                'name' => 'Amaron Hi-Life Pro 45Ah',
                'sku' => 'AM-HI45',
                'brand' => $amaron,
                'category' => $carCat,
                'capacity_ah' => 45,
                'voltage' => 12,
                'warranty_months' => 60,
                'price' => 6800,
                'offer_price' => 5799,
                'short_description' => 'Long-life maintenance-free car battery from Amaron with 60-month warranty.',
                'exchange_available' => true,
                'exchange_discount' => 700,
                'stock_quantity' => 35,
                'is_featured' => true,
            ],
            [
                'name' => 'Amaron Hi-Life 40Ah',
                'sku' => 'AM-HI40',
                'brand' => $amaron,
                'category' => $carCat,
                'capacity_ah' => 40,
                'voltage' => 12,
                'warranty_months' => 48,
                'price' => 5800,
                'offer_price' => 4999,
                'short_description' => 'Reliable car battery for small cars with 48-month warranty.',
                'exchange_available' => true,
                'exchange_discount' => 600,
                'stock_quantity' => 28,
                'is_featured' => false,
            ],
            [
                'name' => 'Exide MotoMatic 9Ah',
                'sku' => 'EX-MOTO9',
                'brand' => $exide,
                'category' => $bikeCat,
                'capacity_ah' => 9,
                'voltage' => 12,
                'warranty_months' => 36,
                'price' => 2500,
                'offer_price' => 1999,
                'short_description' => 'Reliable bike battery with strong cranking power for 150-200cc motorcycles.',
                'exchange_available' => true,
                'exchange_discount' => 200,
                'stock_quantity' => 60,
                'is_featured' => true,
            ],
            [
                'name' => 'SF Sonic Motozone 5Ah',
                'sku' => 'SF-MOTO5',
                'brand' => $sfSonic,
                'category' => $bikeCat,
                'capacity_ah' => 5,
                'voltage' => 12,
                'warranty_months' => 24,
                'price' => 1800,
                'offer_price' => 1499,
                'short_description' => 'Compact battery for scooters and 100-125cc bikes.',
                'exchange_available' => true,
                'exchange_discount' => 150,
                'stock_quantity' => 40,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $data) {
            if (! $data['brand']) {
                continue;
            }

            $product = Product::updateOrCreate(
                ['sku' => $data['sku']],
                [
                    'battery_brand_id' => $data['brand']->id,
                    'category_id' => $data['category']?->id,
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'capacity_ah' => $data['capacity_ah'],
                    'voltage' => $data['voltage'],
                    'warranty_months' => $data['warranty_months'],
                    'price' => $data['price'],
                    'offer_price' => $data['offer_price'],
                    'short_description' => $data['short_description'],
                    'description' => '<p>' . $data['short_description'] . '</p><p>Genuine product with manufacturer warranty. Free doorstep delivery and old battery exchange available.</p>',
                    'exchange_available' => $data['exchange_available'],
                    'exchange_discount' => $data['exchange_discount'],
                    'stock_quantity' => $data['stock_quantity'],
                    'is_featured' => $data['is_featured'],
                    'is_active' => true,
                ],
            );

            ProductImage::updateOrCreate(
                ['product_id' => $product->id, 'path' => 'products/placeholder.svg'],
                ['alt' => $product->name, 'sort_order' => 0, 'is_primary' => true],
            );

            $specs = [
                ['Battery', 'Capacity', $product->capacity_ah . ' Ah'],
                ['Battery', 'Voltage', $product->voltage . ' V'],
                ['Warranty', 'Warranty Period', $product->warranty_months . ' months'],
            ];

            foreach ($specs as $i => [$group, $key, $value]) {
                ProductSpecification::updateOrCreate(
                    ['product_id' => $product->id, 'group' => $group, 'key' => $key],
                    ['value' => $value, 'sort_order' => $i + 1],
                );
            }
        }

        // Fitments
        $carProducts = Product::whereHas('category', fn ($q) => $q->where('slug', 'car-batteries'))->get();
        $bikeProducts = Product::whereHas('category', fn ($q) => $q->where('slug', 'bike-batteries'))->get();

        $carVariants = VehicleVariant::whereHas('vehicleModel.vehicleType', fn ($q) => $q->where('slug', 'car'))->get();
        $bikeVariants = VehicleVariant::whereHas('vehicleModel.vehicleType', fn ($q) => $q->where('slug', 'bike'))->get();

        foreach ($carProducts as $product) {
            foreach ($carVariants as $variant) {
                Fitment::updateOrCreate(
                    ['product_id' => $product->id, 'vehicle_variant_id' => $variant->id],
                    ['is_recommended' => false],
                );
            }
        }

        foreach ($bikeProducts as $product) {
            foreach ($bikeVariants as $variant) {
                Fitment::updateOrCreate(
                    ['product_id' => $product->id, 'vehicle_variant_id' => $variant->id],
                    ['is_recommended' => false],
                );
            }
        }
    }
}
