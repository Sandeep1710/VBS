<?php

namespace Database\Seeders;

use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use App\Models\VehicleVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['Car', 'car', 1],
            ['Bike', 'bike', 2],
        ];

        foreach ($types as [$name, $slug, $order]) {
            VehicleType::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'sort_order' => $order, 'is_active' => true],
            );
        }

        $brands = [
            'Maruti Suzuki', 'Hyundai', 'Tata', 'Mahindra', 'Honda', 'Toyota',
            'Kia', 'Renault', 'Ford', 'Volkswagen', 'Skoda', 'Nissan',
            'Hero', 'Bajaj', 'TVS', 'Royal Enfield', 'Yamaha', 'Suzuki',
        ];

        foreach ($brands as $i => $name) {
            VehicleBrand::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'sort_order' => $i + 1, 'is_active' => true],
            );
        }

        $car = VehicleType::where('slug', 'car')->first();
        $bike = VehicleType::where('slug', 'bike')->first();

        $sampleModels = [
            ['Maruti Suzuki', 'car', 'Swift', [['VXi', 'petrol', 2018, null], ['VDi', 'diesel', 2018, 2020]]],
            ['Maruti Suzuki', 'car', 'Baleno', [['Delta', 'petrol', 2015, null]]],
            ['Maruti Suzuki', 'car', 'WagonR', [['LXi', 'petrol', 2019, null]]],
            ['Hyundai', 'car', 'i20', [['Sportz', 'petrol', 2020, null], ['Asta', 'diesel', 2018, 2022]]],
            ['Hyundai', 'car', 'Creta', [['SX', 'petrol', 2020, null]]],
            ['Tata', 'car', 'Nexon', [['XZ Plus', 'petrol', 2017, null], ['XZ Plus Diesel', 'diesel', 2017, null]]],
            ['Honda', 'car', 'City', [['VX', 'petrol', 2020, null]]],
            ['Honda', 'car', 'Amaze', [['VX', 'petrol', 2018, null]]],
            ['Mahindra', 'car', 'Scorpio', [['S11', 'diesel', 2014, null]]],
            ['Toyota', 'car', 'Innova Crysta', [['VX', 'diesel', 2016, null]]],
            ['Hero', 'bike', 'Splendor Plus', [['Standard', 'petrol', 2010, null]]],
            ['Hero', 'bike', 'Passion Pro', [['Standard', 'petrol', 2014, null]]],
            ['Bajaj', 'bike', 'Pulsar 150', [['Standard', 'petrol', 2010, null]]],
            ['Bajaj', 'bike', 'Pulsar NS200', [['Standard', 'petrol', 2012, null]]],
            ['Royal Enfield', 'bike', 'Classic 350', [['Standard', 'petrol', 2009, null]]],
            ['Royal Enfield', 'bike', 'Bullet 350', [['Standard', 'petrol', 2008, null]]],
            ['TVS', 'bike', 'Apache RTR 160', [['Standard', 'petrol', 2010, null]]],
            ['Honda', 'bike', 'Activa 6G', [['Standard', 'petrol', 2020, null]]],
        ];

        foreach ($sampleModels as [$brandName, $typeSlug, $modelName, $variants]) {
            $brand = VehicleBrand::where('name', $brandName)->first();
            $type = $typeSlug === 'car' ? $car : $bike;
            if (! $brand || ! $type) {
                continue;
            }

            $model = VehicleModel::updateOrCreate(
                [
                    'vehicle_type_id' => $type->id,
                    'vehicle_brand_id' => $brand->id,
                    'slug' => Str::slug($modelName),
                ],
                ['name' => $modelName, 'is_active' => true],
            );

            foreach ($variants as [$vName, $fuel, $yFrom, $yTo]) {
                VehicleVariant::updateOrCreate(
                    [
                        'vehicle_model_id' => $model->id,
                        'name' => $vName,
                        'fuel_type' => $fuel,
                        'year_from' => $yFrom,
                    ],
                    ['year_to' => $yTo, 'is_active' => true],
                );
            }
        }
    }
}
