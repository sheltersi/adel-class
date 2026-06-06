<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Band descriptors define what each score band looks like per criterion.
     * Example: "Content Band 1 (13-15 marks): Thorough exploration of topic,
     * wide range of ideas, consistently relevant."
     * CASCADE: if a criterion is deleted, its descriptors go with it.
     */
    public function up(): void
    {
        Schema::create('marking_descriptors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marking_criterion_id')->constrained()->cascadeOnDelete();
            $table->string('band', 5);
            $table->decimal('min_score', 4, 1);
            $table->decimal('max_score', 4, 1);
            $table->text('descriptor');
            $table->timestamps();

            $table->index('marking_criterion_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marking_descriptors');
    }
};
