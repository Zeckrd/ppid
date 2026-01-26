<?php

namespace App\Notifications\Channels;

use App\Services\WablasService;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\RateLimiter;

class WablasChannel
{
    public function __construct(private WablasService $wablas) {}

    public function send($notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toWablas')) {
            return;
        }

        $phone = $notifiable->routeNotificationFor('wablas');
        if (!$phone) {
            return;
        }

        $message = $notification->toWablas($notifiable);
        if (!is_string($message) || trim($message) === '') {
            return;
        }

        // throttle per user permohonan update
        $actorUserId = $notification->permohonan->user_id ?? null;
        if (!$actorUserId) {
            return;
        }

        $key = "wablas:permohonan-updated-by-user:actor:{$actorUserId}";

        $allowed = RateLimiter::attempt(
            $key,
            3,               // max attempts
            function () use ($phone, $message) {
                $this->wablas->sendMessage($phone, $message);
            },
            6 * 60 * 60      // 6 hours
        );

        if (! $allowed) {
            // log and skip quietly
            logger()->info('Wablas throttled', ['key' => $key]);
            return;
        }
    }
}
