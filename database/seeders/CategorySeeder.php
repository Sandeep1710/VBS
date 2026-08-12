<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Tuple: [name, description, icon-hint, is_featured, is_active]
        $cats = [
            // 4 vehicle-type categories — what customers actually think in
            [
                'Hatchback Batteries',
                'Batteries for compact hatchbacks and small cars — Swift, Alto, i10, Wagon R, Baleno, Etios.',
                true, true,
            ],
            [
                'Sedan Batteries',
                'Batteries for mid-size sedans — Honda City, Hyundai Verna, Skoda Rapid, VW Vento, Maruti Ciaz.',
                true, true,
            ],
            [
                'SUV Batteries',
                'Batteries for SUVs — Creta, Seltos, Duster, Nexon, Innova, Fortuner, Endeavour, XUV500.',
                true, true,
            ],
            [
                'MUV & Commercial Batteries',
                'Heavy-duty batteries for Innova Crysta diesel, tempo, Bolero pickups, Force Traveller and MUVs.',
                true, true,
            ],
            // Legacy categories — inactive but kept in DB for future
            ['Car Batteries', 'Legacy — use the vehicle-type categories above.', false, false],
            ['Bike Batteries', 'Two-wheeler batteries — coming soon.', false, false],
        ];

        foreach ($cats as $i => [$name, $desc, $featured, $active]) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $desc,
                    'is_featured' => $featured,
                    'is_active' => $active,
                    'sort_order' => $i + 1,
                    'meta_title' => "$name - Buy Online | Trikuti Battery",
                    'meta_description' => "Shop $name online with warranty and old battery exchange in Mumbai.",
                ],
            );
        }
    }
}
