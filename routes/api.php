<?php

use App\Http\Controllers\API\AuthenticateController;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {
    Route::controller(AuthenticateController::class)->group(function () {
        Route::post("register", "register");
        Route::post("login", "login");
        Route::post("verify-otp", "verifyOtp");
    });

    Route::middleware("auth:api")->group(function () {
        Route::controller(AuthenticateController::class)->group(function () {
            Route::post("logout", "logout");
        });
    });
});
