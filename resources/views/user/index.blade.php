@extends('admin.layout')

@section('content')
<h3>Users</h3>

@php $today = date('Y-m-d'); @endphp

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
        <input type="date" id="fromDate" class="form-control" max="{{ $today }}">
    </div>

    <div class="col-md-3">
        <input type="date" id="toDate" class="form-control" max="{{ $today }}">
    </div>

    <div class="col-md-3">
        <button id="resetFilters" class="btn btn-secondary w-100">
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

    let table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.users.index') }}",
            data: d => {
                d.role = $('#roleFilter').val();
                d.from_date = $('#fromDate').val();
                d.to_date = $('#toDate').val();
            }
        },
        columns: [
            { data:'DT_RowIndex', orderable:false },
            { data:'name' },
            { data:'email' },
            { data:'roles', orderable:false },
            @canany(['users.edit','users.delete'])
            { data:'action', orderable:false, searchable:false }
            @endcanany
        ]
    });

    $('#roleFilter, #fromDate, #toDate').change(() => table.ajax.reload());

    $('#resetFilters').click(() => {
        $('#roleFilter,#fromDate,#toDate').val('');
        table.ajax.reload();
    });

    /* 🔴 delete */
    $(document).on('click','.delete-btn',function () {
        let form = $(this).closest('form');
        Swal.fire({title:'Delete?',icon:'warning',showCancelButton:true})
        .then(r=>{
            if(r.isConfirmed){
                $.post(form.attr('action'), form.serialize(), ()=>table.ajax.reload());
            }
        });
    });

    /* ♻ restore */
    $(document).on('click','.restore-btn',function () {
        let id = $(this).data('id');
        Swal.fire({title:'Restore?',icon:'question',showCancelButton:true})
        .then(r=>{
            if(r.isConfirmed){
                $.post("{{ url('admin/users') }}/"+id+"/restore",
                    {_token:"{{ csrf_token() }}"},
                    ()=>table.ajax.reload()
                );
            }
        });
    });

});
</script>
@endpush
