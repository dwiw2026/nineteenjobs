<?php

namespace App\Services;

use App\Models\TelegramChannel;
use App\Models\User;
use Illuminate\Support\Str;

class TelegramLinkService
{
    public function __construct(
        private readonly AgentService $agentService
    ) {}

    /**
     * Generate a link token and return the Telegram bot deep-link URL.
     */
    public function generateDeepLink(User $user): string
    {
        $token = $this->agentService->generateLinkToken($user);
        $botUsername = config('services.telegram.bot_username');

        return "https://t.me/{$botUsername}?start=link_{$token}";
    }

    /**
     * Process /start link_{token} command from Telegram webhook.
     */
    public function processLinkCommand(string $token, array $telegramUser): array
    {
        $telegramId = (string) $telegramUser['id'];
        $username = $telegramUser['username'] ?? null;
        $firstName = $telegramUser['first_name'] ?? null;

        // Check if already linked to another account
        $existing = TelegramChannel::where('telegram_id', $telegramId)
            ->whereNotNull('linked_at')
            ->first();

        if ($existing) {
            return ['success' => false, 'message' => 'Akun Telegram ini sudah terhubung ke akun lain.'];
        }

        $linked = $this->agentService->linkTelegram($token, $telegramId, $username, $firstName);

        if (!$linked) {
            return ['success' => false, 'message' => 'Token tidak valid atau sudah kadaluarsa. Silakan generate link baru dari dashboard NineteenJobs.'];
        }

        // Find the user linked to this channel
        $channel = TelegramChannel::where('telegram_id', $telegramId)->with('user')->first();

        return [
            'success' => true,
            'message' => "Akun Telegram kamu berhasil terhubung ke NineteenJobs sebagai {$channel->user->name}! Sekarang kamu bisa menggunakan Career Agent.",
            'user_name' => $channel->user->name,
        ];
    }
}
