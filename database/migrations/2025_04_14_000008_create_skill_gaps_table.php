<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skill_gaps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->uuid('job_listing_id')->nullable();
            $table->foreign('job_listing_id')->references('id')->on('job_listings')->nullOnDelete();
            $table->json('missing_skills'); // skills user lacks
            $table->json('present_skills')->nullable(); // skills user has
            $table->integer('score')->default(0); // overall readiness 0-100
            $table->text('analysis')->nullable(); // AI-generated analysis text
            $table->json('recommendations')->nullable(); // [{skill, resource, priority}]
            $table->timestamp('analyzed_at')->useCurrent();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_gaps');
    }
};
