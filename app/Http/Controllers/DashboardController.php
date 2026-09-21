<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobListing;
use App\Models\JobMatch;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        if ($user->isEmployer()) {
            return $this->employerDashboard($user);
        }

        return $this->jobSeekerDashboard($user);
    }

    private function adminDashboard()
    {
        $stats = [
            'total_talents'      => User::where('role', 'job_seeker')->count(),
            'active_jobs'        => JobListing::where('status', 'published')->count(),
            'total_matches'      => JobMatch::where('score', '>=', 70)->count(),
            'verified_companies' => Company::whereNotNull('verified_at')->count(),
            'ai_recommendations' => JobMatch::count(),
            'talent_growth'      => '12.8',
            'job_growth'         => '8.4',
            'match_growth'       => '18.2',
            'company_growth'     => '6.1',
        ];

        $recentJobs = JobListing::with('company')
            ->withCount('applications')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'recentJobs'));
    }

    private function employerDashboard(User $user)
    {
        $company = $user->company;

        if (!$company) {
            return view('dashboard.employer', compact('company'));
        }

        $activeJobs = $company->jobListings()
            ->withCount('applications')
            ->where('status', 'published')
            ->latest()
            ->limit(5)
            ->get();

        $recentApplicants = Application::whereHas('jobListing', fn ($q) => $q->where('company_id', $company->id))
            ->with(['user', 'jobListing'])
            ->latest()
            ->limit(5)
            ->get();

        $stats = [
            'active_jobs'       => $company->publishedJobs()->count(),
            'total_applicants'  => Application::whereHas('jobListing', fn ($q) => $q->where('company_id', $company->id))->count(),
            'new_applicants'    => Application::whereHas('jobListing', fn ($q) => $q->where('company_id', $company->id))->where('status', 'pending')->count(),
            'response_rate'     => 85,
        ];

        return view('dashboard.employer', compact('company', 'activeJobs', 'recentApplicants', 'stats'));
    }

    private function jobSeekerDashboard(User $user)
    {
        $topMatches = $user->matches()
            ->with('jobListing.company')
            ->orderByDesc('score')
            ->limit(3)
            ->get();

        $recentApplications = $user->applications()
            ->with('jobListing.company')
            ->latest('applied_at')
            ->limit(3)
            ->get();

        $applicationCount = $user->applications()->count();
        $matchCount       = $user->matches()->where('score', '>=', 70)->count();
        $roadmapCount     = $user->careerRoadmaps()->count();

        return view('dashboard.job-seeker', compact(
            'topMatches', 'recentApplications',
            'applicationCount', 'matchCount', 'roadmapCount'
        ));
    }
}
