<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    {{-- BRAND (ROLE BASED) --}}
    @hasanyrole('admin|super-admin')
    <a class="navbar-brand ps-3" href="{{ route('admin.dashboard') }}">
        GTC Admin
    </a>
    @endrole

    @role('manager')
    <a class="navbar-brand ps-3" href="{{ route('manager.dashboard') }}">
        GTC Manager
    </a>
    @endrole

    <button class="btn btn-link btn-sm" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <ul class="navbar-nav ms-auto me-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-user fa-fw"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li class="dropdown-item-text small text-muted">
                    {{ auth()->user()->name }}
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
