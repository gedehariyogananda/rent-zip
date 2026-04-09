<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Member;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return redirect()->route("login");
});

Route::controller(AuthController::class)->group(function () {
    Route::get("login", "showLoginForm")->name("login");
    Route::post("login", "login");
    Route::get("register", "showRegistrationForm")->name("register");
    Route::post("register", "register");
    Route::post("logout", "logout")->name("logout");
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix("admin")
    ->name("admin.")
    ->middleware(["auth"])
    ->group(function () {
        Route::get("/dashboard", [
            Admin\DashboardController::class,
            "index",
        ])->name("dashboard");
        Route::resource("users", Admin\UserController::class);
        Route::resource("costums", Admin\CostumController::class);
        Route::get("finances/export", [
            Admin\FinanceController::class,
            "export",
        ])->name("finances.export");
        Route::resource("finances", Admin\FinanceController::class);
        Route::resource("maintenances", Admin\MaintenanceController::class);

        // Master Data
        Route::prefix("master")->name("master.")->group(function () {
            Route::resource("categories", Admin\CategoryController::class)
                ->except(["show"]);
        });

        Route::controller(Admin\OrderController::class)
            ->prefix("orders")
            ->name("orders.")
            ->group(function () {
                Route::get("/", "index")->name("index");
                Route::get("{id}", "show")->name("show");
                Route::patch("{id}/status", "updateStatus")->name(
                    "updateStatus",
                );
                Route::delete("{id}", "destroy")->name("destroy");
            });
    });

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
*/
Route::prefix("member")
    ->name("member.")
    ->middleware(["auth"])
    ->group(function () {
        Route::controller(Member\CostumController::class)
            ->prefix("costums")
            ->name("costums.")
            ->group(function () {
                Route::get("/", "index")->name("index");
                Route::get("{id}", "show")->name("show");
            });

        Route::controller(Member\CartController::class)
            ->prefix("cart")
            ->name("cart.")
            ->group(function () {
                Route::get("/", "index")->name("index");
                Route::post("/", "store")->name("store");
                Route::patch("{id}", "update")->name("update");
                Route::delete("{id}", "destroy")->name("destroy");
            });

        Route::controller(Member\OrderController::class)
            ->prefix("orders")
            ->name("orders.")
            ->group(function () {
                Route::get("/", "index")->name("index");
                Route::get("{id}", "show")->name("show");
                Route::post("/", "store")->name("store");
            });

        Route::controller(Member\ProfileController::class)
            ->prefix("profile")
            ->name("profile.")
            ->group(function () {
                Route::get("/", "show")->name("show");
                Route::get("edit", "edit")->name("edit");
                Route::put("/", "update")->name("update");
            });

        Route::controller(Member\RatingController::class)
            ->prefix("rating")
            ->name("rating.")
            ->group(function () {
                Route::get("/prompt", "prompt")->name("prompt");
                Route::post("/", "store")->name("store");
                Route::put("{id}", "update")->name("update");
            });
    });
