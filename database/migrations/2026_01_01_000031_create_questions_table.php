<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The core question bank. Supports MCQ, short_answer, fill_blank,
     * true_false, matching, summary, and essay types.
     *
     * RESTRICT on topic delete: questions are valuable content.
     * rubric_id is SET NULL: if a rubric is retired, questions that used it
     * are flagged for reassignment rather than deleted.
     *
     * Composite index on (topic_id, difficulty) is the primary lookup path
     * for adaptive question selection ("find me an easy inference question").
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->restrictOnDelete();
            $table->string('question_type', 30); // mcq, short_answer, fill_blank, true_false, matching, summary, essay
            $table->unsignedTinyInteger('difficulty'); // 1 to 5
            $table->unsignedTinyInteger('marks')->default(1);
            $table->text('stem');
            $table->text('explanation')->nullable();
            $table->boolean('is_ai_scored')->default(false);
            $table->foreignId('rubric_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedSmallInteger('estimated_time_seconds')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('version')->default(1);
            $table->timestamps();

            $table->index(['topic_id', 'difficulty']);
            $table->index('question_type');
            $table->index('rubric_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
