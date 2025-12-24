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
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();


        //STATUS CHECK (ACTIVE / INACTIVE)

        if ($user->status === 'inactive') {

            Auth::logout();

            return redirect('/login')->withErrors([
                'email' => 'Your account is inactive. Please contact admin.',
            ]);
        }

        //OTP CHECK

        if (!$user->is_otp_verified) {

            $otp = rand(100000, 999999);

            EmailOtp::create([
                'user_id'    => $user->id,
                'otp'        => $otp,
                'expires_at' => now()->addMinutes(5),
            ]);

            Mail::raw("Your login OTP is: {$otp}", function ($mail) use ($user) {
                $mail->to($user->email)->subject('Login OTP Verification');
            });

            Auth::logout();
            session(['otp_user_id' => $user->id]);

            return redirect()->route('otp.page');
        }

        //ROLE WISE REDIRECT


        // SUPER ADMIN
        if ($user->roles->contains('name', 'super-admin')) {
            return redirect()->route('admin.dashboard');
        }

        // ADMIN
        if ($user->roles->contains('name', 'admin')) {
            return redirect()->route('admin.dashboard');
        }

        // MANAGER
        if ($user->roles->contains('name', 'manager')) {
            return redirect()->route('manager.dashboard');
        }

        // USER
        if ($user->roles->contains('name', 'user')) {
            return redirect()->route('dashboard');
        }

        // SAFETY
        Auth::logout();
        return redirect('/login')->withErrors([
            'email' => 'Role not assigned.',
        ]);
    }

    //LOGOUT

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
