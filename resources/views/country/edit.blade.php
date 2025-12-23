@extends('admin.layout')

@section('content')
@can('countries.edit')

<h3 class="mb-3">Edit Country</h3>

<form id="countryEditForm"
      method="POST"
      action="{{ route('admin.countries.update', $country) }}">
    @csrf
    @method('PUT')

    <div class="mb-2">
        <input type="text"
               name="name"
               value="{{ old('name', $country->name) }}"
               class="form-control @error('name') is-invalid @enderror"
               placeholder="Country name">

        <!-- Client-side error -->
        <small class="text-danger error-name"></small>

        <!-- Server-side error -->
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button class="btn btn-success">Update</button>
</form>

@endcan
@endsection

@push('scripts')
<script>
document.getElementById('countryEditForm').addEventListener('submit', function (e) {

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
