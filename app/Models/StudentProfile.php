<?php

namespace App\Models;

use Database\Factories\StudentProfileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'parent_user_id',
    'grade_level',
    'target_grade',
    'weekly_study_hours',
    'placement_completed',
    'placement_sections_completed',
    'current_estimated_grade',
])]
class StudentProfile extends Model
{
    /** @use HasFactory<StudentProfileFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'placement_completed' => 'boolean',
            'placement_sections_completed' => 'array',
        ];
    }

    /**
     * The user account this profile belongs to.
     *
     * Inverse one-to-one: each student profile is owned by exactly one user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The parent user linked to this student (optional).
     *
     * Inverse belongs-to via parent_user_id FK.
     * A parent can view this student's progress.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_user_id');
    }

    /**
     * Proficiency scores for each sub-skill.
     *
     * One-to-many: a student has a score for every sub-skill in the taxonomy.
     */
    public function subSkillScores(): HasMany
    {
        return $this->hasMany(StudentSubSkillScore::class);
    }

    /**
     * All assessments taken by this student.
     *
     * One-to-many: diagnostic tests, milestones, mock exams, practice tests.
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    /**
     * All learning plans generated for this student.
     *
     * One-to-many: a new plan is generated after each diagnostic
     * and periodically regenerated based on progress.
     */
    public function learningPlans(): HasMany
    {
        return $this->hasMany(LearningPlan::class);
    }

    /**
     * All writing/essay submissions by this student.
     *
     * One-to-many: each essay, summary, or directed writing submission.
     */
    public function writingSubmissions(): HasMany
    {
        return $this->hasMany(WritingSubmission::class);
    }

    /**
     * Periodic snapshots of skill scores for progress tracking.
     *
     * One-to-many: captured weekly or at milestones to build trend graphs.
     */
    public function progressSnapshots(): HasMany
    {
        return $this->hasMany(ProgressSnapshot::class);
    }

    /**
     * Study session records (login-to-logout tracking).
     *
     * One-to-many: each session captures duration and activities completed.
     */
    public function studySessions(): HasMany
    {
        return $this->hasMany(StudySession::class);
    }

    /**
     * AI-generated diagnostic reports after placement tests.
     *
     * One-to-many: one report per diagnostic assessment taken.
     */
    public function diagnosticReports(): HasMany
    {
        return $this->hasMany(DiagnosticReport::class);
    }

    /**
     * Log of all activities completed by this student.
     *
     * One-to-many: every question answered, exercise completed, or plan activity done.
     */
    public function studentActivityLogs(): HasMany
    {
        return $this->hasMany(StudentActivityLog::class);
    }

    /**
     * All AI interactions made on behalf of this student.
     *
     * One-to-many: every LLM call (scoring, feedback, plan generation) is logged.
     */
    public function aiInteractionLogs(): HasMany
    {
        return $this->hasMany(AiInteractionLog::class);
    }

    /**
     * Daily summaries of AI usage (tokens, cost, call count).
     *
     * One-to-many: one row per day for billing and rate limiting.
     */
    public function aiUsageSummaries(): HasMany
    {
        return $this->hasMany(AiUsageSummary::class);
    }
}
