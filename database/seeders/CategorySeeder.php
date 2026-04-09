<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // ── Kategori Pengeluaran ───────────────────────────────────────
            ["name" => "Laundry & Cuci Kostum", "type" => "pengeluaran"],
            ["name" => "Jahit & Perbaikan Kostum", "type" => "pengeluaran"],
            ["name" => "Pembelian Kostum Baru", "type" => "pengeluaran"],
            ["name" => "Pembelian Aksesori & Prop", "type" => "pengeluaran"],
            ["name" => "Biaya Operasional", "type" => "pengeluaran"],
            ["name" => "Biaya Promosi & Event", "type" => "pengeluaran"],

            // ── Kategori Kostum ────────────────────────────────────────────
            ["name" => "Anime Shounen", "type" => "costum"], // Naruto, One Piece, DBZ
            ["name" => "Anime Shoujo", "type" => "costum"], // Sailor Moon, Cardcaptor
            ["name" => "Tokusatsu", "type" => "costum"], // Kamen Rider, Super Sentai
            ["name" => "Game Character", "type" => "costum"], // Final Fantasy, Genshin
            ["name" => "Maid & Butler", "type" => "costum"], // Maid cafe style
            ["name" => "Seifuku (Seragam)", "type" => "costum"], // Seragam sekolah Jepang
            ["name" => "Samurai & Ninja", "type" => "costum"], // Historical Japanese
            ["name" => "Kimono & Yukata", "type" => "costum"], // Traditional Japanese
            ["name" => "Lolita Fashion", "type" => "costum"], // Gothic, Sweet, Classic
            ["name" => "Visual Kei", "type" => "costum"], // J-rock band style

            // ── Kategori Maintenance ───────────────────────────────────────
            ["name" => "Cuci / Laundry", "type" => "maintenance"],
            ["name" => "Rusak / Sobek", "type" => "maintenance"],
            ["name" => "Hilang", "type" => "maintenance"],
            ["name" => "Penyusutan Kualitas", "type" => "maintenance"],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
