@extends('admin.layout')

@section('content')
@can('countries.create')
<h3>Add Country</h3>

<form id="countryForm"
      method="POST"
      action="{{ route('admin.countries.store') }}">
    @csrf

    <div class="mb-2">
        <input type="text"
               name="name"
               class="form-control"
               placeholder="Country name">
        <small class="text-danger error-name"></small>
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
