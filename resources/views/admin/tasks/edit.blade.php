@extends('layouts.admin')

@section('title','Edit Task')

@section('content')
<h3>Edit Task</h3>

<form method="POST" action="{{ route('admin.tasks.update',$task) }}">
@csrf
@method('PUT')

<div class="mb-3">
    <label>User</label>
    <select name="user_id" class="form-control" required>
        @foreach($users as $user)
            <option value="{{ $user->id }}"
                {{ $task->user_id == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Title</label>
    <input type="text"
           name="title"
           class="form-control"
           value="{{ $task->title }}"
           required>
</div>

<div class="mb-3">
    <label>Task Details</label>
    <textarea name="task_details"
              class="form-control"
              rows="4"
              required>{{ $task->task_details }}</textarea>
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control" required>
        <option value="pending" {{ $task->status=='pending' ? 'selected' : '' }}>
            Pending
        </option>
        <option value="completed" {{ $task->status=='completed' ? 'selected' : '' }}>
            Completed
        </option>
    </select>
</div>

<div class="row">
    <div class="col-md-6">
        <label>Start Date</label>
        <input type="date"
               name="start_date"
               class="form-control"
               value="{{ $task->start_date }}"
               required>
    </div>

    <div class="col-md-6">
        <label>Due Date</label>
        <input type="date"
               name="due_date"
               class="form-control"
               value="{{ $task->due_date }}"
               required>
    </div>
</div>

<button class="btn btn-primary mt-4">Update Task</button>
<a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary mt-4">
    Cancel
</a>
</form>
@endsection
