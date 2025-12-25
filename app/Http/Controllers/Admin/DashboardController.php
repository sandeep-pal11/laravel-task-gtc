<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers'     => User::count(),
            'activeUsers'    => User::where('status', 1)->count(),
            'inactiveUsers'  => User::where('status', 0)->count(),
            'totalCountries' => Country::count(),
            'totalStates'    => State::count(),
            'totalCities'    => City::count(),
        ]);
    }
}
