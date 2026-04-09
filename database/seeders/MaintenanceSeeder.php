<?php

namespace Database\Seeders;

use App\Models\Costum;
use App\Models\Maintenance;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    public function run(): void
    {
        // Setelah order naruto (BOOK-NRT-001) dikembalikan tanggal 13 Maret 2026,
        // kostum-kostum tersebut masuk maintenance: cuci + cek kondisi.

        $kostumNarutoM = Costum::where('name', 'Naruto Uzumaki — Sage Mode')->where('size', 'M')->firstOrFail();
        $kostumSasukeM = Costum::where('name', 'Sasuke Uchiha — Shippuden')->where('size', 'M')->firstOrFail();

        // Naruto Sage Mode — 2 pcs dikembalikan, sudah dicuci
        Maintenance::create([
            'costum_id' => $kostumNarutoM->id,
            'pcs'       => 2,
            'is_wash'   => true,
        ]);

        // Sasuke Shippuden — 1 pcs dikembalikan, belum dicuci
        Maintenance::create([
            'costum_id' => $kostumSasukeM->id,
            'pcs'       => 1,
            'is_wash'   => false,
        ]);

        // Kostum lain yang sedang dalam maintenance mandiri (bukan dari order naruto)
        $kostumKenshin = Costum::where('name', 'Kenshin Himura — Rurouni Kenshin')->firstOrFail();
        $kostumGothic  = Costum::where('name', 'Gothic Lolita — Black Rose')->firstOrFail();
        $kostumMaid    = Costum::where('name', 'Maid Classic — Hitam Putih')->where('size', 'M')->firstOrFail();

        // Kenshin — 1 pcs, sudah dicuci setelah event kemarin
        Maintenance::create([
            'costum_id' => $kostumKenshin->id,
            'pcs'       => 1,
            'is_wash'   => true,
        ]);

        // Gothic Lolita — 1 pcs, dijahit minor, belum dicuci
        Maintenance::create([
            'costum_id' => $kostumGothic->id,
            'pcs'       => 1,
            'is_wash'   => false,
        ]);

        // Maid M — 2 pcs dicuci setelah event cosplay weekend
        Maintenance::create([
            'costum_id' => $kostumMaid->id,
            'pcs'       => 2,
            'is_wash'   => true,
        ]);
    }
}
