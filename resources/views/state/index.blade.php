@extends('admin.layout')

@section('content')
<h3>States</h3>

@can('states.create')
<a href="{{ route('admin.states.create') }}"
   class="btn btn-primary mb-2">
    Add State
</a>
@endcan

<table class="table table-bordered" id="states-table">
    <thead>
        <tr>
            <th>#</th>
            <th>State</th>
            <th>Country</th>

            {{-- Action header sirf admin ke liye --}}
            @canany(['states.edit','states.delete'])
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
        { data: 'country', name: 'country.name' },
    ];

    // Action column sirf admin/super-admin
    @canany(['states.edit','states.delete'])
        columns.push({
            data: 'action',
            orderable:false,
            searchable:false
        });
    @endcanany

    $('#states-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.states.index') }}",
        columns: columns
    });

    // SweetAlert delete
    $(document).on('click','.delete-btn',function () {
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This record will be deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

});
</script>
@endpush
