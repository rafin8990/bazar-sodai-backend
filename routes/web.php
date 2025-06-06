<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'viewLogin']);
Route::post('/loginFromDashboard', [AuthController::class, 'loginFromDashboard'])->name('loginFromDashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.Dashboard.index');
    })->name('dashboard');

    
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});