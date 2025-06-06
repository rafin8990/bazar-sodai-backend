<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/register',[AuthController::class,'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/update', [AuthController::class, 'updateUser']);
    Route::delete('/user/delete', [AuthController::class, 'deleteUser']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
});