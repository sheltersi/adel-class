<?php

namespace App\Models;

use Database\Factories\SubmissionEvaluationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'writing_submission_id',
    'rubric_id',
    'total_score',
    'total_marks',
    'band_score',
    'criterion_scores',
    'inline_annotations',
    'overall_comment',
    'improved_excerpt',
    'ai_confidence',
    'ai_interaction_id',
    'needs_admin_review',
    'is_overridden',
    'overridden_by',
    'overridden_at',
    'evaluated_at',
])]
class SubmissionEvaluation extends Model
{
    /** @use HasFactory<SubmissionEvaluationFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'criterion_scores' => 'array',
            'inline_annotations' => 'array',
            'needs_admin_review' => 'boolean',
            'is_overridden' => 'boolean',
            'overridden_at' => 'datetime',
            'evaluated_at' => 'datetime',
        ];
    }

    /**
     * The writing submission being evaluated.
     *
     * Inverse belongs-to: each evaluation grades one student essay.
     */
    public function writingSubmission(): BelongsTo
    {
        return $this->belongsTo(WritingSubmission::class);
    }

    /**
     * The rubric used to evaluate this submission.
     *
     * Inverse belongs-to: maps which marking criteria were applied.
     */
    public function rubric(): BelongsTo
    {
        return $this->belongsTo(Rubric::class);
    }

    /**
     * The AI interaction that produced this evaluation.
     *
     * Inverse belongs-to: links to ai_interaction_log for audit.
     */
    public function aiInteraction(): BelongsTo
    {
        return $this->belongsTo(AiInteractionLog::class, 'ai_interaction_id');
    }

    /**
     * The admin who manually overrode this evaluation (if applicable).
     *
     * Inverse belongs-to: human-in-the-loop correction for low-confidence AI scores.
     */
    public function overriddenBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'overridden_by');
    }
}
