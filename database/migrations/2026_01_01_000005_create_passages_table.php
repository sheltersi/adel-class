<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reading passages are standalone content entities.
     * One passage can be reused across many questions.
     * passage_type distinguishes reading comprehension texts from
     * summary source texts and creative writing exemplars.
     */
    public function up(): void
    {
        Schema::create('passages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->mediumText('content');
            $table->string('passage_type', 30); // reading_comprehension, summary_source, narrative, descriptive, persuasive
            $table->unsignedSmallInteger('word_count')->nullable();
            $table->unsignedTinyInteger('difficulty')->default(1);
            $table->string('source')->nullable(); // Attribution
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passages');
    }
};
