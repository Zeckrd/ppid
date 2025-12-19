<?php

use App\Http\Middleware\CheckPhoneVerified;
use App\Http\Middleware\IsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'phone.verified' => CheckPhoneVerified::class,
            'is_admin'       => IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            $retryAfter = (int) ($e->getHeaders()['Retry-After'] ?? 60);

            $message = "Terlalu banyak percobaan. Silakan coba lagi dalam {$retryAfter} detik.";

            $headers = $e->getHeaders();

            // For API
            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 429, $headers);
            }

            // For GET endpoints
            if ($request->isMethod('get')) {
                return response($message, 429, $headers);
            }

            // For form POST: redirect back with error
            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['throttle' => $message])
                ->setStatusCode(429)
                ->withHeaders($headers);
        });

    })
    ->create();