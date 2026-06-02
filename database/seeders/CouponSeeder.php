<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME200',
                'name' => 'Welcome Offer',
                'description' => 'Flat ₹200 off on your first order.',
                'type' => Coupon::TYPE_FLAT,
                'value' => 200,
                'min_order_amount' => 1500,
                'is_first_order_only' => true,
            ],
            [
                'code' => 'SAVE10',
                'name' => '10% Off',
                'description' => '10% off up to ₹500 on orders above ₹3000.',
                'type' => Coupon::TYPE_PERCENTAGE,
                'value' => 10,
                'max_discount' => 500,
                'min_order_amount' => 3000,
            ],
            [
                'code' => 'FESTIVE500',
                'name' => 'Festival Offer',
                'description' => 'Flat ₹500 off on orders above ₹5000.',
                'type' => Coupon::TYPE_FLAT,
                'value' => 500,
                'min_order_amount' => 5000,
            ],
        ];

        foreach ($coupons as $data) {
            Coupon::updateOrCreate(['code' => $data['code']], array_merge([
                'is_active' => true,
                'expires_at' => now()->addYear(),
                'per_user_limit' => 1,
            ], $data));
        }
    }
}
