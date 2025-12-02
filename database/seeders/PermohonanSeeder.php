<?php

namespace Database\Seeders;

use App\Models\Permohonan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class PermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'raditfathi@gmail.com')->first();

        Permohonan::factory(40)->create([
            'user_id' => $user->id,
        ])->each(function ($permohonan) {

            $permohonan->update([
                'status' => fake()->randomElement([
                    'Menunggu Verifikasi Berkas Dari Petugas',
                    'Sedang Diverifikasi petugas',
                    'Perlu Diperbaiki',
                    'Diproses',
                    'Diterima',
                    'Ditolak'
                ])
            ]);
        });
    }
}
