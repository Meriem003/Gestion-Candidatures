<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postuler extends Model
{
    use HasFactory;
    public function candidature()
    {
        return $this->belongsTo(Candidature::class);
    }

    public function offre()
    {
        return $this->belongsTo(Offre::class);
    }
}
