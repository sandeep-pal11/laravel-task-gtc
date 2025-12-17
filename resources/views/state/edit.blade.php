@extends('admin.layout')

@section('content')
<h3>Edit State</h3>

<form method="POST"
      action="{{ route('admin.states.update',$state) }}">
    @csrf
    @method('PUT')

    <select name="country_id" class="form-control mb-2">
        @foreach($countries as $c)
            <option value="{{ $c->id }}"
                @selected($state->country_id == $c->id)>
                {{ $c->name }}
            </option>
        @endforeach
    </select>

    <input type="text" name="name"
           value="{{ $state->name }}"
           class="form-control mb-2">

    <button class="btn btn-success">Update</button>
</form>
@endsection
