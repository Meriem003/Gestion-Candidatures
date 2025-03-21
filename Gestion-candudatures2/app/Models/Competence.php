<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;
    public function candidatures()
    {
        return $this->belongsToMany(Candidature::class, 'competence_candidature');
    }
}
