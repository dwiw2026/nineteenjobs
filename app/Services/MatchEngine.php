<?php

namespace App\Services;

use App\Models\CandidateProfile;
use App\Models\JobListing;
use App\Models\JobMatch;
use App\Models\User;

class MatchEngine
{
    /**
     * Weights for each scoring dimension (must sum to 100).
     */
    private const WEIGHTS = [
        'skills' => 45,
        'experience' => 25,
        'location' => 15,
        'salary' => 15,
    ];

    /**
     * Calculate match score between a user and a job listing.
     * Returns the JobMatch model (created or updated).
     */
    public function calculate(User $user, JobListing $job): JobMatch
    {
        $profile = $user->candidateProfile;

        if (!$profile) {
            return $this->upsertMatch($user, $job, 0, [], [], []);
        }

        $userSkills = array_map('strtolower', $profile->skills ?? []);
        $requiredSkills = array_map('strtolower', $job->skills_required ?? []);

        [$skillScore, $skillOverlap, $missingSkills] = $this->scoreSkills($userSkills, $requiredSkills);
        $experienceScore = $this->scoreExperience($profile, $job);
        $locationScore = $this->scoreLocation($profile, $job);
        $salaryScore = $this->scoreSalary($profile, $job);

        $total = (int) round(
            ($skillScore * self::WEIGHTS['skills'] / 100)
            + ($experienceScore * self::WEIGHTS['experience'] / 100)
            + ($locationScore * self::WEIGHTS['location'] / 100)
            + ($salaryScore * self::WEIGHTS['salary'] / 100)
        );

        $reasons = $this->buildReasons($skillOverlap, $missingSkills, $experienceScore, $locationScore, $profile, $job);

        return $this->upsertMatch($user, $job, $total, $reasons, $skillOverlap, $missingSkills);
    }

    /**
     * Calculate and store matches for all published jobs for a user.
     */
    public function calculateAll(User $user): void
    {
        JobListing::published()->chunk(50, function ($jobs) use ($user) {
            foreach ($jobs as $job) {
                $this->calculate($user, $job);
            }
        });
    }

    // ── Private scoring methods ───────────────────────────────────

    private function scoreSkills(array $userSkills, array $requiredSkills): array
    {
        if (empty($requiredSkills)) {
            return [100, [], []];
        }

        $overlap = array_values(array_intersect($requiredSkills, $userSkills));
        $missing = array_values(array_diff($requiredSkills, $userSkills));

        $score = count($requiredSkills) > 0
            ? (int) round((count($overlap) / count($requiredSkills)) * 100)
            : 100;

        return [$score, $overlap, $missing];
    }

    private function scoreExperience(CandidateProfile $profile, JobListing $job): int
    {
        $minYears = $job->experience_years_min ?? 0;
        $userYears = $profile->experience_years ?? 0;

        if ($minYears === 0) {
            return 100;
        }

        if ($userYears >= $minYears) {
            // Slightly favor exact match over overqualified
            $overQualified = $userYears - $minYears;
            return $overQualified > 5 ? 80 : 100;
        }

        // Partial credit for close experience
        $ratio = $userYears / $minYears;

        return (int) round(max(0, $ratio * 100));
    }

    private function scoreLocation(CandidateProfile $profile, JobListing $job): int
    {
        // Remote jobs are always fine
        if ($job->work_type === 'remote') {
            return 100;
        }

        // If user has no location preference or job has no location, neutral
        if (!$profile->location || !$job->location) {
            return 70;
        }

        // Simple city-level match
        $userCity = strtolower(explode(',', $profile->location)[0]);
        $jobCity = strtolower(explode(',', $job->location)[0]);

        return $userCity === $jobCity ? 100 : 50;
    }

    private function scoreSalary(CandidateProfile $profile, JobListing $job): int
    {
        $preferred = $profile->preferred_salary_range;

        if (!$preferred || (!$job->salary_min && !$job->salary_max)) {
            return 80; // neutral when no salary info
        }

        $prefMin = $preferred['min'] ?? 0;
        $prefMax = $preferred['max'] ?? PHP_INT_MAX;
        $jobMin = $job->salary_min ?? 0;
        $jobMax = $job->salary_max ?? $jobMin;

        // Perfect overlap
        if ($jobMax >= $prefMin && $jobMin <= $prefMax) {
            return 100;
        }

        // Job pays less than preferred minimum
        if ($jobMax < $prefMin) {
            $gap = $prefMin - $jobMax;
            return (int) max(0, 100 - ($gap / $prefMin) * 100);
        }

        return 80;
    }

    private function buildReasons(
        array $overlap,
        array $missing,
        int $expScore,
        int $locScore,
        CandidateProfile $profile,
        JobListing $job
    ): array {
        $reasons = [];

        if (!empty($overlap)) {
            $reasons[] = 'Skill cocok: ' . implode(', ', array_slice($overlap, 0, 3));
        }

        if (!empty($missing)) {
            $reasons[] = 'Skill yang perlu dikembangkan: ' . implode(', ', array_slice($missing, 0, 3));
        }

        if ($expScore >= 80) {
            $reasons[] = 'Pengalaman sesuai dengan kebutuhan';
        }

        if ($job->work_type === 'remote') {
            $reasons[] = 'Posisi remote — fleksibel';
        }

        return $reasons;
    }

    private function upsertMatch(User $user, JobListing $job, int $score, array $reasons, array $overlap, array $missing): JobMatch
    {
        return JobMatch::updateOrCreate(
            ['user_id' => $user->id, 'job_listing_id' => $job->id],
            [
                'score' => $score,
                'reasons' => $reasons,
                'skill_overlap' => $overlap,
                'missing_skills' => $missing,
            ]
        );
    }
}
