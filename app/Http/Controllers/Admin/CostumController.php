<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.costums.index', compact('costums'));
    }

    public function create()
    {
        $categories = $this->categoryService->getAll();
        return view('admin.costums.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // TODO: implement
        return redirect()->route('admin.costums.index');
    }

    public function show($id)
    {
        $costum = $this->costumService->find($id);
        return view('admin.costums.show', compact('costum'));
    }

    public function edit($id)
    {
        $costum = $this->costumService->find($id);
        $categories = $this->categoryService->getAll();
        return view('admin.costums.edit', compact('costum', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // TODO: implement
        return redirect()->route('admin.costums.index');
    }

    public function destroy($id)
    {
        // TODO: implement
        return redirect()->route('admin.costums.index');
    }
}
