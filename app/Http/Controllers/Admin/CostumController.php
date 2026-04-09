<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CostumService;
use App\Services\CategoryService;
use App\Services\ImageService;
use Illuminate\Http\Request;

class CostumController extends Controller
{
    protected CostumService $costumService;
    protected CategoryService $categoryService;
    protected ImageService $imageService;

    public function __construct(
        CostumService $costumService,
        CategoryService $categoryService,
        ImageService $imageService,
    ) {
        $this->costumService = $costumService;
        $this->categoryService = $categoryService;
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $filters = [
            "search" => $request->input("search"),
            "category_id" => $request->input("category_id"),
        ];

        $costums = $this->costumService->paginate(10, $filters);
        $categories = $this->categoryService->getAll(["type" => "costum"]);

        return view(
            "admin.costums.index",
            compact("costums", "categories", "filters"),
        );
    }

    public function create()
    {
        $categories = $this->categoryService->getAll(["type" => "costum"]);
        return view("admin.costums.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "source" => "nullable|string|max:255",
            "size" => "required|in:XS,S,M,L,XL,XXL",
            "stock" => "required|integer|min:0",
            "priceday" => "required|numeric|min:0",
            "desc" => "nullable|string",
            "category_id" => "required|exists:categories,id",
            "photo_url" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
        ]);

        if ($request->hasFile("photo_url")) {
            $data["photo_url"] = $this->imageService->upload(
                $request->file("photo_url"),
                "costums",
            );
        }

        $this->costumService->create($data);

        return redirect()
            ->route("admin.costums.index")
            ->with("success", "Kostum berhasil ditambahkan.");
    }

    public function show($id)
    {
        $costum = $this->costumService->find($id);
        return view("admin.costums.show", compact("costum"));
    }

    public function edit($id)
    {
        $costum = $this->costumService->find($id);
        $categories = $this->categoryService->getAll(["type" => "costum"]);
        return view("admin.costums.edit", compact("costum", "categories"));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "source" => "nullable|string|max:255",
            "size" => "required|in:XS,S,M,L,XL,XXL",
            "priceday" => "required|numeric|min:0",
            "desc" => "nullable|string",
            "category_id" => "required|exists:categories,id",
            "photo_url" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
        ]);

        $costum = $this->costumService->find($id);

        if ($request->hasFile("photo_url")) {
            $data["photo_url"] = $this->imageService->replace(
                $request->file("photo_url"),
                $costum->photo_url,
                "costums",
            );
        } else {
            unset($data["photo_url"]); // jangan overwrite dengan null
        }

        $this->costumService->update($data, $id);

        return redirect()
            ->route("admin.costums.index")
            ->with("success", "Kostum berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $costum = $this->costumService->find($id);
        $this->imageService->delete($costum->photo_url);
        $this->costumService->delete($id);

        return redirect()
            ->route("admin.costums.index")
            ->with("success", "Kostum berhasil dihapus.");
    }
}
