<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Audit log of every AI API call. Critical for:
     * - Cost tracking and budget alerts
     * - Prompt debugging (what context was sent?)
     * - Response validation (did the AI return valid JSON?)
     * - Rate limiting (how many calls has this student made today?)
     *
     * All FK columns are SET NULL on delete: the log is an immutable
     * audit trail. Even if a student or prompt is deleted, we keep the
     * record for billing and debugging.
     */
    public function up(): void
    {
        Schema::create('ai_interaction_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('student_profile_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('prompt_template_id')->nullable()->constrained()->nullOnDelete();
            $table->string('engine_type', 50);
            $table->string('model', 50);
            $table->text('system_prompt');
            $table->text('user_prompt');
            $table->json('response_json')->nullable();
            $table->text('response_raw')->nullable();
            $table->unsignedInteger('input_tokens')->nullable();
            $table->unsignedInteger('output_tokens')->nullable();
            $table->decimal('cost_usd', 10, 6)->nullable();
            $table->unsignedInteger('latency_ms')->nullable();
            $table->boolean('is_success')->default(true);
            $table->text('error_message')->nullable();
            $table->timestamp('called_at');
            $table->timestamps();

            $table->index(['user_id', 'called_at']);
            $table->index(['student_profile_id', 'called_at']);
            $table->index(['engine_type', 'called_at']);
            $table->index('is_success');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_interaction_log');
    }
};
