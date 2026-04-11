<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class OrderController extends Controller
{
    use ApiResponse;

    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Get all transactions/orders for the authenticated user
     * Filters: status, start_date, end_date
     *
     * Endpoint: GET /api/v1/orders
     */
    public function index(Request $request)
    {
        try {
            $userId = Auth::guard("api")->id();

            $filters = [
                "status" => $request->query("status"), // pending, canceled, done, paid
                "start_date" => $request->query("start_date"), // YYYY-MM-DD
                "end_date" => $request->query("end_date"), // YYYY-MM-DD
            ];

            $orders = $this->orderService->findByUserId($userId, $filters);

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

            return $this->apiSuccess(
                $orders,
                200,
                "Orders retrieved successfully",
            );
        } catch (Exception $e) {
            return $this->apiError(
                500,
                "Failed to retrieve orders: " . $e->getMessage(),
            );
        }
    }

    /**
     * Get order detail by ID
     *
     * Endpoint: GET /api/v1/orders/{id}
     */
    public function show($id)
    {
        try {
            $userId = Auth::guard("api")->id();
            $order = $this->orderService->find($id);

            // Check if order exists and belongs to the authenticated user
            if (!$order || $order->user_id !== $userId) {
                return $this->apiError(404, "Order not found or unauthorized");
            }

            // Format photo URLs for the costums inside the order items
            $order->items->transform(function ($item) {
                if ($item->costum && $item->costum->photo_url) {
                    $item->costum->photo_url = url(
                        "storage/" . $item->costum->photo_url,
                    );
                }
                return $item;
            });

            return $this->apiSuccess(
                $order,
                200,
                "Order detail retrieved successfully",
            );
        } catch (Exception $e) {
            return $this->apiError(
                500,
                "Failed to retrieve order detail: " . $e->getMessage(),
            );
        }
    }

    /**
     * Confirm payment for an order
     *
     * Endpoint: PUT /api/v1/orders/{id}/confirm-payment
     */
    public function confirmPayment($id)
    {
        try {
            $userId = Auth::guard("api")->id();
            $order = $this->orderService->confirmPayment($id, $userId);

            return $this->apiSuccess(
                $order,
                200,
                "Payment confirmed successfully",
            );
        } catch (Exception $e) {
            $code = $e->getCode() > 0 ? $e->getCode() : 500;
            return $this->apiError($code, $e->getMessage());
        }
    }
}
