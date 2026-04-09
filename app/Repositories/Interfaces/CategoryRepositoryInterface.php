<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAll(array $filters = []);
    public function find($id);
    public function store(array $data);
    public function update(array $data, $id);
    public function delete($id);
}
