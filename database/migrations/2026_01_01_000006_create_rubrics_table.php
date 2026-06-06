<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Rubrics define how writing is evaluated.
     * Each rubric type (essay, summary, directed_writing) has different
     * criteria and mark allocations matching the 1123 mark scheme.
     */
    public function up(): void
    {
        Schema::create('rubrics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rubric_type', 30); // essay, summary, directed_writing
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('total_marks');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rubrics');
    }
};
