<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    // Define the relationship: A candidate can apply to many jobs (through applications)
    public function jobPosts()
    {
        return $this->belongsToMany(JobPost::class, 'applications');
    }
}
