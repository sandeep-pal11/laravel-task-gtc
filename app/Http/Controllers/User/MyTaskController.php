<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MyTaskController extends Controller
{
public function index(Request $request)
{
    if ($request->ajax()) {

        $tasks = Task::where('user_id', Auth::id())
            ->select([
                'id',
                'title',
                'task_details',
                'start_date',
                'due_date',
                'status'
            ]);

        return DataTables::of($tasks)
            ->addIndexColumn()

            ->editColumn('status', function ($t) {
                $cls = $t->status === 'completed' ? 'success' : 'warning';
                return '<span class="badge bg-'.$cls.'">'
                        .ucfirst($t->status).
                       '</span>';
            })

            ->addColumn('action', function ($t) {
                return '
                <form method="POST"
                      action="'.route('user.tasks.update',$t->id).'">
                    '.csrf_field().'

                    <select name="status"
                            class="form-select form-select-sm mb-1">
                        <option value="pending" '.($t->status=='pending'?'selected':'').'>
                            Pending
                        </option>
                        <option value="completed" '.($t->status=='completed'?'selected':'').'>
                            Completed
                        </option>
                    </select>

                    <button class="btn btn-sm btn-primary w-100">
                        Update
                    </button>
                </form>';
            })

            ->rawColumns(['status','action'])
            ->make(true);
    }

    return view('user.tasks.index');
}


    public function update(Request $request, Task $task)
    {
        abort_if($task->user_id !== Auth::id(), 403);

        $request->validate([
            'status' => 'required|in:pending,completed',
        ]);

        $task->update([
            'status' => $request->status,
        ]);

        return back()->with('success','Task updated');
    }
}
