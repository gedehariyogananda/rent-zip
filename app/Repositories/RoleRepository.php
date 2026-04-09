<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAll()
    {
        return Role::orderBy('name')->get();
    }

    public function find($id)
    {
        return Role::find($id);
    }

    public function store(array $data)
    {
        return Role::create($data);
    }

    public function update(array $data, $id)
    {
        $role = Role::find($id);
        if ($role) {
            $role->update($data);
            return $role;
        }
        return null;
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if ($role) {
            $role->delete();
            return $role;
        }
        return null;
    }
}
