<?php

namespace App\Notifications\Channels;

use App\Services\WablasService;
use Illuminate\Notifications\Notification;

class WablasChannel
{
    public function __construct(private WablasService $wablas) {}

    public function send($notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toWablas')) {
            return;
        }

        // routeNotificationFor('wablas') will call routeNotificationForWablas()
        $phone = $notifiable->routeNotificationFor('wablas');
        if (!$phone) {
            return;
        }

        $message = $notification->toWablas($notifiable);
        if (!is_string($message) || trim($message) === '') {
            return;
        }

        $this->wablas->sendMessage($phone, $message);
    }
}
