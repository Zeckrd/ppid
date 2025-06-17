<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhoneVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PhoneVerificationController extends Controller
{
    public function showForm()
    {
        return view('otp.verify-phone');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric'
        ]);

        $user = Auth::user();

        // Store phone
        $user->update(['phone' => $request->phone]);

        // Generate OTP
        $otp = rand(100000, 999999);

        PhoneVerification::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'otp' => $otp,
                'is_verified' => false,
                'expires_at' => now()->addMinutes(5),
            ]
        );

        // send OTP via Wablas or SMS API
        // Wablas::send($request->phone, "Kode OTP Anda adalah $otp");

        return redirect()->back()->with('message', 'Kode OTP telah dikirim ke nomor Anda.');
    }

    public function confirmOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $verification = PhoneVerification::where('user_id', Auth::id())
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return back()->withErrors(['otp' => 'OTP tidak valid atau sudah kadaluarsa.']);
        }

        $verification->update(['is_verified' => true]);

        return redirect()->route('dashboard.create')->with('message', 'Nomor telepon berhasil diverifikasi.');
    }
}
