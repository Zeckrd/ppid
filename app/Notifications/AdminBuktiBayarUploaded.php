<?php

namespace App\Notifications;

use App\Models\Permohonan;
use App\Notifications\Channels\WablasChannel;
use Illuminate\Notifications\Notification;

class AdminBuktiBayarUploaded extends Notification
{
    public function __construct(public Permohonan $permohonan) {}

    public function via($notifiable): array
    {
        return [WablasChannel::class];
    }

    protected function adminPermohonanUrl(): string
    {
        // absolute URL so it works in WhatsApp
        return route('admin.permohonan.show', $this->permohonan->id, true);
    }

    public function toWablas($notifiable): string
    {
        $p = $this->permohonan->loadMissing(['user', 'buktiBayar']);

        $userName = $p->user->name ?? '-';
        $bukti    = $p->buktiBayar;

        $fileName = $bukti?->original_name ?? '-';
        $fileSize = $bukti?->size ? round($bukti->size / 1024, 1) . ' KB' : '-';

        return
            "Bukti Pembayaran Diunggah\n"
            . "User: {$userName}\n"
            . "ID: #{$p->id}\n"
            . "File: {$fileName}\n"
            . "Ukuran: {$fileSize}\n\n"
            . "Status: {$p->status}\n"
            . "Lihat: {$this->adminPermohonanUrl()}";
    }
}
