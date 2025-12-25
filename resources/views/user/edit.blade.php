@extends('layouts.admin')

@section('title','Edit User Roles')

@section('content')
@can('users.edit')

<h3>Edit User Role</h3>

<form id="userRoleForm"
      method="POST"
      action="{{ route('admin.users.update', $user) }}">
    @csrf
    @method('PUT')

    <div class="mb-2">
        @foreach($roles as $role)
            <div class="form-check">
                <input type="checkbox"
                       name="roles[]"
                       value="{{ $role->name }}"
                       class="form-check-input role-checkbox"
                       @checked($user->hasRole($role->name))>

                <label class="form-check-label">
                    {{ ucfirst($role->name) }}
                </label>
            </div>
        @endforeach

        <small class="text-danger error-role"></small>
    </div>

    <button class="btn btn-success mt-2">Update</button>
</form>

@endcan
@endsection

@push('scripts')
<script>
document.getElementById('userRoleForm').addEventListener('submit', function (e) {

    e.preventDefault();

    let checked = document.querySelectorAll('.role-checkbox:checked').length;

    document.querySelector('.error-role').innerText = '';

    if (!checked) {
        document.querySelector('.error-role').innerText =
            'Please select at least one role';

        Swal.fire('Error','Please fix the errors','error');
        return;
    }

    this.submit();
});
</script>
@endpush
