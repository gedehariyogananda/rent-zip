<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Costum;
use Illuminate\Database\Seeder;

class CostumSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Category::pluck('id', 'name');

        $costums = [
            // ── Anime Shounen ──────────────────────────────────────────────
            [
                'name'        => 'Naruto Uzumaki — Sage Mode',
                'source'      => 'Naruto Shippuden',
                'size'        => 'M',
                'stock'       => 3,
                'priceday'    => 75000,
                'desc'        => 'Kostum lengkap Naruto mode sage: jaket oranye, celana biru, headband Konoha, jubah merah hitam.',
                'category_id' => $cat['Anime Shounen'],
            ],
            [
                'name'        => 'Naruto Uzumaki — Sage Mode',
                'source'      => 'Naruto Shippuden',
                'size'        => 'L',
                'stock'       => 2,
                'priceday'    => 75000,
                'desc'        => 'Kostum lengkap Naruto mode sage: jaket oranye, celana biru, headband Konoha, jubah merah hitam.',
                'category_id' => $cat['Anime Shounen'],
            ],
            [
                'name'        => 'Sasuke Uchiha — Shippuden',
                'source'      => 'Naruto Shippuden',
                'size'        => 'M',
                'stock'       => 2,
                'priceday'    => 75000,
                'desc'        => 'Kostum Sasuke arc Shippuden: baju putih lengan pendek, celana putih, ikat kepala Konoha coret, pedang Kusanagi.',
                'category_id' => $cat['Anime Shounen'],
            ],
            [
                'name'        => 'Sasuke Uchiha — Shippuden',
                'source'      => 'Naruto Shippuden',
                'size'        => 'L',
                'stock'       => 2,
                'priceday'    => 75000,
                'desc'        => 'Kostum Sasuke arc Shippuden: baju putih lengan pendek, celana putih, ikat kepala Konoha coret, pedang Kusanagi.',
                'category_id' => $cat['Anime Shounen'],
            ],
            [
                'name'        => 'Monkey D. Luffy — Gear 4',
                'source'      => 'One Piece',
                'size'        => 'M',
                'stock'       => 2,
                'priceday'    => 80000,
                'desc'        => 'Kostum Luffy Gear 4 Boundman: baju merah robek, topi jerami, tanda Q di bahu.',
                'category_id' => $cat['Anime Shounen'],
            ],
            [
                'name'        => 'Roronoa Zoro',
                'source'      => 'One Piece',
                'size'        => 'L',
                'stock'       => 2,
                'priceday'    => 70000,
                'desc'        => 'Kostum Zoro: baju putih, celana hijau, ikat kepala, prop 3 pedang.',
                'category_id' => $cat['Anime Shounen'],
            ],
            [
                'name'        => 'Tanjiro Kamado',
                'source'      => 'Kimetsu no Yaiba',
                'size'        => 'M',
                'stock'       => 3,
                'priceday'    => 85000,
                'desc'        => 'Kostum lengkap Tanjiro: haori kotak-kotak hitam hijau, baju hitam, prop pedang.',
                'category_id' => $cat['Anime Shounen'],
            ],
            [
                'name'        => 'Gojo Satoru',
                'source'      => 'Jujutsu Kaisen',
                'size'        => 'M',
                'stock'       => 3,
                'priceday'    => 90000,
                'desc'        => 'Kostum Gojo: seragam SMA JJK hitam, kacamata mata putih, rambut putih wig.',
                'category_id' => $cat['Anime Shounen'],
            ],
            [
                'name'        => 'Gojo Satoru',
                'source'      => 'Jujutsu Kaisen',
                'size'        => 'L',
                'stock'       => 2,
                'priceday'    => 90000,
                'desc'        => 'Kostum Gojo: seragam SMA JJK hitam, kacamata mata putih, rambut putih wig.',
                'category_id' => $cat['Anime Shounen'],
            ],

            // ── Anime Shoujo ───────────────────────────────────────────────
            [
                'name'        => 'Sailor Moon',
                'source'      => 'Bishoujo Senshi Sailor Moon',
                'size'        => 'S',
                'stock'       => 2,
                'priceday'    => 80000,
                'desc'        => 'Kostum Sailor Moon klasik: baju sailor putih, rok biru, dasi merah, aksesori lengkap.',
                'category_id' => $cat['Anime Shoujo'],
            ],
            [
                'name'        => 'Sailor Moon',
                'source'      => 'Bishoujo Senshi Sailor Moon',
                'size'        => 'M',
                'stock'       => 2,
                'priceday'    => 80000,
                'desc'        => 'Kostum Sailor Moon klasik: baju sailor putih, rok biru, dasi merah, aksesori lengkap.',
                'category_id' => $cat['Anime Shoujo'],
            ],
            [
                'name'        => 'Nezuko Kamado',
                'source'      => 'Kimetsu no Yaiba',
                'size'        => 'S',
                'stock'       => 3,
                'priceday'    => 85000,
                'desc'        => 'Kostum Nezuko: kimono merah muda, obi merah, bambu mulut, prop kotak kayu.',
                'category_id' => $cat['Anime Shoujo'],
            ],
            [
                'name'        => 'Rem — Re:Zero',
                'source'      => 'Re:Zero kara Hajimeru Isekai Seikatsu',
                'size'        => 'S',
                'stock'       => 2,
                'priceday'    => 85000,
                'desc'        => 'Kostum Rem: baju maid biru, headband biru, aksesori lengkap.',
                'category_id' => $cat['Anime Shoujo'],
            ],
            [
                'name'        => 'Zero Two',
                'source'      => 'Darling in the FranXX',
                'size'        => 'M',
                'stock'       => 2,
                'priceday'    => 90000,
                'desc'        => 'Kostum Zero Two: dress merah militer, topi pilot, tanduk merah, rambut merah muda wig.',
                'category_id' => $cat['Anime Shoujo'],
            ],

            // ── Tokusatsu ──────────────────────────────────────────────────
            [
                'name'        => 'Kamen Rider Double — Cyclone Joker',
                'source'      => 'Kamen Rider W',
                'size'        => 'M',
                'stock'       => 1,
                'priceday'    => 120000,
                'desc'        => 'Kostum KR Double versi Cyclone Joker: suit hijau hitam, helm full, aksesori Double Driver.',
                'category_id' => $cat['Tokusatsu'],
            ],
            [
                'name'        => 'Kamen Rider Build — RabbitTank',
                'source'      => 'Kamen Rider Build',
                'size'        => 'L',
                'stock'       => 1,
                'priceday'    => 130000,
                'desc'        => 'Kostum KR Build RabbitTank: suit biru merah, helm, prop Build Driver.',
                'category_id' => $cat['Tokusatsu'],
            ],
            [
                'name'        => 'Super Sentai — Red Ranger',
                'source'      => 'Gokaiger',
                'size'        => 'M',
                'stock'       => 2,
                'priceday'    => 100000,
                'desc'        => 'Kostum Red Ranger Gokaiger: suit merah, helm, prop Gokai Saber.',
                'category_id' => $cat['Tokusatsu'],
            ],

            // ── Game Character ─────────────────────────────────────────────
            [
                'name'        => 'Cloud Strife — FFVII Remake',
                'source'      => 'Final Fantasy VII Remake',
                'size'        => 'L',
                'stock'       => 2,
                'priceday'    => 110000,
                'desc'        => 'Kostum Cloud Strife: baju SOLDIER hitam, shoulder pad, prop Buster Sword (prop busa).',
                'category_id' => $cat['Game Character'],
            ],
            [
                'name'        => 'Eula Lawrence',
                'source'      => 'Genshin Impact',
                'size'        => 'S',
                'stock'       => 2,
                'priceday'    => 100000,
                'desc'        => 'Kostum Eula: dress biru gelap, gloves, prop Claymore.',
                'category_id' => $cat['Game Character'],
            ],
            [
                'name'        => 'Link — Breath of the Wild',
                'source'      => 'The Legend of Zelda: BotW',
                'size'        => 'M',
                'stock'       => 2,
                'priceday'    => 95000,
                'desc'        => 'Kostum Link BotW: tunik biru, celana abu, wig pirang, prop panah & busur.',
                'category_id' => $cat['Game Character'],
            ],
            [
                'name'        => 'Hu Tao',
                'source'      => 'Genshin Impact',
                'size'        => 'S',
                'stock'       => 2,
                'priceday'    => 95000,
                'desc'        => 'Kostum Hu Tao: baju hitam Wangsheng, topi hua, aksesori Ghost.',
                'category_id' => $cat['Game Character'],
            ],

            // ── Maid & Butler ──────────────────────────────────────────────
            [
                'name'        => 'Maid Classic — Hitam Putih',
                'source'      => 'Original',
                'size'        => 'S',
                'stock'       => 4,
                'priceday'    => 55000,
                'desc'        => 'Kostum maid klasik hitam putih: dress, apron, headdress, kaos kaki putih panjang.',
                'category_id' => $cat['Maid & Butler'],
            ],
            [
                'name'        => 'Maid Classic — Hitam Putih',
                'source'      => 'Original',
                'size'        => 'M',
                'stock'       => 4,
                'priceday'    => 55000,
                'desc'        => 'Kostum maid klasik hitam putih: dress, apron, headdress, kaos kaki putih panjang.',
                'category_id' => $cat['Maid & Butler'],
            ],
            [
                'name'        => 'Butler Formal — Hitam',
                'source'      => 'Original',
                'size'        => 'M',
                'stock'       => 3,
                'priceday'    => 60000,
                'desc'        => 'Kostum butler formal: jas hitam, kemeja putih, dasi kupu-kupu, sarung tangan.',
                'category_id' => $cat['Maid & Butler'],
            ],

            // ── Seifuku ────────────────────────────────────────────────────
            [
                'name'        => 'Seifuku Sailor — Navy',
                'source'      => 'Original',
                'size'        => 'S',
                'stock'       => 5,
                'priceday'    => 45000,
                'desc'        => 'Seragam sailor wanita navy: blus sailor, rok pendek navy, dasi merah.',
                'category_id' => $cat['Seifuku (Seragam)'],
            ],
            [
                'name'        => 'Seifuku Sailor — Navy',
                'source'      => 'Original',
                'size'        => 'M',
                'stock'       => 5,
                'priceday'    => 45000,
                'desc'        => 'Seragam sailor wanita navy: blus sailor, rok pendek navy, dasi merah.',
                'category_id' => $cat['Seifuku (Seragam)'],
            ],
            [
                'name'        => 'Gakuran — Seragam Pria Hitam',
                'source'      => 'Original',
                'size'        => 'M',
                'stock'       => 4,
                'priceday'    => 45000,
                'desc'        => 'Gakuran pria: jas hitam kerah tinggi gaya sekolah Jepang.',
                'category_id' => $cat['Seifuku (Seragam)'],
            ],
            [
                'name'        => 'Gakuran — Seragam Pria Hitam',
                'source'      => 'Original',
                'size'        => 'L',
                'stock'       => 3,
                'priceday'    => 45000,
                'desc'        => 'Gakuran pria: jas hitam kerah tinggi gaya sekolah Jepang.',
                'category_id' => $cat['Seifuku (Seragam)'],
            ],

            // ── Samurai & Ninja ────────────────────────────────────────────
            [
                'name'        => 'Kenshin Himura — Rurouni Kenshin',
                'source'      => 'Rurouni Kenshin',
                'size'        => 'M',
                'stock'       => 2,
                'priceday'    => 90000,
                'desc'        => 'Kostum Kenshin: kimono merah, hakama ungu, ikat kepala, prop pedang terbalik.',
                'category_id' => $cat['Samurai & Ninja'],
            ],
            [
                'name'        => 'Samurai Ronin — Edo Period',
                'source'      => 'Original',
                'size'        => 'L',
                'stock'       => 2,
                'priceday'    => 85000,
                'desc'        => 'Kostum samurai ronin era Edo: kimono gelap, hakama, ikat pinggang, prop katana busa.',
                'category_id' => $cat['Samurai & Ninja'],
            ],
            [
                'name'        => 'Ninja Classic — Hitam',
                'source'      => 'Original',
                'size'        => 'M',
                'stock'       => 4,
                'priceday'    => 65000,
                'desc'        => 'Kostum ninja hitam klasik: baju ninja, celana, masker, ikat kepala, prop shuriken busa.',
                'category_id' => $cat['Samurai & Ninja'],
            ],

            // ── Kimono & Yukata ────────────────────────────────────────────
            [
                'name'        => 'Kimono Furisode — Merah Emas',
                'source'      => 'Original',
                'size'        => 'S',
                'stock'       => 2,
                'priceday'    => 100000,
                'desc'        => 'Kimono furisode wanita merah bermotif emas, obi, tabi, sandal zori.',
                'category_id' => $cat['Kimono & Yukata'],
            ],
            [
                'name'        => 'Yukata Pria — Biru Dongker',
                'source'      => 'Original',
                'size'        => 'M',
                'stock'       => 3,
                'priceday'    => 70000,
                'desc'        => 'Yukata pria biru dongker motif wave, obi hitam, geta.',
                'category_id' => $cat['Kimono & Yukata'],
            ],
            [
                'name'        => 'Yukata Wanita — Sakura Pink',
                'source'      => 'Original',
                'size'        => 'S',
                'stock'       => 3,
                'priceday'    => 70000,
                'desc'        => 'Yukata wanita motif sakura pink, obi putih, aksesori kanzashi.',
                'category_id' => $cat['Kimono & Yukata'],
            ],

            // ── Lolita Fashion ─────────────────────────────────────────────
            [
                'name'        => 'Gothic Lolita — Black Rose',
                'source'      => 'Original',
                'size'        => 'S',
                'stock'       => 2,
                'priceday'    => 110000,
                'desc'        => 'Gothic Lolita hitam: dress layer renda hitam, headdress, kaos kaki panjang.',
                'category_id' => $cat['Lolita Fashion'],
            ],
            [
                'name'        => 'Sweet Lolita — Pastel Pink',
                'source'      => 'Original',
                'size'        => 'S',
                'stock'       => 2,
                'priceday'    => 110000,
                'desc'        => 'Sweet Lolita pink: dress layer pink, aksesori pita, bonnet, kaos kaki lace.',
                'category_id' => $cat['Lolita Fashion'],
            ],

            // ── Visual Kei ─────────────────────────────────────────────────
            [
                'name'        => 'Visual Kei — L\'Arc~en~Ciel Style',
                'source'      => 'Original',
                'size'        => 'M',
                'stock'       => 2,
                'priceday'    => 95000,
                'desc'        => 'Visual Kei gaya Hyde LARUKU: jaket kulit hitam, celana ketat, aksesori cross, wig panjang.',
                'category_id' => $cat['Visual Kei'],
            ],
            [
                'name'        => 'Visual Kei — Malice Mizer Style',
                'source'      => 'Original',
                'size'        => 'M',
                'stock'       => 2,
                'priceday'    => 105000,
                'desc'        => 'Visual Kei baroque style Malice Mizer: jas baroque hitam, renda, aksesori gothic.',
                'category_id' => $cat['Visual Kei'],
            ],
        ];

        foreach ($costums as $costum) {
            Costum::create($costum);
        }
    }
}
