<?php

namespace App\Repositories\Interfaces;

interface PenggunaRepositoryInterface
{
    public function find($id);
    public function getAll();
    public function store(array $data);
    public function update(array $data, $id);
    public function delete($id);
}
