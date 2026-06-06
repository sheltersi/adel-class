<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Individual activities within a plan week.
     * Uses a polymorphic relationship: activity_target_type + activity_target_id
     * can point to questions, writing_prompts, or passages tables.
     * This avoids separate FK columns per target type.
     * CASCADE: if a plan week is deleted, its activities are removed.
     */
    public function up(): void
    {
        Schema::create('plan_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_week_id')->constrained()->cascadeOnDelete();
            $table->string('activity_type', 30); // question, writing, passage, drill, reflection
            $table->string('activity_target_type', 50); // questions, writing_prompts, passages
            $table->unsignedBigInteger('activity_target_id');
            $table->unsignedTinyInteger('sort_order');
            $table->boolean('is_optional')->default(false);
            $table->date('scheduled_date')->nullable();
            $table->timestamps();

            $table->index(['plan_week_id', 'sort_order'], 'pa_week_sort_idx');
            $table->index(['activity_target_type', 'activity_target_id'], 'pa_target_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_activities');
    }
};
