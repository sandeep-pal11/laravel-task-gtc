<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark">

        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">CORE</div>

                {{-- ADMIN / SUPER ADMIN --}}
                @hasanyrole('admin|super-admin')
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Dashboard
                </a>
                @endhasanyrole

                {{-- MANAGER --}}
                @role('manager')
                <a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}"
                   href="{{ route('manager.dashboard') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Dashboard
                </a>
                @endrole

                <div class="sb-sidenav-menu-heading">INTERFACE</div>

                {{-- USERS --}}
                @can('users.view')
                <a class="nav-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i>
                    Users
                </a>
                @endcan

                {{-- TASKS --}}
                @can('tasks.view')
                <a class="nav-link {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}"
                   href="{{ route('admin.tasks.index') }}">
                    <i class="fas fa-tasks"></i>
                    Tasks
                </a>
                @endcan

                {{-- LOCATION --}}
                @canany(['countries.view','states.view','cities.view'])
                <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#locationMenu">
                    <i class="fas fa-map-marked-alt"></i>
                    Location
                </a>

                <div class="collapse" id="locationMenu">
                    <nav class="sb-sidenav-menu-nested nav">
                        @can('countries.view')
                        <a class="nav-link" href="{{ route('admin.countries.index') }}">
                            Countries
                        </a>
                        @endcan

                        @can('states.view')
                        <a class="nav-link" href="{{ route('admin.states.index') }}">
                            States
                        </a>
                        @endcan

                        @can('cities.view')
                        <a class="nav-link" href="{{ route('admin.cities.index') }}">
                            Cities
                        </a>
                        @endcan
                    </nav>
                </div>
                @endcanany

            </div>
        </div>

    </nav>
</div>
