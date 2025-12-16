<?php

namespace App\Mail;

use App\Models\EmailChange;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmEmailChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public EmailChange $request,
        public string $confirmUrl
    ) {}

public function build()
{
    return $this->subject('Konfirmasi Perubahan Email')
        ->view('emails.confirm-email-change', [
            'user'       => $this->request->user,
            'confirmUrl' => $this->confirmUrl,
            // token
            // 'token'   => $token,
        ]);
}
}