<?php

namespace App\Models;

use Database\Factories\WritingSubmissionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'student_profile_id',
    'writing_prompt_id',
    'assessment_id',
    'content',
    'word_count',
    'time_spent_seconds',
    'status',
    'auto_saved_at',
    'submitted_at',
])]
class WritingSubmission extends Model
{
    /** @use HasFactory<WritingSubmissionFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'auto_saved_at' => 'datetime',
            'submitted_at' => 'datetime',
        ];
    }

    /**
     * The student who submitted this writing.
     *
     * Inverse belongs-to: each submission belongs to one student.
     */
    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }

    /**
     * The writing prompt this submission is responding to.
     *
     * Inverse belongs-to: the essay question/scenario the student answered.
     */
    public function writingPrompt(): BelongsTo
    {
        return $this->belongsTo(WritingPrompt::class);
    }

    /**
     * The assessment this submission is part of (if mock exam).
     *
     * Inverse belongs-to, nullable: set when the student is writing
     * under timed exam conditions.
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * AI-generated evaluation of this submission.
     *
     * One-to-many: a submission may be re-evaluated (after admin override)
     * producing multiple evaluation records.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(SubmissionEvaluation::class);
    }

    /**
     * The most recent evaluation for this submission.
     *
     * One-to-one convenience: returns the latest evaluation by evaluated_at.
     */
    public function latestEvaluation(): HasOne
    {
        return $this->hasOne(SubmissionEvaluation::class)->latestOfMany('evaluated_at');
    }

    /**
     * The plagiarism check report for this submission.
     *
     * One-to-one: each submission gets one plagiarism similarity check.
     */
    public function plagiarismReport(): HasOne
    {
        return $this->hasOne(PlagiarismReport::class);
    }
}
