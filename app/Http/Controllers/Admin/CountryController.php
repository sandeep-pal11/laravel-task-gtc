<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::latest()->get();
        return view('country.index', compact('countries'));
    }

    public function create()
    {
        return view('country.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Country::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.countries.index');
    }

    public function edit(Country $country)
    {
        return view('country.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $country->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.countries.index');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return back();
    }
}
