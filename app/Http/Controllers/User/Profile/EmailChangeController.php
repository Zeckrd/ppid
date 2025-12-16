<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmEmailChangeMail;
use App\Models\EmailChange;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EmailChangeController extends Controller
{
    private const RESEND_COOLDOWN_SECONDS = 120; // 2 min
    private const EXPIRE_MINUTES = 120;          // 120 min

    public function requestChange(Request $request)
    {
        
        $user = Auth::user();

        $validated = $request->validate([
            'current_password_email' => ['required', 'current_password'],
            'new_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'new_email_confirmation' => ['required', 'same:new_email'],
        ], [
            'current_password_email.required' => 'Password saat ini wajib diisi.',
            'current_password_email.current_password' => 'Password saat ini tidak sesuai.',
            'new_email.required' => 'Email baru wajib diisi.',
            'new_email.email' => 'Format email baru tidak valid.',
            'new_email.max' => 'Email baru maksimal 255 karakter.',
            'new_email.unique' => 'Email tersebut sudah digunakan oleh pengguna lain.',
            'new_email_confirmation.required' => 'Konfirmasi email baru wajib diisi.',
            'new_email_confirmation.same' => 'Konfirmasi email baru tidak cocok.',
        ]);

        // prevent requesting the same emai
        if (strtolower($validated['new_email']) === strtolower($user->email)) {
            return back()->withErrors([
                'new_email' => 'Email baru harus berbeda dari email yang sekarang.'
            ])->withInput();
        }

        // Check existing active request for cooldown
        $existing = EmailChange::where('user_id', $user->id)->first();

        if ($existing && $existing->last_sent_at) {
            $secondsSinceLast = $existing->last_sent_at->diffInSeconds(now());
            $remaining = max(0, self::RESEND_COOLDOWN_SECONDS - $secondsSinceLast);

            if ($remaining > 0) {
                $minutes = intdiv($remaining, 60);
                $seconds = $remaining % 60;

                $text = 'Mohon tunggu ';
                if ($minutes > 0) $text .= $minutes . ' menit ';
                if ($seconds > 0) $text .= $seconds . ' detik ';
                $text .= 'sebelum mengirim ulang tautan konfirmasi.';

                return back()->withErrors(['new_email' => trim($text)])->withInput();
            }
        }

        // Delete old request (resend = re-submit form)
        EmailChange::where('user_id', $user->id)->delete();

        // Create new token + hash
        $token = Str::random(64);
        $tokenHash = hash('sha256', $token);

        $changeRequest = EmailChange::create([
            'user_id'      => $user->id,
            'new_email'    => $validated['new_email'],
            'token_hash'   => $tokenHash,
            'expires_at'   => now()->addMinutes(self::EXPIRE_MINUTES),
            'last_sent_at' => now(),
        ]);

        $confirmUrl = route('email.change.confirm', $token);

        Mail::to($changeRequest->new_email)->send(
            new ConfirmEmailChangeMail($changeRequest, $confirmUrl)
        );

        return redirect()
            ->route('user.profile.edit')
            ->with('success', 'Link konfirmasi telah dikirim ke email baru Anda. Silakan konfirmasi dalam 120 menit.');
    }

    public function confirm(string $token)
    {
        $tokenHash = hash('sha256', $token);

        $changeRequest = EmailChange::where('token_hash', $tokenHash)->firstOrFail();

        // Expired check
        if ($changeRequest->expires_at && $changeRequest->expires_at->isPast()) {
            $changeRequest->delete();
            return redirect('/login')->with('error', 'Link konfirmasi sudah kadaluarsa. Silakan ajukan perubahan email kembali.');
        }

        $user = $changeRequest->user;

        // Re-check unique at confirm time
        $taken = User::where('email', $changeRequest->new_email)
            ->where('id', '!=', $user->id)
            ->exists();

        if ($taken) {
            $changeRequest->delete();
            return redirect('/login')->with('error', 'Email tersebut sudah digunakan. Silakan ajukan perubahan email kembali.');
        }

        // Apply email change
        $user->email = $changeRequest->new_email;
        $user->save();

        // One-time use
        $changeRequest->delete();

        return redirect('/login')->with('success', 'Email berhasil diperbarui. Silakan login kembali.');
    }
}
