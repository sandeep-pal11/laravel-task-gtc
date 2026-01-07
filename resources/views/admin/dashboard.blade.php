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

    {{-- ================= CHARTS ================= --}}
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <i class="fas fa-chart-bar me-1"></i>
                    Tasks by Status
                </div>
                <div class="card-body"><canvas id="tasksChart" width="100%" height="50"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <i class="fas fa-chart-pie me-1"></i>
                    Users by Role
                </div>
                <div class="card-body"><canvas id="rolesChart" width="100%" height="50"></canvas></div>
            </div>
        </div>
    </div>

    {{-- ================= TODAY ASSIGNED TASKS ================= --}}
<div class="row mt-5">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2 text-primary"></i>
                    Today Assigned Tasks
                </h5>
            </div>

            <div class="card-body p-0">
                @if($todayTasks->count())
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Task</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                            <th>Assigned At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($todayTasks as $i => $task)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->user->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $task->status == 'completed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td>{{ $task->created_at->format('h:i A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="p-4 text-center text-muted">
                        No tasks assigned today.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script>
    // TASKS CHART
    var ctxTasks = document.getElementById("tasksChart");
    var tasksChart = new Chart(ctxTasks, {
        type: 'bar',
        data: {
            labels: ["Pending", "In Progress", "Completed"],
            datasets: [{
                label: "Tasks",
                backgroundColor: ["#ffc107", "#0dcaf0", "#198754"],
                borderColor: ["#ffc107", "#0dcaf0", "#198754"],
                data: [{{ $chartTasks['pending'] }}, {{ $chartTasks['in_progress'] }}, {{ $chartTasks['completed'] }}],
            }],
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
            },
            legend: {
                display: false
            }
        }
    });

    // ROLES CHART
    var ctxRoles = document.getElementById("rolesChart");
    var rolesChart = new Chart(ctxRoles, {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_keys($chartRoles)) !!},
            datasets: [{
                data: {!! json_encode(array_values($chartRoles)) !!},
                backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
            }],
        },
    });
</script>
@endpush
