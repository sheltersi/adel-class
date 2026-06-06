<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Weekly breakdowns within a learning plan.
     * target_sub_skill_ids is a JSON array of sub_skill IDs this week focuses on.
     * CASCADE: if a plan is deleted, its weeks are removed.
     */
    public function up(): void
    {
        Schema::create('plan_weeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_plan_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('week_number');
            $table->string('theme')->nullable();
            $table->json('target_sub_skill_ids')->nullable();
            $table->timestamps();

            $table->unique(['learning_plan_id', 'week_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_weeks');
    }
};
