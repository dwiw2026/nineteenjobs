<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('telegram_channels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('telegram_id')->nullable()->unique(); // Telegram user ID (numeric)
            $table->string('telegram_username')->nullable();
            $table->string('telegram_first_name')->nullable();
            $table->string('token_hash')->nullable(); // one-time link token hash
            $table->timestamp('linked_at')->nullable();
            $table->timestamps();

            $table->index('telegram_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telegram_channels');
    }
};
