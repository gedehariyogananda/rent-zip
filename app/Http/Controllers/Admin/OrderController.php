<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Models\Costum;
use App\Models\User;
use App\Models\Profile;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $query = Order::with("user")->orderBy("created_at", "desc");

        if ($request->filled("search")) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where("code_booking", "like", "%{$search}%")->orWhereHas(
                    "user",
                    function ($qu) use ($search) {
                        $qu->where("username", "like", "%{$search}%");
                    },
                );
            });
        }

        if ($request->filled("filter_return")) {
            if ($request->filter_return === "today") {
                $query->whereDate("tgl_pengembalian", Carbon::today());
            } elseif (
                $request->filter_return === "range" &&
                $request->filled("start_date") &&
                $request->filled("end_date")
            ) {
                $query->whereBetween("tgl_pengembalian", [
                    $request->start_date,
                    $request->end_date,
                ]);
            }
        }

        if (
            $request->filled("filter_transaction") &&
            $request->filter_transaction === "range" &&
            $request->filled("trans_start_date") &&
            $request->filled("trans_end_date")
        ) {
            $query->whereBetween("created_at", [
                $request->trans_start_date . " 00:00:00",
                $request->trans_end_date . " 23:59:59",
            ]);
        }

        if ($request->has("export") && $request->export === "excel") {
            $orders = $query->get();
            $filename = "Laporan_Rental_" . date("Ymd") . ".csv";
            $handle = fopen("php://memory", "w");
            fputcsv($handle, [
                "Kode Booking",
                "Tgl Transaksi",
                "Pelanggan",
                "Tgl Sewa",
                "Tgl Pengembalian",
                "Status",
                "Total",
            ]);
            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->code_booking,
                    $order->created_at->format("Y-m-d H:i:s"),
                    $order->user->username ?? "-",
                    Carbon::parse($order->tgl_sewa)->format("Y-m-d"),
                    Carbon::parse($order->tgl_pengembalian)->format("Y-m-d"),
                    $order->status,
                    $order->total,
                ]);
            }
            frewind($handle);
            $csv = stream_get_contents($handle);
            fclose($handle);

            return response($csv)
                ->header("Content-Type", "text/csv")
                ->header(
                    "Content-Disposition",
                    'attachment; filename="' . $filename . '"',
                );
        }

        $orders = $query->get();
        return view("admin.orders.index", compact("orders"));
    }

    public function create()
    {
        $costums = Costum::with([
            "sourceAnimeCategory",
            "brandCostumCategory",
        ])->get();
        $users = User::where("role_id", 2)->get();
        return view("admin.orders.create", compact("costums", "users"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "tgl_sewa" => "required|date",
            "tgl_pengembalian" => "required|date|after_or_equal:tgl_sewa",
            "user_type" => "required|in:existing,new",
            "costums" => "required|array|min:1",
            "costums.*.id" => "required|exists:costums,id",
            "costums.*.pcs" => "required|integer|min:1",
        ]);

        if ($request->user_type === "existing") {
            $request->validate([
                "user_id" => "required|exists:users,id",
            ]);
        } else {
            $request->validate([
                "username" => "required|string|max:255",
                "email" => "required|email|unique:users,email",
                "password" => "required|min:6",
                "phone" => "required|string|max:20",
                "address" => "required|string",
                "no_darurat" => "required|string|max:20",
                "ktp_url" => "required|image|mimes:jpeg,png,jpg|max:2048",
                "nik" => "required|string|max:255",
                "photo_with_nik" =>
                    "required|image|mimes:jpeg,png,jpg|max:2048",
            ]);
        }

        try {
            DB::beginTransaction();

            $userId = $request->user_id;

            if ($request->user_type === "new") {
                $user = User::create([
                    "username" => $request->username,
                    "email" => $request->email,
                    "password" => Hash::make($request->password),
                    "phone" => $request->phone,
                    "address" => $request->address,
                    "role_id" => 2,
                    "is_active" => true,
                ]);

                $ktpPath = $request
                    ->file("ktp_url")
                    ->store("profiles/ktp", "public");
                $photoWithNikPath = $request
                    ->file("photo_with_nik")
                    ->store("profiles/photo_with_nik", "public");

                Profile::create([
                    "user_id" => $user->id,
                    "no_darurat" => $request->no_darurat,
                    "ktp_url" => $ktpPath,
                    "nik" => $request->nik,
                    "photo_with_nik" => $photoWithNikPath,
                ]);

                $userId = $user->id;
            }

            $tglSewa = Carbon::parse($request->tgl_sewa);
            $tglPengembalian = Carbon::parse($request->tgl_pengembalian);
            $days = $tglSewa->diffInDays($tglPengembalian);
            if ($days == 0) {
                $days = 1; // Minimum 1 day rental
            }

            $total = 0;
            $orderItems = [];

            foreach ($request->costums as $item) {
                $costum = Costum::find($item["id"]);
                $subtotal = $costum->calculatePrice($days) * $item["pcs"];
                $total += $subtotal;

                $orderItems[] = [
                    "costum_id" => $costum->id,
                    "pcs" => $item["pcs"],
                ];
            }

            $orderCode = "ORD-" . strtoupper(Str::random(8));

            $order = Order::create([
                "code_booking" => $orderCode,
                "user_id" => $userId,
                "tgl_sewa" => $tglSewa,
                "tgl_pengembalian" => $tglPengembalian,
                "status" => "pending",
                "total" => $total,
            ]);

            foreach ($orderItems as $item) {
                OrderItem::create([
                    "order_id" => $order->id,
                    "costum_id" => $item["costum_id"],
                    "pcs" => $item["pcs"],
                ]);
            }

            DB::commit();

            return redirect()
                ->route("admin.orders.show", $order->id)
                ->with("success", "Pesanan berhasil dibuat");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with("error", "Terjadi kesalahan: " . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $order = Order::with(["user.profile", "items.costum"])->findOrFail($id);
        return view("admin.orders.show", compact("order"));
    }

    public function edit($id)
    {
        $order = Order::with("items")->findOrFail($id);

        if ($order->status !== "pending") {
            return redirect()
                ->route("admin.orders.show", $id)
                ->with("error", "Hanya pesanan pending yang dapat diedit.");
        }

        $costums = Costum::with([
            "sourceAnimeCategory",
            "brandCostumCategory",
        ])->get();
        return view("admin.orders.edit", compact("order", "costums"));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== "pending") {
            return redirect()
                ->route("admin.orders.show", $id)
                ->with("error", "Hanya pesanan pending yang dapat diedit.");
        }

        $request->validate([
            "tgl_sewa" => "required|date",
            "tgl_pengembalian" => "required|date|after_or_equal:tgl_sewa",
            "costums" => "required|array|min:1",
            "costums.*.id" => "required|exists:costums,id",
            "costums.*.pcs" => "required|integer|min:1",
        ]);

        try {
            DB::beginTransaction();

            $tglSewa = Carbon::parse($request->tgl_sewa);
            $tglPengembalian = Carbon::parse($request->tgl_pengembalian);
            $days = $tglSewa->diffInDays($tglPengembalian);
            if ($days == 0) {
                $days = 1; // Minimum 1 day rental
            }

            $total = 0;
            $orderItems = [];

            foreach ($request->costums as $item) {
                $costum = Costum::find($item["id"]);
                $subtotal = $costum->calculatePrice($days) * $item["pcs"];
                $total += $subtotal;

                $orderItems[] = [
                    "costum_id" => $costum->id,
                    "pcs" => $item["pcs"],
                ];
            }

            $order->update([
                "tgl_sewa" => $tglSewa,
                "tgl_pengembalian" => $tglPengembalian,
                "total" => $total,
            ]);

            $order->items()->delete();

            foreach ($orderItems as $item) {
                OrderItem::create([
                    "order_id" => $order->id,
                    "costum_id" => $item["costum_id"],
                    "pcs" => $item["pcs"],
                ]);
            }

            DB::commit();

            return redirect()
                ->route("admin.orders.show", $order->id)
                ->with("success", "Pesanan berhasil diperbarui");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with("error", "Terjadi kesalahan: " . $e->getMessage())
                ->withInput();
        }
    }

    public function qris($id)
    {
        $order = Order::with("items.costum")->findOrFail($id);

        if ($order->status !== "pending") {
            return back()->with(
                "error",
                "Hanya pesanan pending yang dapat membuat QRIS.",
            );
        }

        foreach ($order->items as $item) {
            if ($item->costum && $item->pcs > $item->costum->available_stock) {
                return back()->with(
                    "error",
                    "Stok kostum {$item->costum->name} tidak mencukupi untuk diproses.",
                );
            }
        }

        $order->update([
            "qris" => Str::random(20),
            "status" => "pending",
        ]);

        return back()->with("success", "QRIS berhasil dibuat.");
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            "status" => "required|in:paid,canceled",
        ]);

        $order = Order::with("items.costum")->findOrFail($id);
        $oldStatus = $order->status;

        if ($request->status === "paid" && $oldStatus === "pending") {
            foreach ($order->items as $item) {
                if (
                    $item->costum &&
                    $item->pcs > $item->costum->available_stock
                ) {
                    return back()->with(
                        "error",
                        "Stok kostum {$item->costum->name} tidak mencukupi untuk diproses.",
                    );
                }
            }
        }

        $order->update([
            "status" => $request->status,
        ]);

        if ($request->status === "paid" && $oldStatus === "pending") {
            Finance::create([
                "category_id" => null,
                "total" => $order->total,
                "desc" => "Pembayaran Pesanan [{$order->code_booking}]",
                "type" => "pemasukan",
            ]);
        } elseif (
            $request->status === "canceled" &&
            in_array($oldStatus, ["paid", "done"])
        ) {
            Finance::create([
                "category_id" => null,
                "total" => $order->total,
                "desc" => "Tidak jadinya pemesanan kode {$order->code_booking}",
                "type" => "pengeluaran",
            ]);
        }

        return back()->with(
            "success",
            "Status pesanan diperbarui menjadi " . $request->status,
        );
    }

    public function confirmReturn($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== "paid") {
            return back()->with(
                "error",
                "Hanya pesanan yang sudah dibayar yang dapat dikembalikan.",
            );
        }

        $order->update([
            "status" => "done",
        ]);

        return back()->with(
            "success",
            "Konfirmasi pengembalian kostum berhasil, stok telah dikembalikan.",
        );
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        if (in_array($order->status, ["paid", "done"])) {
            Finance::create([
                "category_id" => null,
                "total" => $order->total,
                "desc" => "Tidak jadinya pemesanan kode {$order->code_booking}",
                "type" => "pengeluaran",
            ]);
        }

        $order->delete();
        return redirect()
            ->route("admin.orders.index")
            ->with("success", "Pesanan berhasil dihapus");
    }
}
