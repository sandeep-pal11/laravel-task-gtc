<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- SB Admin CSS --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    {{-- DataTables Bootstrap 5 --}}
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet"
          href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

    {{-- FontAwesome --}}
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>

<body class="sb-nav-fixed">

@include('adminn.partials.navbar')

<div id="layoutSidenav">
    @include('adminn.partials.sidebar')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-4">
                @yield('content')
            </div>
        </main>

        @include('adminn.partials.footer')
    </div>
</div>

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- SB Admin --}}
<script src="{{ asset('js/scripts.js') }}"></script>

{{-- DataTables --}}
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

{{-- Buttons --}}
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

{{-- Export --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('scripts')

{{-- SUCCESS MESSAGE --}}
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
