<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DioceseController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\PretreController;
use App\Http\Controllers\RegisterLinkController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewController;
use App\Models\Diocese;
use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'auth'])->group(function () {

    // Route::middleware(['role:super_admin'])->group(function () {});
    // Route::middleware(['role:super_admin,admin'])->group(function () {});

    Route::prefix('/')->group(function () {

        Route::middleware(['role:super_admin,admin'])->group(function () {
            Route::get('prete-manager', function () {
                $dioceses = Diocese::orderBy('created_at', 'desc')->get();
                return view('prete-manager', ['dioceses' => $dioceses]);
            })->name('prete');


            Route::get('utilisateur-manager', function () {
                $dioceses = Diocese::orderBy('created_at', 'desc')->get();
                return view('utilisateur', ['dioceses' => $dioceses]);
            })->name('utilisateur.manager');

            Route::get('diocese-manager', function () {
                return view('diocese-manager');
            })->name('diocese.manager');
        });

        Route::middleware(['role:super_admin,admin'])->group(function () {
            Route::get('prete-manager/{prete_id}', [ViewController::class, 'findprete'])->name('prete');
            Route::get('user', [ViewController::class, 'userAuth'])->name('user.auth');

            Route::get('', function () {
                return view('dashboard');
            })->name('dashboard');

            Route::get('diocese-manager/{diocese_id}', function ($diocese_id) {
                return view('diocese-detail', ['diocese_id' => $diocese_id]);
            })->name('diocese-detail');

            Route::get('link-manager', function () {
                $dioceses = Diocese::orderBy('created_at', 'desc')->get();
                return view('link', ['dioceses' => $dioceses]);
            })->name('link');

            Route::get('link-manager', function () {
                $dioceses = Diocese::orderBy('created_at', 'desc')->get();
                return view('link', ['dioceses' => $dioceses]);
            })->name('link');
        });
    });

    Route::middleware(['role:super_admin,admin'])->group(function () {
        Route::get('/analytic', [homeController::class, 'analytic']);
        Route::prefix('user')->group(function () {
            Route::post('/', [UserController::class, 'store']);
            Route::get('/all', [UserController::class, 'listUser']);
            Route::get('/{id}', [UserController::class, 'show']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::delete('/{id}', [UserController::class, 'destroy']);
        });
    });


    Route::prefix('pretres')->group(function () {
        Route::middleware(['role:super_admin,admin'])->group(function () {
            Route::get('/all', [PretreController::class, 'listPretres']);
            Route::post('/parcourt', [PretreController::class, 'parcourt']);
            Route::get('/{id}', [PretreController::class, 'show']);
            Route::delete('/{id}', [PretreController::class, 'destroy']);
        });

        Route::middleware(['role:super_admin,admin'])->group(function () {
            Route::post('/', [PretreController::class, 'store']);
            Route::put('/{id}', [PretreController::class, 'update']);
        });
    });

    Route::prefix('diocesse')->controller(DioceseController::class)->group(function () {
        Route::middleware(['role:super_admin'])->group(function () {
            Route::get('/all', 'listDiocese');
            Route::delete('/{id}', 'destroy');
            Route::get('/{id}/pretres', 'listPretres');
        });
        Route::middleware(['role:super_admin,admin'])->group(function () {
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::put('/diocese-manager/{id}', 'update');
        });
    });

    Route::prefix('register-links')->group(function () {
        Route::middleware(['role:super_admin,admin'])->group(function () {
            Route::post('/create', [RegisterLinkController::class, 'create'])->name('register.link.create');
            Route::delete('/delete/{id}', [RegisterLinkController::class, 'delete'])->name('register.link.delete');
        });
        Route::middleware(['role:super_admin,admin'])->group(function () {
            Route::get('/all', [RegisterLinkController::class, 'all'])->name('register.link.all');
            Route::put('/update/{id}', [RegisterLinkController::class, 'update'])->name('register.link.update');
        });
    });
});


Route::middleware('isAuth')->group(function () {
    Route::get('/register-links/access/{token}', [RegisterLinkController::class, 'access'])->name('access.link.authenticate');
});


Route::get('/authenticate/{token}', function ($token) {
    return view('link-login', ['token' => $token]);
})->name('login.link.authenticate');

Route::post('/authenticate/auth/{token}', [RegisterLinkController::class, 'authenticate'])->name('register.link.authenticate');

Route::prefix('auth')->group(function () {
    Route::get('/login', function () {
        return view('login');
    });
    Route::get('/inscription/ba5d380c-2a26-4dd0-9486-9ebfed4df817', function () {
        $dioceses = Diocese::orderBy('created_at', 'desc')->get();
        return view('inscription', ['dioceses' => $dioceses]);
    })->name('login');

    // Route::get('/inscription/ba5d380c-2a26-4dd0-9486-9ebfed4df817', function () {
    //     return view('inscription');
    // })->name('inscription.auth');

    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/inscription', [PretreController::class, 'store']);
    Route::middleware(['web'])->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
        Route::get('/me', [AuthController::class, 'me'])->middleware('auth');
    });
});
