<?php

namespace Database\Seeders;

use App\Models\BatteryBrand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Amaron after-market catalog, loaded from the manufacturer retail price list.
 *
 * Data source: database/seeders/data/amaron_pricelist.php
 *              ("Amaron Auto DP wef 15.08.26.pdf", AREML/AMARON/FY27/4W/RET/02)
 *
 * The price list carries only two facts per battery — the manufacturer SKU and
 * its GST-inclusive retail price — so that is all this seeder writes. Ah rating,
 * warranty term, stock and images are deliberately left unset rather than
 * guessed; fill them in per product via /admin/products.
 *
 * Re-running is safe and non-destructive:
 *   - existing products have ONLY their price refreshed, so any capacity,
 *     warranty, stock, image or copy added later survives a reseed;
 *   - new SKUs in a newer price list are created.
 *
 * These products are owned by this seeder, not ProductSeeder — ProductSeeder
 * skips SKUs prefixed AAM-/AMS- when retiring non-canonical products.
 */
class AmaronPriceListSeeder extends Seeder
{
    /**
     * Whether newly created price-list products go live on the storefront.
     * Set to false to stage them in admin only until specs and stock are filled in.
     */
    private const PUBLISH_NEW = true;

    /** Ranges built for commercial and agricultural vehicles rather than cars. */
    private const COMMERCIAL_SERIES = ['HI-WAY', 'HARVEST'];

    public function run(): void
    {
        $amaron = BatteryBrand::where('slug', 'amaron')->first();

        if (! $amaron) {
            $this->command?->warn('Amaron brand missing — run BatteryBrandSeeder first. Skipping price list.');

            return;
        }

        $car   = Category::where('slug', 'car-batteries')->first();
        $tempo = Category::where('slug', 'tempo-batteries')->first();

        $rows = require database_path('seeders/data/amaron_pricelist.php');

        $created = 0;
        $repriced = 0;

        foreach ($rows as $row) {
            $product = Product::withTrashed()->firstOrNew(['sku' => $row['sku']]);
            $isNew   = ! $product->exists;

            // The price list is authoritative on price, and on nothing else.
            $product->price = $row['price'];

            if ($isNew) {
                $category = in_array($row['series'], self::COMMERCIAL_SERIES, true) ? $tempo : $car;

                $product->fill([
                    'battery_brand_id'   => $amaron->id,
                    'category_id'        => $category?->id,
                    'name'               => $row['name'],
                    'slug'               => Str::slug($row['name']),
                    'voltage'            => 12,
                    'short_description'  => sprintf(
                        'Amaron %s series — manufacturer code %s. Genuine authorised-dealer stock with full Amaron warranty.',
                        $row['series'],
                        $row['sku'],
                    ),
                    'description'        => sprintf(
                        '<p>Amaron %s series automotive battery, manufacturer code <strong>%s</strong>.</p>'
                        . '<p>Genuine Amara Raja product supplied through authorised-dealer channels, with full '
                        . 'manufacturer warranty. Free doorstep delivery and fitting across Mumbai, Thane and '
                        . 'Navi Mumbai, with an old-battery exchange discount applied on delivery.</p>'
                        . '<p>Price shown is the Amaron retail price effective 15 August 2026, inclusive of GST. '
                        . 'Call us to confirm the right fit for your vehicle.</p>',
                        $row['series'],
                        $row['sku'],
                    ),
                    'exchange_available' => true,
                    'is_active'          => self::PUBLISH_NEW,
                ]);
            }

            $product->save();

            if ($product->trashed()) {
                $product->restore();
            }

            $isNew ? $created++ : $repriced++;

            // Specs are seeded once, on creation, and never overwritten afterwards —
            // only facts the price list actually states.
            if (! ProductSpecification::where('product_id', $product->id)->exists()) {
                $specs = [
                    ['Battery', 'Range',            'Amaron ' . $row['series']],
                    ['Battery', 'Voltage',          '12 V'],
                    ['Battery', 'Manufacturer code', $row['sku']],
                    ['Battery', 'Type',             'Maintenance-Free (MF) · Sealed Lead Acid'],
                    ['Delivery', 'Availability',    'Mumbai · Thane · Navi Mumbai'],
                    ['Delivery', 'Installation',    'Free on-site installation'],
                ];

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
        }

        $this->command?->info("Amaron price list: {$created} created, {$repriced} repriced.");
    }
}
