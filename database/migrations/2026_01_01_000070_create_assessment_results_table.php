<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Overall result summary for an assessment.
     * Unique assessment_id: one result per assessment.
     * overridden_by is SET NULL: keep the result even if the admin account is deleted.
     */
    public function up(): void
    {
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('total_score', 6, 2)->nullable();
            $table->decimal('total_marks', 6, 2);
            $table->decimal('percentage', 5, 2)->nullable();
            $table->string('band_score', 5)->nullable();
            $table->text('ai_generated_summary')->nullable();
            $table->boolean('is_overridden')->default(false);
            $table->foreignId('overridden_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_results');
    }
};
