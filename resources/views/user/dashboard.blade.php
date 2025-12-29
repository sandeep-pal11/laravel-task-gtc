@extends('user.layouts.app')

@section('title','User Dashboard')

@section('content')

<h1 class="mt-4 mb-4">Dashboard</h1>

<p class="text-muted mb-4">
    Welcome back, <strong>{{ auth()->user()->name }}</strong>
</p>

<div class="row g-4">

    {{-- TOTAL TASKS --}}
    <div class="col-md-4 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Tasks</div>
                    <h2 class="mb-0">{{ $totalTasks }}</h2>
                </div>
                <i class="fas fa-tasks fa-2x text-primary"></i>
            </div>
            <div class="card-footer bg-white text-end">
                <a href="{{ route('user.tasks.index') }}" class="small text-primary">
                    View →
                </a>
            </div>
        </div>
    </div>

    {{-- PENDING TASKS --}}
    <div class="col-md-4 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Pending Tasks</div>
                    <h2 class="mb-0">{{ $pendingTasks }}</h2>
                </div>
                <i class="fas fa-hourglass-half fa-2x text-warning"></i>
            </div>
            <div class="card-footer bg-white text-end">
                <a href="{{ route('user.tasks.index') }}" class="small text-warning">
                    Check →
                </a>
            </div>
        </div>
    </div>

    {{-- COMPLETED TASKS --}}
    <div class="col-md-4 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Completed Tasks</div>
                    <h2 class="mb-0">{{ $completedTasks }}</h2>
                </div>
                <i class="fas fa-check-circle fa-2x text-success"></i>
            </div>
            <div class="card-footer bg-white text-end">
                <a href="{{ route('user.tasks.index') }}" class="small text-success">
                    View →
                </a>
            </div>
        </div>
    </div>

    {{-- PROFILE --}}
    <div class="col-md-4 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">My Profile</div>
                    <h5 class="mb-0">Account</h5>
                </div>
                <i class="fas fa-user fa-2x text-info"></i>
            </div>
            <div class="card-footer bg-white text-end">
                <a href="{{ route('profile.edit') }}" class="small text-info">
                    Edit →
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
