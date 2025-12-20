@extends('admin.layout')

@section('content')
@can('countries.edit')
<h3>Edit Country</h3>

<form id="countryEditForm"
      method="POST"
      action="{{ route('admin.countries.update', $country) }}">
    @csrf
    @method('PUT')

    <div class="mb-2">
        <input type="text"
               name="name"
               value="{{ $country->name }}"
               class="form-control">
        <small class="text-danger error-name"></small>
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

    name.classList.remove('is-invalid');
    document.querySelector('.error-name').innerText = '';

    if (name.value.trim() === '') {
        name.classList.add('is-invalid');
        document.querySelector('.error-name').innerText = 'Country name is required';
        Swal.fire('Error','Please fix the errors','error');
        return;
    }

    if (name.value.trim().length < 2) {
        name.classList.add('is-invalid');
        document.querySelector('.error-name').innerText = 'Minimum 2 characters required';
        Swal.fire('Error','Please fix the errors','error');
        return;
    }

    this.submit();
});
</script>
@endpush
