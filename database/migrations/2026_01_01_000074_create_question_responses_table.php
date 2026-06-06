<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Student answers to individual assessment questions.
     * selected_option_id is SET NULL: if an MCQ option is modified/deleted,
     * the response record stays but loses the direct option link.
     * ai_interaction_id is SET NULL: the answer stays even if the AI log is purged.
     */
    public function up(): void
    {
        Schema::create('question_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_question_id')->constrained()->cascadeOnDelete();
            $table->text('student_answer')->nullable();
            $table->foreignId('selected_option_id')->nullable()->constrained('question_options')->nullOnDelete();
            $table->decimal('score', 5, 2)->nullable();
            $table->decimal('max_score', 5, 2);
            $table->boolean('is_correct')->nullable();
            $table->boolean('is_ai_scored')->default(false);
            $table->decimal('ai_confidence', 4, 3)->nullable();
            $table->text('ai_feedback')->nullable();
            $table->foreignId('ai_interaction_id')->nullable()->constrained('ai_interaction_log')->nullOnDelete();
            $table->unsignedSmallInteger('time_spent_seconds')->nullable();
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();

            $table->index('assessment_question_id');
            $table->index('ai_interaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_responses');
    }
};
