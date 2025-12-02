<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmailChangeController extends Controller
{
    public function requestChange(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'new_email_confirmation' => ['required', 'same:new_email'],
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'new_email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
            'new_email_confirmation.same' => 'Konfirmasi email baru tidak cocok.',
        ]);

        // update email
        $user->email = $validated['new_email'];

        $user->save();

        return redirect()
            ->route('user.profile.edit')
            ->with('success', 'Email berhasil diperbarui.');
    }

}
