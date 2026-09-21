<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_roadmaps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->uuid('job_listing_id')->nullable(); // optional: roadmap for specific job
            $table->foreign('job_listing_id')->references('id')->on('job_listings')->nullOnDelete();
            $table->string('title');
            $table->text('goal');
            $table->integer('duration_days')->default(30);
            $table->json('steps'); // [{day, title, description, resources[], completed}]
            $table->boolean('created_by_ai')->default(true);
            $table->integer('progress_percent')->default(0); // 0-100
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_roadmaps');
    }
};
