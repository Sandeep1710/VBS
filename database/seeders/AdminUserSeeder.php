<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Retire any legacy admin row
        User::where('email', 'admin@vehiclebattery.test')->delete();

        User::updateOrCreate(
            ['email' => 'admin@trikutibattery.com'],
            [
                'is_admin' => true,
                'name' => 'Admin',
                'phone' => null, // avoid conflicts with the unique constraint on users.phone
                'password' => Hash::make('P$ajapati@17'),
                'email_verified_at' => now(),
                'status' => 'active',
            ],
        );
    }
}
