<?php

namespace App\Helpers;

class FormatJsonPengguna
{
    public static function formaterBodyJson($data)
    {
        return [
            'id' => $data->id,
            'nama' => $data->nama,
            'email' => $data->email,
            'photo_profile' => $data->photo_profile,
            'divisi' => $data->division->nama_divisi,
        ];
    }
}
