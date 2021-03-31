<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;

Route::prefix('/v1')->group(function() {
    Route::prefix('/user')->group(function() {
        Route::post('/register', [UserController::class, 'register'])
            ->name('api.v1.user.register');

        Route::post('/login', [UserController::class, 'login'])
            ->name('api.v1.user.login');
    });
});
