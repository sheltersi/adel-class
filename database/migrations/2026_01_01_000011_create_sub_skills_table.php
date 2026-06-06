<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sub-skills are granular competencies within each skill domain.
     * Example: the "grammar" domain contains sub-skills like
     * "subject-verb-agreement", "tense-consistency", "prepositions".
     * RESTRICT on delete: don't delete a skill domain that has sub-skills.
     */
    public function up(): void
    {
        Schema::create('sub_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_domain_id')->constrained()->restrictOnDelete();
            $table->string('slug', 100)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('display_order')->default(0);
            $table->timestamps();

            $table->index('skill_domain_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_skills');
    }
};
