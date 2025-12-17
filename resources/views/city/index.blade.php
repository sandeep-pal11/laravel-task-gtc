@extends('admin.layout')

@section('content')
<h3>Cities</h3>

<a href="{{ route('admin.cities.create') }}" class="btn btn-primary mb-2">
    Add City
</a>

<table class="table table-bordered">
<tr>
    <th>ID</th>
    <th>City</th>
    <th>State</th>
    <th>Country</th>
    <th>Action</th>
</tr>

@foreach($cities as $c)
<tr>
    <td>{{ $c->id }}</td>
    <td>{{ $c->name }}</td>
    <td>{{ $c->state->name }}</td>
    <td>{{ $c->state->country->name }}</td>
    <td>
        <a href="{{ route('admin.cities.edit',$c) }}" class="btn btn-warning btn-sm">
            Edit
        </a>

        <form method="POST" action="{{ route('admin.cities.destroy',$c) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</table>
@endsection
