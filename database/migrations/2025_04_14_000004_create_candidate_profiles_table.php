<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('headline')->nullable(); // e.g. "Frontend Developer with 3 years React experience"
            $table->text('bio')->nullable();
            $table->json('skills')->nullable(); // array of skill strings
            $table->integer('experience_years')->default(0);
            $table->string('current_role')->nullable();
            $table->string('current_company')->nullable();
            $table->string('location')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('availability')->default('open'); // open, not_looking, employed
            $table->json('looking_for')->nullable(); // work types they want: remote, hybrid, etc.
            $table->json('preferred_salary_range')->nullable(); // {min, max}
            $table->unsignedInteger('profile_completeness')->default(0); // 0-100
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_profiles');
    }
};
