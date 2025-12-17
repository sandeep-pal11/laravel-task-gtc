<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialUser; // ✅ ADD THIS

class SocialAuthController extends Controller
{
    // ======================
    // GOOGLE LOGIN
    // ======================
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        /** @var SocialUser $googleUser */
        $googleUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            ['email' => (string) $googleUser->getEmail()], // ✅ METHOD, NOT PROPERTY
            [
                'name' => $googleUser->getName()
                    ?? $googleUser->getNickname()
                    ?? 'Google User',
                'password' => bcrypt(Str::random(12)),
                'role_id' => 4,
                'is_otp_verified' => true,
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }

    // ======================
    // GITHUB LOGIN
    // ======================
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        /** @var SocialUser $githubUser */
        $githubUser = Socialite::driver('github')->user();

        $email = $githubUser->getEmail()
            ?? ($githubUser->getNickname() . '@github.local');

        $user = User::firstOrCreate(
            ['email' => (string) $email],
            [
                'name' => $githubUser->getName()
                    ?? $githubUser->getNickname()
                    ?? 'Github User',
                'password' => bcrypt(Str::random(12)),
                'role_id' => 4,
                'is_otp_verified' => true,
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }
}
