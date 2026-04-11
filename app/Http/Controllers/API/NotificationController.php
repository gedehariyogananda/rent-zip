<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use ApiResponse;

    /**
     * Get all notifications for the authenticated user
     *
     * Endpoint: GET /api/v1/notifications
     */
    public function index()
    {
        $userId = Auth::guard("api")->id();

        $notifications = Notification::with("order")
            ->where("user_id", $userId)
            ->orderBy("created_at", "desc")
            ->get();

        return $this->apiSuccess(
            $notifications,
            200,
            "Notifications retrieved successfully",
        );
    }

    /**
     * Get unread notifications count and data
     *
     * Endpoint: GET /api/v1/notifications/unread
     */
    public function unread()
    {
        $userId = Auth::guard("api")->id();

        $notifications = Notification::with("order")
            ->where("user_id", $userId)
            ->where("is_read", false)
            ->orderBy("created_at", "desc")
            ->get();

        return $this->apiSuccess(
            [
                "count" => $notifications->count(),
                "notifications" => $notifications,
            ],
            200,
            "Unread notifications retrieved successfully",
        );
    }

    /**
     * Mark a specific notification as read
     *
     * Endpoint: PATCH /api/v1/notifications/{id}/read
     */
    public function markAsRead($id)
    {
        $userId = Auth::guard("api")->id();

        $notification = Notification::where("id", $id)
            ->where("user_id", $userId)
            ->first();

        if (!$notification) {
            return $this->apiError(
                404,
                "Notification not found or unauthorized",
            );
        }

        $notification->update(["is_read" => true]);

        return $this->apiSuccess(
            $notification,
            200,
            "Notification marked as read",
        );
    }

    /**
     * Mark all notifications as read for the authenticated user
     *
     * Endpoint: PATCH /api/v1/notifications/read-all
     */
    public function markAllAsRead()
    {
        $userId = Auth::guard("api")->id();

        Notification::where("user_id", $userId)
            ->where("is_read", false)
            ->update(["is_read" => true]);

        return $this->apiSuccess(null, 200, "All notifications marked as read");
    }
}
