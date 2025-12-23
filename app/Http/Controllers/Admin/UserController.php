<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users.view')->only('index');
        $this->middleware('permission:users.edit')->only(['edit','update']);
        $this->middleware('permission:users.delete')->only(['destroy','restore']);
    }

    public function index(Request $request)
    {
        // PAGE LOAD
        if (!$request->ajax()) {
            $roles = Role::all();
            return view('user.index', compact('roles'));
        }

        // DATATABLE
        $users = User::withTrashed()->with('roles')
            ->when($request->role, function ($q) use ($request) {
                $q->whereHas('roles', fn ($r) =>
                    $r->where('name', $request->role)
                );
            })
            ->when($request->from_date, fn ($q) =>
                $q->whereDate('created_at','>=',$request->from_date)
            )
            ->when($request->to_date, fn ($q) =>
                $q->whereDate('created_at','<=',$request->to_date)
            );

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('roles', fn ($u) =>
                $u->roles->pluck('name')->implode(', ')
            )
            ->addColumn('action', function ($u) {

                // Deleted and Restore only
                if ($u->deleted_at) {
                    return '
                        <button data-id="'.$u->id.'"
                                class="btn btn-success btn-sm restore-btn">
                            Restore
                        </button>';
                }

                //  Self delete button hide
                if (Auth::id() === $u->id) {
                    return '<span class="badge bg-secondary">You</span>';
                }

                $btn = '';

                if (Gate::allows('users.edit')) {
                    $btn .= '<a href="'.route('admin.users.edit',$u).'"
                              class="btn btn-warning btn-sm me-1">
                              Edit
                             </a>';
                }

                if (Gate::allows('users.delete')) {
                    $btn .= '
                    <form action="'.route('admin.users.destroy',$u).'"
                          method="POST"
                          class="d-inline delete-form">
                        '.csrf_field().method_field('DELETE').'
                        <button type="button"
                                class="btn btn-danger btn-sm delete-btn">
                            Delete
                        </button>
                    </form>';
                }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('user.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required|array'
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')
            ->with('success','Roles updated');
    }

    // SOFT DELETE 
    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot delete your own account'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }

    //  RESTORE
    public function restore($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();

        return response()->json([
            'status' => true,
            'message' => 'User restored successfully'
        ]);
    }
}
