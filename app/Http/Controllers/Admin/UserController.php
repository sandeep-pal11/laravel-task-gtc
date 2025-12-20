<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users.view')->only('index');
        $this->middleware('permission:users.edit')->only(['edit','update']);
        $this->middleware('permission:users.delete')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $users = User::with('roles')->select('users.*');

            $datatable = DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('roles', function ($u) {
                    return implode(', ', $u->roles->pluck('name')->toArray());
                });

            // 👉 Action sirf admin / super-admin
            if (Gate::any(['users.edit','users.delete'])) {
                $datatable->addColumn('action', function ($u) {

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
                ->rawColumns(['action']);
            }

            return $datatable->make(true);
        }

        return view('user.index');
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
            ->with('success','Roles updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success','User deleted successfully');
    }
}
