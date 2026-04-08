<?php

namespace App\Helpers;

class formatRupiah
{
    public static function formatRupiah($amount)
    {
        return "Rp " . number_format($amount, 0, ',', '.');
    }
}
