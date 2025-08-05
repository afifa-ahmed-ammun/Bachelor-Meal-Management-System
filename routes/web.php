<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Test route for CSRF
Route::get('/test-csrf', function () {
    return view('test-csrf');
});

Route::post('/test-csrf', function () {
    return response()->json(['message' => 'CSRF working!']);
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Routes
Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Admin Actions
Route::post('/admin/approve-payment', [AdminDashboardController::class, 'approvePayment'])->name('admin.approve-payment');
Route::post('/admin/reject-payment', [AdminDashboardController::class, 'rejectPayment'])->name('admin.reject-payment');
Route::post('/admin/send-notification', [AdminDashboardController::class, 'sendNotification'])->name('admin.send-notification');
