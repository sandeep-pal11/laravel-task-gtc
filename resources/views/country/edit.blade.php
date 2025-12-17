@extends('admin.layout')

@section('content')
<h3>Edit Country</h3>

<form method="POST" action="{{ route('admin.countries.update', $country) }}">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $country->name }}" class="form-control mb-2">

    <button class="btn btn-success">Update</button>
</form>
@endsection
