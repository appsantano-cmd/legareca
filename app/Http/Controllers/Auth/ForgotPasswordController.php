<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan halaman forgot password (input email)
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Verifikasi email dan langsung reset password (TANPA KIRIM EMAIL)
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'We could not find an account with that email address.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Rate limiting
        $key = 'password-reset:' . Str::lower($request->email);
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            
            return redirect()->back()
                ->withErrors([
                    'email' => 'Too many attempts. Please try again in ' . 
                              ceil($seconds / 60) . ' minutes.'
                ])
                ->withInput();
        }

        RateLimiter::hit($key, 300); // 5 menit

        // Simpan email di session
        session(['reset_email' => $request->email]);

        // Redirect ke form reset password
        return redirect()->route('password.reset')
            ->with('success', 'Email verified. Please set your new password.');
    }

    /**
     * Menampilkan form reset password
     */
    public function showResetForm()
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request')
                ->with('error', 'Please verify your email first.');
        }

        return view('auth.reset-password', [
            'email' => session('reset_email')
        ]);
    }

    /**
     * Reset password langsung tanpa token
     */
    public function resetPassword(Request $request)
    {
        // Cek session
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request')
                ->with('error', 'Session expired. Please try again.');
        }

        $email = session('reset_email');

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password.required' => 'New password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password_confirmation.required' => 'Please confirm your new password.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cari user
        $user = User::where('email', $email)->first();

        if (!$user) {
            session()->forget('reset_email');
            return redirect()->route('password.request')
                ->with('error', 'User not found. Please try again.');
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus session
        session()->forget('reset_email');

        // ============ ACTIVITY LOG ============
        ActivityLog::create([
            'user_id' => $user->id,
            'activity_type' => 'PASSWORD_RESET',
            'description' => 'Password reset successfully without email verification',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'properties' => json_encode([
                'email' => $user->email,
                'name' => $user->name,
                'reset_method' => 'direct_reset_no_email',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]),
        ]);
        // ======================================

        // Redirect ke login
        return redirect()->route('login')
            ->with('status', 'Password has been reset successfully! You can now login with your new password.');
    }

    /**
     * Get the broker to be used during password reset.
     */
    public function broker()
    {
        return Password::broker();
    }
}