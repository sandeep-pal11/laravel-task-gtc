<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;

class CityController extends Controller
{
    // 🔵 ADMIN / SUPER ADMIN
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(City::with('state.country'))
                ->addIndexColumn()
                ->addColumn('state', fn ($c) => $c->state->name)
                ->addColumn('country', fn ($c) => $c->state->country->name)
                ->addColumn('action', function ($c) {

                    $btn = '';

                    if (Gate::allows('cities.edit')) {
                        $btn .= '<a href="'.route('admin.cities.edit',$c).'"
                                  class="btn btn-warning btn-sm me-1">Edit</a>';
                    }

                    if (Gate::allows('cities.delete')) {
                        $btn .= '
                        <form action="'.route('admin.cities.destroy',$c).'"
                              method="POST" class="d-inline">
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

    // 🔴 MANAGER (READ ONLY)
    public function managerIndex()
    {
        $cities = City::with('state.country')->latest()->get();
        return view('city.manager-index', compact('cities'));
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
            'name' => 'required'
        ]);

        City::create($request->only('state_id','name'));

        return redirect()->route('admin.cities.index')
            ->with('success','City added');
    }

    public function edit(City $city)
    {
        $states = State::with('country')->get();
        return view('city.edit', compact('city','states'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'state_id' => 'required',
            'name' => 'required'
        ]);

        $city->update($request->only('state_id','name'));

        return redirect()->route('admin.cities.index')
            ->with('success','City updated');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return back()->with('success','City deleted');
    }
}
