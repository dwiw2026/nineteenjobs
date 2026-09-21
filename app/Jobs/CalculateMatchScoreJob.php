<?php

namespace App\Jobs;

use App\Models\JobListing;
use App\Models\User;
use App\Services\MatchEngine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateMatchScoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(
        public readonly User $user,
        public readonly ?JobListing $jobListing = null,
    ) {}

    public function handle(MatchEngine $engine): void
    {
        if ($this->jobListing) {
            $engine->calculate($this->user, $this->jobListing);
        } else {
            $engine->calculateAll($this->user);
        }
    }
}
