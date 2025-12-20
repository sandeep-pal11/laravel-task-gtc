@extends('admin.layout')

@section('content')
@can('cities.create')
<h3>Add City</h3>

<form id="cityForm" method="POST"
      action="{{ route('admin.cities.store') }}">
    @csrf

    <div class="mb-2">
        <select name="state_id" class="form-control">
            <option value="">Select State</option>
            @foreach($states as $state)
                <option value="{{ $state->id }}">
                    {{ $state->name }} ({{ $state->country->name }})
                </option>
            @endforeach
        </select>
        <small class="text-danger error-state"></small>
    </div>

    <div class="mb-2">
        <input type="text"
               name="name"
               class="form-control"
               placeholder="City name">
        <small class="text-danger error-name"></small>
    </div>

    <button class="btn btn-success">Save</button>
</form>
@endcan
@endsection

@push('scripts')
<script>
document.getElementById('cityForm').addEventListener('submit', function (e) {

    e.preventDefault();

    let state = this.state_id;
    let name  = this.name;

    // reset
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
