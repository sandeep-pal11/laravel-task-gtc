<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 🔥 TODAY ASSIGNED TASKS BY THIS ADMIN
        $todayTasks = Task::with('user')
            ->where('created_by', Auth::id())
            ->whereDate('created_at', now()->toDateString())
            ->latest()
            ->get();

        return view('admin.dashboard', [
            'totalUsers'     => User::count(),
            'activeUsers'    => User::where('status', 1)->count(),
            'inactiveUsers'  => User::where('status', 0)->count(),
            'totalCountries' => Country::count(),
            'totalStates'    => State::count(),
            'totalCities'    => City::count(),

            // 👇 NEW
            'todayTasks'     => $todayTasks,
        ]);
    }
}
