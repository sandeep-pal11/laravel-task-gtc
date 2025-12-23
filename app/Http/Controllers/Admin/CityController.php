<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cities.view')->only('index');
        $this->middleware('permission:cities.create')->only(['create','store']);
        $this->middleware('permission:cities.edit')->only(['edit','update']);
        $this->middleware('permission:cities.delete')->only(['destroy','restore']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $cities = City::withTrashed()->with('state.country');

            return DataTables::of($cities)
                ->addIndexColumn()
                ->addColumn('state', fn ($c) => $c->state->name ?? '-')
                ->addColumn('country', fn ($c) => $c->state->country->name ?? '-')
                ->addColumn('action', function ($c) {

                    if ($c->deleted_at) {
                        return '
                            <button data-id="'.$c->id.'"
                                    class="btn btn-success btn-sm restore-btn">
                                Restore
                            </button>';
                    }

                    $btn = '';

                    if (Gate::allows('cities.edit')) {
                        $btn .= '<a href="'.route('admin.cities.edit',$c).'"
                                   class="btn btn-warning btn-sm me-1">
                                   Edit
                                 </a>';
                    }

                    if (Gate::allows('cities.delete')) {
                        $btn .= '
                        <form action="'.route('admin.cities.destroy',$c).'"
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

        return view('city.index');
    }

    public function create()
    {
        $states = State::with('country')->get();
        return view('city.create', compact('states'));
    }


     // STORE

    public function store(Request $request)
    {
        $request->validate(
            [
                'state_id' => 'required',
                'name' => [
                    'required',
                    'min:2',
                    Rule::unique('cities')
                        ->where(fn ($q) =>
                            $q->where('state_id', $request->state_id)
                        ),
                ],
            ],
            [
                'state_id.required' => 'State is required',
                'name.required'     => 'City name is required',
                'name.min'          => 'Minimum 2 characters required',
                'name.unique'       => 'This city already exists in selected state',
            ]
        );

        City::create($request->only('state_id','name'));

        return redirect()
            ->route('admin.cities.index')
            ->with('success','City created successfully');
    }

    public function edit(City $city)
    {
        $states = State::with('country')->get();
        return view('city.edit', compact('city','states'));
    }

   
     //UPDATE

    public function update(Request $request, City $city)
    {
        $request->validate(
            [
                'state_id' => 'required',
                'name' => [
                    'required',
                    'min:2',
                    Rule::unique('cities')
                        ->where(fn ($q) =>
                            $q->where('state_id', $request->state_id)
                        )
                        ->ignore($city->id),
                ],
            ],
            [
                'state_id.required' => 'State is required',
                'name.required'     => 'City name is required',
                'name.min'          => 'Minimum 2 characters required',
                'name.unique'       => 'This city already exists in selected state',
            ]
        );

        $city->update($request->only('state_id','name'));

        return redirect()
            ->route('admin.cities.index')
            ->with('success','City updated successfully');
    }

   //  Soft delete

    public function destroy(City $city)
    {
        $city->delete();
        return response()->json(['status'=>true]);
    }

    
     //Restore
 
    public function restore($id)
    {
        City::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['status'=>true]);
    }
}
