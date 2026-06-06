<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * AI-generated essay evaluation results.
     * criterion_scores is JSON: {"content":{"score":12,"max":15},"language":{"score":11,"max":15},...}
     * inline_annotations is JSON: [{"position":45,"issue_type":"grammar","correction":"was","explanation":"Subject-verb agreement"}]
     * overridden_by is SET NULL: keep the override history even if admin is deleted.
     * CASCADE: if the writing submission is deleted, evaluations are removed.
     */
    public function up(): void
    {
        Schema::create('submission_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('writing_submission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rubric_id')->constrained()->restrictOnDelete();
            $table->decimal('total_score', 5, 2);
            $table->decimal('total_marks', 5, 2);
            $table->string('band_score', 5)->nullable();
            $table->json('criterion_scores');
            $table->json('inline_annotations')->nullable();
            $table->text('overall_comment')->nullable();
            $table->text('improved_excerpt')->nullable();
            $table->decimal('ai_confidence', 4, 3)->nullable();
            $table->foreignId('ai_interaction_id')->nullable()->constrained('ai_interaction_log')->nullOnDelete();
            $table->boolean('needs_admin_review')->default(false);
            $table->boolean('is_overridden')->default(false);
            $table->foreignId('overridden_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('overridden_at')->nullable();
            $table->timestamp('evaluated_at');
            $table->timestamps();

            $table->index('writing_submission_id');
            $table->index('needs_admin_review');
            $table->index('ai_interaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_evaluations');
    }
};
