<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'V1'], function () {
    // Auth Routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        // middleware routes
        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::get('/user', [UserController::class, 'profile']);
            Route::put('/user', [UserController::class, 'update']);
        });
    });
});


