<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(
                State::with('country')->select('states.*')
            )
            ->addIndexColumn()
            ->addColumn('country', fn ($s) => $s->country->name ?? '-')
            ->addColumn('action', function ($s) {

                $btn = '';

                if (Gate::allows('states.edit')) {
                    $btn .= '<a href="'.route('admin.states.edit',$s).'"
                                class="btn btn-warning btn-sm me-1">Edit</a>';
                }

                if (Gate::allows('states.delete')) {
                    $btn .= '
                    <form action="'.route('admin.states.destroy',$s).'"
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
            ->rawColumns(['action'])
            ->make(true);
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
            'country_id' => ['required'],
            'name' => [
                'required',
                Rule::unique('states', 'name')
                    ->where('country_id', $request->country_id),
            ],
        ]);

        State::create([
            'country_id' => $request->country_id,
            'name'       => $request->name,
        ]);

        return redirect()
            ->route('admin.states.index')
            ->with('success', 'State created successfully');
    }

    public function edit(State $state)
    {
        $countries = Country::all();
        return view('state.edit', compact('state','countries'));
    }

    public function update(Request $request, State $state)
    {
        $request->validate([
            'country_id' => ['required'],
            'name' => [
                'required',
                Rule::unique('states', 'name')
                    ->where('country_id', $request->country_id)
                    ->ignore($state->id),
            ],
        ]);

        $state->update([
            'country_id' => $request->country_id,
            'name'       => $request->name,
        ]);

        return redirect()
            ->route('admin.states.index')
            ->with('success', 'State updated successfully');
    }

    public function destroy(State $state)
    {
        $state->delete();

        return back()
            ->with('success', 'State deleted successfully');
    }
}
