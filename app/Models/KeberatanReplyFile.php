<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KeberatanReplyFile extends Model
{
    protected $fillable = [
        'keberatan_id',
        'path',
        'original_name',
        'size',
        'mime_type',
    ];

    public function keberatan()
    {
        return $this->belongsTo(Keberatan::class);
    }

    public function isPdf(): bool
    {
        $mime = strtolower((string) $this->mime_type);
        $name = strtolower((string) $this->original_name);

        return $mime === 'application/pdf'
            || Str::endsWith($name, '.pdf');
    }
}