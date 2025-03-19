<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'company', 'location', 'salary', 'deadline'];
    public function users()
    {
        return $this->belongsToMany(User::class, 'offer_user')->withTimestamps();
    }
        public function recruiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }
}
