@extends('admin.layout')

@section('content')
<h3>Deleted Countries</h3>

<a href="{{ route('admin.countries.index') }}"
   class="btn btn-dark mb-2">Back</a>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Deleted At</th>
        <th>Action</th>
    </tr>

    @foreach($countries as $c)
    <tr>
        <td>{{ $c->id }}</td>
        <td>{{ $c->name }}</td>
        <td>{{ $c->deleted_at }}</td>
        <td>
            <form method="POST"
                  action="{{ route('admin.countries.restore',$c->id) }}">
                @csrf
                <button class="btn btn-success btn-sm">
                    Restore
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
