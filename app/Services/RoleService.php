<?php

namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleService
{
    protected RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAll()
    {
        return $this->roleRepository->getAll();
    }

    public function find($id)
    {
        return $this->roleRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->roleRepository->store($data);
    }

    public function update(array $data, $id)
    {
        return $this->roleRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->roleRepository->delete($id);
    }
}
