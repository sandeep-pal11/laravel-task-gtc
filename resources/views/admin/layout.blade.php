<!doctype html>
<html>
<head>
    <title>Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3 d-flex justify-content-between">
    <span class="navbar-brand">Admin Panel</span>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger btn-sm">Logout</button>
    </form>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- DELETE CONFIRM --}}
<script>
$(document).on('click','.delete-btn',function (e) {
    e.preventDefault();
    let form = $(this).closest('form');

    Swal.fire({
        title: 'Are you sure?',
        text: 'This record will be deleted!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});
</script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: '{{ session("success") }}',
    timer: 1500,
    showConfirmButton: false
});
</script>
@endif

</body>
</html>
