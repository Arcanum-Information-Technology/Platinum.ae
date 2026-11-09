<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create or update the primary administrator for Platinum Hospitality
        $admin1 = User::updateOrCreate(
            ['email' => 'admin@platinumhospitality.ae'],
            [
                'name' => 'Platinum Administrator',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $admin1->syncRoles(['Super Admin']);

        // Legacy / alternative admin access
        $admin2 = User::updateOrCreate(
            ['email' => 'admin@restaurant.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $admin2->syncRoles(['Super Admin']);
    }
}
