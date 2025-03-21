<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;
    
    public function recruteur()
    {
        return $this->belongsTo(Recruteur::class);
    }

    public function postulers()
    {
        return $this->hasMany(Postuler::class);
    }
}
