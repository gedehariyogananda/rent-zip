<?php

namespace App\Repositories\Interfaces;

interface ProyekRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function store($data);
    public function update($data, $id);
    public function delete($id);
}
