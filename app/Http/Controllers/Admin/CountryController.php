<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:countries.view')->only('index');
        $this->middleware('permission:countries.create')->only(['create','store']);
        $this->middleware('permission:countries.edit')->only(['edit','update']);
        $this->middleware('permission:countries.delete')->only(['destroy','restore']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            // ✅ withTrashed so deleted rows bhi aaye
            $countries = Country::withTrashed();

            return DataTables::of($countries)
                ->addIndexColumn()
                ->addColumn('action', function ($c) {

                    // 🔹 Agar deleted hai → sirf Restore
                    if ($c->deleted_at) {
                        return '
                        <button data-id="'.$c->id.'"
                                class="btn btn-success btn-sm restore-btn">
                            Restore
                        </button>';
                    }

                    // 🔹 Normal row → Edit + Delete
                    $btn = '';

                    if (Gate::allows('countries.edit')) {
                        $btn .= '<a href="'.route('admin.countries.edit',$c).'"
                                   class="btn btn-warning btn-sm me-1">
                                   Edit
                                 </a>';
                    }

                    if (Gate::allows('countries.delete')) {
                        $btn .= '
                        <form action="'.route('admin.countries.destroy',$c).'"
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

        return view('country.index');
    }

    public function create()
    {
        return view('country.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'required|min:2']);

        Country::create(['name'=>$request->name]);

        return redirect()->route('admin.countries.index')
            ->with('success','Country created');
    }

    public function edit(Country $country)
    {
        return view('country.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate(['name'=>'required|min:2']);

        $country->update(['name'=>$request->name]);

        return redirect()->route('admin.countries.index')
            ->with('success','Country updated');
    }

    // 🔴 Soft delete
    public function destroy(Country $country)
    {
        $country->delete();

        return response()->json(['status'=>true]);
    }

    // ♻ Restore
    public function restore($id)
    {
        Country::onlyTrashed()->findOrFail($id)->restore();

        return response()->json(['status'=>true]);
    }
}
