<?php

namespace App\Repositories;

use App\Models\Finance;
use App\Repositories\Interfaces\FinanceRepositoryInterface;

class FinanceRepository implements FinanceRepositoryInterface
{
    public function getAll()
    {
        return Finance::with('category')->orderByDesc('created_at')->get();
    }

    public function find($id)
    {
        return Finance::with('category')->find($id);
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
