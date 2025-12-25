@extends('layouts.admin')

@section('title','Admin Dashboard')

@section('content')

<h1 class="mt-4 mb-4">Dashboard</h1>

<div class="row g-4">

    {{-- TOTAL USERS --}}
    <div class="col-md-4 col-xl-3">
        <div class="card shadow-sm border-0 h-100 d-flex flex-column">
            <div class="card-body d-flex justify-content-between align-items-center flex-grow-1">
                <div>
                    <div class="text-muted small">Total Users</div>
                    <h2 class="mb-0">{{ $totalUsers }}</h2>
                </div>
                <i class="fas fa-users fa-2x text-primary"></i>
            </div>
            <div class="card-footer bg-white text-end mt-auto">
                <a href="{{ route('admin.users.index') }}" class="small text-primary">
                    View →
                </a>
            </div>
        </div>
    </div>

    {{-- COUNTRIES --}}
    <div class="col-md-4 col-xl-3">
        <div class="card shadow-sm border-0 h-100 d-flex flex-column">
            <div class="card-body d-flex justify-content-between align-items-center flex-grow-1">
                <div>
                    <div class="text-muted small">Countries</div>
                    <h2 class="mb-0">{{ $totalCountries }}</h2>
                </div>
                <i class="fas fa-globe fa-2x text-warning"></i>
            </div>
            <div class="card-footer bg-white text-end mt-auto">
                <a href="{{ route('admin.countries.index') }}" class="small text-warning">
                    Manage →
                </a>
            </div>
        </div>
    </div>

    {{-- STATES --}}
    <div class="col-md-4 col-xl-3">
        <div class="card shadow-sm border-0 h-100 d-flex flex-column">
            <div class="card-body d-flex justify-content-between align-items-center flex-grow-1">
                <div>
                    <div class="text-muted small">States</div>
                    <h2 class="mb-0">{{ $totalStates }}</h2>
                </div>
                <i class="fas fa-map fa-2x text-info"></i>
            </div>
            <div class="card-footer bg-white text-end mt-auto">
                <a href="{{ route('admin.states.index') }}" class="small text-info">
                    Manage →
                </a>
            </div>
        </div>
    </div>

    {{-- CITIES --}}
    <div class="col-md-4 col-xl-3">
        <div class="card shadow-sm border-0 h-100 d-flex flex-column">
            <div class="card-body d-flex justify-content-between align-items-center flex-grow-1">
                <div>
                    <div class="text-muted small">Cities</div>
                    <h2 class="mb-0">{{ $totalCities }}</h2>
                </div>
                <i class="fas fa-city fa-2x text-secondary"></i>
            </div>
            <div class="card-footer bg-white text-end mt-auto">
                <a href="{{ route('admin.cities.index') }}" class="small text-secondary">
                    Manage →
                </a>
            </div>
        </div>
    </div>

    {{-- ACTIVE USERS (LAST PART) --}}
    <div class="col-md-4 col-xl-3">
        <div class="card shadow-sm border-0 h-100 d-flex flex-column">
            <div class="card-body d-flex justify-content-between align-items-center flex-grow-1">
                <div>
                    <div class="text-muted small">Active Users</div>
                    <h2 class="mb-0">{{ $activeUsers }}</h2>
                </div>
                <i class="fas fa-user-check fa-2x text-success"></i>
            </div>
            {{-- empty footer for equal height --}}
            <div class="card-footer bg-white mt-auto"></div>
        </div>
    </div>

    {{-- INACTIVE USERS (LAST PART) --}}
    <div class="col-md-4 col-xl-3">
        <div class="card shadow-sm border-0 h-100 d-flex flex-column">
            <div class="card-body d-flex justify-content-between align-items-center flex-grow-1">
                <div>
                    <div class="text-muted small">Inactive Users</div>
                    <h2 class="mb-0">{{ $inactiveUsers }}</h2>
                </div>
                <i class="fas fa-user-times fa-2x text-danger"></i>
            </div>
            {{-- empty footer for equal height --}}
            <div class="card-footer bg-white mt-auto"></div>
        </div>
    </div>

</div>

@endsection
