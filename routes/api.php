<?php

use App\Http\Controllers\API\AuthenticateController;
use App\Http\Controllers\API\PenggunaController;
use App\Http\Controllers\API\ProyekController;
use App\Http\Controllers\API\TugasController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::controller(AuthenticateController::class)->group(function () {
        Route::post('login', 'login');
    });
    Route::middleware('auth:api')->group(function () {

        Route::controller(AuthenticateController::class)->group(function () {
            Route::post('logout', 'logout');
        });

        Route::controller(PenggunaController::class)->prefix('pengguna')->group(function () {
            Route::get('/', 'getPengguna');
            Route::get('{id}', 'getSpesificPengguna');
            Route::post('/', 'createPengguna');
            Route::put('{id}', 'updatePengguna');
            Route::delete('{id}', 'deletePengguna');
        });

        Route::controller(ProyekController::class)->prefix('proyek')->group(function () {
            Route::get('/', 'getProyek');
            Route::get('{id}', 'getSpesificProyek');
            Route::post('/', 'createProyek');
            Route::put('{id}', 'updateProyek');
            Route::delete('{id}', 'deleteProyek');
        });

        Route::controller(TugasController::class)->prefix('tugas')->group(function () {
            Route::get('/', 'getTugas');
            Route::get('{id}', 'getSpesificTugas');
            Route::post('/', 'createTugas');
            Route::put('{id}', 'updateTugas');
            Route::delete('{id}', 'deleteTugas');
        });
    });
});
