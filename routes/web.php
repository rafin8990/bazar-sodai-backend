<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomOrderController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProductController;
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
});