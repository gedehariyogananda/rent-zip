<?php

namespace App\Helpers;

class FormatJsonProyek
{
    public static function formaterBodyJson($data)
    {
        return [
            'id' => $data->id,
            'nama_proyek' => $data->nama_proyek,
            'biaya_proyek' => formatRupiah::formatRupiah($data->biaya_proyek),
            'tanggal_mulai' => $data->tanggal_mulai,
            'tanggal_selesai' => $data->tanggal_selesai,
            'category' => $data->categoryProyek->nama_category,
            'status_proyek' => $data->status_proyek,
        ];
    }
}
