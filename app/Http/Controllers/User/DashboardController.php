<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        return view('user.dashboard', [
            'totalTasks'     => Task::where('user_id',$userId)->count(),
            'pendingTasks'   => Task::where('user_id',$userId)->where('status','pending')->count(),
            'completedTasks' => Task::where('user_id',$userId)->where('status','completed')->count(),
        ]);
    }
}
