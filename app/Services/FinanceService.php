<?php

namespace App\Services;

use App\Repositories\Interfaces\FinanceRepositoryInterface;

class FinanceService
{
    protected FinanceRepositoryInterface $financeRepository;

    public function __construct(FinanceRepositoryInterface $financeRepository)
    {
        $this->financeRepository = $financeRepository;
    }

    public function getAll(array $filters = [])
    {
        return $this->financeRepository->getAll($filters);
    }

    public function paginate(int $perPage = 10, array $filters = [])
    {
        return $this->financeRepository->paginate($perPage, $filters);
    }

    public function find($id)
    {
        return $this->financeRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->financeRepository->store($data);
    }

    public function update(array $data, $id)
    {
        return $this->financeRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->financeRepository->delete($id);
    }
}
