<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\SkillGapService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyzeSkillGapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(
        public readonly User $user,
        public readonly int $limit = 5,
    ) {}

    public function handle(SkillGapService $service): void
    {
        $service->analyzeFromMatches($this->user, $this->limit);
    }
}
