<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PhoneVerification;

class CheckPhoneVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->phone) {
            return redirect()->route('verify-phone')->with('message', 'Please provide your phone number.');
        }

        $verified = PhoneVerification::where('user_id', $user->id)
            ->where('phone', $user->phone)
            ->where('is_verified', true)
            ->exists();

        if (!$verified) {
            return redirect()->route('verify-phone')->with('message', 'Please verify your phone number.');
        }

        return $next($request);
    }
}
