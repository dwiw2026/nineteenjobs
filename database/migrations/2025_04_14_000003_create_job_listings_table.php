<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->longText('requirements')->nullable();
            $table->json('skills_required')->nullable(); // array of skill strings
            $table->unsignedBigInteger('salary_min')->nullable();
            $table->unsignedBigInteger('salary_max')->nullable();
            $table->string('location')->nullable();
            $table->string('work_type')->default('onsite'); // remote, hybrid, onsite
            $table->string('employment_type')->default('full_time'); // full_time, part_time, contract, internship
            $table->string('experience_level')->nullable(); // junior, mid, senior, lead
            $table->integer('experience_years_min')->default(0);
            $table->string('status')->default('draft'); // draft, published, closed, expired
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'published_at']);
            $table->index('company_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
