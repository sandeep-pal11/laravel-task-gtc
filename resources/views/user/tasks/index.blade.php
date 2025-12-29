@extends('user.layouts.app')

@section('title','My Tasks')

@section('content')

<h3 class="mb-3">My Tasks</h3>

<table class="table table-bordered table-striped" id="tasks-table">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Details</th>
            <th>Start Date</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Update</th>
        </tr>
    </thead>
</table>

@endsection

@push('scripts')
<script>
$(function () {

    $('#tasks-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('user.tasks.index') }}",

        columns: [
            { data: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'title' },
            { data: 'task_details' },
            { data: 'start_date' },     // ✅ ALAG
            { data: 'due_date' },       // ✅ ALAG
            { data: 'status', orderable:false, searchable:false },
            { data: 'action', orderable:false, searchable:false }
        ]
    });

});
</script>
@endpush
