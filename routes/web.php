<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MealController;

// Public routes
Route::get('/', [AuthController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    });

    // User routes
    Route::middleware(['role:member'])->group(function () {
        Route::get('/user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
        Route::get('/user/payments', [PaymentController::class, 'index'])->name('user.payments');
        Route::post('/user/payments', [PaymentController::class, 'store'])->name('user.payments.store');
        Route::get('/user/meals', [MealController::class, 'index'])->name('user.meals');
        Route::post('/user/meals', [MealController::class, 'store'])->name('user.meals.store');
    });
    
    // Common authenticated routes
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});
