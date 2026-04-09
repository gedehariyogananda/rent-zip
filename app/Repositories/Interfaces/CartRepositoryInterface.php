<?php

namespace App\Repositories\Interfaces;

interface CartRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function findByUserId($userId);
    public function store(array $data);
    public function update(array $data, $id);
    public function delete($id);
}
