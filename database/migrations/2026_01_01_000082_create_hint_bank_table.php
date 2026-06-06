<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pre-authored hint bank organized by sub-skill and error pattern.
     * Used as a fallback when the AI hint generator is unavailable
     * or to reduce API costs for common mistakes.
     *
     * hint_level: 1 = gentle nudge, 2 = more direct hint, 3 = near-answer.
     * The system escalates through levels if the student keeps requesting hints.
     */
    public function up(): void
    {
        Schema::create('hint_bank', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_skill_id')->constrained()->restrictOnDelete();
            $table->string('error_pattern');
            $table->unsignedTinyInteger('hint_level');
            $table->text('hint_text');
            $table->timestamps();

            $table->index(['sub_skill_id', 'error_pattern']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hint_bank');
    }
};
