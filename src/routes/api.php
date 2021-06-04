<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\GenreController;
use App\Http\Controllers\Api\V1\CrewController;

Route::prefix('/v1')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])
            ->name('api.v1.auth.register');

        Route::post('/login', [AuthController::class, 'login'])
            ->name('api.v1.auth.login');

        Route::get('/info', [AuthController::class, 'info'])
            ->name('api.v1.auth.info');

        Route::get('/logout', [AuthController::class, 'logout'])
            ->name('api.v1.auth.logout');
    });

    Route::prefix('/users')->group(function () {
        Route::middleware('auth')->group(function () {
            Route::post('/create', [UserController::class, 'create'])
                ->name('api.v1.users.create');

            Route::get('/', [UserController::class, 'list'])
                ->name('api.v1.users.list');

            Route::put('/update/{user}', [UserController::class, 'update'])
                ->name('api.v1.users.update');

            Route::delete('/delete/{user}', [UserController::class, 'delete'])
                ->name('api.v1.users.delete');

            Route::put('/update_permissions/{user}', [UserController::class, 'updatePermissions'])
                ->name('api.v1.users.update_permissions');
        });

        Route::get('/{user}', [UserController::class, 'once'])
            ->name('api.v1.users.once');
    });

    Route::prefix('/genres')->group(function () {
        Route::get('/', [GenreController::class, 'list'])
            ->name('api.v1.genres.list');

        Route::middleware('auth')->group(function () {
            Route::post('/create', [GenreController::class, 'create'])
                ->name('api.v1.genres.create');

            Route::delete('/delete/{genre}', [GenreController::class, 'delete'])
                ->name('api.v1.genres.delete');

            Route::put('/update/{genre}', [GenreController::class, 'update'])
                ->name('api.v1.genres.update');
        });
    });

    Route::prefix('/crews')->group(function () {
        Route::get('/', [CrewController::class, 'list'])
            ->name('api.v1.crews.list');

        Route::middleware('auth')->group(function () {
            Route::post('/create', [CrewController::class, 'create'])
                ->name('api.v1.crews.create');
    
            /*Route::delete('/delete/{genre}', [GenreController::class, 'delete'])
                ->name('api.v1.genres.delete');

            Route::put('/update/{genre}', [GenreController::class, 'update'])
                ->name('api.v1.genres.update');*/
        });
    });

    Route::get('/status', function () {
        return response()->json([
            'message' => 'We are up!',
            'details' => 'This API is only for checking that we are Up or not',
        ], 200);
    })->name('api.v1.status');
});
