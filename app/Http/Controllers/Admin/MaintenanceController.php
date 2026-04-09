<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MaintenanceService;
use App\Services\CostumService;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    protected MaintenanceService $maintenanceService;
    protected CostumService $costumService;
    protected CategoryService $categoryService;

    public function __construct(
        MaintenanceService $maintenanceService,
        CostumService $costumService,
        CategoryService $categoryService,
    ) {
        $this->maintenanceService = $maintenanceService;
        $this->costumService = $costumService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $filters = [
            "costum_id" => $request->input("costum_id"),
            "type" => $request->input("type"),
        ];

        $maintenances = $this->maintenanceService->paginate(10, $filters);
        $costums = $this->costumService->getAll();

        return view(
            "admin.maintenances.index",
            compact("maintenances", "costums", "filters"),
        );
    }

    public function create()
    {
        $costums = $this->costumService->getAll();
        $categories = $this->categoryService->getAll(["type" => "maintenance"]);
        return view(
            "admin.maintenances.create",
            compact("costums", "categories"),
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "costum_id" => "required|exists:costums,id",
            "type" => "required|in:penambahan,pengurangan",
            "pcs" => [
                "required",
                "integer",
                "min:1",
                function ($attribute, $value, $fail) use ($request) {
                    if (
                        $request->type === "pengurangan" &&
                        $request->costum_id
                    ) {
                        $costum = $this->costumService->find(
                            $request->costum_id,
                        );
                        if ($costum && $value > $costum->stock) {
                            $fail(
                                "Jumlah pengurangan melebihi stok yang tersedia ({$costum->stock} pcs).",
                            );
                        }
                    }
                },
            ],
            "category_id" =>
                "nullable|required_if:type,pengurangan|exists:categories,id",
            "desc" => "nullable|string",
        ]);

        DB::transaction(function () use ($data) {
            $costum = $this->costumService->find($data["costum_id"]);

            $newStock =
                $data["type"] === "penambahan"
                    ? $costum->stock + $data["pcs"]
                    : max(0, $costum->stock - $data["pcs"]);

            $data["current_stock"] = $newStock;

            $this->maintenanceService->create($data);

            $this->costumService->update(["stock" => $newStock], $costum->id);
        });

        return redirect()
            ->route("admin.maintenances.index")
            ->with(
                "success",
                "Riwayat stok berhasil dicatat dan stok kostum telah diperbarui.",
            );
    }

    public function show($id)
    {
        $maintenance = $this->maintenanceService->find($id);
        return view("admin.maintenances.show", compact("maintenance"));
    }

    public function edit($id)
    {
        return redirect()
            ->route("admin.maintenances.index")
            ->with(
                "error",
                "Log stok tidak dapat diedit untuk menjaga konsistensi data. Silakan hapus dan buat ulang jika ada kesalahan.",
            );
    }

    public function update(Request $request, $id)
    {
        return redirect()->route("admin.maintenances.index");
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $maintenance = $this->maintenanceService->find($id);
            $costum = $this->costumService->find($maintenance->costum_id);

            // Rollback stok
            $newStock =
                $maintenance->type === "penambahan"
                    ? max(0, $costum->stock - $maintenance->pcs)
                    : $costum->stock + $maintenance->pcs;

            $this->costumService->update(["stock" => $newStock], $costum->id);
            $this->maintenanceService->delete($id);
        });

        return redirect()
            ->route("admin.maintenances.index")
            ->with(
                "success",
                "Riwayat stok dihapus dan stok kostum telah disesuaikan.",
            );
    }
}
