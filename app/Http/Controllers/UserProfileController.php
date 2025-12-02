<?php

namespace App\Http\Controllers;

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

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phone')->ignore($user->id),
            ],
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'phone.unique' => 'Nomor WhatsApp ini sudah digunakan oleh pengguna lain.',
        ]);

        // if changed = do save
        if ($validated['phone'] !== $user->phone) {
            $user->phone = $validated['phone'];
            $user->phone_verified_at = null; // force reverify
            $user->save();
        }

        return back()->with('success', 'Nomor WhatsApp berhasil diperbarui. Silakan verifikasi kembali.');
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
