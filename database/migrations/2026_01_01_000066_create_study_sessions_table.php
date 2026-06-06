<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Study session tracking. A session starts when the student logs in
     * or resumes activity and ends on logout or inactivity timeout.
     * Used for engagement analytics and time-on-task reporting.
     */
    public function up(): void
    {
        Schema::create('study_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_profile_id')->constrained()->restrictOnDelete();
            $table->timestamp('session_start');
            $table->timestamp('session_end')->nullable();
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->unsignedTinyInteger('activities_completed')->default(0);
            $table->timestamps();

            $table->index(['student_profile_id', 'session_start']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_sessions');
    }
};
