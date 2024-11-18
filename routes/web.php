<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DioceseController;
use App\Http\Controllers\PretreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::prefix('pretres')->group(function () {
    Route::post('/', [PretreController::class, 'store']);
    Route::get('/{id}', [PretreController::class, 'show']);
    Route::put('/{id}', [PretreController::class, 'update']);
    Route::delete('/{id}', [PretreController::class, 'destroy']);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth');
});

Route::prefix('diocesse')->controller(DioceseController::class)->group(function () {
    Route::post('/', 'store');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::get('/{id}', 'show');
    Route::get('/{id}/pretres', 'listPretres');
});
