<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function getAll()
    {
        return Profile::with('user')->get();
    }

    public function find($id)
    {
        return Profile::with('user')->find($id);
    }

    public function findByUserId($userId)
    {
        return Profile::where('user_id', $userId)->first();
    }

    public function store(array $data)
    {
        return Profile::create($data);
    }

    public function update(array $data, $id)
    {
        $profile = Profile::find($id);
        if ($profile) {
            $profile->update($data);
            return $profile;
        }
        return null;
    }

    public function delete($id)
    {
        $profile = Profile::find($id);
        if ($profile) {
            $profile->delete();
            return $profile;
        }
        return null;
    }
}
