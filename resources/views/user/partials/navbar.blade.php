<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark shadow-sm">

    {{-- BRAND --}}
    <a class="navbar-brand ps-3 fw-semibold" href="{{ route('dashboard') }}">
        <i class="fas fa-layer-group me-1"></i>
        User Panel
    </a>

    {{-- RIGHT SIDE --}}
    <ul class="navbar-nav ms-auto me-4 align-items-center">

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center"
               href="#"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false">

                
                <span class="d-none d-md-inline">
                    {{ auth()->user()->name }}
                </span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">

                <li class="dropdown-item-text fw-semibold">
                    {{ auth()->user()->name }}
                </li>

                <li><hr class="dropdown-divider"></li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger d-flex align-items-center">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Logout
                        </button>
                    </form>
                </li>

            </ul>
        </li>
    </ul>
</nav>
