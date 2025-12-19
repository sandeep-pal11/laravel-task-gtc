@extends('admin.layout')

@section('content')
<h2>Manager Dashboard</h2>

<div class="row g-3 mt-3">

    @can('countries.view')
    <div class="col-md-4">
        <a href="{{ route('manager.countries') }}" class="btn btn-primary w-100">
            Countries
        </a>
    </div>
    @endcan

    @can('states.view')
    <div class="col-md-4">
        <a href="{{ route('manager.states') }}" class="btn btn-success w-100">
            States
        </a>
    </div>
    @endcan

    @can('cities.view')
    <div class="col-md-4">
        <a href="{{ route('manager.cities') }}" class="btn btn-warning w-100">
            Cities
        </a>
    </div>
    @endcan

</div>
@endsection
