<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Kategori keuangan
            ['name' => 'Pendapatan Sewa', 'type' => 'pemasukan'],
            ['name' => 'Pendapatan Lain-lain', 'type' => 'pemasukan'],

            // Kategori kostum cosplay Jepang
            ['name' => 'Anime Shounen', 'type' => 'costum'],       // Naruto, One Piece, DBZ
            ['name' => 'Anime Shoujo', 'type' => 'costum'],        // Sailor Moon, Cardcaptor
            ['name' => 'Tokusatsu', 'type' => 'costum'],           // Kamen Rider, Super Sentai
            ['name' => 'Game Character', 'type' => 'costum'],      // Final Fantasy, Genshin
            ['name' => 'Maid & Butler', 'type' => 'costum'],       // Maid cafe style
            ['name' => 'Seifuku (Seragam)', 'type' => 'costum'],   // Seragam sekolah Jepang
            ['name' => 'Samurai & Ninja', 'type' => 'costum'],     // Historical Japanese
            ['name' => 'Kimono & Yukata', 'type' => 'costum'],     // Traditional Japanese
            ['name' => 'Lolita Fashion', 'type' => 'costum'],      // Gothic, Sweet, Classic
            ['name' => 'Visual Kei', 'type' => 'costum'],          // J-rock band style
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
