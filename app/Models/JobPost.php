<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'user_id',
    'title',
    'description',
    'location',
    'job_type',
    'minimum_experience',
    'status',
])]
class JobPost extends Model
{
    public function company(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(
            Skill::class
        )->withTimestamps();
    }

    protected function casts(): array
    {
        return [
            'minimum_experience' => 'integer',
        ];
    }
}