<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Costum;
use App\Models\Maintenance;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    public function run(): void
    {
        // Setelah order naruto (BOOK-NRT-001) dikembalikan tanggal 13 Maret 2026,
        // kostum-kostum tersebut masuk maintenance: cuci + cek kondisi.

        $kostumNarutoM = Costum::where("name", "Naruto Uzumaki — Sage Mode")
            ->where("size", "M")
            ->firstOrFail();
        $kostumSasukeM = Costum::where("name", "Sasuke Uchiha — Shippuden")
            ->where("size", "M")
            ->firstOrFail();

        $catCuci = Category::where("name", "Cuci / Laundry")->first();
        $catRusak = Category::where("name", "Rusak / Sobek")->first();

        // Naruto Sage Mode — 2 pcs dikembalikan, sudah dicuci
        Maintenance::create([
            "costum_id" => $kostumNarutoM->id,
            "type" => "pengurangan",
            "category_id" => $catCuci?->id,
            "pcs" => 2,
            "desc" => "Dicuci setelah event",
        ]);

        // Sasuke Shippuden — 1 pcs dikembalikan, belum dicuci
        Maintenance::create([
            "costum_id" => $kostumSasukeM->id,
            "type" => "pengurangan",
            "category_id" => $catCuci?->id,
            "pcs" => 1,
            "desc" => "Akan dicuci",
        ]);

        // Kostum lain yang sedang dalam maintenance mandiri (bukan dari order naruto)
        $kostumKenshin = Costum::where(
            "name",
            "Kenshin Himura — Rurouni Kenshin",
        )->firstOrFail();
        $kostumGothic = Costum::where(
            "name",
            "Gothic Lolita — Black Rose",
        )->firstOrFail();
        $kostumMaid = Costum::where("name", "Maid Classic — Hitam Putih")
            ->where("size", "M")
            ->firstOrFail();

        // Kenshin — 1 pcs, sudah dicuci setelah event kemarin
        Maintenance::create([
            "costum_id" => $kostumKenshin->id,
            "type" => "pengurangan",
            "category_id" => $catCuci?->id,
            "pcs" => 1,
            "desc" => "Dicuci",
        ]);

        // Gothic Lolita — 1 pcs, dijahit minor, belum dicuci
        Maintenance::create([
            "costum_id" => $kostumGothic->id,
            "type" => "pengurangan",
            "category_id" => $catRusak?->id,
            "pcs" => 1,
            "desc" => "Jahit minor",
        ]);

        // Maid M — 2 pcs dicuci setelah event cosplay weekend
        Maintenance::create([
            "costum_id" => $kostumMaid->id,
            "type" => "pengurangan",
            "category_id" => $catCuci?->id,
            "pcs" => 2,
            "desc" => "Dicuci setelah event cosplay weekend",
        ]);
    }
}
