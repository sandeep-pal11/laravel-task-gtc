@extends('admin.layout')

@section('content')
<h3>Cities</h3>

@can('cities.create')
<a href="{{ route('admin.cities.create') }}" class="btn btn-primary mb-2">
    Add City
</a>
@endcan

<table class="table table-bordered" id="cities-table">
    <thead>
        <tr>
            <th>#</th>
            <th>City</th>
            <th>State</th>
            <th>Country</th>

            {{-- ✅ Action header sirf admin/super-admin ke liye --}}
            @canany(['cities.edit','cities.delete'])
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
        { data: 'state', name: 'state.name' },
        { data: 'country', name: 'state.country.name' },
    ];

    // ✅ Action column JS me bhi sirf admin ke liye
    @canany(['cities.edit','cities.delete'])
        columns.push({
            data: 'action',
            orderable:false,
            searchable:false
        });
    @endcanany

    $('#cities-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.cities.index') }}",
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
