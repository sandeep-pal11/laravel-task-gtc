<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\SocialAuthController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| OTP (NO AUTH)
|--------------------------------------------------------------------------
*/
Route::get('/verify-otp', [OtpController::class, 'show'])->name('otp.page');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN (ROLE BASED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin|super-admin'])->group(function () {
    Route::get('/admin/dashboard', fn () => view('admin.dashboard'))
        ->name('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| PERMISSION BASED
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'permission:user.create'])->group(function () {
    Route::get('/users/create', function () {
        return "User Create Page";
    });
});

/*
|--------------------------------------------------------------------------
| SOCIAL LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/auth/github', [SocialAuthController::class, 'redirectToGithub']);
Route::get('/auth/github/callback', [SocialAuthController::class, 'handleGithubCallback']);

require __DIR__.'/auth.php';
