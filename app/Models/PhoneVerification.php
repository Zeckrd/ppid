<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneVerification extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
        'last_sent_at',
    ];

    protected $casts = [
        'expires_at'  => 'datetime',
        'last_sent_at'=> 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

