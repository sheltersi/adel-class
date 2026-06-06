<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Student writing submissions (essays, summaries, directed writing).
     * assessment_id is SET NULL: if the assessment is deleted, the writing
     * still exists as a standalone submission for the student's portfolio.
     * status flow: draft → submitted → evaluating → evaluated → reviewed.
     */
    public function up(): void
    {
        Schema::create('writing_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_profile_id')->constrained()->restrictOnDelete();
            $table->foreignId('writing_prompt_id')->constrained()->restrictOnDelete();
            $table->foreignId('assessment_id')->nullable()->constrained()->nullOnDelete();
            $table->mediumText('content');
            $table->unsignedSmallInteger('word_count')->nullable();
            $table->unsignedInteger('time_spent_seconds')->nullable();
            $table->string('status', 20)->default('submitted'); // draft, submitted, evaluating, evaluated, reviewed
            $table->timestamp('auto_saved_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->index(['student_profile_id', 'submitted_at']);
            $table->index('writing_prompt_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('writing_submissions');
    }
};
