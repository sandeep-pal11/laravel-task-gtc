<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;

class SocialAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GOOGLE LOGIN
    |--------------------------------------------------------------------------
    */

    public function redirectToGoogle()
    {
        /** @var AbstractProvider $provider */
        $provider = Socialite::driver('google');

        return $provider->with([
            'prompt' => 'select_account', // ✅ HAR BAAR ACCOUNT PUCHHEGA
        ])->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $email = $googleUser->getEmail();

        if (!$email) {
            return redirect()->route('login')
                ->with('error', 'Google account email not found.');
        }

        $user = User::where('email', $email)->first();

        if ($user) {

            // 🔥 IMPORTANT FIX: provider FORCEFULLY SAVE
            if ($user->provider === null) {
                $user->update([
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                ]);
            }

            Auth::login($user);
            return redirect('/dashboard');
        }

        // NEW USER
        $user = User::create([
            'name' => $googleUser->getName()
                ?? $googleUser->getNickname()
                ?? 'Google User',
            'email' => $email,
            'password' => bcrypt(Str::random(12)),
            'provider' => 'google',
            'provider_id' => $googleUser->getId(),
            'is_otp_verified' => true,
        ]);

        $user->assignRole('user');
        Auth::login($user);

        return redirect('/dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | GITHUB LOGIN
    |--------------------------------------------------------------------------
    */

    public function redirectToGithub()
    {
        /** @var AbstractProvider $provider */
        $provider = Socialite::driver('github');

        return $provider->with([
            'login' => '', // ✅ HAR BAAR LOGIN SCREEN
        ])->redirect();
    }

    public function handleGithubCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $email = $githubUser->getEmail()
            ?? ($githubUser->getNickname() . '@github.local');

        $user = User::where('email', $email)->first();

        if ($user) {

            // 🔥 IMPORTANT FIX: provider FORCEFULLY SAVE
            if ($user->provider === null) {
                $user->update([
                    'provider' => 'github',
                    'provider_id' => $githubUser->getId(),
                ]);
            }

            Auth::login($user);
            return redirect('/dashboard');
        }

        // NEW USER
        $user = User::create([
            'name' => $githubUser->getName()
                ?? $githubUser->getNickname()
                ?? 'GitHub User',
            'email' => $email,
            'password' => bcrypt(Str::random(12)),
            'provider' => 'github',
            'provider_id' => $githubUser->getId(),
            'is_otp_verified' => true,
        ]);

        $user->assignRole('user');
        Auth::login($user);

        return redirect('/dashboard');
    }
}
