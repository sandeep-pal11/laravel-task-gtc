@extends('layouts.admin')

@section('title','Add Country')

@section('content')
@can('countries.create')

<h3 class="mb-3">Add Country</h3>

<form id="countryForm" method="POST" action="{{ route('admin.countries.store') }}">
    @csrf

    <div class="mb-2">
        <input type="text"
               name="name"
               value="{{ old('name') }}"
               class="form-control @error('name') is-invalid @enderror"
               placeholder="Country name">

        <small class="text-danger error-name"></small>

        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button class="btn btn-success">Save</button>
</form>

@endcan
@endsection

@push('scripts')
<script>
document.getElementById('countryForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let name = this.name;
    let errorBox = document.querySelector('.error-name');

    name.classList.remove('is-invalid');
    errorBox.innerText = '';

    if (name.value.trim() === '') {
        name.classList.add('is-invalid');
        errorBox.innerText = 'Country name is required';
        Swal.fire('Error','Please fix the errors','error');
        return;
    }

    if (name.value.trim().length < 2) {
        name.classList.add('is-invalid');
        errorBox.innerText = 'Minimum 2 characters required';
        Swal.fire('Error','Please fix the errors','error');
        return;
    }

    this.submit();
});
</script>
@endpush
