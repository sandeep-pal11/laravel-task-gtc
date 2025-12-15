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

        // Find OTP
        $otp = EmailOtp::where('user_id', session('otp_user_id'))
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return back()->withErrors([
                'otp' => 'Invalid or expired OTP',
            ]);
        }

        // 🔐 Login user safely
        Auth::loginUsingId($otp->user_id);

        // 🔥 IMPORTANT: Fetch user DIRECTLY from DB
        $user = User::find($otp->user_id);

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['otp' => 'User not found. Please login again.']);
        }

        // ✅ Update OTP flag (NO save() issue)
        User::where('id', $user->id)->update([
            'is_otp_verified' => true,
        ]);

        // Cleanup
        $otp->delete();
        session()->forget('otp_user_id');

        // Role based redirect
        if (in_array($user->role->slug, ['super-admin', 'admin', 'manager'])) {
            return redirect('/admin/dashboard');
        }

        return redirect('/dashboard');
    }
}
