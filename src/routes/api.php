<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;

Route::prefix('/v1')->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])
            ->name('api.v1.auth.register');

        Route::post('/login', [AuthController::class, 'login'])
            ->name('api.v1.auth.login');
    });

    Route::get('/status', function () {
        return response()->json([
            'message' => 'We are up!',
            'details' => 'This API is only for checking that we are Up or not',
        ], 200);
    })->name('api.v1.status');
});
