@extends('admin.layout')

@section('content')
<h3>Edit User Role</h3>

<form method="POST" action="{{ route('users.update', $user) }}">
    @csrf
    @method('PUT')

    @foreach($roles as $role)
        <div>
            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                @checked($user->hasRole($role->name))>
            {{ $role->name }}
        </div>
    @endforeach

    <button class="btn btn-success mt-2">Update</button>
</form>
@endsection
