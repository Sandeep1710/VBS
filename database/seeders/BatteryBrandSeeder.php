<?php

namespace Database\Seeders;

use App\Models\BatteryBrand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BatteryBrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['Exide', 'Exide is one of India\'s largest manufacturers of lead-acid storage batteries.', true],
            ['Amaron', 'Amaron offers maintenance-free batteries with long warranty periods.', true],
            ['Luminous', 'Luminous batteries combine reliability with affordable pricing.', true],
            ['SF Sonic', 'SF Sonic is a high-performance battery brand from the Exide group.', true],
            ['Tata Green', 'Tata Green delivers a balance of performance and price.', false],
            ['Livguard', 'Livguard manufactures automotive and inverter batteries.', false],
            ['Bosch', 'Bosch automotive batteries with German engineering.', true],
        ];

        foreach ($brands as $i => [$name, $desc, $featured]) {
            BatteryBrand::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $desc,
                    'is_featured' => $featured,
                    'is_active' => true,
                    'sort_order' => $i + 1,
                ],
            );
        }
    }
}
