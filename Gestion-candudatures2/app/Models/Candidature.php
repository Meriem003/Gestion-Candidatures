<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->hasOne(User::class);
    }
    

    public function postulers()
    {
        return $this->hasMany(Postuler::class);
    }

    public function competences()
    {
        return $this->belongsToMany(Competence::class, 'competence_candidature');
    }
}
