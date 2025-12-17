<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;

class StateController extends Controller
{
    public function index()
    {
        $states = State::with('country')->get();
        return view('state.index', compact('states'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('state.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'name' => 'required'
        ]);

        State::create([
            'country_id' => $request->country_id,
            'name' => $request->name
        ]);

        return redirect()->route('admin.states.index');
    }

    public function edit(State $state)
    {
        $countries = Country::all();
        return view('state.edit', compact('state','countries'));
    }

    public function update(Request $request, State $state)
    {
        $state->update([
            'country_id' => $request->country_id,
            'name' => $request->name
        ]);

        return redirect()->route('admin.states.index');
    }

    public function destroy(State $state)
    {
        $state->delete();
        return back();
    }
}
