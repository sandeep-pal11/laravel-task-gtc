<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

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
        $googleUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name ?? $googleUser->nickname ?? 'Google User',
                'password' => bcrypt(Str::random(12)),
                'role_id' => 4,               // USER
                'is_otp_verified' => true,    // SOCIAL LOGIN = TRUSTED
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
        $githubUser = Socialite::driver('github')->user();

        // 🔥 GitHub email can be NULL
        $email = $githubUser->email ?? $githubUser->nickname . '@github.local';

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $githubUser->name ?? $githubUser->nickname ?? 'Github User',
                'password' => bcrypt(Str::random(12)),
                'role_id' => 4,
                'is_otp_verified' => true,
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }
}
