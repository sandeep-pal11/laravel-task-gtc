@extends('admin.layout')

@section('content')
<h3>Cities</h3>

<a href="{{ route('admin.cities.create') }}" class="btn btn-primary mb-3">
    + Add City
</a>

<table class="table table-bordered" id="citiesTable">
<thead>
<tr>
    <th>#</th>
    <th>City</th>
    <th>State</th>
    <th>Country</th>
    <th>Action</th>
</tr>
</thead>
</table>

<script>
$(function () {
    $('#citiesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.cities.index') }}",
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'name' },
            { data: 'state' },
            { data: 'country' },
            { data: 'action', orderable:false, searchable:false },
        ]
    });
});
</script>
@endsection
