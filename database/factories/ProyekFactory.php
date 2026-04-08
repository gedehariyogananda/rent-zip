<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proyek>
 */
class ProyekFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaProyek = ['proyek bimasakti', 'proyek building', 'proyek accompany'];
        $statusProyek = ['belum', 'sedang-berjalan', 'selesai'];
        return [
            // buat jangan random nama proyeknya tapi pasti dari 1,2,3 ke insert semua 
            'nama_proyek' => $namaProyek[rand(0, 2)],
            'category_proyek_id' => rand(1, 4),
            'tanggal_mulai' => $this->faker->date(),
            'tanggal_selesai' => $this->faker->date(),
            'status_proyek' => $statusProyek[rand(0, 2)],
            'biaya_proyek' => $this->faker->numberBetween(1000000, 10000000),
        ];
    }
}
