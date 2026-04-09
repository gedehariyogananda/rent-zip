<?php

namespace App\Repositories;

use App\Models\Maintenance;
use App\Repositories\Interfaces\MaintenanceRepositoryInterface;

class MaintenanceRepository implements MaintenanceRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        return Maintenance::with("costum")->orderByDesc("created_at")->get();
    }

    public function paginate(int $perPage = 10, array $filters = [])
    {
        $query = Maintenance::with(["costum", "category"]);

        if (isset($filters["costum_id"]) && $filters["costum_id"] !== "") {
            $query->where("costum_id", $filters["costum_id"]);
        }

        if (isset($filters["type"]) && $filters["type"] !== "") {
            $query->where("type", $filters["type"]);
        }

        return $query->orderByDesc("created_at")->paginate($perPage);
    }

    public function find($id)
    {
        return Maintenance::with("costum")->find($id);
    }

    public function store(array $data)
    {
        return Maintenance::create($data);
    }

    public function update(array $data, $id)
    {
        $maintenance = Maintenance::find($id);
        if ($maintenance) {
            $maintenance->update($data);
            return $maintenance;
        }
        return null;
    }

    public function delete($id)
    {
        $maintenance = Maintenance::find($id);
        if ($maintenance) {
            $maintenance->delete();
            return $maintenance;
        }
        return null;
    }
}
