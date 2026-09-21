<?php

namespace App\Services;

use App\Models\JobListing;
use App\Models\SkillGap;
use App\Models\User;

class SkillGapService
{
    /**
     * Analyze skill gap for a user against a specific job.
     */
    public function analyzeForJob(User $user, JobListing $job): SkillGap
    {
        $profile = $user->candidateProfile;
        $userSkills = array_map('strtolower', $profile?->skills ?? []);
        $requiredSkills = array_map('strtolower', $job->skills_required ?? []);

        $present = array_values(array_intersect($requiredSkills, $userSkills));
        $missing = array_values(array_diff($requiredSkills, $userSkills));

        $score = empty($requiredSkills)
            ? 100
            : (int) round((count($present) / count($requiredSkills)) * 100);

        $analysis = $this->buildAnalysis($present, $missing, $score, $job);
        $recommendations = $this->buildRecommendations($missing);

        return SkillGap::updateOrCreate(
            ['user_id' => $user->id, 'job_listing_id' => $job->id],
            [
                'missing_skills' => $missing,
                'present_skills' => $present,
                'score' => $score,
                'analysis' => $analysis,
                'recommendations' => $recommendations,
                'analyzed_at' => now(),
            ]
        );
    }

    /**
     * Analyze skill gap against top matches.
     */
    public function analyzeFromMatches(User $user, int $limit = 5): array
    {
        $topMatches = $user->matches()
            ->with('jobListing')
            ->ordered()
            ->limit($limit)
            ->get();

        return $topMatches->map(function ($match) use ($user) {
            return $this->analyzeForJob($user, $match->jobListing);
        })->all();
    }

    /**
     * Get aggregated missing skills across top matches.
     */
    public function getAggregatedGaps(User $user, int $limit = 5): array
    {
        $gaps = SkillGap::where('user_id', $user->id)
            ->latest('analyzed_at')
            ->limit($limit)
            ->get();

        $skillFrequency = [];
        foreach ($gaps as $gap) {
            foreach ($gap->missing_skills ?? [] as $skill) {
                $skillFrequency[$skill] = ($skillFrequency[$skill] ?? 0) + 1;
            }
        }

        arsort($skillFrequency);

        return array_map(
            fn ($skill, $count) => ['skill' => $skill, 'frequency' => $count, 'recommendation' => $this->getResourceForSkill($skill)],
            array_keys($skillFrequency),
            $skillFrequency
        );
    }

    // ── Private helpers ───────────────────────────────────────────

    private function buildAnalysis(array $present, array $missing, int $score, JobListing $job): string
    {
        $presentStr = !empty($present) ? implode(', ', $present) : 'belum ada';
        $missingStr = !empty($missing) ? implode(', ', $missing) : 'tidak ada';

        return sprintf(
            'Kamu sudah menguasai %d dari %d skill yang dibutuhkan untuk posisi %s (%d%% kesiapan). '
            . 'Skill yang sudah kamu miliki: %s. '
            . 'Skill yang perlu dikembangkan: %s.',
            count($present),
            count($present) + count($missing),
            $job->title,
            $score,
            $presentStr,
            $missingStr
        );
    }

    private function buildRecommendations(array $missingSkills): array
    {
        return array_map(fn ($skill) => [
            'skill' => $skill,
            'priority' => $this->getPriority($skill),
            'resource' => $this->getResourceForSkill($skill),
        ], array_slice($missingSkills, 0, 5));
    }

    private function getPriority(string $skill): string
    {
        $highPriority = ['react', 'typescript', 'python', 'laravel', 'sql', 'docker', 'kubernetes', 'go', 'rust'];

        return in_array(strtolower($skill), $highPriority) ? 'high' : 'medium';
    }

    private function getResourceForSkill(string $skill): string
    {
        $resources = [
            'react' => 'https://react.dev/learn',
            'typescript' => 'https://www.typescriptlang.org/docs/',
            'laravel' => 'https://laravel.com/docs',
            'python' => 'https://docs.python.org/3/tutorial/',
            'docker' => 'https://docs.docker.com/get-started/',
            'sql' => 'https://www.w3schools.com/sql/',
            'javascript' => 'https://javascript.info',
            'vue' => 'https://vuejs.org/guide/introduction',
            'node' => 'https://nodejs.org/en/learn/getting-started/introduction-to-nodejs',
        ];

        return $resources[strtolower($skill)] ?? 'https://www.google.com/search?q=' . urlencode("belajar $skill");
    }
}
