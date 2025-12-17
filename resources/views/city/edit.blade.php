@extends('admin.layout')

@section('content')
<h3>Edit City</h3>

<form method="POST" action="{{ route('admin.cities.update', $city) }}">
    @csrf
    @method('PUT')

    <select name="state_id" class="form-control mb-2">
        @foreach($states as $s)
            <option value="{{ $s->id }}"
                @selected($city->state_id == $s->id)>
                {{ $s->name }}
            </option>
        @endforeach
    </select>

    <input type="text"
           name="name"
           value="{{ $city->name }}"
           class="form-control mb-2">

    <button class="btn btn-success">Update</button>
</form>
@endsection
