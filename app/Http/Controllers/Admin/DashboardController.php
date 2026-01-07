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
        // TODAY ASSIGNED TASKS BY THIS ADMIN
        $todayTasks = Task::with('user')
            ->where('created_by', Auth::id())
            ->whereDate('created_at', now()->toDateString())
            ->latest()
            ->latest()
            ->get();

        // CHART DATA: TASKS BY STATUS
        $taskCounts = Task::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Ensure all statuses are present (even if 0)
        $chartTasks = [
            'pending'     => $taskCounts['pending'] ?? 0,
            'in_progress' => $taskCounts['in_progress'] ?? 0,
            'completed'   => $taskCounts['completed'] ?? 0,
        ];

        //  CHART DATA: USERS BY ROLE
        $chartRoles = \Spatie\Permission\Models\Role::withCount('users')
            ->pluck('users_count', 'name')
            ->toArray();

        return view('admin.dashboard', [
            'totalUsers'     => User::count(),
            'activeUsers'    => User::where('status', 1)->count(),
            'inactiveUsers'  => User::where('status', 0)->count(),
            'totalCountries' => Country::count(),
            'totalStates'    => State::count(),
            'totalCities'    => City::count(),

            //  NEW
            'todayTasks'     => $todayTasks,
            'chartTasks'     => $chartTasks,
            'chartRoles'     => $chartRoles,
        ]);
    }
}
