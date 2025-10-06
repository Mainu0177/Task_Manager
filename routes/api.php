<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\Auth\ForgetPasswordController;
use App\Http\Controllers\API\V1\GroupController;
use App\Http\Controllers\API\V1\GroupUserController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'V1'], function () {
    // Auth Routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);

        Route::post('forget-password/send-otp', [ForgetPasswordController::class, 'forgetPasswordSendOtp']);
        Route::post('forget-password/verify-otp', [ForgetPasswordController::class, 'verifyOtp']);
        Route::post('reset-password', [ForgetPasswordController::class, 'resetPassword']);

        // middleware routes
        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::get('/user', [UserController::class, 'profile']);
            Route::put('/user', [UserController::class, 'update']);
            Route::post('/logout', [AuthController::class, 'logout']);
        });

        Route::group(['middleware' => 'auth:sanctum'], function () {
                Route::apiResource('groups', GroupController::class);
            });
        Route::group(['middleware' => 'auth:sanctum'], function () {
                Route::apiResource('tasks', TaskController::class);
            });

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('group/{group}/members' , [GroupUserController::class, 'store']);
        });
    });
});




