<?php

namespace App\Services;

use App\Models\User;
use App\Models\Permohonan;
use App\Models\Keberatan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class WhatsAppNotificationService
{
    protected WablasService $wablas;

    const USER_RATE_LIMIT_MAX = 5;     // max notifications per user
    const USER_RATE_LIMIT_DECAY = 86400; // seconds (1 day)

    public function __construct(WablasService $wablas)
    {
        $this->wablas = $wablas;
    }

    /**
     * Rate limit key for a user.
     */
    protected function userKey(int $userId): string
    {
        return 'wa_notify_user_' . $userId;
    }

    protected function canSendForUser(?int $userId): bool
    {
        if (!$userId) {
            // No user (just in case): allow, or also block
            return true;
        }

        $key = $this->userKey($userId);

        if (RateLimiter::tooManyAttempts($key, self::USER_RATE_LIMIT_MAX)) {
            return false;
        }

        // record attempt
        RateLimiter::hit($key, self::USER_RATE_LIMIT_DECAY);

        return true;
    }

    /**
     * Get all admin phone numbers.
     */
    protected function getAdminPhones(): array
    {
        return User::admins()->pluck('phone')->all();
    }

    /**
     * Notify admins when a permohonan is created.
     */
    public function notifyPermohonanCreated(Permohonan $permohonan): void
    {
        $user = $permohonan->user;

        if (!$user) {
            return;
        }

        if (!$this->canSendForUser($user->id)) {
            return; // rate limited
        }

        $adminPhones = $this->getAdminPhones();

        if (empty($adminPhones)) {
            return;
        }

        $excerpt = Str::limit($permohonan->keterangan_user ?? '', 300);

        $message = sprintf(
            "Permohonan Baru Dari %s (ID: #%d)\n\nDescription (truncated):\n%s\n\n Silahkan lihat di dashboard admin https://ppid.ptun-bandung.go.id/",
            $user->name,
            $permohonan->id,
            $excerpt
        );

        foreach ($adminPhones as $phone) {
            $this->wablas->sendMessage($phone, $message);
        }
    }

    /**
     * Notify admins when a permohonan is updated by user
     */
    public function notifyPermohonanUpdatedByUser(Permohonan $permohonan): void
    {
        $user = $permohonan->user;

        if (!$user) {
            return;
        }

        if (!$this->canSendForUser($user->id)) {
            return; // rate limited
        }

        $adminPhones = $this->getAdminPhones();

        if (empty($adminPhones)) {
            return;
        }

        $excerpt = Str::limit($permohonan->keterangan_user ?? '', 300);

        $message = sprintf(
            "Permohonan #%d telah diperbarui %s.\n\n keterangan: (truncated):\n%s\n\n Silahkan lihat di dashboard admin https://ppid.ptun-bandung.go.id/",
            $permohonan->id,
            $user->name,
            $excerpt
        );

        foreach ($adminPhones as $phone) {
            $this->wablas->sendMessage($phone, $message);
        }
    }

    /**
     * Notify admins when a keberatan is created
     * Message uses keterangan_user from permohonan table
     */
    public function notifyKeberatanCreated(Keberatan $keberatan): void
    {
        $permohonan = $keberatan->permohonan;

        if (!$permohonan || !$permohonan->user) {
            return;
        }

        $user = $permohonan->user;

        if (!$this->canSendForUser($user->id)) {
            return; // rate limited
        }

        $adminPhones = $this->getAdminPhones();

        if (empty($adminPhones)) {
            return;
        }

        // use keterangan_user from permohonan table
        $excerpt = Str::limit($permohonan->keterangan_user ?? '', 300);

        $message = sprintf(
            "Keberatan baru dibuat oleh %s untuk permohonan #%d.\n\n keterangan: (from permohonan, truncated):\n%s\n\nSilahkan lihat di dashboard admin https://ppid.ptun-bandung.go.id/",
            $user->name,
            $permohonan->id,
            $excerpt
        );

        foreach ($adminPhones as $phone) {
            $this->wablas->sendMessage($phone, $message);
        }
    }
}
