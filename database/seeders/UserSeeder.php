<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. สร้าง Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. สร้าง Provider (เจ้าของสตูฯ)
        User::create([
            'name' => 'Studio Owner',
            'email' => 'provider@test.com',
            'password' => Hash::make('password'),
            'role' => 'provider',
        ]);

        // 3. สร้าง Customer (ลูกค้า)
        User::create([
            'name' => 'John Customer',
            'email' => 'customer@test.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}