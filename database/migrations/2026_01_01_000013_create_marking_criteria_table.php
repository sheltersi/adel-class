<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Marking criteria break a rubric into scored dimensions.
     * For the 1123 essay rubric: Content (15), Language (15),
     * Task Fulfillment (10), Organization (10).
     * CASCADE: if a rubric is deleted, its criteria go with it.
     */
    public function up(): void
    {
        Schema::create('marking_criteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rubric_id')->constrained()->cascadeOnDelete();
            $table->string('criterion_name', 100);
            $table->unsignedTinyInteger('max_marks');
            $table->unsignedTinyInteger('display_order')->default(0);
            $table->timestamps();

            $table->index('rubric_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marking_criteria');
    }
};
