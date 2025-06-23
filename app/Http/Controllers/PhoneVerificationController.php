<?php

namespace App\Http\Controllers;

use App\Models\PhoneVerification;
use Illuminate\Support\Facades\Auth;

class PhoneVerificationController extends Controller
{
    public function verify($token)
    {
        // check if token exist
        $verification = PhoneVerification::where('token', $token)->firstOrFail();

        // update users phone_verified_at
        $user = $verification->user;
        $user->phone_verified_at = now();
        $user->save();

        // delete the verification record
        $verification->delete();

        // Redirect
        return redirect('/login')->with('success', 'Nomor telepon berhasil diverifikasi. Silakan login.');
    }
}
