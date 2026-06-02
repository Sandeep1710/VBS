<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@vehiclebattery.test'],
            [
                'is_admin' => true,
                'name' => 'Admin User',
                'phone' => '9000000001',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'status' => 'active',
            ],
        );
    }
}
