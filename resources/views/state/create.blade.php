@extends('admin.layout')

@section('content')
@can('states.create')
<h3>Add State</h3>

<form id="stateForm" method="POST" action="{{ route('admin.states.store') }}">
    @csrf

    <div class="mb-2">
        <select name="country_id" class="form-control">
            <option value="">Select Country</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
        <small class="text-danger error-country"></small>
    </div>

    <div class="mb-2">
        <input type="text"
               name="name"
               class="form-control"
               placeholder="State name">
        <small class="text-danger error-name"></small>
    </div>

    <button class="btn btn-success">Save</button>
</form>
@endcan
@endsection

@push('scripts')
<script>
document.getElementById('stateForm').addEventListener('submit', function (e) {

    e.preventDefault();

    let country = this.country_id;
    let name    = this.name;

    // reset
    country.classList.remove('is-invalid');
    name.classList.remove('is-invalid');
    document.querySelector('.error-country').innerText = '';
    document.querySelector('.error-name').innerText = '';

    let hasError = false;

    if (country.value === '') {
        country.classList.add('is-invalid');
        document.querySelector('.error-country').innerText = 'Country is required';
        hasError = true;
    }

    if (name.value.trim() === '') {
        name.classList.add('is-invalid');
        document.querySelector('.error-name').innerText = 'State name is required';
        hasError = true;
    } else if (name.value.trim().length < 2) {
        name.classList.add('is-invalid');
        document.querySelector('.error-name').innerText = 'Minimum 2 characters required';
        hasError = true;
    }

    if (hasError) {
        Swal.fire('Error','Please fix the errors','error');
        return;
    }

    this.submit();
});
</script>
@endpush
