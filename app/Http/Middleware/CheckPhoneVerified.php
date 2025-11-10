<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPhoneVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // if user is logged in but hasnt verified their phone
        if ($user && is_null($user->phone_verified_at)) {
            Auth::logout(); // log them out
            return redirect('/login')->withErrors([
                'phone' => 'Silahkan Verifikasi Nomor Whatsapp Anda',
            ]);
        }

        return $next($request);
    }
}
