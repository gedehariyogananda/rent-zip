<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\PenggunaRepositoryInterface;

class PenggunaRepository implements PenggunaRepositoryInterface
{
    public function getAll()
    {
        $pengguna = User::orderBy('nama')
            ->get();

        return $pengguna;
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function store(array $data)
    {
        return User::create($data);
    }

    public function update(array $data, $id)
    {
        $dataUser = User::find($id);
        if ($dataUser) {
            return $dataUser->update($data);
        }

        return null;
    }

    public function delete($id)
    {
        $dataUser = User::find($id);
        if ($dataUser) {
            $dataUser->delete();
            return $dataUser;
        }

        return null;
    }
}
