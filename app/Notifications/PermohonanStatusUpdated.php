<?php

namespace App\Notifications;

use App\Models\Permohonan;
use App\Notifications\Channels\WablasChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PermohonanStatusUpdated extends Notification
{
    public function __construct(
        public Permohonan $permohonan,
        public array $channels = [] // e.g. ['wablas','mail']
    ) {}

    public function via($notifiable): array
    {
        $mapped = [];

        foreach ($this->channels as $ch) {
            $mapped[] = $ch === 'wablas' ? WablasChannel::class : $ch;
        }

        return $mapped;
    }

    protected function userPermohonanUrl(): string
    {
        return route('user.permohonan.show', $this->permohonan->id, true);
    }

    public function toWablas($notifiable): string
    {
        $p = $this->permohonan->loadMissing('keberatan');

        $lines = [];
        $lines[] = "Status Permohonan informasi: *{$p->status}*";

        if (!empty($p->keterangan_petugas)) {
            $lines[] = "Keterangan Petugas: {$p->keterangan_petugas}";
        }

        $lines[] = "";

        if ($p->keberatan) {
            $lines[] = "Status Keberatan atas informasi: {$p->keberatan->status}";

            if (!empty($p->keberatan->keterangan_petugas)) {
                $lines[] = "Keterangan Petugas: {$p->keberatan->keterangan_petugas}";
            }
        }

        $lines[] = "";

        $lines[] = "Lihat detail: " . $this->userPermohonanUrl();

        return implode("\n", $lines);
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pembaruan Status Permohonan Informasi')
            ->view('emails.status_update', [
                'permohonan'      => $this->permohonan,
                'messageContent'  => $this->toWablas($notifiable),
            ]);
    }
}
