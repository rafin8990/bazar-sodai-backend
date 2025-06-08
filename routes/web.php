<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'viewLogin']);
Route::post('/loginFromDashboard', [AuthController::class, 'loginFromDashboard'])->name('loginFromDashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.Dashboard.index');
    })->name('dashboard');


    Route::post('/logoutfromDashboard', [AuthController::class, 'logoutfromDashboard'])->name('logoutfromDashboard');

    Route::get('/viewCategories', [CategoryController::class, 'viewCategories'])->name('viewCategories');
    Route::post('/createCategory', [CategoryController::class, 'createCategory'])->name('createCategory');
    Route::post('/categories/update/{id}', [CategoryController::class, 'updateCategory'])->name('updateCategory');
    Route::delete('/categories/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');
});