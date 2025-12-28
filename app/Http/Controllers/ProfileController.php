<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{

     //Show profile edit page

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


     //Update profile (ONLY name and profile photo)

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'profile_photo' => 'nullable|image',
        ]);

        $user = $request->user();

        // ROFILE PHOTO UPDATE
        if ($request->hasFile('profile_photo')) {

            // old photo delete
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')
                ->store('profile-photos', 'public');

            $user->profile_photo = $path;
        }

        // NAME UPDATE
        $user->name = $request->name;

        $user->save();

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated');
    }


     //Delete account

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // profile photo delete
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
