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

        return $provider
            ->with([
                'prompt' => 'select_account', // force account selection
            ])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            Auth::login($user);
            return redirect('/dashboard');
        }

        $user = User::create([
            'name' => $googleUser->getName()
                ?? $googleUser->getNickname()
                ?? 'Google User',
            'email' => $googleUser->getEmail(),
            'password' => bcrypt(Str::random(12)),
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

        return $provider
            ->with([
                'login' => '', // force GitHub login/account screen
            ])
            ->redirect();
    }

    public function handleGithubCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $email = $githubUser->getEmail()
            ?? ($githubUser->getNickname() . '@github.local');

        $user = User::where('email', $email)->first();

        if ($user) {
            Auth::login($user);
            return redirect('/dashboard');
        }

        $user = User::create([
            'name' => $githubUser->getName()
                ?? $githubUser->getNickname()
                ?? 'GitHub User',
            'email' => $email,
            'password' => bcrypt(Str::random(12)),
            'is_otp_verified' => true,
        ]);

        $user->assignRole('user');

        Auth::login($user);

        return redirect('/dashboard');
    }
}
