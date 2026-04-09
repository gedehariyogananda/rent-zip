<?php

namespace App\Repositories;

use App\Models\Finance;
use App\Repositories\Interfaces\FinanceRepositoryInterface;

class FinanceRepository implements FinanceRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        $query = Finance::with("category");

        if (isset($filters["type"]) && $filters["type"] !== "") {
            $query->where("type", $filters["type"]);
        }

        if (isset($filters["year"]) && $filters["year"] !== "") {
            $query->whereYear("created_at", $filters["year"]);
        }

        return $query->orderByDesc("created_at")->get();
    }

    public function paginate(int $perPage = 10, array $filters = [])
    {
        $query = Finance::with("category");

        if (isset($filters["type"]) && $filters["type"] !== "") {
            $query->where("type", $filters["type"]);
        }

        if (isset($filters["year"]) && $filters["year"] !== "") {
            $query->whereYear("created_at", $filters["year"]);
        }

        return $query->orderByDesc("created_at")->paginate($perPage);
    }

    public function find($id)
    {
        return Finance::with("category")->find($id);
    }

    public function store(array $data)
    {
        return Finance::create($data);
    }

    public function update(array $data, $id)
    {
        $finance = Finance::find($id);
        if ($finance) {
            $finance->update($data);
            return $finance;
        }
        return null;
    }

    public function delete($id)
    {
        $finance = Finance::find($id);
        if ($finance) {
            $finance->delete();
            return $finance;
        }
        return null;
    }
}
