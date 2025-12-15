<?php

namespace App\Notifications;

use App\Models\Keberatan;
use App\Notifications\Channels\WablasChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class AdminKeberatanCreated extends Notification
{
    public function __construct(public Keberatan $keberatan) {}

    public function via($notifiable): array
    {
        return [WablasChannel::class];
    }

    protected function adminPermohonanUrl(): string
    {
        $permohonanId = $this->keberatan->permohonan_id;
        return route('admin.permohonan.show', $permohonanId, true);
    }

    public function toWablas($notifiable): string
    {
        $k = $this->keberatan->loadMissing('permohonan.user');

        $userName = $k->permohonan->user->name ?? '-';
        $permohonanId = $k->permohonan->id;

        $excerpt = Str::limit($k->keterangan_user ?? '', 300);

        return
            "Keberatan Baru\n"
            . "User: {$userName}\n"
            . "Permohonan ID: #{$permohonanId}\n\n"
            . "Keterangan Keberatan:\n{$excerpt}\n\n"
            . "Lihat: {$this->adminPermohonanUrl()}";
    }
}
