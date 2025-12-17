@extends('admin.layout')

@section('content')
<h2>Admin Dashboard</h2>

<div class="row g-3 mt-3">
    <div class="col-md-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-dark w-100">
            Users
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('admin.countries.index') }}" class="btn btn-primary w-100">
            Countries
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('admin.states.index') }}" class="btn btn-success w-100">
            States
        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('admin.cities.index') }}" class="btn btn-warning w-100">
            Cities
        </a>
    </div>
</div>
@endsection
