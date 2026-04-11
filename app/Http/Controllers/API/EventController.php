<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class EventController extends Controller
{
    /**
     * Menampilkan daftar semua Event dengan Pagination & Filter Status
     * Endpoint: GET /api/v1/events
     * Parameter URL:
     * - status: "all" (default) atau "archived"
     * - per_page: jumlah data per halaman (default 10)
     */
    public function index(Request $request)
    {
        try {
            $status = $request->query("status", "all"); // all (available) or archived
            $perPage = $request->query("per_page", 10);

            $query = Event::query();

            if ($status === "archived") {
                // Event yang sudah lewat dari hari ini
                $query->whereDate("date", "<", Carbon::today());
            } else {
                // Event yang masih available (hari ini atau ke depannya)
                $query->whereDate("date", ">=", Carbon::today());
            }

            // Urutkan berdasarkan tanggal terdekat yang akan datang (atau terbaru)
            if ($status === "archived") {
                $query->orderBy("date", "desc"); // Kalau archived, yang paling baru lewat di atas
            } else {
                $query->orderBy("date", "asc"); // Kalau available, yang paling dekat di atas
            }

            $events = $query->paginate($perPage);

            // Format data (URL Gambar & Status Badge)
            $events->getCollection()->transform(function ($event) {
                return [
                    "id" => $event->id,
                    "name" => $event->name,
                    "date" => $event->date->format("Y-m-d"),
                    "formatted_date" => $event->date->format("M d, Y"),
                    "location" => $event->location,
                    "image_url" => $event->image_url
                        ? url("storage/" . $event->image_url)
                        : null,
                    "status" =>
                        $event->date >= Carbon::today()
                            ? "AVAILABLE"
                            : "ARCHIVED",
                    "created_at" => $event->created_at,
                ];
            });

            return response()->json(
                [
                    "success" => true,
                    "message" => "Daftar Event berhasil dimuat",
                    "data" => $events->items(),
                    "meta" => [
                        "current_page" => $events->currentPage(),
                        "last_page" => $events->lastPage(),
                        "per_page" => $events->perPage(),
                        "total" => $events->total(),
                        "next_page_url" => $events->nextPageUrl(),
                        "prev_page_url" => $events->previousPageUrl(),
                    ],
                ],
                200,
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Gagal memuat Event: " . $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Menampilkan Detail Event spesifik
     * Endpoint: GET /api/v1/events/{id}
     */
    public function show($id)
    {
        try {
            $event = Event::findOrFail($id);

            $data = [
                "id" => $event->id,
                "name" => $event->name,
                "date" => $event->date->format("Y-m-d"),
                "formatted_date" => $event->date->format("M d, Y"),
                "location" => $event->location,
                "image_url" => $event->image_url
                    ? url("storage/" . $event->image_url)
                    : null,
                "status" =>
                    $event->date >= Carbon::today() ? "AVAILABLE" : "ARCHIVED",
            ];

            return response()->json(
                [
                    "success" => true,
                    "message" => "Detail Event berhasil dimuat",
                    "data" => $data,
                ],
                200,
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" =>
                        "Event tidak ditemukan atau terjadi kesalahan: " .
                        $e->getMessage(),
                ],
                404,
            );
        }
    }
}
