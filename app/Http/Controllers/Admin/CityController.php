<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cities.view')->only(['index','show']);
        $this->middleware('permission:cities.create')->only(['create','store']);
        $this->middleware('permission:cities.edit')->only(['edit','update']);
        $this->middleware('permission:cities.delete')->only(['destroy','restore']);
    }

    // ===================================================
    // INDEX (DATATABLE)
    // ===================================================
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $cities = City::withTrashed()
                ->with('state.country');

            return DataTables::of($cities)
                ->addIndexColumn()
                ->addColumn('state', fn ($c) => $c->state->name ?? '-')
                ->addColumn('country', fn ($c) => $c->state->country->name ?? '-')
                ->addColumn('action', function ($c) {

                    // RESTORE
                    if ($c->deleted_at) {
                        return '
                        <button data-id="'.$c->id.'"
                                class="btn btn-success btn-sm restore-btn">
                            Restore
                        </button>';
                    }

                    $btn = '';

                    // 👁 VIEW
                    if (Gate::allows('cities.view')) {
                        $btn .= '
                        <button data-id="'.$c->id.'"
                                class="btn btn-info btn-sm me-1 view-btn">
                            View
                        </button>';
                    }

                    // EDIT
                    if (Gate::allows('cities.edit')) {
                        $btn .= '
                        <a href="'.route('admin.cities.edit',$c).'"
                           class="btn btn-warning btn-sm me-1">
                            Edit
                        </a>';
                    }

                    // DELETE
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

    // ===================================================
    // 👁 SHOW (CITY → STATE → COUNTRY)
    // ===================================================
    public function show(City $city)
    {
        $city->load('state.country');

        return response()->json([
            'status' => true,
            'data'   => $city
        ]);
    }

    // ===================================================
    // CREATE
    // ===================================================
    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('city.create', compact('countries'));
    }

    // ===================================================
    // STORE
    // ===================================================
    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'state_id'   => 'required',
            'name'       => [
                'required',
                'min:2',
                Rule::unique('cities')
                    ->where(fn ($q) =>
                        $q->where('state_id', $request->state_id)
                    )
            ],
        ]);

        City::create([
            'state_id' => $request->state_id,
            'name'     => $request->name,
        ]);

        return redirect()
            ->route('admin.cities.index')
            ->with('success','City created successfully');
    }

    // ===================================================
    // EDIT
    // ===================================================
    public function edit(City $city)
    {
        $countries = Country::orderBy('name')->get();
        $states = State::where('country_id', $city->state->country_id)->get();

        return view('city.edit', compact('city','countries','states'));
    }

    // ===================================================
    // UPDATE
    // ===================================================
    public function update(Request $request, City $city)
    {
        $request->validate([
            'country_id' => 'required',
            'state_id'   => 'required',
            'name'       => [
                'required',
                'min:2',
                Rule::unique('cities')
                    ->where(fn ($q) =>
                        $q->where('state_id', $request->state_id)
                    )
                    ->ignore($city->id),
            ],
        ]);

        $city->update([
            'state_id' => $request->state_id,
            'name'     => $request->name,
        ]);

        return redirect()
            ->route('admin.cities.index')
            ->with('success','City updated successfully');
    }

    // ===================================================
    // DELETE (SOFT)
    // ===================================================
    public function destroy(City $city)
    {
        $city->delete();
        return response()->json(['status'=>true]);
    }

    // ===================================================
    // RESTORE
    // ===================================================
    public function restore($id)
    {
        City::onlyTrashed()
            ->findOrFail($id)
            ->restore();

        return response()->json(['status'=>true]);
    }
}
