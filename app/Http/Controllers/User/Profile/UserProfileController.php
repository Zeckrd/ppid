<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\PhoneVerificationController;
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

        // Normalize phone BEFORE compare + validation
        $newPhoneRaw = $request->input('phone', '');
        $newPhone = preg_replace('/[^0-9]/', '', $newPhoneRaw);

        if (str_starts_with($newPhone, '0')) {
            $newPhone = '62' . substr($newPhone, 1);
        }

        $request->merge(['phone' => $newPhone]);

        $oldPhone   = $user->phone;
        $isSamePhone = ($newPhone === $oldPhone);
        $isVerified  = !is_null($user->phone_verified_at);

        // rules (unique only if different)
        $rules = [
            'current_password' => ['required', 'current_password'],
            'phone'            => ['required', 'string', 'max:20'],
        ];

        if (!$isSamePhone) {
            $rules['phone'][] = Rule::unique('users', 'phone')->ignore($user->id);
        }

        // Validate
        $validated = $request->validate($rules, [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'phone.unique' => 'Nomor WhatsApp ini sudah digunakan oleh pengguna lain.',
        ]);

        // Use validated normalized phone
        $newPhone = $validated['phone'];
        $isSamePhone = ($newPhone === $oldPhone);

        // 
        // VERIFIED user
        // 
        if ($isVerified) {
            if ($isSamePhone) {
                return back()->with('error', 'Nomor WhatsApp Anda sudah terverifikasi dan tidak berubah.');
            }

            $user->phone = $newPhone;
            $user->phone_verified_at = null;
            $user->save();

            return app(PhoneVerificationController::class)->send($request);
        }

        // 
        // UNVERIFIED user
        // 
        if ($isSamePhone) {
            return app(PhoneVerificationController::class)->send($request);
        }

        $user->phone = $newPhone;
        $user->phone_verified_at = null;
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
