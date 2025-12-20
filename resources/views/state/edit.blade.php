@extends('admin.layout')

@section('content')
@can('states.edit')
<h3>Edit State</h3>

<form id="stateEditForm"
      method="POST"
      action="{{ route('admin.states.update', $state) }}">
    @csrf
    @method('PUT')

    <div class="mb-2">
        <select name="country_id" class="form-control">
            @foreach($countries as $c)
                <option value="{{ $c->id }}"
                    @selected($state->country_id == $c->id)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
        <small class="text-danger error-country"></small>
    </div>

    <div class="mb-2">
        <input type="text"
               name="name"
               value="{{ $state->name }}"
               class="form-control">
        <small class="text-danger error-name"></small>
    </div>

    <button class="btn btn-success">Update</button>
</form>
@endcan
@endsection

@push('scripts')
<script>
document.getElementById('stateEditForm').addEventListener('submit', function (e) {

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
