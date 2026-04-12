<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Finance;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderController extends Controller
{
    /**
     * Get all transactions for Admin Mobile App
     * Filters: status, search (code_booking), start_date, end_date
     *
     * Endpoint: GET /api/v1/admin/orders
     */
    public function index(Request $request)
    {
        try {
            $query = Order::with(["user", "items.costum"]);

            // Filter by status (pending, paid, canceled, done)
            if ($request->filled("status")) {
                $query->where("status", $request->status);
            }

            // Filter/Search by code_booking
            if ($request->filled("search")) {
                $query->where(
                    "code_booking",
                    "like",
                    "%" . $request->search . "%",
                );
            }

            // Filter by date range (created_at)
            if ($request->filled("start_date")) {
                $query->whereDate("created_at", ">=", $request->start_date);
            }
            if ($request->filled("end_date")) {
                $query->whereDate("created_at", "<=", $request->end_date);
            }

            $orders = $query->orderByDesc("created_at")->get();

            // Format photo URLs for the costums inside the order items
            $orders->transform(function ($order) {
                $order->items->transform(function ($item) {
                    if ($item->costum && $item->costum->photo_url) {
                        $item->costum->photo_url = url(
                            "storage/" . $item->costum->photo_url,
                        );
                    }
                    return $item;
                });
                return $order;
            });

            return response()->json(
                [
                    "success" => true,
                    "message" => "Daftar semua transaksi berhasil dimuat",
                    "data" => $orders,
                ],
                200,
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Gagal memuat transaksi: " . $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Get order detail by ID for Admin
     *
     * Endpoint: GET /api/v1/admin/orders/{id}
     */
    public function show($id)
    {
        try {
            $order = Order::with(["user", "items.costum"])->findOrFail($id);

            // Format photo URLs for the costums inside the order items
            $order->items->transform(function ($item) {
                if ($item->costum && $item->costum->photo_url) {
                    $item->costum->photo_url = url(
                        "storage/" . $item->costum->photo_url,
                    );
                }
                return $item;
            });

            return response()->json(
                [
                    "success" => true,
                    "message" => "Detail pesanan berhasil dimuat",
                    "data" => $order,
                ],
                200,
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Pesanan tidak ditemukan: " . $e->getMessage(),
                ],
                404,
            );
        }
    }

    /**
     * Verifikasi Pembayaran Transaksi (Set status to 'paid')
     *
     * Endpoint: PATCH /api/v1/admin/orders/{id}/verify
     */
    public function verifyPayment($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::with("items.costum")->findOrFail($id);

            if ($order->status !== "pending") {
                throw new Exception(
                    "Hanya pesanan berstatus pending yang dapat diverifikasi pembayarannya.",
                );
            }

            // Cek ketersediaan stok sebelum set ke paid
            foreach ($order->items as $item) {
                if (
                    $item->costum &&
                    $item->pcs > $item->costum->available_stock
                ) {
                    throw new Exception(
                        "Stok kostum {$item->costum->name} tidak mencukupi untuk diproses.",
                    );
                }
            }

            // Update status
            $order->update([
                "status" => "paid",
            ]);

            // Tambah catatan ke Keuangan (Pemasukan)
            Finance::create([
                "category_id" => null,
                "total" => $order->total,
                "desc" => "Pembayaran Pesanan [{$order->code_booking}] via Mobile Admin",
                "type" => "pemasukan",
            ]);

            // Notifikasi ke User
            Notification::create([
                "user_id" => $order->user_id,
                "title" => "Pembayaran Berhasil",
                "message" => "Pembayaran untuk pesanan {$order->code_booking} berhasil dikonfirmasi.",
                "order_id" => $order->id,
            ]);

            // Log Aktivitas Admin
            ActivityLog::create([
                "user_id" => Auth::guard("api")->id(),
                "type" => "validasi",
                "description" =>
                    "Pembayaran pesanan {$order->code_booking} divalidasi oleh " .
                    Auth::guard("api")->user()->username .
                    " via Mobile Admin",
            ]);

            // Log jika stok menipis
            foreach ($order->items as $item) {
                if ($item->costum && $item->costum->available_stock <= 1) {
                    ActivityLog::create([
                        "user_id" => null,
                        "type" => "stok_menipis",
                        "description" => "Stok menipis untuk kostum {$item->costum->name} (Sisa: {$item->costum->available_stock})",
                    ]);
                }
            }

            DB::commit();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Pembayaran berhasil diverifikasi",
                ],
                200,
            );
        } catch (Exception $e) {
            DB::rollBack();
            $code =
                $e->getCode() >= 400 && $e->getCode() < 600
                    ? $e->getCode()
                    : 500;
            return response()->json(
                [
                    "success" => false,
                    "message" =>
                        "Gagal memverifikasi pembayaran: " . $e->getMessage(),
                ],
                $code === 0 ? 400 : $code,
            );
        }
    }

    /**
     * Membatalkan Transaksi (Set status to 'canceled')
     *
     * Endpoint: PATCH /api/v1/admin/orders/{id}/cancel
     */
    public function cancel($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($id);
            $oldStatus = $order->status;

            if ($oldStatus === "canceled") {
                throw new Exception("Pesanan sudah dalam keadaan dibatalkan.");
            }

            // Update status
            $order->update([
                "status" => "canceled",
            ]);

            // Jika sebelumnya sudah dibayar/selesai, maka dianggap sebagai refund / pengeluaran
            if (in_array($oldStatus, ["paid", "done"])) {
                Finance::create([
                    "category_id" => null,
                    "total" => $order->total,
                    "desc" => "Tidak jadinya pemesanan kode {$order->code_booking} via Mobile Admin",
                    "type" => "pengeluaran",
                ]);
            } elseif ($oldStatus === "pending") {
                ActivityLog::create([
                    "user_id" => Auth::guard("api")->id(),
                    "type" => "validasi",
                    "description" =>
                        "Pembatalan pembayaran pesanan {$order->code_booking} dilakukan oleh " .
                        Auth::guard("api")->user()->username .
                        " via Mobile Admin",
                ]);
            }

            // Notifikasi Batal ke User
            Notification::create([
                "user_id" => $order->user_id,
                "title" => "Pesanan Dibatalkan",
                "message" => "Maaf pesanan kamu dibatalkan oleh admin.",
                "order_id" => $order->id,
            ]);

            DB::commit();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Pesanan berhasil dibatalkan",
                ],
                200,
            );
        } catch (Exception $e) {
            DB::rollBack();
            $code =
                $e->getCode() >= 400 && $e->getCode() < 600
                    ? $e->getCode()
                    : 500;
            return response()->json(
                [
                    "success" => false,
                    "message" =>
                        "Gagal membatalkan pesanan: " . $e->getMessage(),
                ],
                $code === 0 ? 400 : $code,
            );
        }
    }

    /**
     * Menyelesaikan Transaksi (Set status to 'done' / Pengembalian Kostum)
     *
     * Endpoint: PATCH /api/v1/admin/orders/{id}/done
     */
    public function markAsDone($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($id);

            if ($order->status !== "paid") {
                throw new Exception(
                    "Hanya pesanan yang sudah dibayar yang dapat diselesaikan (dikembalikan).",
                );
            }

            // Update status
            $order->update([
                "status" => "done",
            ]);

            // Notifikasi Terima Kasih ke User
            Notification::create([
                "user_id" => $order->user_id,
                "title" => "Terima Kasih!",
                "message" =>
                    "Terima kasih telah memesan costum di kami, kami harap puas ya 😊",
                "order_id" => $order->id,
            ]);

            DB::commit();

            return response()->json(
                [
                    "success" => true,
                    "message" =>
                        "Pesanan berhasil diselesaikan (kostum dikembalikan)",
                ],
                200,
            );
        } catch (Exception $e) {
            DB::rollBack();
            $code =
                $e->getCode() >= 400 && $e->getCode() < 600
                    ? $e->getCode()
                    : 500;
            return response()->json(
                [
                    "success" => false,
                    "message" =>
                        "Gagal menyelesaikan pesanan: " . $e->getMessage(),
                ],
                $code === 0 ? 400 : $code,
            );
        }
    }
}
