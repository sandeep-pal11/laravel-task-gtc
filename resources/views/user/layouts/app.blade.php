<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'User Dashboard')</title>

    {{-- SB Admin CSS --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    {{-- FontAwesome --}}
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>

    {{-- ✅ DataTables CSS (REQUIRED) --}}
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="sb-nav-fixed">

@include('user.partials.navbar')

<div id="layoutSidenav">
    @include('user.partials.sidebar')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-4">
                @yield('content')
            </div>
        </main>
    </div>
</div>

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- SB Admin JS --}}
<script src="{{ asset('js/scripts.js') }}"></script>

{{-- ✅ jQuery (DataTables ke liye MUST) --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- ✅ DataTables JS --}}
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

{{-- ========================================================= --}}
{{-- CLIENT SIDE VALIDATION (TERA CODE AS IT IS) --}}
{{-- ========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ================= PROFILE UPDATE ================= */
    const profileForm = document.getElementById('profileUpdateForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function (e) {

            const name = profileForm.querySelector('input[name="name"]');
            const photo = profileForm.querySelector('input[name="profile_photo"]');

            if (!name.value.trim()) {
                e.preventDefault();
                Swal.fire('Validation Error', 'Name is required', 'error');
                return;
            }

            if (photo && photo.files.length > 0) {
                const file = photo.files[0];
                const allowed = ['image/jpeg', 'image/png', 'image/jpg'];

                if (!allowed.includes(file.type)) {
                    e.preventDefault();
                    Swal.fire('Invalid File', 'Only JPG or PNG images allowed', 'error');
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    e.preventDefault();
                    Swal.fire('File Too Large', 'Image must be less than 2MB', 'error');
                    return;
                }
            }
        });
    }

    /* ================= PASSWORD UPDATE ================= */
    const passwordForm = document.getElementById('passwordUpdateForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function (e) {

            const current = passwordForm.querySelector('input[name="current_password"]');
            const pass = passwordForm.querySelector('input[name="password"]');
            const confirm = passwordForm.querySelector('input[name="password_confirmation"]');

            if (!current.value || !pass.value || !confirm.value) {
                e.preventDefault();
                Swal.fire('Validation Error', 'All password fields are required', 'error');
                return;
            }

            if (pass.value.length < 8) {
                e.preventDefault();
                Swal.fire('Weak Password', 'Password must be at least 8 characters', 'error');
                return;
            }

            if (pass.value !== confirm.value) {
                e.preventDefault();
                Swal.fire('Mismatch', 'Passwords do not match', 'error');
                return;
            }
        });
    }
});

/* ================= DELETE ACCOUNT ================= */
function confirmDeleteAccount() {

    const password = document.getElementById('deletePassword');

    if (!password || !password.value) {
        Swal.fire('Validation Error', 'Password is required', 'error');
        return;
    }

    Swal.fire({
        title: 'Are you absolutely sure?',
        text: 'This action will permanently delete your account.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete my account'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteAccountForm').submit();
        }
    });
}
</script>

{{-- ========================================================= --}}
{{-- SERVER SIDE ALERTS --}}
{{-- ========================================================= --}}

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

{{-- ✅ IMPORTANT: YAJRA SCRIPT STACK --}}
@stack('scripts')

</body>
</html>
