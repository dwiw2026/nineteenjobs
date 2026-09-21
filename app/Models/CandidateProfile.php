<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateProfile extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id', 'headline', 'bio', 'skills', 'experience_years',
        'current_role', 'current_company', 'location', 'resume_path',
        'linkedin_url', 'portfolio_url', 'github_url', 'availability',
        'looking_for', 'preferred_salary_range', 'profile_completeness',
    ];

    protected function casts(): array
    {
        return [
            'skills' => 'array',
            'looking_for' => 'array',
            'preferred_salary_range' => 'array',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Accessors ─────────────────────────────────────────────────

    public function getSkillListAttribute(): string
    {
        return implode(', ', $this->skills ?? []);
    }

    public function getResumeUrlAttribute(): ?string
    {
        return $this->resume_path ? asset('storage/' . $this->resume_path) : null;
    }

    // ── Helpers ───────────────────────────────────────────────────

    /**
     * Recalculate and update profile completeness score.
     */
    public function recalculateCompleteness(): void
    {
        $fields = [
            'headline' => 15,
            'bio' => 10,
            'skills' => 20,
            'experience_years' => 10,
            'current_role' => 10,
            'location' => 5,
            'resume_path' => 20,
            'linkedin_url' => 5,
            'portfolio_url' => 5,
        ];

        $total = 0;
        foreach ($fields as $field => $points) {
            $value = $this->$field;
            if (!empty($value)) {
                $total += $points;
            }
        }

        $this->update(['profile_completeness' => min(100, $total)]);
    }
}
