<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Versioned audit trail for content changes.
     * Uses a polymorphic content_type + content_id to track versions
     * across questions, passages, writing_prompts, and rubrics.
     * snapshot_json stores the full row state at the time of versioning.
     * changed_by is SET NULL: keep the version record even if the admin
     * account is later deleted.
     */
    public function up(): void
    {
        Schema::create('content_versions', function (Blueprint $table) {
            $table->id();
            $table->string('content_type', 50); // questions, passages, writing_prompts, rubrics
            $table->unsignedBigInteger('content_id');
            $table->unsignedSmallInteger('version_number');
            $table->json('snapshot_json');
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('changed_at');
            $table->timestamps();

            $table->index(['content_type', 'content_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_versions');
    }
};
