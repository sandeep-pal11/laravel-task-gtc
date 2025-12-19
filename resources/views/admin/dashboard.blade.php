@extends('admin.layout')

@section('content')
<h2>Admin Dashboard</h2>

<div class="row g-3 mt-3">

    @can('users.view')
    <div class="col-md-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-dark w-100">
            Users
        </a>
    </div>
    @endcan

    @can('countries.view')
    <div class="col-md-3">
        <a href="{{ route('admin.countries.index') }}" class="btn btn-primary w-100">
            Countries
        </a>
    </div>
    @endcan

    @can('states.view')
    <div class="col-md-3">
        <a href="{{ route('admin.states.index') }}" class="btn btn-success w-100">
            States
        </a>
    </div>
    @endcan

    @can('cities.view')
    <div class="col-md-3">
        <a href="{{ route('admin.cities.index') }}" class="btn btn-warning w-100">
            Cities
        </a>
    </div>
    @endcan

</div>
@endsection
