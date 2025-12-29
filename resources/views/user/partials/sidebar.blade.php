<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark shadow-sm" id="userSidenav">

        <div class="sb-sidenav-menu">
            <div class="nav">

                {{-- HEADING --}}
                <div class="sb-sidenav-menu-heading text-uppercase small">
                    Core
                </div>

                {{-- DASHBOARD --}}
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Dashboard
                </a>

                {{-- PROFILE --}}
                <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                   href="{{ route('profile.edit') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    Profile
                </a>

                {{-- MY TASKS --}}
                <a class="nav-link {{ request()->routeIs('user.tasks.*') ? 'active' : '' }}"
                   href="{{ route('user.tasks.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    My Tasks
                </a>

            </div>
        </div>

        {{-- FOOTER --}}
        <div class="sb-sidenav-footer small text-muted">
            Logged in as<br>
            <strong>{{ auth()->user()->name }}</strong>
        </div>

    </nav>
</div>
