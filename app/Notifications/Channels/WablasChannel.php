<?php

namespace App\Notifications\Channels;

use App\Services\WablasService;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\RateLimiter;
use App\Notifications\AdminPermohonanCreated;
use App\Notifications\AdminPermohonanUpdatedByUser;

class WablasChannel
{
    public function __construct(private WablasService $wablas) {}

    public function send($notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toWablas')) return;

        $phone = $notifiable->routeNotificationFor('wablas');
        if (!$phone) return;

        $message = $notification->toWablas($notifiable);
        if (!is_string($message) || trim($message) === '') return;

        // Only throttle these notifications
        $shouldThrottle =
            $notification instanceof AdminPermohonanCreated ||
            $notification instanceof AdminPermohonanUpdatedByUser;

        if (! $shouldThrottle) {
            $this->wablas->sendMessage($phone, $message);
            return;
        }

        // Per user who updates/creates
        $actorUserId = $notification->permohonan->user_id ?? null;
        if (! $actorUserId) return;

        $key = "wablas:permohonan:" . class_basename($notification) . ":actor:{$actorUserId}";

        $allowed = RateLimiter::attempt(
            $key,
            3,
            fn () => $this->wablas->sendMessage($phone, $message),
            6 * 60 * 60
        );

        if (! $allowed) {
            logger()->info('Wablas throttled', ['key' => $key]);
        }
    }
}
