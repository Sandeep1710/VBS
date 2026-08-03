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
 * Trikuti Battery catalog — 70Ah – 120Ah range across 5 brands.
 * Prices are typical 2024-2025 Indian market retail with exchange offer.
 * Update via /admin/products once supplier prices are confirmed.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $carCat  = Category::where('slug', 'car-batteries')->first();
        $exide     = BatteryBrand::where('slug', 'exide')->first();
        $amaron    = BatteryBrand::where('slug', 'amaron')->first();
        $sfSonic   = BatteryBrand::where('slug', 'sf-sonic')->first();
        $luminous  = BatteryBrand::where('slug', 'luminous')->first();
        $bosch     = BatteryBrand::where('slug', 'bosch')->first();

        $products = [
            // ─── 70 Ah — Compact SUVs / mid-large sedans ───────────────────────────
            [
                'name' => 'Exide Matrix MI-DIN70 70Ah', 'sku' => 'EX-MTX-70',
                'brand' => $exide, 'capacity_ah' => 70, 'warranty_months' => 48,
                'price' => 10000, 'offer_price' => 8899, 'exchange_discount' => 800,
                'stock_quantity' => 20, 'is_featured' => false,
                'short_description' => 'Exide Matrix 70Ah DIN70 — reliable European-standard battery for compact SUVs.',
                'fits' => 'Ford Ecosport (older) · Renault Duster · Nissan Terrano · Tata Hexa (petrol)',
            ],
            [
                'name' => 'Amaron Hi-Life 70Ah (DIN70)', 'sku' => 'AM-HL-70',
                'brand' => $amaron, 'capacity_ah' => 70, 'warranty_months' => 48,
                'price' => 9800, 'offer_price' => 8699, 'exchange_discount' => 800,
                'stock_quantity' => 20, 'is_featured' => false,
                'short_description' => 'Amaron 70Ah DIN70 — long-life SUV battery with 48-month warranty.',
                'fits' => 'Renault Duster · Nissan Terrano · Ford Ecosport · Tata Hexa',
            ],
            [
                'name' => 'SF Sonic FSF0-DIN70 70Ah', 'sku' => 'SF-DIN-70',
                'brand' => $sfSonic, 'capacity_ah' => 70, 'warranty_months' => 42,
                'price' => 9400, 'offer_price' => 8299, 'exchange_discount' => 700,
                'stock_quantity' => 15, 'is_featured' => false,
                'short_description' => 'SF Sonic 70Ah DIN70 — value SUV battery, Exide-backed reliability.',
                'fits' => 'Renault Duster · Ford Ecosport · Nissan Terrano · Tata Hexa',
            ],
            [
                'name' => 'Luminous Car Batz 70Ah', 'sku' => 'LM-CB-70',
                'brand' => $luminous, 'capacity_ah' => 70, 'warranty_months' => 42,
                'price' => 9200, 'offer_price' => 8199, 'exchange_discount' => 700,
                'stock_quantity' => 15, 'is_featured' => false,
                'short_description' => 'Luminous Car Batz 70Ah — durable maintenance-free battery for compact SUVs.',
                'fits' => 'Renault Duster · Nissan Terrano · Ford Ecosport · Tata Hexa',
            ],
            [
                'name' => 'Bosch S4 70Ah', 'sku' => 'BO-S4-70',
                'brand' => $bosch, 'capacity_ah' => 70, 'warranty_months' => 48,
                'price' => 10200, 'offer_price' => 8999, 'exchange_discount' => 800,
                'stock_quantity' => 12, 'is_featured' => false,
                'short_description' => 'Bosch S4 70Ah — German engineering, top-tier calcium technology for extended life.',
                'fits' => 'Renault Duster · Nissan Terrano · Ford Ecosport · Tata Hexa · VW Polo',
            ],

            // ─── 75 Ah — SUVs (Creta, Seltos, Nexon segment) ───────────────────────
            [
                'name' => 'Exide MP-DIN75 75Ah', 'sku' => 'EX-MP-75',
                'brand' => $exide, 'capacity_ah' => 75, 'warranty_months' => 55,
                'price' => 10500, 'offer_price' => 9299, 'exchange_discount' => 900,
                'stock_quantity' => 25, 'is_featured' => false,
                'short_description' => 'Exide Marathon Plus 75Ah DIN75 — heavy-duty for popular SUVs.',
                'fits' => 'Hyundai Creta · Kia Seltos · Tata Nexon · Mahindra XUV300 · MG Astor',
            ],
            [
                'name' => 'Amaron Hi-Life Pro 75Ah (DIN75)', 'sku' => 'AM-HL-75',
                'brand' => $amaron, 'capacity_ah' => 75, 'warranty_months' => 55,
                'price' => 10300, 'offer_price' => 9099, 'exchange_discount' => 900,
                'stock_quantity' => 30, 'is_featured' => true,
                'short_description' => 'Amaron 75Ah DIN75 with 55-month warranty — proven SUV battery.',
                'fits' => 'Hyundai Creta · Kia Seltos · Tata Nexon · Ford Ecosport · MG Hector',
            ],
            [
                'name' => 'SF Sonic FSF0-DIN75 75Ah', 'sku' => 'SF-DIN-75',
                'brand' => $sfSonic, 'capacity_ah' => 75, 'warranty_months' => 48,
                'price' => 9900, 'offer_price' => 8699, 'exchange_discount' => 800,
                'stock_quantity' => 20, 'is_featured' => false,
                'short_description' => 'SF Sonic 75Ah DIN75 — Exide-backed value pick for SUVs.',
                'fits' => 'Hyundai Creta · Kia Seltos · Tata Nexon · Renault Duster',
            ],
            [
                'name' => 'Luminous Car Batz 75Ah', 'sku' => 'LM-CB-75',
                'brand' => $luminous, 'capacity_ah' => 75, 'warranty_months' => 48,
                'price' => 9700, 'offer_price' => 8499, 'exchange_discount' => 800,
                'stock_quantity' => 18, 'is_featured' => false,
                'short_description' => 'Luminous 75Ah — maintenance-free SUV battery.',
                'fits' => 'Hyundai Creta · Kia Seltos · Tata Nexon · Mahindra XUV300',
            ],
            [
                'name' => 'Bosch S4 75Ah', 'sku' => 'BO-S4-75',
                'brand' => $bosch, 'capacity_ah' => 75, 'warranty_months' => 55,
                'price' => 10700, 'offer_price' => 9499, 'exchange_discount' => 900,
                'stock_quantity' => 15, 'is_featured' => false,
                'short_description' => 'Bosch S4 75Ah — premium German-engineered SUV battery.',
                'fits' => 'Hyundai Creta · Kia Seltos · Tata Nexon · VW Vento · Skoda Rapid',
            ],

            // ─── 80 Ah — Innova / Fortuner / Bolero / Endeavour segment ────────────
            [
                'name' => 'Exide MP-DIN80 80Ah', 'sku' => 'EX-MP-80',
                'brand' => $exide, 'capacity_ah' => 80, 'warranty_months' => 55,
                'price' => 10800, 'offer_price' => 9599, 'exchange_discount' => 900,
                'stock_quantity' => 30, 'is_featured' => true,
                'short_description' => 'Exide Marathon Plus 80Ah — heavy-duty for Innova, Fortuner, Bolero.',
                'fits' => 'Toyota Innova · Toyota Fortuner (older) · Mahindra Bolero · Ford Endeavour (older)',
            ],
            [
                'name' => 'Amaron Hi-Life Pro 80Ah (DIN80)', 'sku' => 'AM-HL-80',
                'brand' => $amaron, 'capacity_ah' => 80, 'warranty_months' => 55,
                'price' => 10500, 'offer_price' => 9299, 'exchange_discount' => 900,
                'stock_quantity' => 30, 'is_featured' => true,
                'short_description' => 'Amaron 80Ah DIN80 with 55-month warranty — proven SUV/diesel battery.',
                'fits' => 'Mahindra XUV500 · Tata Safari · Toyota Innova · Ford Endeavour',
            ],
            [
                'name' => 'SF Sonic FSF0-DIN80 80Ah', 'sku' => 'SF-DIN-80',
                'brand' => $sfSonic, 'capacity_ah' => 80, 'warranty_months' => 48,
                'price' => 10200, 'offer_price' => 8999, 'exchange_discount' => 800,
                'stock_quantity' => 25, 'is_featured' => false,
                'short_description' => 'SF Sonic 80Ah DIN80 — value option for SUVs and diesel MPVs.',
                'fits' => 'Mahindra Scorpio · Tata Safari · Toyota Innova · Bolero',
            ],
            [
                'name' => 'Luminous Car Batz 80Ah', 'sku' => 'LM-CB-80',
                'brand' => $luminous, 'capacity_ah' => 80, 'warranty_months' => 48,
                'price' => 9900, 'offer_price' => 8799, 'exchange_discount' => 800,
                'stock_quantity' => 20, 'is_featured' => false,
                'short_description' => 'Luminous 80Ah — durable SUV battery.',
                'fits' => 'Mahindra Scorpio · Tata Safari · Toyota Innova · Bolero',
            ],
            [
                'name' => 'Bosch S4 80Ah', 'sku' => 'BO-S4-80',
                'brand' => $bosch, 'capacity_ah' => 80, 'warranty_months' => 55,
                'price' => 11000, 'offer_price' => 9799, 'exchange_discount' => 900,
                'stock_quantity' => 15, 'is_featured' => false,
                'short_description' => 'Bosch S4 80Ah — reliable German engineering for large SUVs.',
                'fits' => 'Mahindra XUV500 · Toyota Innova · Ford Endeavour · Skoda Superb',
            ],

            // ─── 90 Ah — Larger diesel SUVs ────────────────────────────────────────
            [
                'name' => 'Exide Matrix MI-DIN90 90Ah', 'sku' => 'EX-MTX-90',
                'brand' => $exide, 'capacity_ah' => 90, 'warranty_months' => 55,
                'price' => 11900, 'offer_price' => 10499, 'exchange_discount' => 1000,
                'stock_quantity' => 18, 'is_featured' => false,
                'short_description' => 'Exide 90Ah DIN90 — high-capacity for premium diesel SUVs.',
                'fits' => 'Hyundai Tucson · Jeep Compass · Skoda Kodiaq · VW Tiguan',
            ],
            [
                'name' => 'Amaron Hi-Life 90Ah (DIN90)', 'sku' => 'AM-HL-90',
                'brand' => $amaron, 'capacity_ah' => 90, 'warranty_months' => 55,
                'price' => 11700, 'offer_price' => 10299, 'exchange_discount' => 1000,
                'stock_quantity' => 18, 'is_featured' => false,
                'short_description' => 'Amaron 90Ah DIN90 — premium SUV battery with 55-month warranty.',
                'fits' => 'Hyundai Tucson · Jeep Compass · Volvo XC40 · Skoda Kodiaq',
            ],
            [
                'name' => 'SF Sonic FSF0-DIN90 90Ah', 'sku' => 'SF-DIN-90',
                'brand' => $sfSonic, 'capacity_ah' => 90, 'warranty_months' => 48,
                'price' => 11200, 'offer_price' => 9899, 'exchange_discount' => 900,
                'stock_quantity' => 15, 'is_featured' => false,
                'short_description' => 'SF Sonic 90Ah DIN90 — value premium-SUV battery.',
                'fits' => 'Hyundai Tucson · Jeep Compass · Skoda Kodiaq',
            ],
            [
                'name' => 'Luminous Car Batz 90Ah', 'sku' => 'LM-CB-90',
                'brand' => $luminous, 'capacity_ah' => 90, 'warranty_months' => 48,
                'price' => 10800, 'offer_price' => 9599, 'exchange_discount' => 900,
                'stock_quantity' => 15, 'is_featured' => false,
                'short_description' => 'Luminous 90Ah — maintenance-free for large diesel SUVs.',
                'fits' => 'Hyundai Tucson · Jeep Compass · Skoda Kodiaq',
            ],
            [
                'name' => 'Bosch S4 90Ah', 'sku' => 'BO-S4-90',
                'brand' => $bosch, 'capacity_ah' => 90, 'warranty_months' => 55,
                'price' => 12100, 'offer_price' => 10699, 'exchange_discount' => 1000,
                'stock_quantity' => 12, 'is_featured' => false,
                'short_description' => 'Bosch S4 90Ah — high-performance battery for premium European SUVs.',
                'fits' => 'Jeep Compass · VW Tiguan · Skoda Kodiaq · Audi Q3 · BMW X1',
            ],

            // ─── 100 Ah — Luxury SUV / premium sedan ───────────────────────────────
            [
                'name' => 'Exide MI-DIN100 100Ah', 'sku' => 'EX-MI-100',
                'brand' => $exide, 'capacity_ah' => 100, 'warranty_months' => 55,
                'price' => 13200, 'offer_price' => 11899, 'exchange_discount' => 1000,
                'stock_quantity' => 20, 'is_featured' => true,
                'short_description' => 'Exide 100Ah DIN100 — trusted premium-vehicle battery.',
                'fits' => 'Toyota Fortuner · Ford Endeavour · Skoda Superb · Audi A4',
            ],
            [
                'name' => 'Amaron Hi-Life 100Ah (DIN100)', 'sku' => 'AM-HL-100',
                'brand' => $amaron, 'capacity_ah' => 100, 'warranty_months' => 55,
                'price' => 12800, 'offer_price' => 11499, 'exchange_discount' => 1000,
                'stock_quantity' => 20, 'is_featured' => true,
                'short_description' => 'Amaron 100Ah DIN100 — luxury SUV / premium diesel battery, 55-month warranty.',
                'fits' => 'Toyota Fortuner · Ford Endeavour · Skoda Superb · Hyundai Elantra · MG Gloster',
            ],
            [
                'name' => 'SF Sonic FSF0-DIN100 100Ah', 'sku' => 'SF-DIN-100',
                'brand' => $sfSonic, 'capacity_ah' => 100, 'warranty_months' => 48,
                'price' => 12300, 'offer_price' => 10899, 'exchange_discount' => 900,
                'stock_quantity' => 18, 'is_featured' => false,
                'short_description' => 'SF Sonic 100Ah DIN100 — value luxury-SUV battery.',
                'fits' => 'Toyota Fortuner · Ford Endeavour · Skoda Superb · Hyundai Elantra',
            ],
            [
                'name' => 'Luminous Car Batz 100Ah', 'sku' => 'LM-CB-100',
                'brand' => $luminous, 'capacity_ah' => 100, 'warranty_months' => 48,
                'price' => 11900, 'offer_price' => 10499, 'exchange_discount' => 900,
                'stock_quantity' => 15, 'is_featured' => false,
                'short_description' => 'Luminous 100Ah — reliable for luxury SUVs and premium sedans.',
                'fits' => 'Toyota Fortuner · Ford Endeavour · Skoda Superb · MG Gloster',
            ],
            [
                'name' => 'Bosch S5 100Ah', 'sku' => 'BO-S5-100',
                'brand' => $bosch, 'capacity_ah' => 100, 'warranty_months' => 60,
                'price' => 13500, 'offer_price' => 11999, 'exchange_discount' => 1100,
                'stock_quantity' => 12, 'is_featured' => false,
                'short_description' => 'Bosch S5 100Ah — top-tier silver-calcium technology, 60-month warranty.',
                'fits' => 'Toyota Fortuner · Ford Endeavour · Audi A6 · BMW 5 Series · Mercedes E-Class',
            ],

            // ─── 120 Ah — Innova Crysta diesel / Tempo / MUV ───────────────────────
            [
                'name' => 'Exide MI-DIN120 120Ah', 'sku' => 'EX-MI-120',
                'brand' => $exide, 'capacity_ah' => 120, 'warranty_months' => 55,
                'price' => 15200, 'offer_price' => 13799, 'exchange_discount' => 1100,
                'stock_quantity' => 15, 'is_featured' => true,
                'short_description' => 'Exide 120Ah DIN120 — heavy-duty for Innova Crysta diesel, tempos, and large MUVs.',
                'fits' => 'Toyota Innova Crysta (diesel) · Tata Xenon · Mahindra Tempo · Force Traveller',
            ],
            [
                'name' => 'Amaron Hi-Life 120Ah (DIN120)', 'sku' => 'AM-HL-120',
                'brand' => $amaron, 'capacity_ah' => 120, 'warranty_months' => 55,
                'price' => 14900, 'offer_price' => 13499, 'exchange_discount' => 1100,
                'stock_quantity' => 15, 'is_featured' => false,
                'short_description' => 'Amaron 120Ah DIN120 — 55-month warranty, heavy-duty MUV/tempo battery.',
                'fits' => 'Toyota Innova Crysta · Tata Xenon · Mahindra Tempo · Force Traveller',
            ],
            [
                'name' => 'SF Sonic FSF0-DIN120 120Ah', 'sku' => 'SF-DIN-120',
                'brand' => $sfSonic, 'capacity_ah' => 120, 'warranty_months' => 48,
                'price' => 14400, 'offer_price' => 12999, 'exchange_discount' => 1000,
                'stock_quantity' => 12, 'is_featured' => false,
                'short_description' => 'SF Sonic 120Ah DIN120 — value pick for Innova Crysta and tempos.',
                'fits' => 'Toyota Innova Crysta · Tata Xenon · Force Traveller',
            ],
            [
                'name' => 'Luminous Car Batz 120Ah', 'sku' => 'LM-CB-120',
                'brand' => $luminous, 'capacity_ah' => 120, 'warranty_months' => 48,
                'price' => 13900, 'offer_price' => 12499, 'exchange_discount' => 1000,
                'stock_quantity' => 12, 'is_featured' => false,
                'short_description' => 'Luminous 120Ah — durable MUV/tempo battery.',
                'fits' => 'Toyota Innova Crysta · Tata Xenon · Mahindra Tempo',
            ],
            [
                'name' => 'Bosch S5 120Ah', 'sku' => 'BO-S5-120',
                'brand' => $bosch, 'capacity_ah' => 120, 'warranty_months' => 60,
                'price' => 15700, 'offer_price' => 14199, 'exchange_discount' => 1200,
                'stock_quantity' => 10, 'is_featured' => false,
                'short_description' => 'Bosch S5 120Ah — premium silver-calcium heavy-duty battery, 60-month warranty.',
                'fits' => 'Toyota Innova Crysta · Force Traveller · Tempo Traveller · Mercedes Sprinter',
            ],
        ];

        // Retire any product not in the canonical SKU list
        $canonical = array_column($products, 'sku');
        foreach (Product::whereNotIn('sku', $canonical)->get() as $stale) {
            ProductImage::where('product_id', $stale->id)->delete();
            ProductSpecification::where('product_id', $stale->id)->delete();
            Fitment::where('product_id', $stale->id)->delete();
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
                continue; // brand not seeded — skip gracefully
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
                    'category_id'         => $carCat?->id,
                    'name'                => $data['name'],
                    'slug'                => Str::slug($data['name']),
                    'capacity_ah'         => $data['capacity_ah'],
                    'voltage'             => 12,
                    'warranty_months'     => $data['warranty_months'],
                    'price'               => $data['price'],
                    'offer_price'         => $data['offer_price'],
                    'short_description'   => $data['short_description'],
                    'description'         => $description,
                    'exchange_available'  => true,
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
                ['Delivery', 'Old battery',     '₹' . number_format($data['exchange_discount']) . ' off on exchange'],
            ];

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

        // Fitments — every car product attaches to every car variant
        $carProducts  = Product::whereHas('category', fn ($q) => $q->where('slug', 'car-batteries'))->get();
        $carVariants  = VehicleVariant::whereHas('vehicleModel.vehicleType', fn ($q) => $q->where('slug', 'car'))->get();

        foreach ($carProducts as $product) {
            foreach ($carVariants as $variant) {
                Fitment::updateOrCreate(
                    ['product_id' => $product->id, 'vehicle_variant_id' => $variant->id],
                    ['is_recommended' => false],
                );
            }
        }
    }
}
