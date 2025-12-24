@extends('admin.layout')

@section('content')
<h3>Users</h3>

@php $today = date('Y-m-d'); @endphp

{{-- FILTERS --}}
<div class="row mb-3">
    <div class="col-md-3">
        <select id="roleFilter" class="form-control">
            <option value="">All Roles</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}">
                    {{ ucfirst($role->name) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <input type="date" id="fromDate"
               class="form-control"
               max="{{ $today }}">
    </div>

    <div class="col-md-3">
        <input type="date" id="toDate"
               class="form-control"
               max="{{ $today }}">
    </div>

    <div class="col-md-3">
        <button id="resetFilters"
                class="btn btn-secondary w-100">
            Clear Filters
        </button>
    </div>
</div>

<table class="table table-bordered" id="users-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
</table>
@endsection

@push('scripts')
<script>
$(function () {

    let table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.users.index') }}",
            data: function (d) {
                d.role      = $('#roleFilter').val();
                d.from_date = $('#fromDate').val();
                d.to_date   = $('#toDate').val();
            }
        },
        columns: [
            { data:'DT_RowIndex', orderable:false, searchable:false },
            { data:'name' },
            { data:'email' },
            { data:'roles', orderable:false },
            { data:'status', orderable:false, searchable:false },
            { data:'action', orderable:false, searchable:false }
        ]
    });

    // FILTER CHANGE
    $('#roleFilter, #fromDate, #toDate').change(function () {
        table.ajax.reload();
    });

    // RESET FILTER
    $('#resetFilters').click(function () {
        $('#roleFilter').val('');
        $('#fromDate').val('');
        $('#toDate').val('');
        table.ajax.reload();
    });

    //  DELETE USER
    $(document).on('click','.delete-btn',function () {

        let form = $(this).closest('form');

        Swal.fire({
            title: 'Delete user?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete'
        }).then(res=>{
            if(res.isConfirmed){
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function (res) {
                        Swal.fire('Success', res.message, 'success');
                        table.ajax.reload(null,false);
                    },
                    error: function (xhr) {
                        Swal.fire(
                            'Blocked',
                            xhr.responseJSON.message,
                            'error'
                        );
                    }
                });
            }
        });
    });

    // RESTORE USER
    $(document).on('click','.restore-btn',function () {

        let id = $(this).data('id');

        Swal.fire({
            title: 'Restore user?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, restore'
        }).then(res=>{
            if(res.isConfirmed){
                $.post(
                    "{{ route('admin.users.restore','__id__') }}"
                        .replace('__id__',id),
                    { _token: "{{ csrf_token() }}" },
                    function(res){
                        Swal.fire('Restored', res.message, 'success');
                        table.ajax.reload(null,false);
                    }
                );
            }
        });
    });

    // STATUS TOGGLE (ACTIVE / INACTIVE)
    $(document).on('click','.status-btn',function () {

        let id = $(this).data('id');

        Swal.fire({
            title: 'Change user status?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then(res=>{
            if(res.isConfirmed){
                $.post(
                    "{{ route('admin.users.status','__id__') }}"
                        .replace('__id__',id),
                    { _token: "{{ csrf_token() }}" },
                    function(res){
                        Swal.fire('Done', res.message, 'success');
                        table.ajax.reload(null,false);
                    }
                );
            }
        });
    });

});
</script>
@endpush
