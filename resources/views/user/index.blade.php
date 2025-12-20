@extends('admin.layout')

@section('content')
<h3>Users</h3>

<table class="table table-bordered" id="users-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>

            @canany(['users.edit','users.delete'])
                <th>Action</th>
            @endcanany
        </tr>
    </thead>
</table>
@endsection

@push('scripts')
<script>
$(function () {

    let columns = [
        { data: 'DT_RowIndex', orderable:false, searchable:false },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'roles', name: 'roles', orderable:false }
    ];

    @canany(['users.edit','users.delete'])
        columns.push({
            data: 'action',
            orderable:false,
            searchable:false
        });
    @endcanany

    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.users.index') }}",
        columns: columns
    });

    // SweetAlert delete
    $(document).on('click','.delete-btn',function () {
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This user will be deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

});
</script>
@endpush
