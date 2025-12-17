@extends('admin.layout')

@section('content')
<h3>Add Country</h3>

<form method="POST" action="{{ route('admin.countries.store') }}">
    @csrf

    <input type="text" name="name" class="form-control mb-2" placeholder="Country name">

    <button class="btn btn-success">Save</button>
</form>
@endsection
