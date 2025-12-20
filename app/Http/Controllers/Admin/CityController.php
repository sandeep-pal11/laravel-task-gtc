<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cities.view')->only('index');
        $this->middleware('permission:cities.create')->only(['create','store']);
        $this->middleware('permission:cities.edit')->only(['edit','update']);
        $this->middleware('permission:cities.delete')->only('destroy');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $cities = City::with('state.country')->select('cities.*');

            $datatable = DataTables::of($cities)
                ->addIndexColumn()
                ->addColumn('state', fn ($c) => $c->state->name ?? '-')
                ->addColumn('country', fn ($c) => $c->state->country->name ?? '-');

            // ✅ ACTION COLUMN SIRF ADMIN / SUPER-ADMIN KE LIYE
            if (Gate::any(['cities.edit','cities.delete'])) {
                $datatable->addColumn('action', function ($c) {

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
                ->rawColumns(['action']);
            }

            return $datatable->make(true);
        }

        return view('city.index');
    }

    public function create()
    {
        $states = State::with('country')->get();
        return view('city.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'name'     => 'required|min:2',
        ]);

        City::create($request->only('state_id','name'));

        return redirect()->route('admin.cities.index')
            ->with('success','City created successfully');
    }

    public function edit(City $city)
    {
        $states = State::all();
        return view('city.edit', compact('city','states'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'name'     => 'required|min:2',
        ]);

        $city->update($request->only('state_id','name'));

        return redirect()->route('admin.cities.index')
            ->with('success','City updated successfully');
    }

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('admin.cities.index')
            ->with('success','City deleted successfully');
    }
}
