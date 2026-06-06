<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Log of every activity a student completes.
     * plan_activity_id is SET NULL: if a plan activity is removed, the log
     * remains as evidence of work done.
     * Polymorphic target: an activity log can reference any exercise type
     * (question, writing_prompt, passage) directly.
     */
    public function up(): void
    {
        Schema::create('student_activity_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_profile_id')->constrained()->restrictOnDelete();
            $table->foreignId('plan_activity_id')->nullable()->constrained()->nullOnDelete();
            $table->string('activity_type', 30);
            $table->string('activity_target_type', 50);
            $table->unsignedBigInteger('activity_target_id');
            $table->string('status', 20)->default('started'); // started, completed, skipped
            $table->decimal('score', 5, 2)->nullable();
            $table->unsignedInteger('time_spent_seconds')->nullable();
            $table->unsignedTinyInteger('hints_requested')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['student_profile_id', 'completed_at'], 'sal_profile_completed_idx');
            $table->index('plan_activity_id');
            $table->index(['activity_target_type', 'activity_target_id'], 'sal_target_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_activity_log');
    }
};
