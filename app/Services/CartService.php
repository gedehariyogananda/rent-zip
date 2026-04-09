<?php

namespace App\Services;

use App\Repositories\Interfaces\CartRepositoryInterface;

class CartService
{
    protected CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getAll()
    {
        return $this->cartRepository->getAll();
    }

    public function find($id)
    {
        return $this->cartRepository->find($id);
    }

    public function findByUserId($userId)
    {
        return $this->cartRepository->findByUserId($userId);
    }

    public function create(array $data)
    {
        return $this->cartRepository->store($data);
    }

    public function update(array $data, $id)
    {
        return $this->cartRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->cartRepository->delete($id);
    }
}
