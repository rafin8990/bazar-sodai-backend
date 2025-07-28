<?php

use App\Http\Controllers\Api\AdvertiseController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomOrderController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SliderController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'viewLogin']);


Route::post('/loginFromDashboard', [AuthController::class, 'loginFromDashboard'])->name('loginFromDashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/logoutfromDashboard', [AuthController::class, 'logoutfromDashboard'])->name('logoutfromDashboard');
    Route::get('/viewCategories', [CategoryController::class, 'viewCategories'])->name('viewCategories');
    Route::post('/createCategory', [CategoryController::class, 'createCategory'])->name('createCategory');
    Route::post('/categories/update/{id}', [CategoryController::class, 'updateCategory'])->name('updateCategory');
    Route::delete('/categories/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');

    Route::get('/dashboard/products', [ProductController::class, 'viewProducts'])->name('viewProducts');
    Route::post('/products', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/dashboard/custom-order', [CustomOrderController::class, 'index'])->name('custom-orders.index');
    Route::put('/dashboard/custom-order/{id}', [CustomOrderController::class, 'update'])->name('custom-orders.update');

    Route::get('/dashboard/orders', [OrderController::class, 'allOrders'])->name('all.orders');
    Route::put('/dashboard/order/{id}', [OrderController::class, 'update'])->name('order.status.update');
    Route::get('/dashboard/review', [ReviewController::class, 'index']);
    Route::delete('/dashboard/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/dashboard/sliders', [SliderController::class, 'viewSliders'])->name('viewSliders');
    Route::post('/reviews/{reviewId}/reply', [ReviewController::class, 'replyToReview'])->name('reviews.reply');

    Route::get('/dashboard/advertise', [AdvertiseController::class, 'index'])->name('advertise.index');
    Route::post('/dashboard/advertise', [AdvertiseController::class, 'store'])->name('advertise.store');
    Route::put('/dashboard/advertise/{id}', [AdvertiseController::class, 'update'])->name('advertise.update');
    Route::delete('/dashboard/advertise/{id}', [AdvertiseController::class, 'destroy'])->name('advertise.destroy');
});