<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User One',
            'email' => 'test13@afrojee.com',
        ]);

        User::updateOrCreate(
            ['email' => 'admin@afrojee.com'], // Search criteria
            [
                'name' => 'AfrojeeAdmin',
                'password' => Hash::make(env('ADMIN_DEFAULT_PASSWORD', 'afrojee')),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        $this->call(OrderSeeder::class);
        
    }
}
