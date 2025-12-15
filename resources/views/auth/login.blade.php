<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full"
                type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Remember -->
        <div class="block mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember">
                <span class="ms-2 text-sm">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Login
            </x-primary-button>
        </div>
    </form>

    <!-- 🔥 SOCIAL LOGIN BUTTONS (YAHAN) -->
    <hr class="my-4">

    <a href="{{ url('/auth/google') }}"
       class="block w-full text-center bg-red-600 text-white py-2 rounded mb-2">
        Login with Google
    </a>

    <a href="{{ url('/auth/github') }}"
       class="block w-full text-center bg-gray-800 text-white py-2 rounded">
        Login with GitHub
    </a>

</x-guest-layout>
