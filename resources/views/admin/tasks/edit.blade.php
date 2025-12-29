@extends('layouts.admin')

@section('title','Edit Task')

@section('content')
<h3>Edit Task</h3>

<form id="editTaskForm" method="POST" action="{{ route('admin.tasks.update',$task) }}">
@csrf
@method('PUT')

<div class="mb-3">
    <label>User</label>
    <select name="user_id" class="form-control">
        <option value="">Select User</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}"
                {{ $task->user_id == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    <small class="text-danger error-user_id"></small>
</div>

<div class="mb-3">
    <label>Title</label>
    <input type="text"
           name="title"
           class="form-control"
           value="{{ $task->title }}">
    <small class="text-danger error-title"></small>
</div>

<div class="mb-3">
    <label>Task Details</label>
    <textarea name="task_details"
              class="form-control"
              rows="4">{{ $task->task_details }}</textarea>
    <small class="text-danger error-task_details"></small>
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="">Select Status</option>
        <option value="pending" {{ $task->status=='pending' ? 'selected' : '' }}>
            Pending
        </option>
        <option value="completed" {{ $task->status=='completed' ? 'selected' : '' }}>
            Completed
        </option>
    </select>
    <small class="text-danger error-status"></small>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Start Date</label>
        <input type="date"
               name="start_date"
               class="form-control"
               value="{{ $task->start_date }}">
        <small class="text-danger error-start_date"></small>
    </div>

    <div class="col-md-6 mb-3">
        <label>Due Date</label>
        <input type="date"
               name="due_date"
               class="form-control"
               value="{{ $task->due_date }}">
        <small class="text-danger error-due_date"></small>
    </div>
</div>

<button type="submit" class="btn btn-primary mt-3">
    Update Task
</button>
<a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary mt-3">
    Cancel
</a>
</form>
@endsection
@push('scripts')
<script>
$(function () {

    $('#editTaskForm').on('submit', function (e) {
        e.preventDefault();

        // clear old errors
        $('.text-danger').text('');
        $('.form-control').removeClass('is-invalid');

        let valid = true;

        let user_id    = $('select[name="user_id"]');
        let title      = $('input[name="title"]');
        let details    = $('textarea[name="task_details"]');
        let status     = $('select[name="status"]');
        let start_date = $('input[name="start_date"]');
        let due_date   = $('input[name="due_date"]');

        // USER
        if (user_id.val() === '') {
            valid = false;
            user_id.addClass('is-invalid');
            $('.error-user_id').text('Please select a user.');
        }

        // TITLE
        if ($.trim(title.val()) === '') {
            valid = false;
            title.addClass('is-invalid');
            $('.error-title').text('Task title is required.');
        }

        // DETAILS
        if ($.trim(details.val()) === '') {
            valid = false;
            details.addClass('is-invalid');
            $('.error-task_details').text('Task description is required.');
        }

        // STATUS
        if (status.val() === '') {
            valid = false;
            status.addClass('is-invalid');
            $('.error-status').text('Please select task status.');
        }

        // START DATE
        if (start_date.val() === '') {
            valid = false;
            start_date.addClass('is-invalid');
            $('.error-start_date').text('Start date is required.');
        }

        // DUE DATE
        if (due_date.val() === '') {
            valid = false;
            due_date.addClass('is-invalid');
            $('.error-due_date').text('Due date is required.');
        }

        // DATE LOGIC
        if (start_date.val() && due_date.val()) {
            if (due_date.val() < start_date.val()) {
                valid = false;
                due_date.addClass('is-invalid');
                $('.error-due_date')
                    .text('Due date must be equal to or after start date.');
            }
        }

        if (valid) {
            this.submit(); 
        }
    });

});
</script>
@endpush
