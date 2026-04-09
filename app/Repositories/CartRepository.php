<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    public function getAll()
    {
        return Cart::with('user', 'costum')->get();
    }

    public function find($id)
    {
        return Cart::with('costum')->find($id);
    }

    public function findByUserId($userId)
    {
        return Cart::with('costum')->where('user_id', $userId)->get();
    }

    public function store(array $data)
    {
        return Cart::create($data);
    }

    public function update(array $data, $id)
    {
        $cart = Cart::find($id);
        if ($cart) {
            $cart->update($data);
            return $cart;
        }
        return null;
    }

    public function delete($id)
    {
        $cart = Cart::find($id);
        if ($cart) {
            $cart->delete();
            return $cart;
        }
        return null;
    }
}
