<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Maps to the 1123 exam structure:
     * Paper 1 (Reading, Summary, Directed Writing) and
     * Paper 2 (Creative Writing — narrative/descriptive).
     * The unique constraint on (paper, section_number) prevents duplicates.
     */
    public function up(): void
    {
        Schema::create('syllabus_sections', function (Blueprint $table) {
            $table->id();
            $table->string('paper', 20);
            $table->string('section_number', 10);
            $table->string('section_name');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('max_marks')->nullable();
            $table->unsignedTinyInteger('display_order')->default(0);
            $table->timestamps();

            $table->unique(['paper', 'section_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('syllabus_sections');
    }
};
