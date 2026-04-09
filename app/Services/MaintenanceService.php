<?php

namespace App\Services;

use App\Repositories\Interfaces\MaintenanceRepositoryInterface;

class MaintenanceService
{
    protected MaintenanceRepositoryInterface $maintenanceRepository;

    public function __construct(MaintenanceRepositoryInterface $maintenanceRepository)
    {
        $this->maintenanceRepository = $maintenanceRepository;
    }

    public function getAll()
    {
        return $this->maintenanceRepository->getAll();
    }

    public function find($id)
    {
        return $this->maintenanceRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->maintenanceRepository->store($data);
    }

    public function update(array $data, $id)
    {
        return $this->maintenanceRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->maintenanceRepository->delete($id);
    }
}
