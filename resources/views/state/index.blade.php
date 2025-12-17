@extends('admin.layout')

@section('content')
<h3>States</h3>

<a href="{{ route('admin.states.create') }}" class="btn btn-primary mb-2">
    Add State
</a>

<table class="table table-bordered">
<tr>
    <th>ID</th>
    <th>State</th>
    <th>Country</th>
    <th>Action</th>
</tr>

@foreach($states as $s)
<tr>
    <td>{{ $s->id }}</td>
    <td>{{ $s->name }}</td>
    <td>{{ $s->country->name }}</td>
    <td>
        <a href="{{ route('admin.states.edit', $s) }}"
           class="btn btn-warning btn-sm">
           Edit
        </a>

        <form action="{{ route('admin.states.destroy', $s) }}"
              method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</table>
@endsection
