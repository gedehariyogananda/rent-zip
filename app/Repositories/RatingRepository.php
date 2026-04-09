<?php

namespace App\Repositories;

use App\Models\Rating;
use App\Repositories\Interfaces\RatingRepositoryInterface;

class RatingRepository implements RatingRepositoryInterface
{
    public function getAll()
    {
        return Rating::with('user')->orderByDesc('created_at')->get();
    }

    public function find($id)
    {
        return Rating::with('user')->find($id);
    }

    public function findByUserId($userId)
    {
        return Rating::where('user_id', $userId)->first();
    }

    public function store(array $data)
    {
        return Rating::create($data);
    }

    public function update(array $data, $id)
    {
        $rating = Rating::find($id);
        if ($rating) {
            $rating->update($data);
            return $rating;
        }
        return null;
    }

    public function delete($id)
    {
        $rating = Rating::find($id);
        if ($rating) {
            $rating->delete();
            return $rating;
        }
        return null;
    }
}
