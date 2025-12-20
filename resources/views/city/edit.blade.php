@extends('admin.layout')

@section('content')
@can('cities.edit')
<h3>Edit City</h3>

<form id="cityEditForm"
      method="POST"
      action="{{ route('admin.cities.update', $city) }}">
    @csrf
    @method('PUT')

    <div class="mb-2">
        <select name="state_id" class="form-control">
            @foreach($states as $s)
                <option value="{{ $s->id }}"
                    @selected($city->state_id == $s->id)>
                    {{ $s->name }}
                </option>
            @endforeach
        </select>
        <small class="text-danger error-state"></small>
    </div>

    <div class="mb-2">
        <input type="text"
               name="name"
               value="{{ $city->name }}"
               class="form-control">
        <small class="text-danger error-name"></small>
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
