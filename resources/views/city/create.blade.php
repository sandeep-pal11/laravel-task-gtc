@extends('layouts.admin')

@section('title','Add City')

@section('content')
@can('cities.create')

<h3 class="mb-3">Add City</h3>

<form method="POST" action="{{ route('admin.cities.store') }}">
@csrf

{{-- Country --}}
<div class="mb-2">
    <select id="country" name="country_id" class="form-control">
        <option value="">Select Country</option>
        @foreach($countries as $country)
            <option value="{{ $country->id }}">{{ $country->name }}</option>
        @endforeach
    </select>
</div>

{{-- State --}}
<div class="mb-2">
    <select id="state" name="state_id" class="form-control">
        <option value="">Select State</option>
    </select>
</div>

{{-- City --}}
<div class="mb-2">
    <input type="text" name="name" class="form-control" placeholder="City name">
</div>

<button class="btn btn-success">Save</button>
</form>

@endcan
@endsection

@push('scripts')
<script>
$('#country').change(function () {

    let countryId = $(this).val();
    $('#state').html('<option value="">Loading...</option>');

    if (!countryId) {
        $('#state').html('<option value="">Select State</option>');
        return;
    }

    $.get("{{ route('admin.get.states','__id__') }}"
        .replace('__id__', countryId),
        function (states) {

            let options = '<option value="">Select State</option>';

            states.forEach(state => {
                options += `<option value="${state.id}">${state.name}</option>`;
            });

            $('#state').html(options);
        }
    );
});
</script>
@endpush
