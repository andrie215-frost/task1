<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'professional_title',
    'bio',
    'location',
    'experience_years',
    'preferred_job_type',
    'is_available',
])]
class SkilledProfile extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'experience_years' => 'integer',
            'is_available' => 'boolean',
        ];
    }
}