<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($admin) {
            $admin->uid = str_unique();
        });
    }
    // Define the relationship: An admin belongs to one tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
