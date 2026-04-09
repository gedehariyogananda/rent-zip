<?php

namespace App\Repositories\Interfaces;

interface CostumRepositoryInterface
{
    public function getAll();
    public function paginate(int $perPage = 10, array $filters = []);
    public function find($id);
    public function store(array $data);
    public function update(array $data, $id);
    public function delete($id);
}
