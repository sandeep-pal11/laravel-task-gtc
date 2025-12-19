@extends('admin.layout')

@section('content')
<h3>Countries</h3>

@can('countries.create')
<a href="{{ route('admin.countries.create') }}" class="btn btn-primary mb-3">
    + Add Country
</a>
@endcan

<table class="table table-bordered" id="country-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th width="200">Action</th>
        </tr>
    </thead>
</table>

<link rel="stylesheet"
 href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {

    let table = $('#country-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.countries.index') }}",
        columns: [
            { data: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'name' },
            { data: 'action', orderable:false, searchable:false }
        ]
    });

    $(document).on('click','.delete-btn',function(){
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: "This country will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection
