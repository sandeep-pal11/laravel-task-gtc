@extends('admin.layout')

@section('content')
<h3>Countries</h3>

<a href="{{ route('admin.countries.create') }}" class="btn btn-primary mb-2">
    Add Country
</a>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Action</th>
    </tr>

    @foreach($countries as $country)
    <tr>
        <td>{{ $country->id }}</td>
        <td>{{ $country->name }}</td>
        <td>
            <a href="{{ route('admin.countries.edit', $country) }}" class="btn btn-sm btn-warning">
                Edit
            </a>

            <form method="POST" action="{{ route('admin.countries.destroy', $country) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
