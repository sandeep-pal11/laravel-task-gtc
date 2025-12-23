<section class="min-h-[70vh] flex items-center justify-center bg-gray-100">

    <div class="bg-white w-full max-w-2xl rounded-xl shadow border border-gray-200">

        <!-- Header -->
        <div class="px-6 py-4 border-b text-center">
            <h2 class="text-lg font-semibold text-gray-800">
                Profile Settings
            </h2>
            <p class="text-sm text-gray-500">
                Update your profile photo and name
            </p>
        </div>

        <form method="POST"
              action="{{ route('profile.update') }}"
              enctype="multipart/form-data"
              class="p-6 flex flex-col items-center gap-6">

            @csrf
            @method('patch')

            <!-- PROFILE IMAGE -->
            <div class="flex flex-col items-center gap-3">

                <div class="avatar">
                    <img
                        src="{{ auth()->user()->profile_photo_url }}"
                        alt="Profile">
                </div>

                <label class="text-sm text-indigo-600 cursor-pointer hover:underline">
                    Change Photo
                    <input
                        type="file"
                        name="profile_photo"
                        accept="image/*"
                        class="hidden">
                </label>

                @error('profile_photo')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- NAME -->
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Name
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- EMAIL -->
            <div class="w-full">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input
                    type="email"
                    value="{{ $user->email }}"
                    disabled
                    class="w-full rounded-md bg-gray-100 border-gray-300 text-gray-500 cursor-not-allowed">
            </div>

            <!-- SAVE BUTTON  -->
            <button
                type="submit"
                class="w-full bg-white text-indigo-600 border border-indigo-600
                       py-2.5 rounded-md text-sm font-semibold
                       hover:bg-indigo-50 transition">
                Save Changes
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-600 text-center">
                    Profile updated successfully
                </p>
            @endif

        </form>
    </div>
</section>

<!-- AVATAR STYLE -->
<style>
    .avatar {
        width: 90px;      
        height: 90px;
        border-radius: 9999px;
        overflow: hidden;
        border: 2px solid #e5e7eb;
        background: #f9fafb;
    }
    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
