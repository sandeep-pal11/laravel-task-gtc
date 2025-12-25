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

//PUBLIC
Route::get('/admin/dashboardd', function () {
    return view('adminn.dashboard');
})->name('admin.dashboardd');

Route::get('/admin/401', function () {
    return view('adminn.401');
})->name('admin.401');

Route::get('/admin/404', function () {
    return view('adminn.404');
})->name('admin.404');

Route::get('/admin/500', function () {
    return view('adminn.500');
})->name('admin.500');

Route::get('/admin/charts', function () {
    return view('adminn.charts');
})->name('admin.charts');

Route::get('/admin/layout-sidenav-light', function () {
    return view('adminn.layout-sidenav-light');
})->name('admin.layout-sidenav-light');

Route::get('/admin/layout-static', function () {
    return view('adminn.layout-static');
})->name('admin.layout-static');

Route::get('/admin/login', function () {
    return view('adminn.login');
})->name('admin.login');

Route::get('/admin/password', function () {
    return view('adminn.password');
})->name('admin.password');

Route::get('/admin/register', function () {
    return view('adminn.register');
})->name('admin.register');

Route::get('/admin/tables', function () {
    return view('adminn.tables');
})->name('admin.tables');

Route::get('/', fn () => view('auth.login'));

Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

//OTP

Route::get('/verify-otp', [OtpController::class, 'show'])
    ->name('otp.page');

Route::post('/verify-otp', [OtpController::class, 'verify'])
    ->name('otp.verify');


//USER (ROLE: user)

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/dashboard', fn () => view('dashboard'))
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

//MANAGER (ROLE: manager)

Route::middleware(['auth', 'role:manager'])->group(function () {

    Route::get('/manager/dashboard', fn () => view('manager.dashboard'))
        ->name('manager.dashboard');
});


//ADMIN / SUPER ADMIN (PERMISSION BASED)

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {


        //Dashboard

        Route::get('/dashboard', fn () => view('admin.dashboard'))
            ->middleware('role:admin|super-admin')
            ->name('dashboard');


        //CRUD RESOURCES Permission handled inside controllers

        Route::resource('countries', CountryController::class);
        Route::resource('states', StateController::class);
        Route::resource('cities', CityController::class);
        Route::resource('users', UserController::class);


        //RESTORE (SOFT DELETE)

        Route::post('countries/{id}/restore', [CountryController::class, 'restore'])
            ->name('countries.restore');

        Route::post('states/{id}/restore', [StateController::class, 'restore'])
            ->name('states.restore');

        Route::post('cities/{id}/restore', [CityController::class, 'restore'])
            ->name('cities.restore');

        Route::post('users/{id}/restore', [UserController::class, 'restore'])
            ->name('users.restore');


        //USER STATUS TOGGLE (ACTIVE / INACTIVE)

        Route::post(
            'users/{user}/status',
            [UserController::class, 'changeStatus']
        )->name('users.status');


        // CITY MODULE – COUNTRY and  STATE AJAX

        Route::get(
            'get-states/{country}',
            function ($countryId) {
                return \App\Models\State::where('country_id', $countryId)
                    ->orderBy('name')
                    ->get();
            }
        )->name('get.states');
    });

//SOCIAL LOGIN

Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/auth/github', [SocialAuthController::class, 'redirectToGithub']);
Route::get('/auth/github/callback', [SocialAuthController::class, 'handleGithubCallback']);


require __DIR__ . '/auth.php';
