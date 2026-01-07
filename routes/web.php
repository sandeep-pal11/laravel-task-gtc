<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\TaskController;

use App\Http\Controllers\User\MyTaskController;


// DEFAULT

Route::get('/', function () {
    return redirect()->route('login');
});


//FORCE LOGOUT

Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
});


// OTP

Route::get('/verify-otp', [OtpController::class, 'show'])
    ->name('otp.page');

Route::post('/verify-otp', [OtpController::class, 'verify'])
    ->name('otp.verify');

//USER PANEL (ROLE: user)

Route::middleware(['auth','role:user'])->group(function () {

    //  USER DASHBOARD
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // ✅ DELETE PROFILE PHOTO (SEPARATE ROUTE)
    Route::delete('/profile/photo', [ProfileController::class, 'deleteProfilePhoto'])
        ->name('profile.photo.delete');

    // MY TASKS
    Route::get('/my-tasks', [MyTaskController::class, 'index'])
        ->name('user.tasks.index');

    Route::post('/my-tasks/{task}', [MyTaskController::class, 'update'])
        ->name('user.tasks.update');
});


// MANAGER PANEL (ROLE: manager)

Route::middleware(['auth','role:manager'])->group(function () {

    Route::get('/manager/dashboard', function () {
        return view('manager.dashboard');
    })->name('manager.dashboard');
});

//ADMIN PANEL

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {


        // DASHBOARD

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->middleware('permission:dashboard.view')
            ->name('dashboard');


        Route::resource('tasks', TaskController::class);
        Route::get('users/export', [UserController::class, 'export'])->name('users.export');
        Route::resource('users', UserController::class);
        Route::resource('countries', CountryController::class);
        Route::resource('states', StateController::class);
        Route::resource('cities', CityController::class);


        // RESTORE (SOFT DELETE)

        Route::post('users/{id}/restore', [UserController::class, 'restore'])
            ->name('users.restore');

        Route::post('countries/{id}/restore', [CountryController::class, 'restore'])
            ->name('countries.restore');

        Route::post('states/{id}/restore', [StateController::class, 'restore'])
            ->name('states.restore');

        Route::post('cities/{id}/restore', [CityController::class, 'restore'])
            ->name('cities.restore');


        //USER STATUS

        Route::post('users/{user}/status', [UserController::class, 'changeStatus'])
            ->name('users.status');


    // AJAX STATES BY COUNTRY

        Route::get('get-states/{country}', function ($countryId) {
            return \App\Models\State::where('country_id', $countryId)
                ->orderBy('name')
                ->get();
        })->name('get.states');
    });


//SOCIAL LOGIN

Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/auth/github', [SocialAuthController::class, 'redirectToGithub']);
Route::get('/auth/github/callback', [SocialAuthController::class, 'handleGithubCallback']);


require __DIR__.'/auth.php';
