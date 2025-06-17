<?php

namespace Database\Seeders;

use App\Models\Keberatan;
use App\Models\Permohonan;
use Illuminate\Database\Seeder;

class KeberatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get all permohonans with status 'Selesai' and no existing keberatan
        $eligiblePermohonans = Permohonan::where('status', 'Selesai')
            ->doesntHave('keberatan') // prevent duplicate
            ->inRandomOrder()
            ->take(40)
            ->get();

        foreach ($eligiblePermohonans as $permohonan) {
            Keberatan::factory()->create([
                'permohonan_id' => $permohonan->id,
            ]);
        }
    }
}
