<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Assessments represent any test instance: diagnostic placement tests,
     * milestone check-ins, mock full-length exams, and practice tests.
     *
     * time_remaining_seconds is updated on each auto-save during timed
     * exams so the student can resume with the correct remaining time
     * after a disconnect.
     *
     * RESTRICT on delete: assessments are primary data records.
     */
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_profile_id')->constrained()->restrictOnDelete();
            $table->string('assessment_type', 30); // diagnostic, milestone, mock, practice
            $table->string('paper', 20)->nullable(); // Paper 1, Paper 2, Full
            $table->string('status', 20)->default('pending'); // pending, in_progress, completed, expired
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->unsignedInteger('time_limit_seconds')->nullable();
            $table->unsignedInteger('time_remaining_seconds')->nullable();
            $table->unsignedSmallInteger('total_marks')->nullable();
            $table->timestamps();

            $table->index(['student_profile_id', 'assessment_type']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
