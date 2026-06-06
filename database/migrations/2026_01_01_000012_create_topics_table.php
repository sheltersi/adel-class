<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Topics group questions under syllabus sections.
     * RESTRICT on delete: a syllabus section cannot be removed while
     * topics still reference it. This is intentional — curriculum content
     * should never be silently orphaned.
     */
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('syllabus_section_id')->constrained()->restrictOnDelete();
            $table->string('slug', 150)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('syllabus_section_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
