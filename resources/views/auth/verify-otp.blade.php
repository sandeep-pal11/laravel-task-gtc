<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        We have sent a 6-digit OTP to your email. Please enter it below.
    </div>

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <div>
            <x-input-label for="otp" value="Enter OTP" />
            <x-text-input id="otp" name="otp" required autofocus />
            <x-input-error :messages="$errors->get('otp')" />
        </div>

        <x-primary-button class="mt-4">
            Verify OTP
        </x-primary-button>
    </form>
</x-guest-layout>
