<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:states.view')->only(['index','show']);
        $this->middleware('permission:states.create')->only(['create','store']);
        $this->middleware('permission:states.edit')->only(['edit','update']);
        $this->middleware('permission:states.delete')->only(['destroy','restore']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $states = State::withTrashed()->with('country');

            return DataTables::of($states)
                ->addIndexColumn()
                ->addColumn('country', fn ($s) => $s->country->name ?? '-')
                ->addColumn('action', function ($s) {

                    if ($s->deleted_at) {
                        return '
                        <button data-id="'.$s->id.'"
                                class="btn btn-success btn-sm restore-btn">
                            Restore
                        </button>';
                    }

                    $btn = '';

                    // 👁 VIEW
                    if (Gate::allows('states.view')) {
                        $btn .= '
                        <button data-id="'.$s->id.'"
                                class="btn btn-info btn-sm me-1 view-btn">
                            View
                        </button>';
                    }

                    if (Gate::allows('states.edit')) {
                        $btn .= '<a href="'.route('admin.states.edit',$s).'"
                                   class="btn btn-warning btn-sm me-1">
                                   Edit
                                 </a>';
                    }

                    if (Gate::allows('states.delete')) {
                        $btn .= '
                        <form action="'.route('admin.states.destroy',$s).'"
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

        return view('state.index');
    }

    // 👁 SHOW STATE → CITIES
    public function show(State $state)
    {
        $state->load(['country','cities']);

        return response()->json([
            'status' => true,
            'data' => $state
        ]);
    }

    // CREATE
    public function create()
    {
        $countries = Country::all();
        return view('state.create', compact('countries'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'name' => [
                'required',
                'min:2',
                Rule::unique('states')
                    ->where(fn ($q) =>
                        $q->where('country_id', $request->country_id)
                    ),
            ],
        ]);

        State::create($request->only('country_id','name'));

        return redirect()
            ->route('admin.states.index')
            ->with('success','State created successfully');
    }

    // EDIT
    public function edit(State $state)
    {
        $countries = Country::all();
        return view('state.edit', compact('state','countries'));
    }

    // UPDATE
    public function update(Request $request, State $state)
    {
        $request->validate([
            'country_id' => 'required',
            'name' => [
                'required',
                'min:2',
                Rule::unique('states')
                    ->where(fn ($q) =>
                        $q->where('country_id', $request->country_id)
                    )
                    ->ignore($state->id),
            ],
        ]);

        $state->update($request->only('country_id','name'));

        return redirect()
            ->route('admin.states.index')
            ->with('success','State updated successfully');
    }

    public function destroy(State $state)
    {
        $state->delete();
        return response()->json(['status'=>true]);
    }

    public function restore($id)
    {
        State::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['status'=>true]);
    }
}
