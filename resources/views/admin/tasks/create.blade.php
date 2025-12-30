@extends('layouts.admin')

@section('title','Create Task')

@section('content')
<h3>Assign Task</h3>

<form id="taskForm" method="POST" action="{{ route('admin.tasks.store') }}">
@csrf

{{-- USER SELECT --}}
<div class="mb-3">
    <label>User</label>
    <select name="user_id" class="form-control user-select">
        <option value="" disabled selected>
            -- Select User --
        </option>
        @foreach($users as $user)
            <option value="{{ $user->id }}">
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    <small class="text-danger error-user_id"></small>
</div>

{{-- TITLE --}}
<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control">
    <small class="text-danger error-title"></small>
</div>

{{-- DETAILS --}}
<div class="mb-3">
    <label>Task Details</label>
    <textarea name="task_details" class="form-control" rows="4"></textarea>
    <small class="text-danger error-task_details"></small>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Start Date</label>
        <input type="date" name="start_date" class="form-control">
        <small class="text-danger error-start_date"></small>
    </div>

    <div class="col-md-6 mb-3">
        <label>Due Date</label>
        <input type="date" name="due_date" class="form-control">
        <small class="text-danger error-due_date"></small>
    </div>
</div>

<button type="submit" class="btn btn-success mt-3">
    Save Task
</button>

</form>
@endsection

@push('scripts')

{{-- 🔥 CSS (ONLY FOR SELECT LOOK) --}}
<style>
.user-select {
    color: #6c757d; /* muted placeholder */
}

.user-select option:not([disabled]) {
    color: #212529;
}

.user-select:focus {
    color: #212529;
}
</style>

<script>
$(function () {

    // 🔥 Select change → normal text
    $('select[name="user_id"]').on('change', function () {
        $(this).css('color', '#212529');
    });

    $('#taskForm').on('submit', function (e) {
        e.preventDefault();

        // clear old errors
        $('.text-danger').text('');
        $('.form-control').removeClass('is-invalid');

        let valid = true;

        let user_id     = $('select[name="user_id"]');
        let title       = $('input[name="title"]');
        let details     = $('textarea[name="task_details"]');
        let start_date  = $('input[name="start_date"]');
        let due_date    = $('input[name="due_date"]');

        // USER
        if (user_id.val() === null) {
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
