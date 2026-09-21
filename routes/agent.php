<?php

use App\Http\Controllers\AgentController;
use App\Http\Middleware\AgentTokenMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Agent API Routes (for Hermes NineteenJobs Plugin)
|--------------------------------------------------------------------------
|
| These routes are consumed exclusively by the Hermes agent plugin.
| All routes require a valid Bearer agent token.
| The Telegram user identity is passed via request body (telegram_id).
|
| Security layers:
|   1. AgentTokenMiddleware  — verifies Hermes Bearer token
|   2. AgentController::authorize — permission check per tool call
|   3. Laravel rate limiting  — 120 requests/minute per token
|
*/

Route::prefix('agent')->middleware([AgentTokenMiddleware::class, 'throttle:120,1'])->group(function () {

    // ── Context & Authorization ───────────────────────────────────
    Route::get('context', [AgentController::class, 'context']);
    Route::post('authorize', [AgentController::class, 'authorize']);

    // ── Public Job Tools ──────────────────────────────────────────
    Route::get('jobs/search', [AgentController::class, 'searchJobs']);
    Route::get('jobs/{id}', [AgentController::class, 'getJob']);
    Route::get('companies/{id}', [AgentController::class, 'getCompany']);

    // ── Job Seeker Tools (require linked Telegram account) ────────
    Route::get('profile', [AgentController::class, 'getProfile']);
    Route::get('matches', [AgentController::class, 'getMatches']);
    Route::get('skill-gap', [AgentController::class, 'getSkillGap']);
    Route::get('roadmap', [AgentController::class, 'getRoadmap']);
    Route::post('roadmap', [AgentController::class, 'createRoadmap']);
    Route::get('applications', [AgentController::class, 'getApplications']);

    // ── Telegram Linking ──────────────────────────────────────────
    Route::post('telegram/link', [AgentController::class, 'linkTelegram']);
});
