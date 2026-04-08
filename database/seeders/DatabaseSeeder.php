<?php

namespace Database\Seeders;

use App\Models\CategoryProyek;
use App\Models\Division;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // sedder for Division
        $divisions = ['Head Proyek', 'PJ Proyek', 'Staff Proyek', 'Staff 2 Proyek', 'Staff Engineer Proyek', 'Staff 2 Engineer Proyek'];

        foreach ($divisions as $key => $division) {
            Division::create([
                'nama_divisi' => $division,
            ]);
        }

        // factory dumy admin roles
        User::create([
            'nama' => 'Gede Hari Yoga Nanda',
            'email' => 'gede@example.com',
            'password' => bcrypt('pastibisa'),
            'photo_profile' => 'default.jpg',
            'division_id' => 1,
        ]);

        // dummy users many
        User::factory(30)->create();

        // dummy category proyek factory 
        $categoryProyek = ['medium scale', 'small scale', 'large scale', 'very large scale'];
        foreach ($categoryProyek as $category) {
            CategoryProyek::create([
                'nama_category' => $category,
            ]);
        }

        // dummy proyek
        $namaProyek = ['proyek bimasakti', 'proyek building', 'proyek accompany', 'proyek accompany 2'];
        $statusProyek = ['belum', 'sedang-berjalan', 'selesai'];

        // buat untuk model Proyek 3 proyek dan 3 status diatas
        foreach ($namaProyek as $proyek) {
            \App\Models\Proyek::factory(1)->create([
                'nama_proyek' => $proyek,
                'category_proyek_id' => rand(1, 4),
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now(),
                'status_proyek' => $statusProyek[rand(0, 2)],
                'biaya_proyek' => rand(1000000, 10000000),
            ]);
        }

        // dumy tugas 
        Tugas::factory(30)->create();
    }
}
