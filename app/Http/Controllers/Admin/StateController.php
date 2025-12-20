<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:states.view')->only('index');
        $this->middleware('permission:states.create')->only(['create','store']);
        $this->middleware('permission:states.edit')->only(['edit','update']);
        $this->middleware('permission:states.delete')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $states = State::with('country')->select('states.*');

            $datatable = DataTables::of($states)
                ->addIndexColumn()
                ->addColumn('country', fn ($s) => $s->country->name ?? '-');

            // ✅ ACTION column sirf admin / super-admin ke liye
            if (Gate::any(['states.edit','states.delete'])) {
                $datatable->addColumn('action', function ($s) {

                    $btn = '';

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
                ->rawColumns(['action']);
            }

            return $datatable->make(true);
        }

        return view('state.index');
    }

    public function create()
    {
        $countries = Country::all();
        return view('state.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name'       => 'required|min:2',
        ]);

        State::create($request->only('country_id','name'));

        return redirect()->route('admin.states.index')
            ->with('success','State created successfully');
    }

    public function edit(State $state)
    {
        $countries = Country::all();
        return view('state.edit', compact('state','countries'));
    }

    public function update(Request $request, State $state)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name'       => 'required|min:2',
        ]);

        $state->update($request->only('country_id','name'));

        return redirect()->route('admin.states.index')
            ->with('success','State updated successfully');
    }

    public function destroy(State $state)
    {
        $state->delete();

        return redirect()->route('admin.states.index')
            ->with('success','State deleted successfully');
    }
}
