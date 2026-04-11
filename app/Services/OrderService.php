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

    public function findByUserId($userId, array $filters = [])
    {
        return $this->orderRepository->findByUserId($userId, $filters);
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

    public function confirmPayment($id, $userId)
    {
        $order = $this->find($id);

        if (!$order || $order->user_id !== $userId) {
            throw new \Exception("Order not found or unauthorized", 404);
        }

        if ($order->status !== "pending") {
            throw new \Exception("Only pending orders can be confirmed", 400);
        }

        $this->update(
            [
                "status" => "paid",
                "qris" => null,
            ],
            $id,
        );

        $order->status = "paid";
        $order->qris = null;

        return $order;
    }
}
