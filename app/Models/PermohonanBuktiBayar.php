<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermohonanBuktiBayar extends Model
{
    protected $table = 'permohonan_bukti_bayar';

    protected $fillable = [
        'permohonan_id',
        'uploaded_by',
        'path',
        'original_name',
        'mime',
        'size',
    ];

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
