<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AgentToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'token_hash', 'abilities', 'last_used_at', 'expires_at',
    ];

    protected $hidden = ['token_hash'];

    protected function casts(): array
    {
        return [
            'abilities' => 'array',
            'last_used_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    // ── Static helpers ────────────────────────────────────────────

    /**
     * Generate a new raw token and return both raw and model.
     */
    public static function generate(string $name, array $abilities = ['*']): array
    {
        $raw = Str::random(64);
        $model = self::create([
            'name' => $name,
            'token_hash' => hash('sha256', $raw),
            'abilities' => $abilities,
        ]);

        return [$raw, $model];
    }

    /**
     * Find a token by its raw value.
     */
    public static function findByRaw(string $raw): ?self
    {
        return self::where('token_hash', hash('sha256', $raw))->first();
    }

    // ── Accessors ─────────────────────────────────────────────────

    public function can(string $ability): bool
    {
        $abilities = $this->abilities ?? [];

        return in_array('*', $abilities) || in_array($ability, $abilities);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
