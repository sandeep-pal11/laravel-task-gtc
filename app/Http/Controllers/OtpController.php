<?php

namespace App\Http\Controllers;

use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    /**
     * Show OTP page
     */
    public function show()
    {
        return view('auth.verify-otp');
    }

    /**
     * Verify OTP
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $otp = EmailOtp::where('user_id', session('otp_user_id'))
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return back()->withErrors([
                'otp' => 'Invalid or expired OTP',
            ]);
        }

        // Login user
        Auth::loginUsingId($otp->user_id);

        $user = User::find($otp->user_id);

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['otp' => 'User not found. Please login again.']);
        }

        // Mark OTP verified
        User::where('id', $user->id)->update([
            'is_otp_verified' => true,
        ]);

        // Cleanup
        $otp->delete();
        session()->forget('otp_user_id');

        //  SPATIE ROLE BASED REDIRECT
        if ($user->hasAnyRole(['super-admin', 'admin', 'manager'])) {
            return redirect('/admin/dashboard');
        }

        return redirect('/dashboard');
    }
}
