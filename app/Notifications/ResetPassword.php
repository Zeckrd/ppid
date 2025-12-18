<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification //implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $token
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    protected function resetUrl($notifiable): string
    {
        // route params: token + email
        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }

    public function toMail($notifiable): MailMessage
    {
        $confirmUrl = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject('Reset Password Akun Anda')
            ->view('emails.reset-password', [
                'user' => $notifiable,
                'confirmUrl' => $confirmUrl,
                'logoUrl' => asset('img/logoppid.png'),
                'expireMinutes' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire', 60),
            ]);
    }
}
