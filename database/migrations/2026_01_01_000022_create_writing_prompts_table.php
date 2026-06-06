<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Writing prompts are the essay/scenario questions students respond to.
     * mark_scheme_json stores structured marking points (e.g., bullet points
     * the student should cover in a summary) as a JSON array.
     * rubric_id is SET NULL on rubric deletion: the prompt still exists,
     * but must be reassigned to a new rubric before it can be used again.
     */
    public function up(): void
    {
        Schema::create('writing_prompts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->restrictOnDelete();
            $table->string('prompt_type', 30); // narrative, descriptive, argumentative, discursive, directed, summary
            $table->string('title');
            $table->text('scenario');
            $table->unsignedSmallInteger('word_limit_min')->nullable();
            $table->unsignedSmallInteger('word_limit_max');
            $table->unsignedTinyInteger('suggested_time_minutes')->nullable();
            $table->unsignedTinyInteger('difficulty')->default(1);
            $table->foreignId('rubric_id')->nullable()->constrained()->nullOnDelete();
            $table->json('mark_scheme_json')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('topic_id');
            $table->index('rubric_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('writing_prompts');
    }
};
