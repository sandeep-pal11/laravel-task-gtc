<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OtpController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// ==========================
// USER AUTHENTICATED ROUTES
// ==========================
Route::middleware(['auth'])->group(function () {

    // USER DASHBOARD
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // USER PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// ==========================
// OTP ROUTES (NO AUTH)
// ==========================
Route::get('/verify-otp', [OtpController::class, 'show'])
    ->name('otp.page');

Route::post('/verify-otp', [OtpController::class, 'verify'])
    ->name('otp.verify');

// ==========================
// ADMIN DASHBOARD
// ==========================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// ==========================
// AUTH ROUTES (BREEZE)
// ==========================
require __DIR__ . '/auth.php';
