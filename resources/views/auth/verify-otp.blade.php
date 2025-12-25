@extends('layouts.guest')

@section('title','Verify OTP')

@section('content')

<div class="card shadow-lg" style="width:420px;border-radius:16px">
    <div class="card-body p-4">

        <h4 class="text-center mb-2">Verify OTP</h4>
        <p class="text-center text-muted mb-4">
            We have sent a 6-digit OTP to your email
        </p>

        {{-- SERVER ERROR --}}
        @if ($errors->any())
            <div class="alert alert-danger py-2">
                {{ $errors->first() }}
            </div>
        @endif

        <form id="otpForm" method="POST" action="{{ route('otp.verify') }}">
            @csrf

            <div class="mb-3">
                <label>Enter OTP</label>
                <input type="text"
                       name="otp"
                       id="otp"
                       maxlength="6"
                       class="form-control text-center"
                       placeholder="******"
                       autofocus>

                <small class="text-danger d-none" id="otpError"></small>
            </div>

            <button class="btn btn-primary w-100">
                Verify OTP
            </button>
        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>
$('#otpForm').submit(function(e){
    let otp = $('#otp').val().trim();
    $('#otpError').addClass('d-none');

    if(otp === '' || otp.length !== 6 || !/^\d+$/.test(otp)){
        $('#otpError')
            .text('Please enter a valid 6-digit OTP')
            .removeClass('d-none');
        e.preventDefault();
    }
});
</script>
@endpush
