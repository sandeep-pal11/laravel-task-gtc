@extends('admin.layout')

@section('content')
<h3>Users</h3>

<table class="table table-bordered" id="users-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th width="150">Action</th>
        </tr>
    </thead>
</table>
@endsection

@push('scripts')
<script>
$(function () {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.users.index') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'roles', name: 'roles', orderable:false },
            { data: 'action', name: 'action', orderable:false, searchable:false },
        ]
    });
});
</script>
@endpush
