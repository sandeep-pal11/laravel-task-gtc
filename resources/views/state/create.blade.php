@extends('admin.layout')

@section('content')
@can('states.create')

<h3 class="mb-3">Add State</h3>

<form id="stateForm"
      method="POST"
      action="{{ route('admin.states.store') }}">
    @csrf

    <!-- Country -->
    <div class="mb-2">
        <select name="country_id"
                class="form-control @error('country_id') is-invalid @enderror">
            <option value="">Select Country</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}"
                    {{ old('country_id') == $country->id ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>

        <!-- Client error -->
        <small class="text-danger error-country"></small>

        <!-- Server error -->
        @error('country_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- State name -->
    <div class="mb-2">
        <input type="text"
               name="name"
               value="{{ old('name') }}"
               class="form-control @error('name') is-invalid @enderror"
               placeholder="State name">

        <!-- Client error -->
        <small class="text-danger error-name"></small>

        <!-- Server error -->
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
document.getElementById('stateForm').addEventListener('submit', function (e) {

    e.preventDefault();

    let country = this.country_id;
    let name    = this.name;

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
