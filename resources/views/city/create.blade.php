@extends('admin.layout')

@section('content')
<h3>Add City</h3>

@can('cities.create')
<form method="POST" action="{{ route('admin.cities.store') }}">
    @csrf

    <select name="state_id" class="form-control mb-2">
        @foreach($states as $state)
            <option value="{{ $state->id }}">
                {{ $state->name }} ({{ $state->country->name }})
            </option>
        @endforeach
    </select>

    <input type="text" name="name" class="form-control mb-2"
           placeholder="City name">

    <button class="btn btn-success">Save</button>
</form>
@else
<div class="alert alert-danger">No permission</div>
@endcan
@endsection
