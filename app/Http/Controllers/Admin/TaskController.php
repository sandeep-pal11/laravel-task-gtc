<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tasks.view')->only('index','show');
        $this->middleware('permission:tasks.create')->only(['create','store']);
        $this->middleware('permission:tasks.edit')->only(['edit','update']);
        $this->middleware('permission:tasks.delete')->only('destroy');
    }

    // ================= LIST =================
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $tasks = Task::with(['user','creator'])->select('tasks.*');

            return DataTables::of($tasks)
                ->addIndexColumn()

                ->addColumn('user', fn ($t) => $t->user->name ?? '-')
                ->addColumn('created_by', fn ($t) => $t->creator->name ?? '-')

                ->addColumn('status', function ($t) {
                    $cls = $t->status == 'completed' ? 'success' : 'warning';
                    return '<span class="badge bg-'.$cls.'">'.ucfirst($t->status).'</span>';
                })

                ->addColumn('action', function ($t) {

                    $btn = '';

                    // VIEW
                    $btn .= '
                    <button class="btn btn-info btn-sm me-1 view-btn"
                            data-id="'.$t->id.'">
                        View
                    </button>';

                    // EDIT
                    if (Gate::allows('tasks.edit')) {
                        $btn .= '
                        <a href="'.route('admin.tasks.edit',$t).'"
                           class="btn btn-warning btn-sm me-1">
                           Edit
                        </a>';
                    }

                    // DELETE
                    if (Gate::allows('tasks.delete')) {
                        $btn .= '
                        <form action="'.route('admin.tasks.destroy',$t).'"
                              method="POST"
                              class="d-inline delete-form">
                            '.csrf_field().method_field('DELETE').'
                            <button class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>';
                    }

                    return $btn;
                })

                ->rawColumns(['status','action'])
                ->make(true);
        }

        return view('admin.tasks.index');
    }

    // ================= VIEW (AJAX) =================
    public function show(Task $task)
    {
        $task->load(['user','creator']);

        return response()->json([
            'title'       => $task->title,
            'details'     => $task->task_details,
            'status'      => ucfirst($task->status),
            'assigned_to' => $task->user->name ?? '-',
            'assigned_by' => $task->creator->name ?? '-',
            'start_date'  => $task->start_date,
            'due_date'    => $task->due_date,
            'created_at'  => $task->created_at->format('d M Y h:i A'),
        ]);
    }

    // ================= CREATE =================
    public function create()
    {
        $users = User::role('user')->get();
        return view('admin.tasks.create', compact('users'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'task_details' => 'required|string',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
        ]);

        Task::create([
            'user_id' => $request->user_id,
            'created_by' => Auth::id(),
            'title' => $request->title,
            'task_details' => $request->task_details,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.tasks.index')
            ->with('success','Task assigned successfully');
    }

    // ================= EDIT =================
    public function edit(Task $task)
    {
        $users = User::role('user')->get();
        return view('admin.tasks.edit', compact('task','users'));
    }

    // ================= UPDATE =================
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'task_details' => 'required|string',
            'status' => 'required|in:pending,completed',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
        ]);

        $task->update($request->all());

        return redirect()->route('admin.tasks.index')
            ->with('success','Task updated successfully');
    }

    // ================= DELETE =================
    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success','Task deleted successfully');
    }
}
