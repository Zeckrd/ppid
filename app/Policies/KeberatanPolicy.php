<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Keberatan;

class KeberatanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Keberatan $keberatan): bool
    {
        return $user->id === $keberatan->permohonan->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Keberatan $keberatan): bool
    {
        return $user->id === $keberatan->permohonan->user_id
            && in_array($keberatan->status, [
                'Pending',
            ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Keberatan $keberatan): bool
    {
        return $user->id === $keberatan->permohonan->user_id
            && in_array($keberatan->status, [
                'Pending',
            ]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Keberatan $keberatan): bool
    {
        return false;
    }

        public function updateFiles(User $user, Keberatan $keberatan): bool
    {
        if ($keberatan->permohonan->user_id !== $user->id) return false;

        return in_array($keberatan->permohonan->status, [
            'Pending',
        ], true);
    }
}
