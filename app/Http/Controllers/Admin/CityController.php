<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('state.country')->get();
        return view('city.index', compact('cities'));
    }

    public function create()
    {
        $states = State::all();
        return view('city.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'state_id' => 'required',
            'name' => 'required'
        ]);

        City::create([
            'state_id' => $request->state_id,
            'name' => $request->name
        ]);

        return redirect()->route('admin.cities.index');
    }

    public function edit(City $city)
    {
        $states = State::all();
        return view('city.edit', compact('city','states'));
    }

    public function update(Request $request, City $city)
    {
        $city->update([
            'state_id' => $request->state_id,
            'name' => $request->name
        ]);

        return redirect()->route('admin.cities.index');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return back();
    }
}
