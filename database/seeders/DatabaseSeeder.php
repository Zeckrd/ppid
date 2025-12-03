<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permohonan;
use App\Models\Keberatan;
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

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'raditfathi@gmail.com',
            'is_admin' => 1,
            'password' => Hash::make('asdasd'),
            'phone' => '628123',
            'phone_verified_at' => now(),
        ]);

        User::factory()->create([
            'name'              => 'reg',
            'email'             => 'test@example.com',
            'is_admin'          => 0,
            'password'          => Hash::make('asdasd'),
            'phone'             => '1111111111',
            'phone_verified_at' => now(),
        ]);

        $this->call([PermohonanSeeder::class,KeberatanSeeder::class]);
    }
}
