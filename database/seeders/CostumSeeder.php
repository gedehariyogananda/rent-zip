<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Costum;
use Illuminate\Database\Seeder;

class CostumSeeder extends Seeder
{
    public function run(): void
    {
        $sourceId = \App\Models\Category::where("type", "source_anime")->first()
            ->id;
        $brandId = \App\Models\Category::where("type", "brand")->first()->id;

        $costums = [
            // ── Anime Shounen ──────────────────────────────────────────────
            [
                "name" => "Naruto Uzumaki — Sage Mode",
                "name_anime" => "Naruto Shippuden",
                "nama_cosplayer" => "Hakken",
                "size" => "M",
                "stock" => 3,
                "priceday" => 75000,
                "lokasi" => "Surabaya",
                "desc" =>
                    "Kostum lengkap Naruto mode sage: jaket oranye, celana biru, headband Konoha, jubah merah hitam.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Naruto Uzumaki — Sage Mode",
                "name_anime" => "Naruto Shippuden",
                "size" => "L",
                "stock" => 2,
                "priceday" => 75000,
                "desc" =>
                    "Kostum lengkap Naruto mode sage: jaket oranye, celana biru, headband Konoha, jubah merah hitam.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Sasuke Uchiha — Shippuden",
                "name_anime" => "Naruto Shippuden",
                "size" => "M",
                "stock" => 2,
                "priceday" => 75000,
                "desc" =>
                    "Kostum Sasuke arc Shippuden: baju putih lengan pendek, celana putih, ikat kepala Konoha coret, pedang Kusanagi.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Sasuke Uchiha — Shippuden",
                "name_anime" => "Naruto Shippuden",
                "size" => "L",
                "stock" => 2,
                "priceday" => 75000,
                "desc" =>
                    "Kostum Sasuke arc Shippuden: baju putih lengan pendek, celana putih, ikat kepala Konoha coret, pedang Kusanagi.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Monkey D. Luffy — Gear 4",
                "name_anime" => "One Piece",
                "size" => "M",
                "stock" => 2,
                "priceday" => 80000,
                "desc" =>
                    "Kostum Luffy Gear 4 Boundman: baju merah robek, topi jerami, tanda Q di bahu.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Roronoa Zoro",
                "name_anime" => "One Piece",
                "size" => "L",
                "stock" => 2,
                "priceday" => 70000,
                "desc" =>
                    "Kostum Zoro: baju putih, celana hijau, ikat kepala, prop 3 pedang.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Tanjiro Kamado",
                "name_anime" => "Kimetsu no Yaiba",
                "size" => "M",
                "stock" => 3,
                "priceday" => 85000,
                "desc" =>
                    "Kostum lengkap Tanjiro: haori kotak-kotak hitam hijau, baju hitam, prop pedang.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Gojo Satoru",
                "name_anime" => "Jujutsu Kaisen",
                "size" => "M",
                "stock" => 3,
                "priceday" => 90000,
                "desc" =>
                    "Kostum Gojo: seragam SMA JJK hitam, kacamata mata putih, rambut putih wig.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Gojo Satoru",
                "name_anime" => "Jujutsu Kaisen",
                "size" => "L",
                "stock" => 2,
                "priceday" => 90000,
                "desc" =>
                    "Kostum Gojo: seragam SMA JJK hitam, kacamata mata putih, rambut putih wig.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],

            // ── Anime Shoujo ───────────────────────────────────────────────
            [
                "name" => "Sailor Moon",
                "name_anime" => "Bishoujo Senshi Sailor Moon",
                "size" => "S",
                "stock" => 2,
                "priceday" => 80000,
                "desc" =>
                    "Kostum Sailor Moon klasik: baju sailor putih, rok biru, dasi merah, aksesori lengkap.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Sailor Moon",
                "name_anime" => "Bishoujo Senshi Sailor Moon",
                "size" => "M",
                "stock" => 2,
                "priceday" => 80000,
                "desc" =>
                    "Kostum Sailor Moon klasik: baju sailor putih, rok biru, dasi merah, aksesori lengkap.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Nezuko Kamado",
                "name_anime" => "Kimetsu no Yaiba",
                "size" => "S",
                "stock" => 3,
                "priceday" => 85000,
                "desc" =>
                    "Kostum Nezuko: kimono merah muda, obi merah, bambu mulut, prop kotak kayu.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Rem — Re:Zero",
                "name_anime" => "Re:Zero kara Hajimeru Isekai Seikatsu",
                "size" => "S",
                "stock" => 2,
                "priceday" => 85000,
                "desc" =>
                    "Kostum Rem: baju maid biru, headband biru, aksesori lengkap.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Zero Two",
                "name_anime" => "Darling in the FranXX",
                "size" => "M",
                "stock" => 2,
                "priceday" => 90000,
                "desc" =>
                    "Kostum Zero Two: dress merah militer, topi pilot, tanduk merah, rambut merah muda wig.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],

            // ── Tokusatsu ──────────────────────────────────────────────────
            [
                "name" => "Kamen Rider Double — Cyclone Joker",
                "name_anime" => "Kamen Rider W",
                "size" => "M",
                "stock" => 1,
                "priceday" => 120000,
                "desc" =>
                    "Kostum KR Double versi Cyclone Joker: suit hijau hitam, helm full, aksesori Double Driver.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Kamen Rider Build — RabbitTank",
                "name_anime" => "Kamen Rider Build",
                "size" => "L",
                "stock" => 1,
                "priceday" => 130000,
                "desc" =>
                    "Kostum KR Build RabbitTank: suit biru merah, helm, prop Build Driver.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Super Sentai — Red Ranger",
                "name_anime" => "Gokaiger",
                "size" => "M",
                "stock" => 2,
                "priceday" => 100000,
                "desc" =>
                    "Kostum Red Ranger Gokaiger: suit merah, helm, prop Gokai Saber.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],

            // ── Game Character ─────────────────────────────────────────────
            [
                "name" => "Cloud Strife — FFVII Remake",
                "name_anime" => "Final Fantasy VII Remake",
                "size" => "L",
                "stock" => 2,
                "priceday" => 110000,
                "desc" =>
                    "Kostum Cloud Strife: baju SOLDIER hitam, shoulder pad, prop Buster Sword (prop busa).",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Eula Lawrence",
                "name_anime" => "Genshin Impact",
                "size" => "S",
                "stock" => 2,
                "priceday" => 100000,
                "desc" =>
                    "Kostum Eula: dress biru gelap, gloves, prop Claymore.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Link — Breath of the Wild",
                "name_anime" => "The Legend of Zelda: BotW",
                "size" => "M",
                "stock" => 2,
                "priceday" => 95000,
                "desc" =>
                    "Kostum Link BotW: tunik biru, celana abu, wig pirang, prop panah & busur.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Hu Tao",
                "name_anime" => "Genshin Impact",
                "size" => "S",
                "stock" => 2,
                "priceday" => 95000,
                "desc" =>
                    "Kostum Hu Tao: baju hitam Wangsheng, topi hua, aksesori Ghost.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],

            // ── Maid & Butler ──────────────────────────────────────────────
            [
                "name" => "Maid Classic — Hitam Putih",
                "name_anime" => "Original",
                "size" => "S",
                "stock" => 4,
                "priceday" => 55000,
                "desc" =>
                    "Kostum maid klasik hitam putih: dress, apron, headdress, kaos kaki putih panjang.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Maid Classic — Hitam Putih",
                "name_anime" => "Original",
                "size" => "M",
                "stock" => 4,
                "priceday" => 55000,
                "desc" =>
                    "Kostum maid klasik hitam putih: dress, apron, headdress, kaos kaki putih panjang.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Butler Formal — Hitam",
                "name_anime" => "Original",
                "size" => "M",
                "stock" => 3,
                "priceday" => 60000,
                "desc" =>
                    "Kostum butler formal: jas hitam, kemeja putih, dasi kupu-kupu, sarung tangan.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],

            // ── Seifuku ────────────────────────────────────────────────────
            [
                "name" => "Seifuku Sailor — Navy",
                "name_anime" => "Original",
                "size" => "S",
                "stock" => 5,
                "priceday" => 45000,
                "desc" =>
                    "Seragam sailor wanita navy: blus sailor, rok pendek navy, dasi merah.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Seifuku Sailor — Navy",
                "name_anime" => "Original",
                "size" => "M",
                "stock" => 5,
                "priceday" => 45000,
                "desc" =>
                    "Seragam sailor wanita navy: blus sailor, rok pendek navy, dasi merah.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Gakuran — Seragam Pria Hitam",
                "name_anime" => "Original",
                "size" => "M",
                "stock" => 4,
                "priceday" => 45000,
                "desc" =>
                    "Gakuran pria: jas hitam kerah tinggi gaya sekolah Jepang.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Gakuran — Seragam Pria Hitam",
                "name_anime" => "Original",
                "size" => "L",
                "stock" => 3,
                "priceday" => 45000,
                "desc" =>
                    "Gakuran pria: jas hitam kerah tinggi gaya sekolah Jepang.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],

            // ── Samurai & Ninja ────────────────────────────────────────────
            [
                "name" => "Kenshin Himura — Rurouni Kenshin",
                "name_anime" => "Rurouni Kenshin",
                "size" => "M",
                "stock" => 2,
                "priceday" => 90000,
                "desc" =>
                    "Kostum Kenshin: kimono merah, hakama ungu, ikat kepala, prop pedang terbalik.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Samurai Ronin — Edo Period",
                "name_anime" => "Original",
                "size" => "L",
                "stock" => 2,
                "priceday" => 85000,
                "desc" =>
                    "Kostum samurai ronin era Edo: kimono gelap, hakama, ikat pinggang, prop katana busa.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Ninja Classic — Hitam",
                "name_anime" => "Original",
                "size" => "M",
                "stock" => 4,
                "priceday" => 65000,
                "desc" =>
                    "Kostum ninja hitam klasik: baju ninja, celana, masker, ikat kepala, prop shuriken busa.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],

            // ── Kimono & Yukata ────────────────────────────────────────────
            [
                "name" => "Kimono Furisode — Merah Emas",
                "name_anime" => "Original",
                "size" => "S",
                "stock" => 2,
                "priceday" => 100000,
                "desc" =>
                    "Kimono furisode wanita merah bermotif emas, obi, tabi, sandal zori.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Yukata Pria — Biru Dongker",
                "name_anime" => "Original",
                "size" => "M",
                "stock" => 3,
                "priceday" => 70000,
                "desc" =>
                    "Yukata pria biru dongker motif wave, obi hitam, geta.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Yukata Wanita — Sakura Pink",
                "name_anime" => "Original",
                "size" => "S",
                "stock" => 3,
                "priceday" => 70000,
                "desc" =>
                    "Yukata wanita motif sakura pink, obi putih, aksesori kanzashi.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],

            // ── Lolita Fashion ─────────────────────────────────────────────
            [
                "name" => "Gothic Lolita — Black Rose",
                "name_anime" => "Original",
                "size" => "S",
                "stock" => 2,
                "priceday" => 110000,
                "desc" =>
                    "Gothic Lolita hitam: dress layer renda hitam, headdress, kaos kaki panjang.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Sweet Lolita — Pastel Pink",
                "name_anime" => "Original",
                "size" => "S",
                "stock" => 2,
                "priceday" => 110000,
                "desc" =>
                    "Sweet Lolita pink: dress layer pink, aksesori pita, bonnet, kaos kaki lace.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],

            // ── Visual Kei ─────────────────────────────────────────────────
            [
                "name" => 'Visual Kei — L\'Arc~en~Ciel Style',
                "name_anime" => "Original",
                "size" => "M",
                "stock" => 2,
                "priceday" => 95000,
                "desc" =>
                    "Visual Kei gaya Hyde LARUKU: jaket kulit hitam, celana ketat, aksesori cross, wig panjang.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
            [
                "name" => "Visual Kei — Malice Mizer Style",
                "name_anime" => "Original",
                "size" => "M",
                "stock" => 2,
                "priceday" => 105000,
                "desc" =>
                    "Visual Kei baroque style Malice Mizer: jas baroque hitam, renda, aksesori gothic.",
                "source_anime_category_id" => $sourceId,
                "brand_costum_category_id" => $brandId,
                "paxel" => "medium",
                "berat_jnt" => 1.5,
            ],
        ];

        foreach ($costums as $costum) {
            $costum["nama_cosplayer"] = $costum["nama_cosplayer"] ?? null;
            $costum["lokasi"] = $costum["lokasi"] ?? "Surabaya";
            Costum::create($costum);
        }
    }
}
