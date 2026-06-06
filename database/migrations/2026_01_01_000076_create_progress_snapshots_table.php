<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Periodic snapshots of a student's skill profile for trend analysis.
     * skill_scores_json freezes the current state of all sub-skill scores
     * at a point in time so we can chart improvement over weeks.
     * ai_interaction_id is SET NULL: the snapshot stays even if the AI log is purged.
     */
    public function up(): void
    {
        Schema::create('progress_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_profile_id')->constrained()->restrictOnDelete();
            $table->string('snapshot_type', 20); // weekly, milestone, manual
            $table->json('skill_scores_json');
            $table->string('estimated_grade', 5)->nullable();
            $table->unsignedInteger('activities_completed')->default(0);
            $table->unsignedInteger('total_time_minutes')->default(0);
            $table->text('ai_insight')->nullable();
            $table->foreignId('ai_interaction_id')->nullable()->constrained('ai_interaction_log')->nullOnDelete();
            $table->timestamp('captured_at');
            $table->timestamps();

            $table->index(['student_profile_id', 'captured_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress_snapshots');
    }
};
