<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'new_email',
        'token_hash',
        'expires_at',
        'last_sent_at',
    ];

    protected $casts = [
        'expires_at'   => 'datetime',
        'last_sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
