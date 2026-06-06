<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reference/exemplar answers for subjective questions and essays.
     * Used by the AI evaluator to compare student answers against.
     * band_score identifies which grade band the model answer exemplifies.
     * Both FKs are SET NULL: if a prompt/question is deleted, the model
     * answer can still exist as a standalone reference.
     */
    public function up(): void
    {
        Schema::create('model_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('writing_prompt_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('question_id')->nullable()->constrained()->nullOnDelete();
            $table->mediumText('content');
            $table->string('band_score', 5)->nullable();
            $table->timestamps();

            $table->index('writing_prompt_id');
            $table->index('question_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_answers');
    }
};
