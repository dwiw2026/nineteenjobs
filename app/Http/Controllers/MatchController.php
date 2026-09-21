<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Ensure match scores are updated before viewing
        \App\Jobs\CalculateMatchScoreJob::dispatchSync($user);

        $matches = $user->matches()
            ->with('jobListing.company')
            ->orderByDesc('score')
            ->paginate(10);

        return view('matches.index', compact('matches'));
    }
}
