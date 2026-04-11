<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function findByEmail($email);
    public function store(array $data);
    public function update(array $data, $id);
    public function delete($id);
}
