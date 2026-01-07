<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users.view')->only('index');
        $this->middleware('permission:users.edit')->only(['edit','update','changeStatus']);
        $this->middleware('permission:users.delete')->only(['destroy','restore']);
    }

    // INDEX

    public function index(Request $request)
    {
        if (!$request->ajax()) {
            $roles = Role::all();
            return view('user.index', compact('roles'));
        }

        $users = User::withTrashed()->with('roles')
            ->when($request->role, fn ($q) =>
                $q->whereHas('roles', fn ($r) =>
                    $r->where('name', $request->role)
                )
            );

        return DataTables::of($users)
            ->addIndexColumn()

            ->addColumn('roles', fn ($u) =>
                $u->roles->pluck('name')->implode(', ')
            )

            ->addColumn('status', fn ($u) =>
                $u->status === 'active'
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>'
            )

            ->addColumn('action', function ($u) {

                //  restore
                if ($u->deleted_at) {
                    return '<button data-id="'.$u->id.'"
                        class="btn btn-success btn-sm restore-btn">
                        Restore
                        </button>';
                }

                // self protection
                if (Auth::id() === $u->id) {
                    return '<span class="badge bg-secondary">You</span>';
                }

                $auth = Auth::user();
                $btn  = '';

                // STATUS TOGGLE
                if (
                    Gate::allows('users.edit') &&
                    !$u->roles->contains('name','super-admin') &&
                    !(
                        $auth->roles->contains('name','admin') &&
                        $u->roles->contains('name','super-admin')
                    )
                ) {
                    $btn .= '<button data-id="'.$u->id.'"
                        class="btn btn-sm me-1 status-btn '
                        .($u->status === 'active' ? 'btn-danger' : 'btn-success').'">
                        '.($u->status === 'active' ? 'Inactive' : 'Active').'
                        </button>';
                }

                //  EDIT (admin and super-admin )
                if (
                    Gate::allows('users.edit') &&
                    !(
                        $auth->roles->contains('name','admin') &&
                        $u->roles->contains('name','super-admin')
                    )
                ) {
                    $btn .= '<a href="'.route('admin.users.edit',$u).'"
                        class="btn btn-warning btn-sm me-1">
                        Edit
                        </a>';
                }

                // DELETE
                if (Gate::allows('users.delete')) {
                    $btn .= '
                    <form action="'.route('admin.users.destroy',$u).'"
                        method="POST" class="d-inline delete-form">
                        '.csrf_field().method_field('DELETE').'
                        <button type="button"
                            class="btn btn-danger btn-sm delete-btn">
                            Delete
                        </button>
                    </form>';
                }

                return $btn;
            })

            ->rawColumns(['action','status'])
            ->make(true);
    }

    // EDIT

    public function edit(User $user)
    {
        $auth = Auth::user();

        //  admin and super admin edit blocked
        if (
            $auth->roles->contains('name','admin') &&
            $user->roles->contains('name','super-admin')
        ) {
            abort(403, 'Admin cannot edit Super Admin');
        }

        $roles = Role::all();
        return view('user.edit', compact('user','roles'));
    }

    // UPDATE

    public function update(Request $request, User $user)
    {
        $auth = Auth::user();

        //  admin → super admin update blocked
        if (
            $auth->roles->contains('name','admin') &&
            $user->roles->contains('name','super-admin')
        ) {
            return redirect()
                ->route('admin.users.index')
                ->withErrors(['error' => 'Admin cannot update Super Admin']);
        }

        $request->validate([
            'roles' => 'required|array'
        ]);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('admin.users.index')
            ->with('success','User updated successfully');
    }


    // STATUS CHANGE

    public function changeStatus(User $user)
    {
        $auth = Auth::user();

        //  self
        if ($auth->id === $user->id) {
            return response()->json([
                'message' => 'You cannot change your own status'
            ], 403);
        }

        //  super admin protected
        if ($user->roles->contains('name','super-admin')) {
            return response()->json([
                'message' => 'Super Admin status cannot be changed'
            ], 403);
        }

        // admin and super admin
        if (
            $auth->roles->contains('name','admin') &&
            $user->roles->contains('name','super-admin')
        ) {
            return response()->json([
                'message' => 'Admin cannot change Super Admin status'
            ], 403);
        }

        $user->update([
            'status' => $user->status === 'active'
                ? 'inactive'
                : 'active'
        ]);

        return response()->json([
            'message' => 'User status updated successfully'
        ]);
    }

    // RESTORE

    public function restore($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();

        return response()->json([
            'message' => 'User restored successfully'
        ]);
    }

    // DESTROY

    public function destroy(User $user)
    {
        $auth = Auth::user();

        //  self
        if ($auth->id === $user->id) {
            return response()->json([
                'message' => 'You cannot delete yourself'
            ], 403);
        }

        //  super admin protected
        if ($user->roles->contains('name','super-admin')) {
            return response()->json([
                'message' => 'Super Admin cannot be deleted'
            ], 403);
        }

        // admin and super admin
        if (
            $auth->roles->contains('name','admin') &&
            $user->roles->contains('name','super-admin')
        ) {
            return response()->json([
                'message' => 'Admin cannot delete Super Admin'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
