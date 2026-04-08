<?php

namespace App\Repositories;

use App\Models\Proyek;
use App\Repositories\Interfaces\ProyekRepositoryInterface;

class ProyekRepository implements ProyekRepositoryInterface
{
    public $proyek;

    public function __construct()
    {
        $this->proyek = Proyek::with('categoryProyek');
    }

    public function getAll()
    {
        $proyek = $this->proyek->orderBy('nama_proyek')
            ->get();

        return $proyek;
    }

    public function find($id)
    {
        return $this->proyek->find($id);
    }

    public function store($data)
    {
        return Proyek::create($data);
    }

    public function update($data, $id)
    {
        $dataProyek = $this->proyek->find($id);
        if ($dataProyek) {
            return $dataProyek->update($data);
        }

        return null;
    }

    public function delete($id)
    {
        $dataProyek = $this->proyek->find($id);
        if ($dataProyek) {
            $dataProyek->delete();
            return $dataProyek;
        }

        return null;
    }
}
