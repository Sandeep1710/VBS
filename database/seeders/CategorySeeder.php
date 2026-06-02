<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $cats = [
            ['Car Batteries', 'Batteries for passenger cars and SUVs.', true],
            ['Bike Batteries', 'Two-wheeler batteries for motorcycles and scooters.', true],
        ];

        foreach ($cats as $i => [$name, $desc, $featured]) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $desc,
                    'is_featured' => $featured,
                    'is_active' => true,
                    'sort_order' => $i + 1,
                    'meta_title' => "$name - Buy Online | Vehicle Battery Store",
                    'meta_description' => "Shop $name online with warranty and old battery exchange.",
                ],
            );
        }
    }
}
