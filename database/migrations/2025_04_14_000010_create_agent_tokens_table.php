<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agent_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "Hermes NineteenJobs Plugin"
            $table->string('token_hash', 64)->unique(); // SHA-256 of the raw token
            $table->json('abilities')->nullable(); // allowed abilities/scopes
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agent_tokens');
    }
};
