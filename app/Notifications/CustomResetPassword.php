<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomResetPassword extends ResetPassword
{
    /**
     * Create new notification instance.
     */
    public function __construct($token)
    {
        parent::__construct($token);
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        // ✅ Create the custom reset link with email included
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => urlencode($notifiable->getEmailForPasswordReset()),
        ], false));

        return (new MailMessage)
            ->subject(Lang::get('Reset Password Notification'))
            ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
            ->action(Lang::get('Reset Password'), $url)
            ->line(Lang::get('This password reset link will expire in :count minutes.', [
                'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire'),
            ]))
            ->line(Lang::get('If you did not request a password reset, no further action is required.'));
    }
}
