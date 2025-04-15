<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPost extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($jobPost) {
            $jobPost->uid = str_unique();
        });
    }
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * @return HasMany
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * @return HasMany
     */
    public function views(): HasMany
    {
        return $this->hasMany(JobView::class);
    }

    // Define the relationship: A job can have many candidates (applicants)
    public function candidates()
    {
        return $this->belongsToMany(Candidate::class);
    }
}
