<?php

namespace App\Services;

use App\Models\AgentToken;
use App\Models\TelegramChannel;
use App\Models\User;
use Illuminate\Support\Str;

class AgentService
{
    /**
     * Build context object for a Telegram user.
     * This is what Hermes sends to the LLM to understand user permissions.
     */
    public function buildContext(string $telegramId): array
    {
        $channel = TelegramChannel::where('telegram_id', $telegramId)
            ->with('user.candidateProfile', 'user.company')
            ->first();

        if (!$channel || !$channel->is_linked) {
            return [
                'mode' => 'guest',
                'authenticated' => false,
                'telegram_id' => $telegramId,
                'permissions' => [
                    'jobs.search.public',
                    'company.read.public',
                ],
            ];
        }

        $user = $channel->user;

        return match ($user->role) {
            'employer' => $this->buildEmployerContext($user),
            'admin' => $this->buildAdminContext($user),
            default => $this->buildJobSeekerContext($user),
        };
    }

    /**
     * Verify that a Telegram user has a specific permission.
     * Used by pre_tool_call hook in Hermes plugin.
     */
    public function authorize(string $telegramId, string $permission): bool
    {
        $context = $this->buildContext($telegramId);

        return in_array($permission, $context['permissions'] ?? [])
            || in_array('*', $context['permissions'] ?? []);
    }

    /**
     * Generate a one-time link token for linking Telegram to a user account.
     */
    public function generateLinkToken(User $user): string
    {
        $token = Str::random(32);

        TelegramChannel::updateOrCreate(
            ['user_id' => $user->id],
            ['token_hash' => hash('sha256', $token)]
        );

        return $token;
    }

    /**
     * Link a Telegram account using the one-time token.
     */
    public function linkTelegram(string $token, string $telegramId, string $username = null, string $firstName = null): bool
    {
        $channel = TelegramChannel::where('token_hash', hash('sha256', $token))->first();

        if (!$channel) {
            return false;
        }

        $channel->update([
            'telegram_id' => $telegramId,
            'telegram_username' => $username,
            'telegram_first_name' => $firstName,
            'token_hash' => null,
            'linked_at' => now(),
        ]);

        return true;
    }

    // ── Context builders ──────────────────────────────────────────

    private function buildJobSeekerContext(User $user): array
    {
        return [
            'mode' => 'job_seeker',
            'authenticated' => true,
            'user_id' => (string) $user->id,
            'name' => $user->name,
            'profile_completeness' => $user->candidateProfile?->profile_completeness ?? 0,
            'permissions' => [
                'jobs.search.public',
                'jobs.read.public',
                'company.read.public',
                'profile.read.self',
                'profile.update.self',
                'matches.read.self',
                'skill_gap.read.self',
                'roadmap.read.self',
                'roadmap.create.self',
                'applications.read.self',
                'applications.create.self',
                'telegram.link.self',
            ],
        ];
    }

    private function buildEmployerContext(User $user): array
    {
        return [
            'mode' => 'employer',
            'authenticated' => true,
            'user_id' => (string) $user->id,
            'company_id' => $user->company ? (string) $user->company->id : null,
            'verified' => $user->company?->is_verified ?? false,
            'name' => $user->name,
            'permissions' => [
                'jobs.search.public',
                'jobs.read.public',
                'company.read.public',
                'company.read.self',
                'company.update.self',
                'jobs.read.own',
                'jobs.create.own',
                'jobs.update.own',
                'candidates.read.own_jobs',
                'applications.read.own_jobs',
            ],
        ];
    }

    private function buildAdminContext(User $user): array
    {
        return [
            'mode' => 'admin',
            'authenticated' => true,
            'user_id' => (string) $user->id,
            'name' => $user->name,
            'permissions' => ['*'],
        ];
    }
}
