<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 1:1 extension of the users table for student data.
     * Separating profile data from auth data keeps concerns clean.
     * parent_user_id is SET NULL on parent account deletion:
     * the student still exists, just unlinked.
     * CASCADE on user delete: if the account is deleted, the profile goes too.
     */
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('parent_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('grade_level', 20)->nullable();
            $table->string('target_grade', 5)->nullable();
            $table->unsignedTinyInteger('weekly_study_hours')->nullable();
            $table->boolean('placement_completed')->default(false);
            $table->string('current_estimated_grade', 5)->nullable();
            $table->timestamps();

            $table->index('parent_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
