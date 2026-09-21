<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\TelegramChannel;
use App\Services\AgentService;
use App\Services\CareerRoadmapService;
use App\Services\MatchEngine;
use App\Services\SkillGapService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function __construct(
        private readonly AgentService $agentService,
        private readonly MatchEngine $matchEngine,
        private readonly SkillGapService $skillGapService,
        private readonly CareerRoadmapService $roadmapService,
    ) {}

    // ── Context & Authorization ───────────────────────────────────

    /**
     * GET /api/agent/context
     * Returns user context for the Hermes LLM.
     * Called by pre_llm_call hook in Hermes plugin.
     */
    public function context(Request $request): JsonResponse
    {
        $telegramId = $request->input('telegram_id');

        if (!$telegramId) {
            return response()->json(['error' => 'telegram_id required'], 422);
        }

        return response()->json($this->agentService->buildContext($telegramId));
    }

    /**
     * POST /api/agent/authorize
     * Checks if a Telegram user can execute a specific tool.
     * Called by pre_tool_call hook in Hermes plugin.
     */
    public function authorize(Request $request): JsonResponse
    {
        $telegramId = $request->input('telegram_id');
        $permission = $request->input('permission');

        if (!$telegramId || !$permission) {
            return response()->json(['error' => 'telegram_id and permission required'], 422);
        }

        $allowed = $this->agentService->authorize($telegramId, $permission);

        return response()->json([
            'allowed' => $allowed,
            'telegram_id' => $telegramId,
            'permission' => $permission,
        ], $allowed ? 200 : 403);
    }

    // ── Job Search ────────────────────────────────────────────────

    /**
     * GET /api/agent/jobs/search
     * nineteenjobs_search_jobs tool endpoint.
     */
    public function searchJobs(Request $request): JsonResponse
    {
        $query = JobListing::with('company')->published();

        if ($q = $request->input('q')) {
            $query->where(function ($qb) use ($q) {
                $qb->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($skill = $request->input('skill')) {
            $query->whereJsonContains('skills_required', strtolower($skill));
        }

        if ($workType = $request->input('work_type')) {
            $query->where('work_type', $workType);
        }

        if ($location = $request->input('location')) {
            $query->where('location', 'like', "%{$location}%");
        }

        if ($minSalary = $request->input('min_salary')) {
            $query->where('salary_min', '>=', (int) $minSalary * 1_000_000);
        }

        $jobs = $query->latest('published_at')->paginate(10);

        return response()->json([
            'total' => $jobs->total(),
            'data' => $jobs->map(fn ($job) => $this->formatJob($job)),
        ]);
    }

    /**
     * GET /api/agent/jobs/{id}
     * nineteenjobs_get_job tool endpoint.
     */
    public function getJob(string $id): JsonResponse
    {
        $job = JobListing::with('company')->published()->findOrFail($id);

        return response()->json($this->formatJob($job, detailed: true));
    }

    /**
     * GET /api/agent/companies/{id}
     * nineteenjobs_get_public_company tool endpoint.
     */
    public function getCompany(string $id): JsonResponse
    {
        $company = \App\Models\Company::withCount('publishedJobs')->findOrFail($id);

        return response()->json([
            'id' => $company->id,
            'name' => $company->name,
            'industry' => $company->industry,
            'size' => $company->size,
            'location' => $company->location,
            'description' => $company->description,
            'website' => $company->website,
            'is_verified' => $company->is_verified,
            'published_jobs_count' => $company->published_jobs_count,
            'logo_url' => $company->logo_url,
        ]);
    }

    // ── Candidate (Job Seeker) Tools ──────────────────────────────

    /**
     * GET /api/agent/profile
     * nineteenjobs_get_my_profile tool endpoint.
     */
    public function getProfile(Request $request): JsonResponse
    {
        $telegramId = $request->input('telegram_id');
        $user = $this->resolveUser($telegramId);

        if (!$user) {
            return response()->json(['error' => 'User not found. Link your Telegram account first.'], 404);
        }

        $profile = $user->candidateProfile;

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'headline' => $profile?->headline,
            'skills' => $profile?->skills ?? [],
            'experience_years' => $profile?->experience_years ?? 0,
            'location' => $profile?->location,
            'availability' => $profile?->availability ?? 'open',
            'profile_completeness' => $profile?->profile_completeness ?? 0,
            'linkedin_url' => $profile?->linkedin_url,
            'portfolio_url' => $profile?->portfolio_url,
        ]);
    }

    /**
     * GET /api/agent/matches
     * nineteenjobs_get_my_matches tool endpoint.
     */
    public function getMatches(Request $request): JsonResponse
    {
        $telegramId = $request->input('telegram_id');
        $user = $this->resolveUser($telegramId);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        // Calculate if no matches yet
        if ($user->matches()->count() === 0) {
            $this->matchEngine->calculateAll($user);
        }

        $matches = $user->matches()
            ->with('jobListing.company')
            ->ordered()
            ->limit(10)
            ->get();

        return response()->json([
            'total' => $matches->count(),
            'data' => $matches->map(fn ($m) => [
                'score' => $m->score,
                'reasons' => $m->reasons,
                'missing_skills' => $m->missing_skills,
                'job' => $this->formatJob($m->jobListing),
            ]),
        ]);
    }

    /**
     * GET /api/agent/skill-gap
     * nineteenjobs_get_skill_gap tool endpoint.
     */
    public function getSkillGap(Request $request): JsonResponse
    {
        $telegramId = $request->input('telegram_id');
        $user = $this->resolveUser($telegramId);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $aggregated = $this->skillGapService->getAggregatedGaps($user);

        return response()->json([
            'aggregated_missing_skills' => $aggregated,
            'message' => empty($aggregated)
                ? 'Belum ada analisis skill gap. Cari lowongan yang cocok terlebih dahulu.'
                : 'Berikut adalah skill yang paling sering muncul sebagai gap:',
        ]);
    }

    /**
     * GET /api/agent/roadmap
     * nineteenjobs_get_roadmap tool endpoint.
     */
    public function getRoadmap(Request $request): JsonResponse
    {
        $telegramId = $request->input('telegram_id');
        $user = $this->resolveUser($telegramId);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $roadmaps = $user->careerRoadmaps()->latest()->limit(5)->get();

        return response()->json([
            'total' => $roadmaps->count(),
            'data' => $roadmaps->map(fn ($r) => [
                'id' => $r->id,
                'title' => $r->title,
                'goal' => $r->goal,
                'duration_days' => $r->duration_days,
                'progress_percent' => $r->progress_percent,
                'completed_steps' => $r->completed_steps,
                'total_steps' => $r->total_steps,
                'is_completed' => $r->is_completed,
                'created_at' => $r->created_at->toDateString(),
            ]),
        ]);
    }

    /**
     * POST /api/agent/roadmap
     * nineteenjobs_create_roadmap tool endpoint.
     */
    public function createRoadmap(Request $request): JsonResponse
    {
        $telegramId = $request->input('telegram_id');
        $user = $this->resolveUser($telegramId);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $jobId = $request->input('job_listing_id');
        $goal = $request->input('goal');
        $days = (int) $request->input('duration_days', 30);

        if ($jobId) {
            $job = JobListing::with('company')->find($jobId);
            if (!$job) {
                return response()->json(['error' => 'Job listing not found.'], 404);
            }
            $roadmap = $this->roadmapService->generate($user, $job, $days);
        } elseif ($goal) {
            $roadmap = $this->roadmapService->generateGeneral($user, $goal, $days);
        } else {
            return response()->json(['error' => 'Provide job_listing_id or goal.'], 422);
        }

        return response()->json([
            'id' => $roadmap->id,
            'title' => $roadmap->title,
            'goal' => $roadmap->goal,
            'duration_days' => $roadmap->duration_days,
            'steps' => $roadmap->steps,
            'message' => "Roadmap berhasil dibuat! Ada {$roadmap->total_steps} langkah yang perlu diselesaikan dalam {$roadmap->duration_days} hari.",
        ], 201);
    }

    /**
     * GET /api/agent/applications
     * nineteenjobs_get_application_status tool endpoint.
     */
    public function getApplications(Request $request): JsonResponse
    {
        $telegramId = $request->input('telegram_id');
        $user = $this->resolveUser($telegramId);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $applications = $user->applications()
            ->with('jobListing.company')
            ->latest('applied_at')
            ->get();

        return response()->json([
            'total' => $applications->count(),
            'data' => $applications->map(fn ($app) => [
                'id' => $app->id,
                'job_title' => $app->jobListing->title,
                'company' => $app->jobListing->company->name,
                'status' => $app->status,
                'status_label' => $app->status_label,
                'applied_at' => $app->applied_at->toDateString(),
            ]),
        ]);
    }

    /**
     * POST /api/agent/telegram/link
     * nineteenjobs_link_telegram tool endpoint.
     */
    public function linkTelegram(Request $request): JsonResponse
    {
        $token = $request->input('token');
        $telegramUser = $request->input('telegram_user'); // {id, username, first_name}

        if (!$token || !$telegramUser || !isset($telegramUser['id'])) {
            return response()->json(['error' => 'token and telegram_user.id required'], 422);
        }

        $service = app(\App\Services\TelegramLinkService::class);
        $result = $service->processLinkCommand($token, $telegramUser);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    // ── Private helpers ───────────────────────────────────────────

    private function resolveUser(string $telegramId): ?\App\Models\User
    {
        return TelegramChannel::where('telegram_id', $telegramId)
            ->whereNotNull('linked_at')
            ->with('user')
            ->first()
            ?->user;
    }

    private function formatJob(JobListing $job, bool $detailed = false): array
    {
        $data = [
            'id' => $job->id,
            'title' => $job->title,
            'company' => $job->company?->name,
            'company_id' => $job->company_id,
            'location' => $job->location,
            'work_type' => $job->work_type,
            'work_type_label' => $job->work_type_label,
            'salary_range' => $job->salary_range,
            'employment_type' => $job->employment_type,
            'experience_level' => $job->experience_level,
            'skills_required' => $job->skills_required ?? [],
            'published_at' => $job->published_at?->toDateString(),
        ];

        if ($detailed) {
            $data['description'] = $job->description;
            $data['requirements'] = $job->requirements;
        }

        return $data;
    }
}
