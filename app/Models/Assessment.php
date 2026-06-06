<?php

namespace App\Models;

use Database\Factories\AssessmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'student_profile_id',
    'assessment_type',
    'paper',
    'status',
    'started_at',
    'completed_at',
    'time_limit_seconds',
    'time_remaining_seconds',
    'total_marks',
])]
class Assessment extends Model
{
    /** @use HasFactory<AssessmentFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * The student who took this assessment.
     *
     * Inverse belongs-to: every assessment belongs to one student.
     */
    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }

    /**
     * Questions included in this assessment (with sort ordering).
     *
     * Many-to-many via assessment_questions pivot.
     * Supports ordering questions within the test and tracking
     * which questions were selected for this specific test instance.
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'assessment_questions')
            ->withPivot('sort_order')
            ->withTimestamps();
    }

    /**
     * The pivot rows linking questions to this assessment.
     *
     * One-to-many: used to access student responses via the pivot.
     */
    public function assessmentQuestions(): HasMany
    {
        return $this->hasMany(AssessmentQuestion::class);
    }

    /**
     * The overall result for this assessment.
     *
     * One-to-one: each assessment has one result summary (total score,
     * band, AI-generated summary).
     */
    public function result(): HasOne
    {
        return $this->hasOne(AssessmentResult::class);
    }

    /**
     * Writing submissions made during this assessment (mock exams).
     *
     * One-to-many: if the assessment includes essay sections, the
     * writing is submitted through the assessment context.
     */
    public function writingSubmissions(): HasMany
    {
        return $this->hasMany(WritingSubmission::class);
    }

    /**
     * The diagnostic report generated from this assessment.
     *
     * One-to-one: only populated for assessment_type = 'diagnostic'.
     */
    public function diagnosticReport(): HasOne
    {
        return $this->hasOne(DiagnosticReport::class);
    }
}
