<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillGap extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id', 'job_listing_id', 'missing_skills', 'present_skills',
        'score', 'analysis', 'recommendations', 'analyzed_at',
    ];

    protected function casts(): array
    {
        return [
            'missing_skills' => 'array',
            'present_skills' => 'array',
            'recommendations' => 'array',
            'analyzed_at' => 'datetime',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class);
    }
}
