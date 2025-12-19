<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
public function boot(): void
    {
        // password-reset: limit by IP
        RateLimiter::for('password-reset', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // login: limit by email + IP
        RateLimiter::for('login', function (Request $request) {
            $email = Str::lower((string) $request->input('email', ''));
            $key = $email.'|'.$request->ip();

            return Limit::perMinute(10)->by($key);
        });

        // register: limit by IP
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(2)->by($request->ip());
        });

        // email-change: request: limit per user + IP fallback
        RateLimiter::for('email-change', function (Request $request) {
            $userId = optional($request->user())->id;

            if ($userId) {
                return [
                    Limit::perMinute(2)->by('email-change:user:'.$userId),
                    Limit::perHour(5)->by('email-change:user:'.$userId),
                ];
            }

            return Limit::perMinute(2)->by('email-change:ip:'.$request->ip());
        });

        // email-confirm link: limit by IP
        RateLimiter::for('email-confirm', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        // phone-verify link: limit by IP
        RateLimiter::for('phone-verify', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        // phone-send: limit per user + per IP fallback
        RateLimiter::for('phone-send', function (Request $request) {
            $userId = optional($request->user())->id;

            if ($userId) {
                return [
                    Limit::perMinute(2)->by('phone-send:user:'.$userId),
                    Limit::perHour(6)->by('phone-send:user:'.$userId),
                ];
            }

            return Limit::perMinute(2)->by('phone-send:ip:'.$request->ip());
        });
    }

    protected $policies = [
        Permohonan::class => PermohonanPolicy::class,
    ];
}
