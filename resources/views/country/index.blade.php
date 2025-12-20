@extends('admin.layout')

@section('content')
<h3>Countries</h3>

@can('countries.create')
<a href="{{ route('admin.countries.create') }}"
   class="btn btn-primary mb-2">
    Add Country
</a>
@endcan

<table class="table table-bordered" id="countries-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Country</th>

            {{-- Action header sirf admin ke liye --}}
            @canany(['countries.edit','countries.delete'])
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
    ];

    @canany(['countries.edit','countries.delete'])
        columns.push({
            data: 'action',
            orderable:false,
            searchable:false
        });
    @endcanany

    $('#countries-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.countries.index') }}",
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
