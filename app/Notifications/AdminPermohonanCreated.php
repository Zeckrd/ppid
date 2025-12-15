<?php

namespace App\Notifications;

use App\Models\Permohonan;
use App\Notifications\Channels\WablasChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class AdminPermohonanCreated extends Notification
{
    public function __construct(public Permohonan $permohonan) {}

    public function via($notifiable): array
    {
        return [WablasChannel::class];
    }

    protected function adminPermohonanUrl(): string
    {
        return route('admin.permohonan.show', $this->permohonan->id, true);
    }

    public function toWablas($notifiable): string
    {
        $p = $this->permohonan->loadMissing('user');

        $excerpt = Str::limit($p->keterangan_user ?? '', 300);

        return
            "Permohonan Baru\n"
            . "User: {$p->user->name}\n"
            . "ID: #{$p->id}\n\n"
            . "Keterangan:\n{$excerpt}\n\n"
            . "Lihat: {$this->adminPermohonanUrl()}";
    }
}
