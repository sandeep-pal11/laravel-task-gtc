@extends('layouts.admin')

@section('title','Manager Dashboard')

@section('content')

<h1 class="mt-4 mb-4">Manager Dashboard</h1>

<div class="row g-4">

    {{-- COUNTRIES --}}
    @can('countries.view')
    <div class="col-md-4 col-xl-3">
        <div class="card shadow-sm border-0 h-100 d-flex flex-column">
            <div class="card-body d-flex justify-content-between align-items-center flex-grow-1">
                <div>
                    <div class="text-muted small">Countries</div>
                    <h2 class="mb-0">Manage</h2>
                </div>
                <i class="fas fa-globe fa-2x text-primary"></i>
            </div>
            <div class="card-footer bg-white text-end mt-auto">
                <a href="{{ route('admin.countries.index') }}"
                   class="small text-primary">
                    Open →
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- STATES --}}
    @can('states.view')
    <div class="col-md-4 col-xl-3">
        <div class="card shadow-sm border-0 h-100 d-flex flex-column">
            <div class="card-body d-flex justify-content-between align-items-center flex-grow-1">
                <div>
                    <div class="text-muted small">States</div>
                    <h2 class="mb-0">Manage</h2>
                </div>
                <i class="fas fa-map fa-2x text-success"></i>
            </div>
            <div class="card-footer bg-white text-end mt-auto">
                <a href="{{ route('admin.states.index') }}"
                   class="small text-success">
                    Open →
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- CITIES --}}
    @can('cities.view')
    <div class="col-md-4 col-xl-3">
        <div class="card shadow-sm border-0 h-100 d-flex flex-column">
            <div class="card-body d-flex justify-content-between align-items-center flex-grow-1">
                <div>
                    <div class="text-muted small">Cities</div>
                    <h2 class="mb-0">Manage</h2>
                </div>
                <i class="fas fa-city fa-2x text-warning"></i>
            </div>
            <div class="card-footer bg-white text-end mt-auto">
                <a href="{{ route('admin.cities.index') }}"
                   class="small text-warning">
                    Open →
                </a>
            </div>
        </div>
    </div>
    @endcan

</div>

@endsection
