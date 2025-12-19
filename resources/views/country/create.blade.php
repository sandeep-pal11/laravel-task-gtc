@extends('admin.layout')

@section('content')
<h3>Add Country</h3>

<form method="POST" action="{{ route('admin.countries.store') }}">
    @csrf

    <div class="mb-3">
        <label>Country Name</label>
        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button class="btn btn-success">Save</button>
    <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
