<?php


namespace App\Helpers;

class FormatJsonTugas
{
    public static function formaterBodyJson($data)
    {
        return [
            'id' => $data->id,
            'nama_tugas' => $data->nama_tugas,
            'penanggung_jawab' => $data->user->nama,
            'proyek' => $data->proyek->nama_proyek,
            'deskripsi_tugas' => $data->deskripsi_tugas,
        ];
    }
}
