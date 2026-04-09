<?php

use App\Http\Controllers\API\AuthenticateController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::controller(AuthenticateController::class)->group(function () {
        Route::post('login', 'login');
    });

    Route::middleware('auth:api')->group(function () {
        Route::controller(AuthenticateController::class)->group(function () {
            Route::post('logout', 'logout');
        });
    });
});
