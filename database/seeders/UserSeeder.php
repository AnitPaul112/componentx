<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@componentx.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Create regular user
        User::create([
            'name' => 'Test User',
            'email' => 'user@componentx.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
    }
} 