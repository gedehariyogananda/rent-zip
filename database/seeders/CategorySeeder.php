<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ["name" => "Laundry & Cuci Kostum", "type" => "pengeluaran"],
            ["name" => "Jahit & Perbaikan Kostum", "type" => "pengeluaran"],
            ["name" => "Pembelian Kostum Baru", "type" => "pengeluaran"],
            ["name" => "Pembelian Aksesori & Prop", "type" => "pengeluaran"],
            ["name" => "Biaya Operasional", "type" => "pengeluaran"],
            ["name" => "Biaya Promosi & Event", "type" => "pengeluaran"],

            ["name" => "Cuci / Laundry", "type" => "maintenance"],
            ["name" => "Rusak / Sobek", "type" => "maintenance"],
            ["name" => "Hilang", "type" => "maintenance"],
            ["name" => "Penyusutan Kualitas", "type" => "maintenance"],

            [
                "name" => "Wuthering Waves",
                "type" => "source_anime",
                "desc" => null,
            ],
            ["name" => "Whitedeerm", "type" => "brand", "desc" => null],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
