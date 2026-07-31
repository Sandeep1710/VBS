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
use Throwable;

/**
 * Catalog — realistic Indian market prices (2024-2025).
 * Verify current prices with your local Exide / Amaron / SF Sonic distributor
 * before going live. Update via /admin/products once confirmed.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $carCat  = Category::where('slug', 'car-batteries')->first();
        $bikeCat = Category::where('slug', 'bike-batteries')->first();
        $exide   = BatteryBrand::where('slug', 'exide')->first();
        $amaron  = BatteryBrand::where('slug', 'amaron')->first();
        $sfSonic = BatteryBrand::where('slug', 'sf-sonic')->first();

        $products = [
            // ─── SMALL CARS (35 – 45 Ah) ───────────────────────────────────────────
            [
                'name'  => 'Amaron Hi-Life Pro 35Ah',
                'sku'   => 'AM-HL-35',
                'brand' => $amaron, 'category' => $carCat,
                'capacity_ah' => 35, 'voltage' => 12, 'warranty_months' => 48,
                'price' => 5200, 'offer_price' => 4499,
                'short_description' => 'Compact 35Ah battery for small hatchbacks — Alto, Kwid, Nano, i10 (older).',
                'exchange_available' => true, 'exchange_discount' => 500,
                'stock_quantity' => 30, 'is_featured' => false,
                'fits' => 'Maruti Alto · Renault Kwid · Tata Nano · Hyundai i10 (pre-2014)',
            ],
            [
                'name'  => 'Exide Mileage MLDIN44 44Ah',
                'sku'   => 'EX-ML-44',
                'brand' => $exide, 'category' => $carCat,
                'capacity_ah' => 44, 'voltage' => 12, 'warranty_months' => 48,
                'price' => 6200, 'offer_price' => 5399,
                'short_description' => 'Exide Mileage series 44Ah — reliable, low-maintenance battery for entry-level cars.',
                'exchange_available' => true, 'exchange_discount' => 550,
                'stock_quantity' => 30, 'is_featured' => false,
                'fits' => 'Maruti Wagon R · Datsun Redi-Go · Renault Triber',
            ],
            [
                'name'  => 'Amaron Hi-Life Pro 45Ah',
                'sku'   => 'AM-HL-45',
                'brand' => $amaron, 'category' => $carCat,
                'capacity_ah' => 45, 'voltage' => 12, 'warranty_months' => 48,
                'price' => 6900, 'offer_price' => 5999,
                'short_description' => 'Long-life 45Ah battery for compact cars — Swift, Baleno, Grand i10, Kwid Climber.',
                'exchange_available' => true, 'exchange_discount' => 600,
                'stock_quantity' => 40, 'is_featured' => true,
                'fits' => 'Maruti Swift · Hyundai Grand i10 · Ford Figo · Renault Kwid Climber',
            ],

            // ─── MID SEDANS (55 – 65 Ah) ───────────────────────────────────────────
            [
                'name'  => 'Exide Matrix MTR-DIN55 55Ah',
                'sku'   => 'EX-MT-55',
                'brand' => $exide, 'category' => $carCat,
                'capacity_ah' => 55, 'voltage' => 12, 'warranty_months' => 48,
                'price' => 7800, 'offer_price' => 6799,
                'short_description' => 'Exide Matrix 55Ah — European DIN standard for hatchbacks and compact sedans.',
                'exchange_available' => true, 'exchange_discount' => 700,
                'stock_quantity' => 45, 'is_featured' => true,
                'fits' => 'Maruti Baleno · Toyota Etios · Hyundai Xcent · Tata Tigor',
            ],
            [
                'name'  => 'Amaron Hi-Life Pro 65Ah (DIN65)',
                'sku'   => 'AM-HL-65',
                'brand' => $amaron, 'category' => $carCat,
                'capacity_ah' => 65, 'voltage' => 12, 'warranty_months' => 55,
                'price' => 8600, 'offer_price' => 7599,
                'short_description' => 'Amaron 65Ah DIN65 — premium sedan battery with 55-month warranty.',
                'exchange_available' => true, 'exchange_discount' => 800,
                'stock_quantity' => 35, 'is_featured' => true,
                'fits' => 'Honda City · Hyundai Verna · Skoda Rapid · VW Vento · Maruti Ciaz',
            ],
            [
                'name'  => 'SF Sonic FSF0-DIN65 65Ah',
                'sku'   => 'SF-DIN-65',
                'brand' => $sfSonic, 'category' => $carCat,
                'capacity_ah' => 65, 'voltage' => 12, 'warranty_months' => 48,
                'price' => 8200, 'offer_price' => 7199,
                'short_description' => 'SF Sonic 65Ah DIN65 — Exide-backed reliability at a value price.',
                'exchange_available' => true, 'exchange_discount' => 700,
                'stock_quantity' => 30, 'is_featured' => false,
                'fits' => 'Honda City · Hyundai Verna · VW Vento · Skoda Rapid',
            ],

            // ─── SUV / LARGE SEDAN (75 – 80 Ah) ────────────────────────────────────
            [
                'name'  => 'Amaron Hi-Life Pro 75Ah (DIN75)',
                'sku'   => 'AM-HL-75',
                'brand' => $amaron, 'category' => $carCat,
                'capacity_ah' => 75, 'voltage' => 12, 'warranty_months' => 55,
                'price' => 9600, 'offer_price' => 8499,
                'short_description' => 'Amaron 75Ah DIN75 — SUV-grade battery for Creta, Seltos, Nexon, Ecosport.',
                'exchange_available' => true, 'exchange_discount' => 800,
                'stock_quantity' => 30, 'is_featured' => true,
                'fits' => 'Hyundai Creta · Kia Seltos · Tata Nexon · Ford Ecosport · MG Hector',
            ],
            [
                'name'  => 'Exide MP-DIN80 80Ah',
                'sku'   => 'EX-MP-80',
                'brand' => $exide, 'category' => $carCat,
                'capacity_ah' => 80, 'voltage' => 12, 'warranty_months' => 55,
                'price' => 10800, 'offer_price' => 9599,
                'short_description' => 'Exide Marathon Plus 80Ah — heavy-duty battery for large SUVs and older Innova / Fortuner.',
                'exchange_available' => true, 'exchange_discount' => 900,
                'stock_quantity' => 25, 'is_featured' => true,
                'fits' => 'Toyota Innova · Toyota Fortuner (older) · Mahindra Bolero · Ford Endeavour (older)',
            ],
            [
                'name'  => 'Amaron Hi-Life Pro 80Ah (DIN80)',
                'sku'   => 'AM-HL-80',
                'brand' => $amaron, 'category' => $carCat,
                'capacity_ah' => 80, 'voltage' => 12, 'warranty_months' => 55,
                'price' => 10500, 'offer_price' => 9299,
                'short_description' => 'Amaron 80Ah DIN80 with 55-month warranty — proven SUV/diesel battery.',
                'exchange_available' => true, 'exchange_discount' => 900,
                'stock_quantity' => 25, 'is_featured' => true,
                'fits' => 'Mahindra XUV500 · Tata Safari · Toyota Innova · Ford Endeavour',
            ],
            [
                'name'  => 'SF Sonic FSF0-DIN80 80Ah',
                'sku'   => 'SF-DIN-80',
                'brand' => $sfSonic, 'category' => $carCat,
                'capacity_ah' => 80, 'voltage' => 12, 'warranty_months' => 48,
                'price' => 10200, 'offer_price' => 8999,
                'short_description' => 'SF Sonic 80Ah DIN80 — value option for SUVs and diesel MPVs.',
                'exchange_available' => true, 'exchange_discount' => 800,
                'stock_quantity' => 20, 'is_featured' => false,
                'fits' => 'Mahindra Scorpio · Tata Safari · Toyota Innova · Bolero',
            ],

            // ─── LUXURY / PREMIUM SUV (100 Ah) ─────────────────────────────────────
            [
                'name'  => 'Amaron Hi-Life 100Ah (DIN100)',
                'sku'   => 'AM-HL-100',
                'brand' => $amaron, 'category' => $carCat,
                'capacity_ah' => 100, 'voltage' => 12, 'warranty_months' => 55,
                'price' => 12800, 'offer_price' => 11499,
                'short_description' => 'Amaron 100Ah DIN100 — luxury SUV / premium diesel battery, 55-month warranty.',
                'exchange_available' => true, 'exchange_discount' => 1000,
                'stock_quantity' => 15, 'is_featured' => true,
                'fits' => 'Toyota Fortuner · Ford Endeavour · Skoda Superb · Hyundai Elantra · MG Gloster',
            ],
            [
                'name'  => 'Exide MI-DIN100 100Ah',
                'sku'   => 'EX-MI-100',
                'brand' => $exide, 'category' => $carCat,
                'capacity_ah' => 100, 'voltage' => 12, 'warranty_months' => 55,
                'price' => 13200, 'offer_price' => 11899,
                'short_description' => 'Exide Mileage 100Ah DIN100 — trusted premium-vehicle battery.',
                'exchange_available' => true, 'exchange_discount' => 1000,
                'stock_quantity' => 15, 'is_featured' => false,
                'fits' => 'Toyota Fortuner · Ford Endeavour · Skoda Superb · Audi A4',
            ],

            // ─── COMMERCIAL / MUV (120 Ah) ─────────────────────────────────────────
            [
                'name'  => 'Exide MI-DIN120 120Ah',
                'sku'   => 'EX-MI-120',
                'brand' => $exide, 'category' => $carCat,
                'capacity_ah' => 120, 'voltage' => 12, 'warranty_months' => 55,
                'price' => 15200, 'offer_price' => 13799,
                'short_description' => 'Exide 120Ah DIN120 — heavy-duty for Innova Crysta diesel, tempos, and large MUVs.',
                'exchange_available' => true, 'exchange_discount' => 1000,
                'stock_quantity' => 12, 'is_featured' => false,
                'fits' => 'Toyota Innova Crysta (diesel) · Tata Xenon · Mahindra Tempo · Force Traveller',
            ],

            // ─── BIKES ─────────────────────────────────────────────────────────────
            [
                'name'  => 'Amaron Pro Bike Rider 5Ah',
                'sku'   => 'AM-BIKE-5',
                'brand' => $amaron, 'category' => $bikeCat,
                'capacity_ah' => 5, 'voltage' => 12, 'warranty_months' => 30,
                'price' => 1650, 'offer_price' => 1399,
                'short_description' => 'Sealed maintenance-free battery for scooters and 100-125cc bikes.',
                'exchange_available' => true, 'exchange_discount' => 150,
                'stock_quantity' => 50, 'is_featured' => false,
                'fits' => 'Honda Activa · TVS Jupiter · Hero Splendor · Bajaj Platina · Yamaha Fascino',
            ],
            [
                'name'  => 'Exide MotoMatic 9Ah',
                'sku'   => 'EX-MOTO-9',
                'brand' => $exide, 'category' => $bikeCat,
                'capacity_ah' => 9, 'voltage' => 12, 'warranty_months' => 36,
                'price' => 2400, 'offer_price' => 1999,
                'short_description' => 'Higher-capacity bike battery with strong cranking for 150-200cc motorcycles.',
                'exchange_available' => true, 'exchange_discount' => 200,
                'stock_quantity' => 40, 'is_featured' => true,
                'fits' => 'Bajaj Pulsar 150-220 · TVS Apache RTR 160-200 · Honda Unicorn · Hero Xtreme',
            ],
        ];

        // Retire any stale product not in the canonical SKU list.
        // Clean up child rows first; if the product is FK-referenced by orders,
        // deactivate + rename its slug so it can't collide with new products.
        $canonical = array_column($products, 'sku');
        foreach (Product::whereNotIn('sku', $canonical)->get() as $stale) {
            \App\Models\ProductImage::where('product_id', $stale->id)->delete();
            \App\Models\ProductSpecification::where('product_id', $stale->id)->delete();
            \App\Models\Fitment::where('product_id', $stale->id)->delete();
            if (class_exists(\App\Models\CartItem::class)) {
                \App\Models\CartItem::where('product_id', $stale->id)->delete();
            }
            try {
                $stale->delete();
            } catch (Throwable) {
                $stale->update([
                    'is_active' => false,
                    'sku'  => $stale->sku . '-retired-' . $stale->id,
                    'slug' => $stale->slug . '-retired-' . $stale->id,
                ]);
            }
        }

        foreach ($products as $data) {
            if (! $data['brand']) {
                continue;
            }

            $description = sprintf(
                '<p>%s</p><p><strong>Fits:</strong> %s.</p><p>Genuine product with full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',
                $data['short_description'],
                $data['fits'],
            );

            $product = Product::updateOrCreate(
                ['sku' => $data['sku']],
                [
                    'battery_brand_id'    => $data['brand']->id,
                    'category_id'         => $data['category']?->id,
                    'name'                => $data['name'],
                    'slug'                => Str::slug($data['name']),
                    'capacity_ah'         => $data['capacity_ah'],
                    'voltage'             => $data['voltage'],
                    'warranty_months'     => $data['warranty_months'],
                    'price'               => $data['price'],
                    'offer_price'         => $data['offer_price'],
                    'short_description'   => $data['short_description'],
                    'description'         => $description,
                    'exchange_available'  => $data['exchange_available'],
                    'exchange_discount'   => $data['exchange_discount'],
                    'stock_quantity'      => $data['stock_quantity'],
                    'is_featured'         => $data['is_featured'],
                    'is_active'           => true,
                ],
            );

            ProductImage::updateOrCreate(
                ['product_id' => $product->id, 'path' => 'products/placeholder.svg'],
                ['alt' => $product->name, 'sort_order' => 0, 'is_primary' => true],
            );

            $specs = [
                ['Battery',  'Capacity',        $product->capacity_ah . ' Ah'],
                ['Battery',  'Voltage',         $product->voltage . ' V'],
                ['Battery',  'Type',            'Maintenance-Free (MF) · Sealed Lead Acid'],
                ['Warranty', 'Warranty Period', $product->warranty_months . ' months'],
                ['Warranty', 'Coverage',        'Full manufacturer warranty · we handle claims'],
                ['Delivery', 'Availability',    'Mumbai · Thane · Navi Mumbai'],
                ['Delivery', 'Installation',    'Free on-site installation'],
                ['Delivery', 'Old battery',     $data['exchange_available'] ? '₹' . number_format($data['exchange_discount']) . ' off on exchange' : 'Exchange not offered'],
            ];

            // Refresh specs to keep the list clean (avoids duplicates if keys renamed)
            ProductSpecification::where('product_id', $product->id)->delete();
            foreach ($specs as $i => [$group, $key, $value]) {
                ProductSpecification::create([
                    'product_id' => $product->id,
                    'group'      => $group,
                    'key'        => $key,
                    'value'      => $value,
                    'sort_order' => $i + 1,
                ]);
            }
        }

        // Fitments (attach every car product to every seeded car variant, etc.)
        $carProducts  = Product::whereHas('category', fn ($q) => $q->where('slug', 'car-batteries'))->get();
        $bikeProducts = Product::whereHas('category', fn ($q) => $q->where('slug', 'bike-batteries'))->get();

        $carVariants  = VehicleVariant::whereHas('vehicleModel.vehicleType', fn ($q) => $q->where('slug', 'car'))->get();
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
