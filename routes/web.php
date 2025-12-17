<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\SocialAuthController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\CityController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| OTP
|--------------------------------------------------------------------------
*/
Route::get('/verify-otp', [OtpController::class, 'show'])->name('otp.page');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');

/*
|--------------------------------------------------------------------------
| USER (ROLE: user)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:user'])->group(function () {

    Route::get('/dashboard', fn () => view('dashboard'))
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| MANAGER (ROLE: manager)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:manager'])->group(function () {

    Route::get('/manager/dashboard', fn () => view('manager.dashboard'))
        ->name('manager.dashboard');

    Route::get('/manager/countries', [CountryController::class, 'index'])
        ->name('manager.countries');

    Route::get('/manager/states', [StateController::class, 'index'])
        ->name('manager.states');

    Route::get('/manager/cities', [CityController::class, 'index'])
        ->name('manager.cities');
});

/*
|--------------------------------------------------------------------------
| ADMIN + SUPER ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','role:admin|super-admin'])
    ->group(function () {

    Route::get('/dashboard', fn () => view('admin.dashboard'))
        ->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('countries', CountryController::class);
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
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
