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
 * Trikuti Battery catalog — 70Ah – 120Ah range.
 *
 * SKU codes and MRP prices are pulled from the official manufacturer MRCP PDFs
 * (see storage/app/public/catalogs/):
 *   - Exide MRCP dated 1 June 2026
 *   - SF Batteries MRCP dated 10 June 2026
 * Amaron entries use street-price data from batterybhai.com (no public MRP).
 *
 * Offer prices are set at typical Mumbai dealer/street discount (~20-30% off MRP).
 * Update via /admin/products once your distributor confirms wholesale pricing.
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Vehicle-class categories (see CategorySeeder).
        $car   = Category::where('slug', 'car-batteries')->first();
        $tempo = Category::where('slug', 'tempo-batteries')->first();
        // Bike + Truck categories exist but are inactive — no products yet.

        $exide  = BatteryBrand::where('slug', 'exide')->first();
        $amaron = BatteryBrand::where('slug', 'amaron')->first();
        // SF Sonic retired — see BatteryBrandSeeder

        /**
         * Assign category by vehicle class:
         *   - Exide Xpress (XP series) + Amaron Hi-Way (HW) = commercial → Tempo
         *   - Everything else (44-100Ah personal-car batteries) → Car
         */
        $categoryFor = function (int $ah, string $sku) use ($car, $tempo) {
            if (str_starts_with($sku, 'EX-XP') || str_starts_with($sku, 'AM-HW')) return $tempo;
            if ($ah > 100) return $tempo;
            return $car;
        };

        $products = [
            // ═══════════════════════════════════════════════════════════════════════
            // 44 Ah — Small hatchbacks (WagonR, Datsun, small compacts)
            // ═══════════════════════════════════════════════════════════════════════
            [
                'name' => 'Exide Mileage MLDIN44 44Ah',
                'sku'  => 'EX-MLDIN44',
                'brand' => $exide, 'capacity_ah' => 44, 'warranty_months' => 60,
                'price' => 6499, 'offer_price' => null, 'exchange_discount' => 400,
                'stock_quantity' => 20, 'is_featured' => false,
                'short_description' => 'Exide Mileage 44Ah DIN44 — reliable low-maintenance battery for small hatchbacks. 60-month warranty (30+30).',
                'fits' => 'Maruti Wagon R · Datsun Redi-Go · Renault Triber · Datsun GO · small compacts',
            ],

            // ═══════════════════════════════════════════════════════════════════════
            // 45 Ah — Compact cars (Swift, i10, Baleno, Kwid Climber)
            // ═══════════════════════════════════════════════════════════════════════
            [
                'name' => 'Amaron Hi-Life 45Ah',
                'sku'  => 'AM-HL-45',
                'brand' => $amaron, 'capacity_ah' => 45, 'warranty_months' => 60,
                'price' => 5999, 'offer_price' => null, 'exchange_discount' => 400,
                'stock_quantity' => 25, 'is_featured' => true,
                'short_description' => 'Amaron Hi-Life 45Ah — proven long-life battery for compact hatchbacks and small sedans.',
                'fits' => 'Maruti Swift · Hyundai Grand i10 · Ford Figo · Renault Kwid Climber · Nissan Micra',
            ],

            [
                'name' => 'Exide Mileage ML45D21LBH 45Ah',
                'sku'  => 'EX-ML45D21LBH',
                'brand' => $exide, 'capacity_ah' => 45, 'warranty_months' => 60,
                'price' => 6499, 'offer_price' => null, 'exchange_discount' => 400,
                'stock_quantity' => 20, 'is_featured' => false,
                'short_description' => 'Exide Mileage 45Ah (JIS ML45D21) — 60-month warranty option for compact cars.',
                'fits' => 'Maruti Swift · Hyundai Grand i10 · Ford Figo · Nissan Micra · Kwid Climber',
            ],

            // ═══════════════════════════════════════════════════════════════════════
            // 55 Ah — Mid hatchbacks / compact sedans
            // ═══════════════════════════════════════════════════════════════════════
            [
                'name' => 'Exide Mileage MLDIN55 55Ah',
                'sku'  => 'EX-MLDIN55',
                'brand' => $exide, 'capacity_ah' => 55, 'warranty_months' => 60,
                'price' => 7999, 'offer_price' => null, 'exchange_discount' => 450,
                'stock_quantity' => 20, 'is_featured' => true,
                'short_description' => 'Exide Mileage 55Ah DIN55 — mid-range workhorse for Baleno, Etios, Tigor segment.',
                'fits' => 'Maruti Baleno · Toyota Etios · Hyundai Xcent · Tata Tigor · Hyundai i20',
            ],

            // ═══════════════════════════════════════════════════════════════════════
            // 65 Ah — Mid sedans (City, Verna, Ciaz, Rapid, Vento)
            // ═══════════════════════════════════════════════════════════════════════
            [
                'name' => 'Amaron Hi-Life DIN65 65Ah',
                'sku'  => 'AM-HL-DIN65',
                'brand' => $amaron, 'capacity_ah' => 65, 'warranty_months' => 60,
                'price' => 7499, 'offer_price' => null, 'exchange_discount' => 500,
                'stock_quantity' => 20, 'is_featured' => false,
                'short_description' => 'Amaron Hi-Life 65Ah DIN65 — dependable battery for mid-size sedans with 60-month warranty.',
                'fits' => 'Honda City · Hyundai Verna · Skoda Rapid · VW Vento · Maruti Ciaz',
            ],

            [
                'name' => 'Exide Mileage MLDIN66 66Ah',
                'sku'  => 'EX-MLDIN66',
                'brand' => $exide, 'capacity_ah' => 66, 'warranty_months' => 60,
                'price' => 7999, 'offer_price' => null, 'exchange_discount' => 500,
                'stock_quantity' => 20, 'is_featured' => false,
                'short_description' => 'Exide Mileage 66Ah DIN66 — 60-month warranty option for mid-size sedans.',
                'fits' => 'Honda City · Hyundai Verna · Skoda Rapid · VW Vento · Maruti Ciaz',
            ],

            // ═══════════════════════════════════════════════════════════════════════
            // 70 Ah — Compact SUVs / mid-large sedans
            // ═══════════════════════════════════════════════════════════════════════
            [
                'name' => 'Exide Mileage MLDIN70(ISS) 70Ah',
                'sku'  => 'EX-MLDIN70-ISS',
                'brand' => $exide, 'capacity_ah' => 70, 'warranty_months' => 60,
                'price' => 9099, 'offer_price' => null, 'exchange_discount' => 500,
                'stock_quantity' => 20, 'is_featured' => false,
                'short_description' => 'Exide Mileage ISS 70Ah — for Idle Stop-Start vehicles. 60-month warranty (30+30).',
                'fits' => 'Renault Duster · Nissan Terrano · Ford Ecosport · Tata Hexa · start-stop vehicles',
            ],
            [
                'name' => 'Amaron Hi-Life Pro DIN70 70Ah',
                'sku'  => 'AM-HL-DIN70',
                'brand' => $amaron, 'capacity_ah' => 70, 'warranty_months' => 48,
                'price' => 8799, 'offer_price' => null, 'exchange_discount' => 500,
                'stock_quantity' => 20, 'is_featured' => false,
                'short_description' => 'Amaron 70Ah DIN70 — long-life SUV battery with 48-month warranty.',
                'fits' => 'Renault Duster · Nissan Terrano · Ford Ecosport · Tata Hexa',
            ],

            // ═══════════════════════════════════════════════════════════════════════
            // 74 Ah — Premium mid-sedan (Honda City, Verna DINi74)
            // ═══════════════════════════════════════════════════════════════════════
            [
                'name' => 'Exide EPIQ DIN74L 74Ah',
                'sku'  => 'EX-EPIQ-DIN74L',
                'brand' => $exide, 'capacity_ah' => 74, 'warranty_months' => 77,
                'price' => 12099, 'offer_price' => null, 'exchange_discount' => 550,
                'stock_quantity' => 12, 'is_featured' => true,
                'short_description' => 'Exide EPIQ — premium DIN74L with class-leading 77-month warranty (42+35).',
                'fits' => 'Honda City · Hyundai Verna · Skoda Rapid · VW Vento · premium sedans',
            ],
            [
                'name' => 'Amaron Pro 574102069 74Ah',
                'sku'  => 'AM-PR-574102069',
                'brand' => $amaron, 'capacity_ah' => 74, 'warranty_months' => 66,
                'price' => 9399, 'offer_price' => null, 'exchange_discount' => 550,
                'stock_quantity' => 15, 'is_featured' => false,
                'short_description' => 'Amaron Pro 74Ah — 66-month warranty (36+30), silver-alloy technology.',
                'fits' => 'Honda City · Hyundai Verna · Skoda Rapid · VW Vento',
            ],

            // ═══════════════════════════════════════════════════════════════════════
            // 80 Ah — Innova / Fortuner (older) / Bolero / Endeavour segment
            // ═══════════════════════════════════════════════════════════════════════
            [
                'name' => 'Exide Mileage MLDIN80 80Ah',
                'sku'  => 'EX-MLDIN80',
                'brand' => $exide, 'capacity_ah' => 80, 'warranty_months' => 60,
                'price' => 11399, 'offer_price' => null, 'exchange_discount' => 600,
                'stock_quantity' => 25, 'is_featured' => true,
                'short_description' => 'Exide Mileage 80Ah DIN80 — trusted 60-month workhorse for large SUVs.',
                'fits' => 'Toyota Innova · Toyota Fortuner (older) · Ford Endeavour · Mahindra XUV500',
            ],
            [
                'name' => 'Exide Drive DRIVE80L 80Ah',
                'sku'  => 'EX-DRIVE80L',
                'brand' => $exide, 'capacity_ah' => 80, 'warranty_months' => 36,
                'price' => 6399, 'offer_price' => null, 'exchange_discount' => 600,
                'stock_quantity' => 20, 'is_featured' => false,
                'short_description' => 'Exide Drive 80Ah — budget-friendly 36-month option, dependable performance.',
                'fits' => 'Older Innova · Bolero · older diesel SUVs',
            ],
            [
                'name' => 'Amaron FL-580112073 80Ah',
                'sku'  => 'AM-FL-580112073',
                'brand' => $amaron, 'capacity_ah' => 80, 'warranty_months' => 60,
                'price' => 8999, 'offer_price' => null, 'exchange_discount' => 600,
                'stock_quantity' => 25, 'is_featured' => true,
                'short_description' => 'Amaron Hi-Way 80Ah — 60-month warranty (30+30), proven large-SUV battery.',
                'fits' => 'Toyota Innova · Ford Endeavour · Mahindra XUV500 · Tata Safari',
            ],

            // ═══════════════════════════════════════════════════════════════════════
            // 100 Ah — Fortuner / Endeavour / luxury SUV segment
            // ═══════════════════════════════════════════════════════════════════════
            [
                'name' => 'Exide Xpress XP800 100Ah',
                'sku'  => 'EX-XP800',
                'brand' => $exide, 'capacity_ah' => 100, 'warranty_months' => 42,
                'price' => 8099, 'offer_price' => null, 'exchange_discount' => 700,
                'stock_quantity' => 20, 'is_featured' => false,
                'short_description' => 'Exide Xpress 100Ah — commercial-grade heavy-duty battery for tempos and MUVs.',
                'fits' => 'Toyota Innova Crysta · Force Traveller · Tata Xenon · commercial vehicles',
            ],
            [
                'name' => 'Exide Matrix MTREDDIN100 100Ah',
                'sku'  => 'EX-MTRED-DIN100',
                'brand' => $exide, 'capacity_ah' => 100, 'warranty_months' => 72,
                'price' => 18099, 'offer_price' => null, 'exchange_discount' => 700,
                'stock_quantity' => 10, 'is_featured' => true,
                'short_description' => 'Exide Matrix 100Ah — top-tier premium battery with 72-month warranty (36+36).',
                'fits' => 'Toyota Fortuner · Ford Endeavour · Skoda Superb · MG Gloster · Audi A4',
            ],
            [
                'name' => 'Amaron Pro 600109087 100Ah',
                'sku'  => 'AM-PR-600109087',
                'brand' => $amaron, 'capacity_ah' => 100, 'warranty_months' => 66,
                'price' => 14999, 'offer_price' => null, 'exchange_discount' => 700,
                'stock_quantity' => 12, 'is_featured' => true,
                'short_description' => 'Amaron Pro 100Ah — 66-month warranty (36+30), premium SUV / diesel battery.',
                'fits' => 'Toyota Fortuner · Ford Endeavour · Skoda Superb · MG Gloster',
            ],

            // ═══════════════════════════════════════════════════════════════════════
            // 120 Ah — Innova Crysta diesel / Tempo / MUV segment
            // ═══════════════════════════════════════════════════════════════════════
            [
                'name' => 'Exide Xpress XP880 120Ah',
                'sku'  => 'EX-XP880',
                'brand' => $exide, 'capacity_ah' => 120, 'warranty_months' => 42,
                'price' => 11199, 'offer_price' => null, 'exchange_discount' => 700,
                'stock_quantity' => 12, 'is_featured' => true,
                'short_description' => 'Exide Xpress 120Ah — heavy-duty for Innova Crysta diesel, tempos and large MUVs.',
                'fits' => 'Toyota Innova Crysta (diesel) · Tata Xenon · Force Traveller · Mahindra Tempo',
            ],
            [
                'name' => 'Amaron Hi-Way 120Ah DIN120',
                'sku'  => 'AM-HW-DIN120',
                'brand' => $amaron, 'capacity_ah' => 120, 'warranty_months' => 42,
                'price' => 12899, 'offer_price' => null, 'exchange_discount' => 700,
                'stock_quantity' => 10, 'is_featured' => false,
                'short_description' => 'Amaron Hi-Way 120Ah — commercial-grade battery for MUVs and tempos.',
                'fits' => 'Toyota Innova Crysta · Force Traveller · Tempo Traveller · Mahindra Tempo',
            ],
        ];

        // Retire any product not in the canonical SKU list.
        // Clean up child rows first; if FK-blocked by orders, deactivate + rename slug/sku.
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
                continue;
            }

            $description = sprintf(
                '<p>%s</p><p><strong>Fits:</strong> %s.</p><p>Genuine authorised-dealer product. Full manufacturer warranty. Free doorstep delivery in Mumbai, Thane and Navi Mumbai. Old battery exchange discount applied on delivery.</p>',
                $data['short_description'],
                $data['fits'],
            );

            $product = Product::updateOrCreate(
                ['sku' => $data['sku']],
                [
                    'battery_brand_id'    => $data['brand']->id,
                    'category_id'         => $categoryFor((int) $data['capacity_ah'], $data['sku'])?->id,
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

            // Only seed a placeholder image if this product has NO images yet.
            // This prevents reseeds from clobbering real product images uploaded
            // via admin or mapped by the scratchpad/map_product_images.php script.
            if (! ProductImage::where('product_id', $product->id)->exists()) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path'       => 'products/placeholder.svg',
                    'alt'        => $product->name,
                    'sort_order' => 0,
                    'is_primary' => true,
                ]);
            }

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

        // Fitments — every car product attaches to every car variant seeded
        // All active products count as "car products" for fitment purposes
        // (all our vehicle-type categories are variants of car batteries).
        $carProducts = Product::where('is_active', true)->get();
        $carVariants = VehicleVariant::whereHas('vehicleModel.vehicleType', fn ($q) => $q->where('slug', 'car'))->get();

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
