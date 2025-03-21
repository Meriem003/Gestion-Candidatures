<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruteur extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->hasOne(User::class);
    }
    

    public function offres()
    {
        return $this->hasMany(Offre::class);
    }
}
