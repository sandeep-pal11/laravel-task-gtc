@extends('admin.layout')

@section('content')
<h3>States</h3>

@can('states.create')
<a href="{{ route('admin.states.create') }}" class="btn btn-primary mb-3">
    + Add State
</a>
@endcan

<table class="table table-bordered" id="statesTable">
    <thead>
        <tr>
            <th>#</th>
            <th>State</th>
            <th>Country</th>
            <th>Action</th>
        </tr>
    </thead>
</table>

{{-- JS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {

    $('#statesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.states.index') }}",
        columns: [
            { data: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'name' },
            { data: 'country' },
            { data: 'action', orderable:false, searchable:false },
        ]
    });

    $(document).on('click','.delete-btn',function(){
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: 'State will be deleted!',
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
