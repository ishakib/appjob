<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Candidate extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($candidate) {
            $candidate->uid = str_unique();
        });
    }
    // Define the relationship: A candidate can apply to many jobs (through applications)
    public function jobPosts(): BelongsToMany
    {
        return $this->belongsToMany(JobPost::class, 'applications');
    }
}
