<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Finance;
use App\Models\Order;
use Illuminate\Database\Seeder;

class FinanceSeeder extends Seeder
{
    public function run(): void
    {
        $catLaundry = Category::where(
            "name",
            "Laundry & Cuci Kostum",
        )->firstOrFail();
        $catJahit = Category::where(
            "name",
            "Jahit & Perbaikan Kostum",
        )->firstOrFail();
        $catBeli = Category::where(
            "name",
            "Pembelian Kostum Baru",
        )->firstOrFail();
        $catAksesori = Category::where(
            "name",
            "Pembelian Aksesori & Prop",
        )->firstOrFail();
        $catOperasional = Category::where(
            "name",
            "Biaya Operasional",
        )->firstOrFail();
        $catPromosi = Category::where(
            "name",
            "Biaya Promosi & Event",
        )->firstOrFail();

        // ────────────────────────────────────────────────────────────────────
        // PEMASUKAN — otomatis masuk saat order di-confirmated
        // category_id = null (pemasukan tidak butuh kategori pengeluaran)
        // Simulasi: BOOK-NRT-001 dikonfirmasi admin → auto masuk finance
        // ────────────────────────────────────────────────────────────────────
        $order1 = Order::where("code_booking", "BOOK-NRT-001")
            ->with("items.costum", "user")
            ->firstOrFail();

        $durasi = $order1->tgl_sewa->diffInDays($order1->tgl_pengembalian);

        foreach ($order1->items as $item) {
            $subtotal = $item->costum->calculatePrice($durasi) * $item->pcs;

            Finance::create([
                "category_id" => null,
                "total" => $subtotal,
                "desc" => "Rental {$item->costum->name} (Size: {$item->costum->size}, {$item->pcs} pcs, {$durasi} hari) — {$order1->user->username} [{$order1->code_booking}]",
                "type" => "pemasukan",
            ]);
        }

        // ────────────────────────────────────────────────────────────────────
        // PENGELUARAN — diinput manual oleh admin via form
        // ────────────────────────────────────────────────────────────────────

        Finance::create([
            "category_id" => $catLaundry->id,
            "total" => 50000,
            "desc" =>
                "Cuci laundry — Naruto Sage Mode (M) x2 pcs, Sasuke Shippuden (M) x1 pcs pasca BOOK-NRT-001",
            "type" => "pengeluaran",
        ]);

        Finance::create([
            "category_id" => $catJahit->id,
            "total" => 35000,
            "desc" =>
                "Jahit perbaikan minor — Gothic Lolita Black Rose (S) x1 pcs, sobek di bagian renda bawah",
            "type" => "pengeluaran",
        ]);

        Finance::create([
            "category_id" => $catLaundry->id,
            "total" => 40000,
            "desc" =>
                "Cuci laundry — Kenshin Himura x1 pcs, Maid Classic Hitam Putih (M) x2 pcs pasca event weekend",
            "type" => "pengeluaran",
        ]);

        Finance::create([
            "category_id" => $catAksesori->id,
            "total" => 85000,
            "desc" =>
                "Pembelian aksesori — kacamata mata putih cadangan Gojo Satoru x2 pcs",
            "type" => "pengeluaran",
        ]);

        Finance::create([
            "category_id" => $catAksesori->id,
            "total" => 120000,
            "desc" =>
                "Pembelian prop — pedang Kusanagi busa pengganti Sasuke Shippuden x2 pcs",
            "type" => "pengeluaran",
        ]);

        Finance::create([
            "category_id" => $catOperasional->id,
            "total" => 250000,
            "desc" => "Tagihan listrik toko — Maret 2026",
            "type" => "pengeluaran",
        ]);

        Finance::create([
            "category_id" => $catOperasional->id,
            "total" => 150000,
            "desc" => "Tagihan internet — Maret 2026",
            "type" => "pengeluaran",
        ]);

        Finance::create([
            "category_id" => $catPromosi->id,
            "total" => 200000,
            "desc" =>
                "Instagram Ads — promosi Bali Cosplay Festival April 2026",
            "type" => "pengeluaran",
        ]);
    }
}
