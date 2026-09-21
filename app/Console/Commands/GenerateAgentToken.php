<?php

namespace App\Console\Commands;

use App\Models\AgentToken;
use Illuminate\Console\Command;

class GenerateAgentToken extends Command
{
    protected $signature = 'agent:token:generate
                            {name : Name/label for this token}
                            {--abilities= : Comma-separated abilities (default: *)}';

    protected $description = 'Generate a new Agent API token for Hermes integration';

    public function handle(): int
    {
        $name      = $this->argument('name');
        $abilities = $this->option('abilities')
            ? explode(',', $this->option('abilities'))
            : ['*'];

        [$raw, $token] = AgentToken::generate($name, $abilities);

        $this->newLine();
        $this->line('  <fg=green;options=bold>Agent token created successfully!</>');
        $this->newLine();
        $this->table(
            ['Field', 'Value'],
            [
                ['ID', $token->id],
                ['Name', $token->name],
                ['Abilities', implode(', ', $token->abilities)],
                ['Created at', $token->created_at->toDateTimeString()],
            ]
        );

        $this->newLine();
        $this->line('  <fg=yellow>Raw token (copy this — it will NOT be shown again):</>');
        $this->newLine();
        $this->line("  <fg=white;bg=black;options=bold>  {$raw}  </>");
        $this->newLine();
        $this->line('  Add to your .env:');
        $this->line("  <fg=cyan>NINETEENJOBS_AGENT_TOKEN={$raw}</>");
        $this->newLine();
        $this->line('  Add to Hermes .env:');
        $this->line("  <fg=cyan>NINETEENJOBS_AGENT_TOKEN={$raw}</>");
        $this->newLine();

        return self::SUCCESS;
    }
}
