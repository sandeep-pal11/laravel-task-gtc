<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Services\CountryService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;

class CountryController extends Controller
{
    public function __construct(
        protected CountryService $countryService
    ) {}

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of($this->countryService->query())
                ->addIndexColumn()
                ->addColumn('action', function ($country) {

                    $btn = '';

                    if (Gate::allows('countries.edit')) {
                        $btn .= '<a href="'.route('admin.countries.edit',$country).'"
                                  class="btn btn-warning btn-sm me-1">Edit</a>';
                    }

                    if (Gate::allows('countries.delete')) {
                        $btn .= '
                        <form action="'.route('admin.countries.destroy',$country).'"
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

        return view('country.index');
    }

    public function create()
    {
        return view('country.create');
    }

    public function store(Request $request)
    {
            $request->validate([
    'name' => 'required|unique:countries,name'
]);

        $this->countryService->store($request->only('name'));

        return redirect()
            ->route('admin.countries.index')
            ->with('success','Country created successfully');
    }

    public function edit(Country $country)
    {
        return view('country.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
     $request->validate([
    'name' => 'required|unique:countries,name'
]);


        $this->countryService->update($country, $request->only('name'));

        return redirect()
            ->route('admin.countries.index')
            ->with('success','Country updated successfully');
    }

    public function destroy(Country $country)
    {
        $this->countryService->delete($country);

        return back()->with('success','Country deleted successfully');
    }
}
