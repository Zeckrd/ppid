<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password as PasswordBroker;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PasswordResetController extends Controller
{
    // Show "Forgot Password" form
    public function requestForm()
    {
        return view('auth.forgot-password');
    }

    // Handle form submission and send reset link
    public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email']);

    // Attempt to send the reset link
    $status = PasswordBroker::sendResetLink($request->only('email'));

    // log the attempt for monitoring
    Log::info('Password reset requested', [
        'email' => $request->input('email'),
        'status' => $status, // internal only
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);

    try {
        usleep(random_int(100000, 300000));
    } catch (\Throwable $e) {
    }

    return back()->with('success', __('Jika email Anda terdaftar, Anda akan menerima tautan pengaturan ulang password.'));
}

    // Show "Reset Password" form
    public function resetForm(string $token, string $email)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => urldecode($email),
        ]);
    }

    // Handle password reset
    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Password::min(5)->letters()],
        ]);

        $status = PasswordBroker::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === PasswordBroker::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
