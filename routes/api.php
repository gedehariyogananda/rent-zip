<?php

use App\Http\Controllers\API\AuthenticateController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CostumController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {
    Route::controller(AuthenticateController::class)->group(function () {
        Route::post("register", "register");
        Route::post("login", "login");
        Route::post("verify-otp", "verifyOtp");
    });

    Route::controller(CostumController::class)
        ->prefix("costums")
        ->group(function () {
            Route::get("/", "index");
            Route::get("/{id}", "show");
        });

    Route::controller(CategoryController::class)->group(function () {
        Route::get("categories/source-animes", "sourceAnimes");
        Route::get("categories/brands", "brands");
        Route::get("locations", "locations");
    });

    Route::middleware("auth:api")->group(function () {
        Route::controller(AuthenticateController::class)->group(function () {
            Route::post("logout", "logout");
        });

        Route::controller(NotificationController::class)
            ->prefix("notifications")
            ->group(function () {
                Route::get("/", "index");
                Route::get("/unread", "unread");
                Route::patch("/read-all", "markAllAsRead");
                Route::patch("/{id}/read", "markAsRead");
            });

        Route::controller(OrderController::class)
            ->prefix("orders")
            ->group(function () {
                Route::get("/", "index");
                Route::get("/{id}", "show");
                Route::put("/{id}/confirm-payment", "confirmPayment");
            });
    });
});
