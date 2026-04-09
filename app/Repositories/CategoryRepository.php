<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll()
    {
        return Category::orderBy('name')->get();
    }

    public function find($id)
    {
        return Category::find($id);
    }

    public function store(array $data)
    {
        return Category::create($data);
    }

    public function update(array $data, $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->update($data);
            return $category;
        }
        return null;
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return $category;
        }
        return null;
    }
}
