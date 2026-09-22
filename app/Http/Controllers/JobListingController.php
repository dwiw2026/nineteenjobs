<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index(Request $request)
    {
        $query = JobListing::with('company')->published();

        if ($q = $request->input('q')) {
            $query->where(fn ($qb) =>
                $qb->where('title', 'like', "%$q%")
                   ->orWhere('description', 'like', "%$q%")
            );
        }

        if ($wt = $request->input('work_type')) {
            $query->where('work_type', $wt);
        }

        if ($loc = $request->input('location')) {
            $query->where('location', 'like', "%$loc%");
        }

        $jobs = $query->latest('published_at')->paginate(12)->withQueryString();

        return view('jobs.index', compact('jobs'));
    }

    public function show(JobListing $jobListing)
    {
        abort_if($jobListing->status !== 'published', 404);

        $jobListing->increment('views_count');
        $jobListing->load('company');

        $similar = JobListing::with('company')
            ->published()
            ->where('id', '!=', $jobListing->id)
            ->where('company_id', $jobListing->company_id)
            ->limit(3)
            ->get();

        return view('jobs.show', compact('jobListing', 'similar'));
    }

    public function apply(Request $request, JobListing $jobListing)
    {
        abort_if($jobListing->status !== 'published', 404);
        
        $user = $request->user();

        if ($user->applications()->where('job_listing_id', $jobListing->id)->exists()) {
            return back()->with('error', 'Anda sudah melamar pekerjaan ini.');
        }

        $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
        ]);

        $user->applications()->create([
            'job_listing_id' => $jobListing->id,
            'cover_letter' => $request->input('cover_letter'),
            'resume_path' => $user->candidateProfile?->resume_path,
        ]);

        return redirect()->route('applications.index')->with('success', 'Berhasil melamar pekerjaan!');
    }
}
