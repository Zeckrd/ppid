<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanFile extends Model
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

    public function isPdf(): bool
    // for view/download button, checks if file stored is .pdf in mime or ends with
    {
        // Prefer MIME type if stored
        if (! empty($this->mime_type) && str_contains($this->mime_type, 'pdf')) {
            return true;
        }

        // Fallback to extension check
        $name = strtolower($this->original_name ?? '');
        $path = strtolower($this->path ?? '');

        return str_ends_with($name, '.pdf') || str_ends_with($path, '.pdf');
    }
}
