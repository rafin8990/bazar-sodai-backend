<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomOrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;


Route::post('/register',[AuthController::class,'register']);


Route::get('/categories', [CategoryController::class, 'getCategories']);
Route::get('/categories/{id}', [CategoryController::class, 'getCategory']);

Route::get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/products/{id}', [ProductController::class, 'getProduct']);

Route::post('/custom-orders', [CustomOrderController::class, 'createOrder']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/update', [AuthController::class, 'updateUser']);
    Route::delete('/user/delete', [AuthController::class, 'deleteUser']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
});