<?php

namespace Database\Seeders;

use App\Models\Pincode;
use Illuminate\Database\Seeder;

class PincodeSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['400001', 'Mumbai', 'Maharashtra', true, 0, 1],
            ['400050', 'Mumbai', 'Maharashtra', true, 0, 2],
            ['110001', 'New Delhi', 'Delhi', true, 0, 1],
            ['110020', 'New Delhi', 'Delhi', true, 0, 1],
            ['560001', 'Bangalore', 'Karnataka', true, 0, 1],
            ['560066', 'Bangalore', 'Karnataka', true, 0, 2],
            ['500001', 'Hyderabad', 'Telangana', true, 0, 2],
            ['500081', 'Hyderabad', 'Telangana', true, 0, 1],
            ['600001', 'Chennai', 'Tamil Nadu', true, 99, 3],
            ['700001', 'Kolkata', 'West Bengal', true, 99, 3],
            ['380001', 'Ahmedabad', 'Gujarat', true, 99, 3],
            ['411001', 'Pune', 'Maharashtra', true, 0, 2],
        ];

        foreach ($rows as [$pin, $city, $state, $serviceable, $charge, $days]) {
            Pincode::updateOrCreate(
                ['pincode' => $pin],
                [
                    'city' => $city,
                    'state' => $state,
                    'is_serviceable' => $serviceable,
                    'cod_available' => true,
                    'delivery_charge' => $charge,
                    'expected_delivery_days' => $days,
                ],
            );
        }
    }
}
