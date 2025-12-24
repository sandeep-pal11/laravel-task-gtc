@extends('admin.layout')

@section('content')
@can('cities.edit')

<h3 class="mb-3">Edit City</h3>

<form method="POST" action="{{ route('admin.cities.update',$city) }}">
@csrf
@method('PUT')

{{-- COUNTRY --}}
<div class="mb-2">
    <select id="country"
            name="country_id"
            class="form-control">
        @foreach($countries as $country)
            <option value="{{ $country->id }}"
                {{ $city->state->country_id == $country->id ? 'selected' : '' }}>
                {{ $country->name }}
            </option>
        @endforeach
    </select>
</div>

{{-- STATE --}}
<div class="mb-2">
    <select id="state"
            name="state_id"
            class="form-control">
        @foreach($states as $state)
            <option value="{{ $state->id }}"
                {{ $city->state_id == $state->id ? 'selected' : '' }}>
                {{ $state->name }}
            </option>
        @endforeach
    </select>
</div>

{{-- CITY --}}
<div class="mb-2">
    <input type="text"
           name="name"
           value="{{ $city->name }}"
           class="form-control">
</div>

<button class="btn btn-success">Update</button>
</form>

@endcan
@endsection

@push('scripts')
<script>
$('#country').change(function () {

    let countryId = $(this).val();
    $('#state').html('<option>Loading...</option>');

    $.get("{{ route('admin.get.states','__id__') }}"
        .replace('__id__', countryId),
        function (states) {

            let options = '';

            states.forEach(state => {
                options += `<option value="${state.id}">${state.name}</option>`;
            });

            $('#state').html(options);
        }
    );
});
</script>
@endpush
