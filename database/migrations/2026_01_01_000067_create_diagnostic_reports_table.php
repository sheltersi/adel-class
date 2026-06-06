<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * AI-generated diagnostic reports after the placement test.
     * strengths_json and weaknesses_json store arrays of {sub_skill_id, proficiency}
     * for rendering skill profile charts.
     */
    public function up(): void
    {
        Schema::create('diagnostic_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_profile_id')->constrained()->restrictOnDelete();
            $table->foreignId('assessment_id')->unique()->constrained()->cascadeOnDelete();
            $table->text('summary');
            $table->json('strengths_json')->nullable();
            $table->json('weaknesses_json')->nullable();
            $table->foreignId('ai_interaction_id')->nullable()->constrained('ai_interaction_log')->nullOnDelete();
            $table->timestamp('generated_at');
            $table->timestamps();

            $table->index('student_profile_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnostic_reports');
    }
};
