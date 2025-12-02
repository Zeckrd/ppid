<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPhoneVerified
{
    /**
     * Pages unverified users ARE allowed to access
     */
    protected array $allowedRoutes = [
        'user.setup',
        'user.profile.edit',
        'user.profile.update',
        'user.phone.reverify',
        'logout',
    ];

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // if not logged in, middleware does nothing
        if (!$user) {
            return $next($request);
        }

        // if phone already verified = allow everything
        if (!is_null($user->phone_verified_at)) {
            return $next($request);
        }

        // unverified user = check if current route is allowed
        $currentRoute = $request->route()->getName();

        if (in_array($currentRoute, $this->allowedRoutes)) {
            return $next($request);
        }

        // redirect and warning to setup page
        return redirect()->route('user.setup')
            ->with('warning', 'Silakan verifikasi nomor WhatsApp Anda untuk melanjutkan.');
    }
}
