@extends('admin.layout')

@section('content')
@can('cities.edit')

<h3 class="mb-3">Edit City</h3>

<form id="cityEditForm"
      method="POST"
      action="{{ route('admin.cities.update', $city) }}">
    @csrf
    @method('PUT')

    <!-- State -->
    <div class="mb-2">
        <select name="state_id"
                class="form-control @error('state_id') is-invalid @enderror">
            @foreach($states as $state)
                <option value="{{ $state->id }}"
                    {{ old('state_id', $city->state_id) == $state->id ? 'selected' : '' }}>
                    {{ $state->name }} ({{ $state->country->name }})
                </option>
            @endforeach
        </select>

        <!-- Client error -->
        <small class="text-danger error-state"></small>

        <!-- Server error -->
        @error('state_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- City name -->
    <div class="mb-2">
        <input type="text"
               name="name"
               value="{{ old('name', $city->name) }}"
               class="form-control @error('name') is-invalid @enderror"
               placeholder="City name">

        <!-- Client error -->
        <small class="text-danger error-name"></small>

        <!-- Server error -->
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
document.getElementById('cityEditForm').addEventListener('submit', function (e) {

    e.preventDefault();

    let state = this.state_id;
    let name  = this.name;

    state.classList.remove('is-invalid');
    name.classList.remove('is-invalid');
    document.querySelector('.error-state').innerText = '';
    document.querySelector('.error-name').innerText = '';

    let hasError = false;

    if (state.value === '') {
        state.classList.add('is-invalid');
        document.querySelector('.error-state').innerText = 'State is required';
        hasError = true;
    }

    if (name.value.trim() === '') {
        name.classList.add('is-invalid');
        document.querySelector('.error-name').innerText = 'City name is required';
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
