<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // validate email and password
        $this->validateLogin($request);

        // validate recaptcha
        $this->verifyRecaptcha($request);

        // login
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'credential' => 'Email atau Password salah',
            ]);
        }

        // Regenerate session
        $request->session()->regenerate();

        $user = auth()->user();

        // Admin login
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard.index');
        }

        // If user has NOT verified their phone = send to setup page
        if (is_null($user->phone_verified_at)) {
            return redirect()->route('user.setup')
                ->with('warning', 'Silakan verifikasi nomor WhatsApp Anda sebelum mengakses dashboard.');
        }

        // Normal verified user = dashboard
        return redirect()->route('user.dashboard.index');

    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * validate login input fields
     */
    protected function validateLogin(Request $request): void
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
            'g-recaptcha-response' => ['required'],
        ], [
            'g-recaptcha-response.required' => 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.',
        ]);
    }

    /**
     * verify recaptcha response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function verifyRecaptcha(Request $request): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!($response->json('success') ?? false)) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.',
            ]);
        }
    }
}
