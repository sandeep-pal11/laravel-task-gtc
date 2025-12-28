<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'User Dashboard')</title>

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>

    <!-- SweetAlert2 -->
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/scripts.js') }}"></script>

{{-- ========================================================= --}}
{{-- CLIENT SIDE VALIDATION --}}
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
{{-- SERVER SIDE RESPONSE HANDLING --}}
{{-- ========================================================= --}}

@if(session('status') === 'profile-updated')
<script>
Swal.fire({
    icon: 'success',
    title: 'Profile Updated',
    text: 'Your profile has been updated successfully',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@if(session('status') === 'password-updated')
<script>
Swal.fire({
    icon: 'success',
    title: 'Password Updated',
    text: 'Your password has been changed successfully',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@if($errors->updatePassword->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Password Update Failed',
    html: @json(implode('<br>', $errors->updatePassword->all()))
});
</script>
@endif

@if($errors->userDeletion->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Delete Account Failed',
    html: @json(implode('<br>', $errors->userDeletion->all()))
});
</script>
@endif

</body>
</html>
