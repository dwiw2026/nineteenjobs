<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelegramChannel extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id', 'telegram_id', 'telegram_username', 'telegram_first_name',
        'token_hash', 'linked_at',
    ];

    protected $hidden = ['token_hash'];

    protected function casts(): array
    {
        return [
            'linked_at' => 'datetime',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Accessors ─────────────────────────────────────────────────

    public function getIsLinkedAttribute(): bool
    {
        return $this->linked_at !== null;
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->telegram_username
            ? '@' . $this->telegram_username
            : ($this->telegram_first_name ?? 'Telegram User');
    }
}
