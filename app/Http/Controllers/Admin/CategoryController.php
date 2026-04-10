<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $type = $request->query("type", "source_anime");

        if (
            !in_array($type, [
                "pengeluaran",
                "maintenance",
                "source_anime",
                "brand",
            ])
        ) {
            $type = "source_anime";
        }

        $categories = $this->categoryService->getAll(["type" => $type]);

        return view(
            "admin.master.categories.index",
            compact("categories", "type"),
        );
    }

    public function create(Request $request)
    {
        $type = $request->query("type", "source_anime");
        if (
            !in_array($type, [
                "pengeluaran",
                "maintenance",
                "source_anime",
                "brand",
            ])
        ) {
            $type = "source_anime";
        }
        return view("admin.master.categories.create", compact("type"));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|max:100",
            "desc" => "nullable|string",
            "type" => "required|in:pengeluaran,maintenance,source_anime,brand",
        ]);

        $this->categoryService->create($data);

        return redirect()
            ->route("admin.master.categories.index", ["type" => $data["type"]])
            ->with("success", "Kategori berhasil ditambahkan.");
    }

    public function edit(Request $request, $id)
    {
        $category = $this->categoryService->find($id);
        $type = $category->type;

        return view(
            "admin.master.categories.edit",
            compact("category", "type"),
        );
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "name" => "required|string|max:100",
            "desc" => "nullable|string",
            "type" => "required|in:pengeluaran,maintenance,source_anime,brand",
        ]);

        $this->categoryService->update($data, $id);

        return redirect()
            ->route("admin.master.categories.index", ["type" => $data["type"]])
            ->with("success", "Kategori berhasil diperbarui.");
    }

    public function destroy(Request $request, $id)
    {
        $category = $this->categoryService->find($id);
        $type = $category->type;
        $this->categoryService->delete($id);

        return redirect()
            ->route("admin.master.categories.index", ["type" => $type])
            ->with("success", "Kategori berhasil dihapus.");
    }
}
