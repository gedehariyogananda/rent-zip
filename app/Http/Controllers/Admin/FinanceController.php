<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FinanceService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    protected FinanceService $financeService;
    protected CategoryService $categoryService;

    public function __construct(FinanceService $financeService, CategoryService $categoryService)
    {
        $this->financeService = $financeService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $finances = $this->financeService->getAll();
        return view('admin.finances.index', compact('finances'));
    }

    public function create()
    {
        $categories = $this->categoryService->getAll();
        return view('admin.finances.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // TODO: implement
        return redirect()->route('admin.finances.index');
    }

    public function show($id)
    {
        $finance = $this->financeService->find($id);
        return view('admin.finances.show', compact('finance'));
    }

    public function edit($id)
    {
        $finance = $this->financeService->find($id);
        $categories = $this->categoryService->getAll();
        return view('admin.finances.edit', compact('finance', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // TODO: implement
        return redirect()->route('admin.finances.index');
    }

    public function destroy($id)
    {
        // TODO: implement
        return redirect()->route('admin.finances.index');
    }
}
