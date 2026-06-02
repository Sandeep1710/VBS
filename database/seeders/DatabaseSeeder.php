<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            VehicleSeeder::class,
            BatteryBrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PincodeSeeder::class,
            CouponSeeder::class,
            BannerSeeder::class,
            CmsContentSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
