<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keberatan extends Model
{
    use HasFactory;
    protected $table = 'keberatan';

    protected $guarded =[];

    public function user()
    {
        return $this->belongsTo(Permohonan::class);
    }
}
