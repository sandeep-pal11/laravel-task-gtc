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

        /*
        | Admin Dashboard
        | Only admin / super-admin
        */
        Route::get('/dashboard', fn () => view('admin.dashboard'))
            ->middleware('role:admin|super-admin')
            ->name('dashboard');

        /*
        | CRUD Routes
        | Access controlled by permission middleware in controllers
        */
        Route::resource('countries', CountryController::class);
        Route::resource('states', StateController::class);
        Route::resource('cities', CityController::class);
        Route::resource('users', UserController::class);

        /*
        | SOFT DELETE – RESTORE ROUTES
        */
        Route::post(
            'countries/{id}/restore',
            [CountryController::class, 'restore']
        )->name('countries.restore');

        Route::post(
            'states/{id}/restore',
            [StateController::class, 'restore']
        )->name('states.restore');
        Route::post(
    'cities/{id}/restore',
    [CityController::class,'restore']
)->name('cities.restore');
Route::post(
    'users/{id}/restore',
    [UserController::class,'restore']
)->name('users.restore');


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
