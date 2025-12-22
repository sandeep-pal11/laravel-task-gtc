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
        $this->middleware('permission:users.delete')->only(['destroy','restore']);
    }

   public function index(Request $request)
{
    /* ===== PAGE LOAD ===== */
    if (!$request->ajax()) {
        $roles = Role::all();
        return view('user.index', compact('roles'));
    }

    /* ===== DATATABLE AJAX ===== */
    $users = User::withTrashed()->with('roles');

    return DataTables::of($users)
        ->addIndexColumn()

        /* ===== SEARCH FIX (name + email) ===== */
        ->filter(function ($query) use ($request) {
            if ($search = $request->get('search')['value'] ?? null) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            // role filter dropdown
            if ($request->role) {
                $query->whereHas('roles', function ($r) use ($request) {
                    $r->where('name', $request->role);
                });
            }

            // date filters
            if ($request->from_date) {
                $query->whereDate('created_at','>=',$request->from_date);
            }

            if ($request->to_date) {
                $query->whereDate('created_at','<=',$request->to_date);
            }
        })

        /* ===== ROLES COLUMN ===== */
        ->addColumn('roles', function ($u) {
            return $u->roles->pluck('name')->implode(', ');
        })

        /* ===== ACTION COLUMN ===== */
        ->addColumn('action', function ($u) {

            // 🔴 deleted → restore only
            if ($u->deleted_at) {
                return '
                <button data-id="'.$u->id.'"
                        class="btn btn-success btn-sm restore-btn">
                    Restore
                </button>';
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

    /* 🔴 Soft delete */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['status'=>true]);
    }

    /* ♻ Restore */
    public function restore($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['status'=>true]);
    }
}
