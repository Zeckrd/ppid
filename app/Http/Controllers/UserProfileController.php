<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PhoneVerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    /**
     * Show the main profile page (all sections).
     */
    public function edit()
    {
        $user = Auth::user();

        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update basic profile info:
     * - name
     * - pekerjaan
     * - phone (WhatsApp)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
        ]);

        $user->name = $validated['name'];
        $user->pekerjaan = $validated['pekerjaan'] ?? null;

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update phone number
     */
    public function updatePhone(Request $request)
    {

        $user = Auth::user();


        $rules = [
            'current_password' => ['required', 'current_password'],
            'phone' => ['required', 'string', 'max:20'],
        ];

        $newPhone = $request->input('phone');
        $oldPhone = $user->phone;

        $isSamePhone = $newPhone === $oldPhone;
        $isVerified  = !is_null($user->phone_verified_at);

        // enforce unique if the phone is different
        if (!$isSamePhone) {
            $rules['phone'][] = Rule::unique('users', 'phone')->ignore($user->id);
        }

        // validation
        $validated = $request->validate($rules, [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'phone.unique' => 'Nomor WhatsApp ini sudah digunakan oleh pengguna lain.',
        ]);

        // in case validation trimmed/normalized
        $newPhone = $validated['phone'];
        $isSamePhone = $newPhone === $oldPhone;

        // ============================
        // VERIFIED user
        // ============================
        if ($isVerified) {

            // Verified + same phone = show error, do NOT send anything
            if ($isSamePhone) {
                return back()->with('error', 'Nomor WhatsApp Anda sudah terverifikasi dan tidak berubah.');
            }

            // Verified + different phone
            //     = update phone, reset verification, send new link (with cooldown)
            $user->phone = $newPhone;
            $user->phone_verified_at = null; // force re-verification
            $user->save();

            // handle 120s cooldown, token creation, and sending WA
            return app(PhoneVerificationController::class)->send($request);
        }

        // ============================
        // UNVERIFIED user
        // ============================

        // Unverified + same phone = just (re)send verification
        if ($isSamePhone) {
            return app(PhoneVerificationController::class)->send($request);
        }

        // Unverified + different phone
        //     = update phone, keep unverified, send new link
        $user->phone = $newPhone;
        $user->phone_verified_at = null; // stays unverified (explicit)
        $user->save();
        return app(PhoneVerificationController::class)->send($request);
    }



    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:5'],
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
