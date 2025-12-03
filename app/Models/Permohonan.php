<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permohonan extends Model
{
    use HasFactory;

    protected $table = 'permohonan';

    protected $guarded =[];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function keberatan()
    {
        return $this->hasOne(Keberatan::class);
    }

    public function files()
    {
        return $this->hasMany(PermohonanFile::class);
    }
}
