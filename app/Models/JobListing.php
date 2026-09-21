<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class JobListing extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'company_id', 'title', 'slug', 'description', 'requirements',
        'skills_required', 'salary_min', 'salary_max', 'location', 'work_type',
        'employment_type', 'experience_level', 'experience_years_min',
        'status', 'published_at', 'expires_at', 'views_count',
    ];

    protected function casts(): array
    {
        return [
            'skills_required' => 'array',
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function matches(): HasMany
    {
        return $this->hasMany(JobMatch::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function skillGaps(): HasMany
    {
        return $this->hasMany(SkillGap::class);
    }

    public function roadmaps(): HasMany
    {
        return $this->hasMany(CareerRoadmap::class);
    }

    // ── Scopes ────────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
    }

    public function scopeRemote($query)
    {
        return $query->where('work_type', 'remote');
    }

    public function scopeBySkill($query, string $skill)
    {
        return $query->whereJsonContains('skills_required', $skill);
    }

    // ── Accessors ─────────────────────────────────────────────────

    public function getSalaryRangeAttribute(): ?string
    {
        if (!$this->salary_min && !$this->salary_max) {
            return null;
        }

        $format = fn ($n) => 'Rp ' . number_format($n / 1_000_000, 0, ',', '.') . ' jt';

        if ($this->salary_min && $this->salary_max) {
            return $format($this->salary_min) . '–' . $format($this->salary_max);
        }

        return $format($this->salary_min ?? $this->salary_max);
    }

    public function getWorkTypeLabelAttribute(): string
    {
        return match ($this->work_type) {
            'remote' => 'Remote',
            'hybrid' => 'Hybrid',
            default => 'On-site',
        };
    }

    // ── Mutators ──────────────────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $job) {
            if (empty($job->slug)) {
                $job->slug = Str::slug($job->title) . '-' . Str::random(6);
            }
        });

        static::updating(function (self $job) {
            if ($job->isDirty('status') && $job->status === 'published' && !$job->published_at) {
                $job->published_at = now();
            }
        });
    }
}
