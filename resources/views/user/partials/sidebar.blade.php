<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark">

        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">CORE</div>

                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>

                <a class="nav-link" href="{{ route('profile.edit') }}">
                    <i class="fas fa-user"></i>
                    Profile
                </a>

                {{-- USER TASKS --}}
                <a class="nav-link" href="{{ route('user.tasks.index') }}">
                    <i class="fas fa-tasks"></i>
                    My Tasks
                </a>

            </div>
        </div>

    </nav>
</div>
