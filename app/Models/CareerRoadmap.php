<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerRoadmap extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id', 'job_listing_id', 'title', 'goal', 'duration_days',
        'steps', 'created_by_ai', 'progress_percent', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'steps' => 'array',
            'created_by_ai' => 'boolean',
            'completed_at' => 'datetime',
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

    // ── Accessors ─────────────────────────────────────────────────

    public function getCompletedStepsAttribute(): int
    {
        return count(array_filter($this->steps ?? [], fn ($s) => !empty($s['completed'])));
    }

    public function getTotalStepsAttribute(): int
    {
        return count($this->steps ?? []);
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->completed_at !== null;
    }
}
