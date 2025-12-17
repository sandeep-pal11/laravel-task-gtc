@extends('admin.layout')

@section('content')
<h3>Add State</h3>

<form method="POST" action="{{ route('admin.states.store') }}">
    @csrf

    <select name="country_id" class="form-control mb-2">
        @foreach($countries as $country)
            <option value="{{ $country->id }}">{{ $country->name }}</option>
        @endforeach
    </select>

    <input type="text" name="name" class="form-control mb-2" placeholder="State name">

    <button class="btn btn-success">Save</button>
</form>
@endsection
