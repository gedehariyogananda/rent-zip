<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FinanceService;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Models\Finance;

class FinanceController extends Controller
{
    protected FinanceService $financeService;
    protected CategoryService $categoryService;

    public function __construct(
        FinanceService $financeService,
        CategoryService $categoryService,
    ) {
        $this->financeService = $financeService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $filters = [
            "type" => $request->input("type"),
            "year" => $request->input("year", date("Y")),
        ];

        $allFinances = $this->financeService->getAll($filters);
        $finances = $this->financeService->paginate(10, $filters);

        $totalPemasukan = $allFinances
            ->where("type", "pemasukan")
            ->sum("total");
        $totalPengeluaran = $allFinances
            ->where("type", "pengeluaran")
            ->sum("total");
        $keuntungan = $totalPemasukan - $totalPengeluaran;
        $jumlahTransaksi = $allFinances->count();

        $availableYears = Finance::selectRaw("YEAR(created_at) as year")
            ->distinct()
            ->pluck("year")
            ->sort()
            ->reverse()
            ->toArray();

        if (empty($availableYears)) {
            $availableYears = [date("Y")];
        }

        return view(
            "admin.finances.index",
            compact(
                "finances",
                "keuntungan",
                "totalPengeluaran",
                "jumlahTransaksi",
                "filters",
                "availableYears",
            ),
        );
    }

    public function export(Request $request)
    {
        $filters = [
            "type" => $request->input("type"),
            "year" => $request->input("year"),
        ];

        $finances = $this->financeService->getAll($filters);

        $fileName = "Laporan_Keuangan_" . date("Ymd_His") . ".csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = ["Tanggal", "Jenis", "Kategori", "Deskripsi", "Jumlah"];

        $callback = function () use ($finances, $columns) {
            $file = fopen("php://output", "w");
            fputcsv($file, $columns);

            foreach ($finances as $finance) {
                fputcsv($file, [
                    $finance->created_at,
                    $finance->type,
                    $finance->category ? $finance->category->name : "-",
                    $finance->desc,
                    $finance->total,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function create()
    {
        $categories = $this->categoryService->getAll(["type" => "pengeluaran"]);
        return view("admin.finances.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "category_id" => "required|exists:categories,id",
            "total" => "required|numeric|min:0",
            "desc" => "required|string",
            "created_at" => "required|date",
        ]);

        $data["type"] = "pengeluaran";

        $this->financeService->create($data);

        return redirect()
            ->route("admin.finances.index")
            ->with("success", "Pengeluaran berhasil ditambahkan");
    }

    public function show($id)
    {
        $finance = $this->financeService->find($id);
        return view("admin.finances.show", compact("finance"));
    }

    public function edit($id)
    {
        $finance = $this->financeService->find($id);
        $categories = $this->categoryService->getAll(["type" => "pengeluaran"]);
        return view("admin.finances.edit", compact("finance", "categories"));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "category_id" => "required|exists:categories,id",
            "total" => "required|numeric|min:0",
            "desc" => "required|string",
            "created_at" => "required|date",
        ]);

        $this->financeService->update($data, $id);

        return redirect()
            ->route("admin.finances.index")
            ->with("success", "Data berhasil diubah");
    }

    public function destroy($id)
    {
        $this->financeService->delete($id);

        return redirect()
            ->route("admin.finances.index")
            ->with("success", "Data berhasil dihapus");
    }
}
