<?php

namespace App\Services;

use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderService
{
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAll()
    {
        return $this->orderRepository->getAll();
    }

    public function find($id)
    {
        return $this->orderRepository->find($id);
    }

    public function findByUserId($userId)
    {
        return $this->orderRepository->findByUserId($userId);
    }

    public function create(array $data)
    {
        return $this->orderRepository->store($data);
    }

    public function update(array $data, $id)
    {
        return $this->orderRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->orderRepository->delete($id);
    }
}
