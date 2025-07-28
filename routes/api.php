<?php

use App\Http\Controllers\Api\AdvertiseController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomOrderController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SliderController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/auth/login', [AuthController::class, 'loginWithGoogle']);


Route::get('/categories', [CategoryController::class, 'getCategories']);
Route::get('/categories/{id}', [CategoryController::class, 'getCategory']);

Route::get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/products/{id}', [ProductController::class, 'getProduct']);

Route::post('/custom-orders', [CustomOrderController::class, 'createOrder']);
Route::get('/products/reviews/{productId}', [ReviewController::class, 'getByProduct']);


Route::get('/sliders', [SliderController::class, 'getAllSliders']);
Route::get('/sliders/active', [SliderController::class, 'getActiveSliders']);
Route::post('/sliders/create', [SliderController::class, 'createSlider']);
Route::post('/sliders/update/{id}', [SliderController::class, 'updateSlider']);
Route::post('/sliders/delete/{id}', [SliderController::class, 'deleteSlider']);
Route::get('/active-advertisements', [AdvertiseController::class, 'getActiveAdvertises']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/update', [AuthController::class, 'updateUser']);
    Route::delete('/user/delete', [AuthController::class, 'deleteUser']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    Route::post('/place-order', [OrderController::class, 'placeOrder']);
    Route::get('/my-orders', [OrderController::class, 'getOrders']);
    Route::post('/reviews', [ReviewController::class, 'store']);

    Route::post('/reviews/{reviewId}/reply', [ReviewController::class, 'replyToReview']);

});