<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Method 2: Using updateOrCreate to avoid duplicates
        User::updateOrCreate(
            ['email' => 'admin@afrojee.com'], // Search criteria
            [
                'name' => 'AfrojeeAdmin',
                'password' => Hash::make(env('ADMIN_DEFAULT_PASSWORD', 'afrojee')),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
