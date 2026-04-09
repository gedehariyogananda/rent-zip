<?php

namespace App\Services;

use App\Repositories\Interfaces\CostumRepositoryInterface;

class CostumService
{
    protected CostumRepositoryInterface $costumRepository;

    public function __construct(CostumRepositoryInterface $costumRepository)
    {
        $this->costumRepository = $costumRepository;
    }

    public function getAll()
    {
        return $this->costumRepository->getAll();
    }

    public function paginate(int $perPage = 10, array $filters = [])
    {
        return $this->costumRepository->paginate($perPage, $filters);
    }

    public function find($id)
    {
        return $this->costumRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->costumRepository->store($data);
    }

    public function update(array $data, $id)
    {
        return $this->costumRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->costumRepository->delete($id);
    }
}
