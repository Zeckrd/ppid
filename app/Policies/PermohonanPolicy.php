<?php

namespace App\Policies;

use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermohonanPolicy
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
    public function view(User $user, Permohonan $permohonan): bool
    {
        return $user->id === $permohonan->user_id;
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
    public function update(User $user, Permohonan $permohonan): bool
    {
        return $user->id === $permohonan->user_id && 
               in_array($permohonan->status, [
                   'Menunggu Verifikasi Berkas Dari Petugas',
                   'Perlu Diperbaiki'
               ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permohonan $permohonan): bool
    {
        return $user->id === $permohonan->user_id && 
               $permohonan->status === 'Menunggu Verifikasi Berkas Dari Petugas';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Permohonan $permohonan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Permohonan $permohonan): bool
    {
        return false;
    }
}
