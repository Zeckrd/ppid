<?php

namespace App\Http\Controllers;

use App\Models\PhoneVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\WablasService;

class PhoneVerificationController extends Controller
{
    protected $wablas;

    public function __construct(WablasService $wablas)
    {
        $this->wablas = $wablas;
    }

    /**
     * Send or resend verification WhatsApp message
     */
    public function send(Request $request)
    {
        $user = auth()->user();

        // Check existing active verification token
        $existing = PhoneVerification::where('user_id', $user->id)->first();

        if ($existing && $existing->last_sent_at) {
            $secondsSinceLast = now()->diffInSeconds($existing->last_sent_at);

            if ($secondsSinceLast < 120) {
                $remaining = 120 - $secondsSinceLast;

                return back()->with('error', 'Silakan tunggu ' . $remaining . ' detik sebelum mengirim ulang.');
            }
        }

        // delete old token
        PhoneVerification::where('user_id', $user->id)->delete();

        // create new token
        $token = Str::random(40);

        $verification = PhoneVerification::create([
            'user_id' => $user->id,
            'token'   => $token,
            'expires_at' => now()->addMinutes(120),
            'last_sent_at' => now(),
        ]);

        $url = route('verify.phone', $token);

        $message = "Halo *{$user->name}*,\n"
                . "Klik link berikut untuk verifikasi nomor WhatsApp Anda:\n\n"
                . "$url\n\n"
                . "Link berlaku 120 menit.";

        $this->wablas->sendMessage($user->phone, $message);

        return back()->with('success', 'Link verifikasi telah dikirim ke WhatsApp Anda.');
    }


    /**
     * Verify phone number using token
     */
    public function verify($token)
    {
        $verification = PhoneVerification::where('token', $token)->firstOrFail();

        // expiration check
        if ($verification->expires_at && $verification->expires_at->isPast()) {
            $verification->delete();
            return redirect('/login')->with('error', 'Token verifikasi sudah kadaluarsa.');
        }

        // Mark user as verified
        $user = $verification->user;
        $user->phone_verified_at = now();
        $user->save();

        // Remove used token
        $verification->delete();

        return redirect('/login')->with('success', 'Nomor WhatsApp berhasil diverifikasi. Silakan login.');
    }
}
