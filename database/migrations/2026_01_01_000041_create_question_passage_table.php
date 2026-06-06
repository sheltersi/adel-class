<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pivot linking questions to reading passages.
     * CASCADE on both sides: a passage-question link is meaningless
     * if either side is deleted.
     * sort_order: when one passage has multiple questions, this
     * orders them in reading sequence.
     */
    public function up(): void
    {
        Schema::create('question_passage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('passage_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['question_id', 'passage_id']);
            $table->index('passage_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_passage');
    }
};
