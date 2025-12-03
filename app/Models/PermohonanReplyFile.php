<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanReplyFile extends Model
{
    protected $fillable = [
        'permohonan_id',
        'path',
        'original_name',
        'size',
        'mime_type',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }
}
