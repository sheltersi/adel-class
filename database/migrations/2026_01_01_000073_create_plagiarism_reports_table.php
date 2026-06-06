<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Plagiarism similarity check results.
     * Unique writing_submission_id: one check per submission.
     * matched_submission_id is SET NULL: if the matched submission is later
     * deleted, the current report still documents that similarity was found.
     * CASCADE: if the submission is deleted, its plagiarism report is removed.
     */
    public function up(): void
    {
        Schema::create('plagiarism_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('writing_submission_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('similarity_score', 5, 2);
            $table->foreignId('matched_submission_id')->nullable()->constrained('writing_submissions')->nullOnDelete();
            $table->string('matched_source')->nullable();
            $table->json('details_json')->nullable();
            $table->timestamp('checked_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plagiarism_reports');
    }
};
