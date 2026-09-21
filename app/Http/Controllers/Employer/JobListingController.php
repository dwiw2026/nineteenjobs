<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobListingController extends Controller
{
    public function index(Request $request)
    {
        $company = $request->user()->company;

        if (!$company) {
            return redirect()->route('employer.company.create')
                ->with('error', 'Daftarkan perusahaan terlebih dahulu.');
        }

        $jobs = $company->jobListings()
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('employer.jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'requirements'      => 'nullable|string',
            'skills_required'   => 'nullable|string', // comma-separated
            'salary_min'        => 'nullable|integer|min:0',
            'salary_max'        => 'nullable|integer|min:0',
            'location'          => 'nullable|string|max:255',
            'work_type'         => 'required|in:remote,hybrid,onsite',
            'employment_type'   => 'required|in:full_time,part_time,contract,internship',
            'experience_level'  => 'nullable|in:junior,mid,senior,lead',
            'experience_years_min' => 'nullable|integer|min:0',
        ]);

        $company = $request->user()->company;

        if (!$company) {
            return redirect()->route('employer.company.create')
                ->with('error', 'Daftarkan perusahaan terlebih dahulu.');
        }

        $skills = $validated['skills_required'] ?? '';
        $skillsArray = array_filter(array_map('trim', explode(',', $skills)));

        $company->jobListings()->create([
            'title'              => $validated['title'],
            'slug'               => Str::slug($validated['title']) . '-' . Str::random(6),
            'description'        => $validated['description'],
            'requirements'       => $validated['requirements'] ?? null,
            'skills_required'    => $skillsArray,
            'salary_min'         => $validated['salary_min'] ?? null,
            'salary_max'         => $validated['salary_max'] ?? null,
            'location'           => $validated['location'] ?? $company->location,
            'work_type'          => $validated['work_type'],
            'employment_type'    => $validated['employment_type'],
            'experience_level'   => $validated['experience_level'] ?? null,
            'experience_years_min' => $validated['experience_years_min'] ?? 0,
            'status'             => 'draft',
        ]);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Lowongan berhasil dibuat! Publish saat siap.');
    }

    public function show(JobListing $job)
    {
        $job->load(['company', 'applications.user']);
        return view('employer.jobs.show', compact('job'));
    }

    public function edit(JobListing $job)
    {
        return view('employer.jobs.edit', compact('job'));
    }

    public function update(Request $request, JobListing $job)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'status'      => 'nullable|in:draft,published,closed',
        ]);

        $job->update($validated);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(JobListing $job)
    {
        $job->delete();

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Lowongan dihapus.');
    }
}
