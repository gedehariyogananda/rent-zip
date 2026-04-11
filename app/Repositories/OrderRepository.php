<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function getAll()
    {
        return Order::with("user", "items.costum")
            ->orderByDesc("created_at")
            ->get();
    }

    public function find($id)
    {
        return Order::with("user", "items.costum")->find($id);
    }

    public function findByUserId($userId, array $filters = [])
    {
        $query = Order::with("items.costum")->where("user_id", $userId);

        if (!empty($filters["status"])) {
            $query->where("status", $filters["status"]);
        }

        if (!empty($filters["start_date"])) {
            $query->whereDate("created_at", ">=", $filters["start_date"]);
        }

        if (!empty($filters["end_date"])) {
            $query->whereDate("created_at", "<=", $filters["end_date"]);
        }

        return $query->orderByDesc("created_at")->get();
    }

    public function store(array $data)
    {
        return Order::create($data);
    }

    public function update(array $data, $id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->update($data);
            return $order;
        }
        return null;
    }

    public function delete($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
            return $order;
        }
        return null;
    }
}
