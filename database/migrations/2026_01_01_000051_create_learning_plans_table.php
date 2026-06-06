<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * AI-generated learning plans. Each plan is a multi-week study program
     * targeting a student's weakest sub-skills.
     *
     * ai_interaction_id is SET NULL: if the AI log is purged, the plan
     * remains usable without the generation audit trail.
     */
    public function up(): void
    {
        Schema::create('learning_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_profile_id')->constrained()->restrictOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status', 20)->default('active'); // active, completed, paused, abandoned
            $table->unsignedTinyInteger('total_weeks');
            $table->timestamp('generated_at');
            $table->foreignId('ai_interaction_id')->nullable()->constrained('ai_interaction_log')->nullOnDelete();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['student_profile_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_plans');
    }
};
