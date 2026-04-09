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

    public function paginate(int $perPage = 10, array $filters = [])
    {
        $query = Costum::with('category');

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        return $query->orderBy('name')->paginate($perPage);
    }

    public function find($id)
    {
        return Costum::with('category')->find($id);
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
