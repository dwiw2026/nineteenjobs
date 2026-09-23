<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id', 'job_listing_id', 'cover_letter', 'resume_path',
        'status', 'employer_notes', 'applied_at', 'status_updated_at',
        'interview_at', 'interview_location',
    ];

    protected function casts(): array
    {
        return [
            'applied_at' => 'datetime',
            'status_updated_at' => 'datetime',
            'interview_at' => 'datetime',
        ];
    }

    const STATUSES = ['pending', 'review', 'interview', 'offered', 'rejected', 'withdrawn'];

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

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'review' => 'Ditinjau',
            'interview' => 'Interview',
            'offered' => 'Diterima',
            'rejected' => 'Ditolak',
            'withdrawn' => 'Dicabut',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'interview', 'offered' => 'green',
            'rejected', 'withdrawn' => 'red',
            'review' => 'yellow',
            default => 'gray',
        };
    }
}
