<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DioceseController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\PretreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'auth'])->group(function () {

    Route::prefix('/')->group(function () {
        Route::get('', function () {
            return view('dashboard');
        })->name('dashboard');


        Route::get('prete-manager', function () {
            return view('prete-manager');
        })->name('prete');

        Route::get('prete-manager/{prete_id}', function ($prete_id) {
            return view('prete-detail', ['prete_id' => $prete_id]);
        })->name('prete');

        Route::get('utilisateur-manager', function () {
            return view('utilisateur');
        })->name('utilisateur.manager');

        Route::get('diocese-manager', function () {
            return view('diocese-manager');
        })->name('diocese.manager');

        Route::get('diocese-manager/{diocese_id}', function ($diocese_id) {
            return view('diocese-detail', ['diocese_id' => $diocese_id]);
        })->name('diocese-detail');
    });

    Route::get('/analytic', [homeController::class, 'analytic']);

    Route::prefix('user')->group(function () {
        Route::post('/', [UserController::class, 'store']);
        Route::get('/all', [UserController::class, 'listUser']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });


    Route::prefix('pretres')->group(function () {
        Route::post('/', [PretreController::class, 'store']);
        Route::get('/all', [PretreController::class, 'listPretres']);
        Route::get('/{id}', [PretreController::class, 'show']);
        Route::put('/{id}', [PretreController::class, 'update']);
        Route::delete('/{id}', [PretreController::class, 'destroy']);
    });

    Route::prefix('diocesse')->controller(DioceseController::class)->group(function () {
        Route::post('/', 'store');
        Route::get('/all', 'listDiocese');
        Route::put('/diocese-manager/{id}', 'update');
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
        Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
        Route::get('/me', [AuthController::class, 'me'])->middleware('auth');
    });
});
