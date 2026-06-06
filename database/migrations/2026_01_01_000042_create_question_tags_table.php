<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pivot linking questions to the sub-skills they test.
     * weight: a question can test multiple sub-skills with different weights.
     * Example: a summary question might weight "comprehension" at 0.6 and
     * "concision" at 0.4.
     * CASCADE on both sides: remove the tag if either entity is deleted.
     */
    public function up(): void
    {
        Schema::create('question_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_skill_id')->constrained()->cascadeOnDelete();
            $table->decimal('weight', 4, 3)->default(1.000);
            $table->timestamps();

            $table->unique(['question_id', 'sub_skill_id']);
            $table->index('sub_skill_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_tags');
    }
};
