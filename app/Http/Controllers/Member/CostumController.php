<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\CostumService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CostumController extends Controller
{
    protected CostumService $costumService;
    protected CategoryService $categoryService;

    public function __construct(CostumService $costumService, CategoryService $categoryService)
    {
        $this->costumService = $costumService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $costums = $this->costumService->getAll();
        $categories = $this->categoryService->getAll();
        return view('member.costums.index', compact('costums', 'categories'));
    }

    public function show($id)
    {
        $costum = $this->costumService->find($id);
        return view('member.costums.show', compact('costum'));
    }
}
