<?php

namespace App\Services;

use App\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileService
{
    protected ProfileRepositoryInterface $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function getAll()
    {
        return $this->profileRepository->getAll();
    }

    public function find($id)
    {
        return $this->profileRepository->find($id);
    }

    public function findByUserId($userId)
    {
        return $this->profileRepository->findByUserId($userId);
    }

    public function create(array $data)
    {
        return $this->profileRepository->store($data);
    }

    public function update(array $data, $id)
    {
        return $this->profileRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->profileRepository->delete($id);
    }
}
