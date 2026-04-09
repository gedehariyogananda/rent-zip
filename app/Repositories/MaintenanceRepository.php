<?php

namespace App\Repositories;

use App\Models\Maintenance;
use App\Repositories\Interfaces\MaintenanceRepositoryInterface;

class MaintenanceRepository implements MaintenanceRepositoryInterface
{
    public function getAll()
    {
        return Maintenance::with('costum')->orderByDesc('created_at')->get();
    }

    public function find($id)
    {
        return Maintenance::with('costum')->find($id);
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
