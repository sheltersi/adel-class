<?php

namespace App\Models;

use Database\Factories\QuestionResponseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'assessment_question_id',
    'student_answer',
    'selected_option_id',
    'score',
    'max_score',
    'is_correct',
    'is_ai_scored',
    'ai_confidence',
    'ai_feedback',
    'ai_interaction_id',
    'time_spent_seconds',
    'answered_at',
])]
class QuestionResponse extends Model
{
    /** @use HasFactory<QuestionResponseFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
            'is_ai_scored' => 'boolean',
            'answered_at' => 'datetime',
        ];
    }

    /**
     * The assessment question this response answers.
     *
     * Inverse one-to-one: each assessment question gets one student answer.
     */
    public function assessmentQuestion(): BelongsTo
    {
        return $this->belongsTo(AssessmentQuestion::class);
    }

    /**
     * The MCQ option the student selected (if applicable).
     *
     * Inverse belongs-to, nullable: only populated for MCQ questions.
     */
    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(QuestionOption::class, 'selected_option_id');
    }

    /**
     * The AI interaction that produced this score/feedback.
     *
     * Inverse belongs-to, nullable: links back to the ai_interaction_log
     * for audit, cost tracking, and prompt debugging.
     */
    public function aiInteraction(): BelongsTo
    {
        return $this->belongsTo(AiInteractionLog::class, 'ai_interaction_id');
    }
}
