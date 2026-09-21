<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->uuid('job_listing_id');
            $table->foreign('job_listing_id')->references('id')->on('job_listings')->cascadeOnDelete();
            $table->unsignedInteger('score')->default(0); // 0-100
            $table->json('reasons')->nullable(); // array of reasons for the match
            $table->json('skill_overlap')->nullable(); // matched skills
            $table->json('missing_skills')->nullable(); // skills not in profile
            $table->string('status')->default('pending'); // pending, viewed, saved, dismissed
            $table->timestamps();

            $table->unique(['user_id', 'job_listing_id']);
            $table->index(['user_id', 'score']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
