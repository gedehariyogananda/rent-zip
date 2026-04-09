<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Costum;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;

class NarutoOrderSeeder extends Seeder
{
    public function run(): void
    {
        $naruto = User::where('email', 'naruto@mail.com')->firstOrFail();

        $kostumNarutoM  = Costum::where('name', 'Naruto Uzumaki — Sage Mode')->where('size', 'M')->firstOrFail();
        $kostumSasukeM  = Costum::where('name', 'Sasuke Uchiha — Shippuden')->where('size', 'M')->firstOrFail();
        $kostumGojo     = Costum::where('name', 'Gojo Satoru')->where('size', 'M')->firstOrFail();
        $kostumCloud    = Costum::where('name', 'Cloud Strife — FFVII Remake')->firstOrFail();
        $kostumNinjaHit = Costum::where('name', 'Ninja Classic — Hitam')->firstOrFail();

        // ────────────────────────────────────────────────────────────────────
        // ORDER 1 — CONFIRMATED (transaksi pertama, sudah selesai)
        // Sewa: 10 Maret 2026, 3 hari
        // Naruto Sage Mode M (2 pcs) + Sasuke Shippuden M (1 pcs)
        // ────────────────────────────────────────────────────────────────────
        $hargaOrder1 = ($kostumNarutoM->priceday * 2 * 3) + ($kostumSasukeM->priceday * 1 * 3);

        $order1 = Order::create([
            'user_id'          => $naruto->id,
            'code_booking'     => 'BOOK-NRT-001',
            'status'           => 'confirmated',
            'qris'             => 'qris_payment_nrt001.png',
            'total'            => $hargaOrder1,
            'tgl_sewa'         => '2026-03-10',
            'tgl_pengembalian' => '2026-03-13',
        ]);

        OrderItem::create([
            'order_id'  => $order1->id,
            'costum_id' => $kostumNarutoM->id,
            'pcs'       => 2,
        ]);

        OrderItem::create([
            'order_id'  => $order1->id,
            'costum_id' => $kostumSasukeM->id,
            'pcs'       => 1,
        ]);

        // ────────────────────────────────────────────────────────────────────
        // ORDER 2 — PENDING (transaksi kedua, menunggu konfirmasi admin)
        // Sewa: 25 April 2026, 2 hari
        // Gojo Satoru M (1 pcs) + Cloud Strife L (1 pcs)
        // ────────────────────────────────────────────────────────────────────
        $hargaOrder2 = ($kostumGojo->priceday * 1 * 2) + ($kostumCloud->priceday * 1 * 2);

        $order2 = Order::create([
            'user_id'          => $naruto->id,
            'code_booking'     => 'BOOK-NRT-002',
            'status'           => 'pending',
            'qris'             => 'qris_payment_nrt002.png',
            'total'            => $hargaOrder2,
            'tgl_sewa'         => '2026-04-25',
            'tgl_pengembalian' => '2026-04-27',
        ]);

        OrderItem::create([
            'order_id'  => $order2->id,
            'costum_id' => $kostumGojo->id,
            'pcs'       => 1,
        ]);

        OrderItem::create([
            'order_id'  => $order2->id,
            'costum_id' => $kostumCloud->id,
            'pcs'       => 1,
        ]);

        // ────────────────────────────────────────────────────────────────────
        // CART — item yang naruto simpan untuk transaksi berikutnya
        // ────────────────────────────────────────────────────────────────────
        Cart::create([
            'user_id'   => $naruto->id,
            'costum_id' => $kostumNinjaHit->id,
            'pcs'       => 2,
        ]);

        Cart::create([
            'user_id'   => $naruto->id,
            'costum_id' => $kostumSasukeM->id,
            'pcs'       => 1,
        ]);

        // ────────────────────────────────────────────────────────────────────
        // RATING — muncul karena order pertama sudah confirmated
        // is_submitted = false → sistem akan show prompt rating ke naruto
        // ────────────────────────────────────────────────────────────────────
        Rating::create([
            'user_id'      => $naruto->id,
            'rating'       => 0,
            'is_submitted' => false,
        ]);
    }
}
