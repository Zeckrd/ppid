<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Keberatan>
 */
class KeberatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'keberatan_file' => 'keberatan_files/' . $this->faker->uuid . '.pdf',
            'status' => 'Menunggu Verifikasi Berkas Dari Petugas',
            'alasan' => fake()->sentence(10),
            'keterangan_petugas' => null,
            'reply_file' => null,
        ];
    }
}
