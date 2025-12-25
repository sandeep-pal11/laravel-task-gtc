<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- SB Admin CSS --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    {{-- DataTables (Backend requirement) --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    {{-- FontAwesome --}}
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

    {{-- Navbar --}}
    @include('adminn.partials.navbar')

    <div id="layoutSidenav">

        {{-- Sidebar --}}
        @include('adminn.partials.sidebar')

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 mt-4">
                    @yield('content')
                </div>
            </main>

            {{-- Footer --}}
            @include('adminn.partials.footer')
        </div>
    </div>

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- jQuery (for DataTables & SweetAlert) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- SB Admin JS --}}
    <script src="{{ asset('js/scripts.js') }}"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

    {{-- Export --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Page specific scripts --}}
    @stack('scripts')

    {{-- Success Alert --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: @json(session('success')),
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif

</body>
</html>
