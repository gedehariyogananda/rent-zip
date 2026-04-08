<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tugas>
 */
class TugasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaTugas = ['Mengawasi', 'Mendidik', 'Mengurus'];
        $deskripsiTugas = ['Mengawasi pekerjaan', 'Mendidik anak buah', 'Mengurus keuangan'];

        return [
            'nama_tugas' => $namaTugas[rand(0, 2)],
            'proyek_id' => rand(1, 4),
            'user_id' => rand(1, 30),
            'deskripsi_tugas' => $deskripsiTugas[rand(0, 2)],
        ];
    }
}
