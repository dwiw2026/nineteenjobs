<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobMatch extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'matches';

    protected $fillable = [
        'user_id', 'job_listing_id', 'score', 'reasons',
        'skill_overlap', 'missing_skills', 'status',
    ];

    protected function casts(): array
    {
        return [
            'reasons' => 'array',
            'skill_overlap' => 'array',
            'missing_skills' => 'array',
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

    // ── Scopes ────────────────────────────────────────────────────

    public function scopeStrongFit($query)
    {
        return $query->where('score', '>=', 80);
    }

    public function scopePotential($query)
    {
        return $query->whereBetween('score', [60, 79]);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('score');
    }
}
