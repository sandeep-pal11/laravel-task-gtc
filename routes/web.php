<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OtpController;
use App\Http\Controllers\ProfileController;
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

Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

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

    /*
     * ❗ Manager CRUD ke liye alag routes nahi
     * ❗ Manager SAME admin routes use karega
     * ❗ Permission middleware controller me handle karega
     */
});

/*
|--------------------------------------------------------------------------
| ADMIN + SUPER ADMIN + MANAGER (PERMISSION BASED)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

    // Admin dashboard (sirf admin/super-admin)
    Route::get('/dashboard', fn () => view('admin.dashboard'))
        ->middleware('role:admin|super-admin')
        ->name('dashboard');

    /*
     * CRUD routes
     * Access controller ke permission middleware se control hoga
     */
    Route::resource('countries', CountryController::class);
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('users', UserController::class);
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
