<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $company = $request->user()->company;

        if (!$company) {
            return redirect()->route('employer.company.create')
                ->with('info', 'Belum ada perusahaan terdaftar. Daftarkan sekarang.');
        }

        $applications = Application::query()
            ->whereHas('jobListing', fn ($query) => $query->where('company_id', $company->id))
            ->with(['user', 'jobListing'])
            ->latest('applied_at')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('employer.applications.index', compact('applications', 'company'));
    }

    public function show(Request $request, Application $application)
    {
        $company = $request->user()->company;
        $this->ensureBelongsToCompany($application, $company?->id);

        $application->load(['user.candidateProfile', 'jobListing.company']);

        return view('employer.applications.show', compact('application', 'company'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $company = $request->user()->company;
        $this->ensureBelongsToCompany($application, $company?->id);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,review,interview,offered,rejected'],
            'employer_notes' => ['nullable', 'string', 'max:5000'],
            'interview_at' => ['nullable', 'date', 'required_if:status,interview'],
            'interview_location' => ['nullable', 'string', 'max:255'],
        ]);

        $application->update([
            'status' => $validated['status'],
            'employer_notes' => $validated['employer_notes'] ?? null,
            'interview_at' => $validated['status'] === 'interview' ? ($validated['interview_at'] ?? null) : null,
            'interview_location' => $validated['status'] === 'interview' ? ($validated['interview_location'] ?? null) : null,
            'status_updated_at' => now(),
        ]);

        return back()->with('success', 'Status pelamar berhasil diperbarui.');
    }

    public function resume(Request $request, Application $application)
    {
        $company = $request->user()->company;
        $this->ensureBelongsToCompany($application, $company?->id);

        $application->load('user.candidateProfile');
        $resumePath = $application->resume_path ?: $application->user->candidateProfile?->resume_path;

        abort_unless($resumePath && Storage::disk('public')->exists($resumePath), 404, 'CV tidak ditemukan.');

        return response()->file(Storage::disk('public')->path($resumePath));
    }

    private function ensureBelongsToCompany(Application $application, ?string $companyId): void
    {
        abort_unless($companyId && $application->jobListing()->where('company_id', $companyId)->exists(), 404);
    }
}
