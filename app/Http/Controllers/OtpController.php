<?php

namespace App\Http\Controllers;

use App\Models\EmailOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function show()
    {
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $otp = EmailOtp::where('user_id', session('otp_user_id'))
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        Auth::loginUsingId($otp->user_id);
        $otp->delete();

        // Role based redirect
        $user = Auth::user();
        if (in_array($user->role->slug, ['super-admin','admin','manager'])) {
            return redirect('/admin/dashboard');
        }

        return redirect('/dashboard');
    }
}
