<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tracks each student's proficiency in every sub-skill.
     * Unique on (student_profile_id, sub_skill_id): one score per student per sub-skill.
     * RESTRICT on delete: scores are critical data — don't silently lose them
     * if a profile or sub-skill is deleted without migration.
     */
    public function up(): void
    {
        Schema::create('student_sub_skill_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_profile_id')->constrained()->restrictOnDelete();
            $table->foreignId('sub_skill_id')->constrained()->restrictOnDelete();
            $table->decimal('proficiency_score', 5, 4); // 0.0000 to 1.0000
            $table->decimal('confidence_score', 5, 4)->default(0);
            $table->timestamp('last_updated_at');
            $table->timestamps();

            $table->unique(['student_profile_id', 'sub_skill_id']);
            $table->index('student_profile_id');
            $table->index('sub_skill_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_sub_skill_scores');
    }
};
