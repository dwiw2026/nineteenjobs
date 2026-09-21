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
}
