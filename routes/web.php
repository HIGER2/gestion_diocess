<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DioceseController;
use App\Http\Controllers\PretreController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web'])->group(function () {

    Route::prefix('/')->group(function () {
        Route::get('', function () {
            return view('home');
        })->name('home');
        Route::get('prete-manager', function () {
            return view('prete-manager');
        })->name('prete');

        Route::get('diocese-manager', function () {
            return view('diocese-manager');
        })->name('prete');

        Route::get('diocese/{diocese_id}', function ($diocese_id) {
            return view('diocese-detail', ['diocese_id' => $diocese_id]);
        })->name('diocese-detail');
    });

    Route::prefix('pretres')->group(function () {
        Route::get('/all', [PretreController::class, 'listPretres']);
        Route::get('/{id}', [PretreController::class, 'show']);
        Route::put('/{id}', [PretreController::class, 'update']);
        Route::delete('/{id}', [PretreController::class, 'destroy']);
    });

    Route::prefix('diocesse')->controller(DioceseController::class)->group(function () {
        Route::post('/', 'store');
        Route::get('/all', 'listDiocese');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
        Route::get('/{id}', 'show');
        Route::get('/{id}/pretres', 'listPretres');
    });
});



Route::prefix('auth')->group(function () {
    Route::get('/login', function () {
        return view('login');
    });
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::middleware(['web'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
        Route::get('/me', [AuthController::class, 'me'])->middleware('auth');
    });
});