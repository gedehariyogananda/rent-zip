<?php

namespace App\Repositories;

use App\Models\Costum;
use App\Repositories\Interfaces\CostumRepositoryInterface;

class CostumRepository implements CostumRepositoryInterface
{
    public function getAll()
    {
        return Costum::with('category')->orderBy('name')->get();
    }

    public function find($id)
    {
        return Costum::with('category', 'ratings')->find($id);
    }

    public function store(array $data)
    {
        return Costum::create($data);
    }

    public function update(array $data, $id)
    {
        $costum = Costum::find($id);
        if ($costum) {
            $costum->update($data);
            return $costum;
        }
        return null;
    }

    public function delete($id)
    {
        $costum = Costum::find($id);
        if ($costum) {
            $costum->delete();
            return $costum;
        }
        return null;
    }
}
