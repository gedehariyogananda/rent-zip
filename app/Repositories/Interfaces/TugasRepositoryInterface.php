<?php

namespace App\Repositories\Interfaces;

interface TugasRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function store($data);
    public function update($data, $id);
    public function delete($id);
}
