<?php

namespace App\Repositories;


use App\Models\Tugas;
use App\Repositories\Interfaces\TugasRepositoryInterface;

class TugasRepository implements TugasRepositoryInterface
{
    public $tugas;

    public function __construct()
    {
        $this->tugas = Tugas::with(['proyek', 'user']);
    }

    public function getAll()
    {
        return $this->tugas->get();
    }

    public function find($id)
    {
        return $this->tugas->find($id);
    }

    public function store($data)
    {
        return $this->tugas->create($data);
    }

    public function update($data, $id)
    {
        $tugas = $this->tugas->find($id);
        return $tugas->update($data);
    }

    public function delete($id)
    {
        $tugas = $this->tugas->find($id);
        return $tugas->delete();
    }
}
