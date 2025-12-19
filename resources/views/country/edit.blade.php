@extends('admin.layout')

@section('content')
<h3>Edit Country</h3>

<form method="POST" action="{{ route('admin.countries.update',$country) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Country Name</label>
        <input type="text"
               name="name"
               value="{{ $country->name }}"
               class="form-control @error('name') is-invalid @enderror">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button class="btn btn-success">Update</button>
    <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
