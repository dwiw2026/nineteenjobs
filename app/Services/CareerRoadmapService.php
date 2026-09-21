<?php

namespace App\Services;

use App\Models\CareerRoadmap;
use App\Models\JobListing;
use App\Models\User;

class CareerRoadmapService
{
    /**
     * Generate a career roadmap for a user targeting a specific job.
     */
    public function generate(User $user, JobListing $job, int $durationDays = 30): CareerRoadmap
    {
        $profile = $user->candidateProfile;
        $userSkills = array_map('strtolower', $profile?->skills ?? []);
        $requiredSkills = array_map('strtolower', $job->skills_required ?? []);
        $missingSkills = array_values(array_diff($requiredSkills, $userSkills));

        $steps = $this->buildSteps($missingSkills, $durationDays, $job);

        return CareerRoadmap::create([
            'user_id' => $user->id,
            'job_listing_id' => $job->id,
            'title' => "Roadmap menuju {$job->title} di {$job->company->name}",
            'goal' => "Mempersiapkan diri untuk posisi {$job->title} dengan menguasai skill yang diperlukan dalam {$durationDays} hari.",
            'duration_days' => $durationDays,
            'steps' => $steps,
            'created_by_ai' => true,
            'progress_percent' => 0,
        ]);
    }

    /**
     * Generate a general career roadmap based on a goal description.
     */
    public function generateGeneral(User $user, string $goal, int $durationDays = 30): CareerRoadmap
    {
        $steps = $this->buildGeneralSteps($goal, $durationDays);

        return CareerRoadmap::create([
            'user_id' => $user->id,
            'title' => "Roadmap: {$goal}",
            'goal' => $goal,
            'duration_days' => $durationDays,
            'steps' => $steps,
            'created_by_ai' => true,
            'progress_percent' => 0,
        ]);
    }

    /**
     * Mark a step as completed and update overall progress.
     */
    public function completeStep(CareerRoadmap $roadmap, int $stepIndex): CareerRoadmap
    {
        $steps = $roadmap->steps;
        if (isset($steps[$stepIndex])) {
            $steps[$stepIndex]['completed'] = true;
            $steps[$stepIndex]['completed_at'] = now()->toIsoString();
        }

        $completed = count(array_filter($steps, fn ($s) => !empty($s['completed'])));
        $progress = count($steps) > 0 ? (int) round(($completed / count($steps)) * 100) : 0;

        $roadmap->update([
            'steps' => $steps,
            'progress_percent' => $progress,
            'completed_at' => $progress === 100 ? now() : null,
        ]);

        return $roadmap->fresh();
    }

    // ── Private step builders ─────────────────────────────────────

    private function buildSteps(array $missingSkills, int $durationDays, JobListing $job): array
    {
        $steps = [];
        $dayIncrement = max(1, (int) floor($durationDays / (count($missingSkills) + 3)));
        $currentDay = 1;

        // Step 1: Profile & preparation
        $steps[] = [
            'day' => $currentDay,
            'title' => 'Persiapan & Penyempurnaan Profil',
            'description' => 'Update profil, resume, dan LinkedIn agar mencerminkan skill yang sudah dimiliki. Riset lebih dalam tentang ' . $job->company->name . '.',
            'resources' => ['https://www.linkedin.com', 'https://canva.com/templates/resumes/'],
            'completed' => false,
        ];
        $currentDay += $dayIncrement;

        // Steps for missing skills
        foreach (array_slice($missingSkills, 0, 5) as $skill) {
            $steps[] = [
                'day' => $currentDay,
                'title' => "Pelajari {$skill}",
                'description' => "Kuasai dasar-dasar {$skill} yang dibutuhkan untuk posisi {$job->title}. Buat 1-2 project kecil menggunakan {$skill}.",
                'resources' => [$this->getResourceForSkill($skill)],
                'completed' => false,
            ];
            $currentDay += $dayIncrement;
        }

        // Step: Apply
        $lastDay = min($durationDays - 3, $currentDay);
        $steps[] = [
            'day' => $lastDay,
            'title' => 'Persiapan Interview & Lamaran',
            'description' => 'Latih jawaban pertanyaan interview umum, buat cover letter yang menarik, dan kirim lamaran ke ' . $job->title . ' di ' . $job->company->name . '.',
            'resources' => ['https://www.glassdoor.com/blog/common-interview-questions/'],
            'completed' => false,
        ];

        // Final step
        $steps[] = [
            'day' => $durationDays,
            'title' => 'Review & Evaluasi',
            'description' => 'Evaluasi progress, cek status lamaran, dan identifikasi area yang masih perlu ditingkatkan.',
            'resources' => [],
            'completed' => false,
        ];

        return $steps;
    }

    private function buildGeneralSteps(string $goal, int $durationDays): array
    {
        $phases = [
            ['title' => 'Riset & Perencanaan', 'description' => "Riset mendalam tentang: {$goal}. Buat rencana belajar dan tentukan resource utama."],
            ['title' => 'Fondasi & Dasar', 'description' => 'Pelajari konsep dasar dan bangun fondasi yang kuat.'],
            ['title' => 'Praktik & Implementasi', 'description' => 'Terapkan yang sudah dipelajari dengan membuat project nyata.'],
            ['title' => 'Penyempurnaan & Portfolio', 'description' => 'Perbaiki project, dokumentasikan, dan tambahkan ke portfolio.'],
            ['title' => 'Review & Langkah Selanjutnya', 'description' => 'Evaluasi progress dan rencanakan langkah selanjutnya.'],
        ];

        $dayIncrement = (int) floor($durationDays / count($phases));
        $steps = [];

        foreach ($phases as $index => $phase) {
            $steps[] = [
                'day' => max(1, $index * $dayIncrement + 1),
                'title' => $phase['title'],
                'description' => $phase['description'],
                'resources' => [],
                'completed' => false,
            ];
        }

        return $steps;
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
        ];

        return $resources[strtolower($skill)] ?? 'https://www.google.com/search?q=' . urlencode("belajar $skill");
    }
}
