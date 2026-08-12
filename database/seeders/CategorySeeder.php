<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Tuple: [name, description, is_featured, is_active]
        $cats = [
            // 4 vehicle-class categories
            ['Car Batteries',
             'Batteries for personal cars — hatchbacks, sedans and SUVs.',
             true, true],
            ['Bike Batteries',
             'Two-wheeler batteries for motorcycles and scooters. Coming soon — call us if you need one urgently.',
             true, true],
            ['Tempo Batteries',
             'Heavy-duty batteries for tempos, MUVs and small commercial vehicles — Innova Crysta diesel, Tempo Traveller, Bolero Pickup.',
             true, true],
            ['Truck Batteries',
             'High-capacity batteries for trucks and heavy commercial vehicles. Coming soon — call us if you need one urgently.',
             true, true],

            // Legacy categories — kept in DB but inactive
            ['Hatchback Batteries',           'Legacy — merged into Car Batteries.',           false, false],
            ['Sedan Batteries',               'Legacy — merged into Car Batteries.',           false, false],
            ['SUV Batteries',                 'Legacy — merged into Car Batteries.',           false, false],
            ['MUV & Commercial Batteries',    'Legacy — split into Tempo and Truck.',          false, false],
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
