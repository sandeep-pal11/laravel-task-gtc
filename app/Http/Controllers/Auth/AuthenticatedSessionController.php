<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\EmailOtp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display login view
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1️⃣ Authenticate user (email + password)
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // 2️⃣ OTP ONLY FIRST LOGIN
        if (!$user->is_otp_verified) {

            $otp = rand(100000, 999999);

            EmailOtp::create([
                'user_id'    => $user->id,
                'otp'        => $otp,
                'expires_at' => now()->addMinutes(5),
            ]);

            Mail::raw("Your login OTP is: $otp", function ($mail) use ($user) {
                $mail->to($user->email)
                     ->subject('Login OTP Verification');
            });

            Auth::logout();
            session(['otp_user_id' => $user->id]);

            return redirect()->route('otp.page');
        }

        // 3️⃣ ROLE BASED REDIRECT
        // ✅ Normal users have 'web' guard role
        if ($user->hasRole('user')) {
            return redirect()->route('dashboard');
        }

        // ❌ Agar user ko role nahi hai
        Auth::logout();
        return redirect('/login')->withErrors([
            'email' => 'Role not assigned. Contact admin.',
        ]);
    }

    /**
     * Destroy an authenticated session
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
