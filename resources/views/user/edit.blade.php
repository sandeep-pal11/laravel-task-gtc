@extends('admin.layout')

@section('content')
<h3>Edit User Roles</h3>

<form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf
    @method('PUT')

    @foreach($roles as $role)
        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="roles[]"
                   value="{{ $role->name }}"
                   @checked($user->hasRole($role->name))>
            <label class="form-check-label">
                {{ $role->name }}
            </label>
        </div>
    @endforeach

    <button class="btn btn-success mt-2">Update</button>
</form>
@endsection
