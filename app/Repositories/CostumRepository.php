<?php

namespace App\Repositories;

use App\Models\Costum;
use App\Repositories\Interfaces\CostumRepositoryInterface;

class CostumRepository implements CostumRepositoryInterface
{
    public function getAll()
    {
        return Costum::with(["sourceAnimeCategory", "brandCostumCategory"])
            ->orderBy("name")
            ->get();
    }

    public function paginate(int $perPage = 10, array $filters = [])
    {
        $query = Costum::with(["sourceAnimeCategory", "brandCostumCategory"]);

        if (!empty($filters["search"])) {
            $query->where("name", "like", "%" . $filters["search"] . "%");
        }

        if (!empty($filters["source_anime_category_id"])) {
            $query->where(
                "source_anime_category_id",
                $filters["source_anime_category_id"],
            );
        }

        if (!empty($filters["brand_costum_category_id"])) {
            $query->where(
                "brand_costum_category_id",
                $filters["brand_costum_category_id"],
            );
        }

        return $query->orderBy("name")->paginate($perPage);
    }

    public function find($id)
    {
        return Costum::with([
            "sourceAnimeCategory",
            "brandCostumCategory",
        ])->find($id);
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
