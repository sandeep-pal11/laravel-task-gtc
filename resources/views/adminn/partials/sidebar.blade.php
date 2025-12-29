<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">

        <div class="sb-sidenav-menu">
            <div class="nav">

                {{-- ================= CORE ================= --}}
                <div class="sb-sidenav-menu-heading">CORE</div>

                {{-- ADMIN / SUPER ADMIN DASHBOARD --}}
                @hasanyrole('admin|super-admin')
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Dashboard
                </a>
                @endhasanyrole

                {{-- MANAGER DASHBOARD --}}
                @role('manager')
                <a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}"
                   href="{{ route('manager.dashboard') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Dashboard
                </a>
                @endrole


                {{-- ================= INTERFACE ================= --}}
                <div class="sb-sidenav-menu-heading">INTERFACE</div>

                {{-- USERS --}}
                @can('users.view')
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                   href="{{ route('admin.users.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    Users
                </a>
                @endcan

                {{-- TASKS --}}
                @can('tasks.view')
                <a class="nav-link {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}"
                   href="{{ route('admin.tasks.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    Tasks
                </a>
                @endcan

                {{-- LOCATION DROPDOWN --}}
                @canany(['countries.view','states.view','cities.view'])
                <a class="nav-link d-flex justify-content-between align-items-center
                   {{ request()->routeIs('admin.countries.*','admin.states.*','admin.cities.*') ? '' : 'collapsed' }}"
                   href="#"
                   data-bs-toggle="collapse"
                   data-bs-target="#locationMenu"
                   aria-expanded="{{ request()->routeIs('admin.countries.*','admin.states.*','admin.cities.*') ? 'true' : 'false' }}"
                   aria-controls="locationMenu">

                    <span>
                        <div class="sb-nav-link-icon d-inline-block">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        Location
                    </span>

                    <i class="fas fa-angle-down dropdown-arrow"></i>
                </a>

                <div class="collapse
                    {{ request()->routeIs('admin.countries.*','admin.states.*','admin.cities.*') ? 'show' : '' }}"
                     id="locationMenu"
                     data-bs-parent="#sidenavAccordion">

                    <nav class="sb-sidenav-menu-nested nav">

                        @can('countries.view')
                        <a class="nav-link {{ request()->routeIs('admin.countries.*') ? 'active' : '' }}"
                           href="{{ route('admin.countries.index') }}">
                            <i class="fas fa-flag me-2 text-muted"></i>
                            Countries
                        </a>
                        @endcan

                        @can('states.view')
                        <a class="nav-link {{ request()->routeIs('admin.states.*') ? 'active' : '' }}"
                           href="{{ route('admin.states.index') }}">
                            <i class="fas fa-map me-2 text-muted"></i>
                            States
                        </a>
                        @endcan

                        @can('cities.view')
                        <a class="nav-link {{ request()->routeIs('admin.cities.*') ? 'active' : '' }}"
                           href="{{ route('admin.cities.index') }}">
                            <i class="fas fa-city me-2 text-muted"></i>
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
