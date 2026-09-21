<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobListingController;
use App\Services\AgentService;
use Illuminate\Support\Facades\Route;

// ── Public routes ───────────────────────────────────────────────────────
Route::get('/', function () {
    $latestJobs = \App\Models\JobListing::with('company')
        ->published()
        ->latest('published_at')
        ->limit(3)
        ->get();

    $stats = [
        'talents' => \App\Models\User::where('role', 'job_seeker')->count(),
        'jobs'    => \App\Models\JobListing::where('status', 'published')->count(),
    ];

    return view('welcome', compact('latestJobs', 'stats'));
})->name('home');

Route::get('/jobs', [JobListingController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{jobListing:slug}', [JobListingController::class, 'show'])->name('jobs.show');

// ── Auth routes (Breeze default, overridden as needed) ──────────────────
require __DIR__ . '/auth.php';

// ── Authenticated routes ────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard — role-based
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Telegram linking
    Route::post('/telegram/link', function () {
        $user = auth()->user();
        $agentService = app(AgentService::class);
        $token = $agentService->generateLinkToken($user);
        $botUsername = config('services.telegram.bot_username', 'nineteenjobs_bot');
        $deepLink = "https://t.me/{$botUsername}?start=link_{$token}";

        return back()->with('success', "Link Telegram kamu: <a href='{$deepLink}' target='_blank' class='underline'>{$deepLink}</a> — Salin dan kirim ke bot.");
    })->name('telegram.link');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/candidate', [\App\Http\Controllers\ProfileController::class, 'updateCandidate'])->name('candidate.profile.update');

    // Job seeker routes
    Route::middleware('can:isJobSeeker')->group(function () {
        Route::prefix('my')->group(function () {
            Route::get('/matches', [\App\Http\Controllers\MatchController::class, 'index'])->name('matches.index');
            Route::get('/applications', fn () => view('applications.index'))->name('applications.index');
            Route::get('/roadmap', fn () => view('roadmap.index'))->name('roadmap.index');
        });
        Route::get('/agent', fn () => view('agent.chat'))->name('agent.chat');
    });

    // Employer routes
    Route::prefix('employer')->name('employer.')->group(function () {
        Route::resource('jobs', \App\Http\Controllers\Employer\JobListingController::class);
        Route::get('/applications', fn () => view('employer.applications.index'))->name('applications.index');
        Route::get('/company', \App\Http\Controllers\Employer\CompanyController::class . '@index')->name('company.index');
        Route::get('/company/create', \App\Http\Controllers\Employer\CompanyController::class . '@create')->name('company.create');
        Route::post('/company', \App\Http\Controllers\Employer\CompanyController::class . '@store')->name('company.store');
        Route::get('/company/{company}', \App\Http\Controllers\Employer\CompanyController::class . '@show')->name('company.show');
        Route::get('/company/{company}/edit', \App\Http\Controllers\Employer\CompanyController::class . '@edit')->name('company.edit');
        Route::patch('/company/{company}', \App\Http\Controllers\Employer\CompanyController::class . '@update')->name('company.update');
        Route::delete('/company/{company}', \App\Http\Controllers\Employer\CompanyController::class . '@destroy')->name('company.destroy');
        Route::get('/company/{company}/jobs/{job}', fn () => view('employer.jobs.show'))->name('jobs.show');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('can:admin')->group(function () {
        Route::get('/jobs', fn () => redirect()->route('dashboard'))->name('jobs.index');
    });
});
