<?php

namespace App\Models;

use Database\Factories\AssessmentQuestionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['assessment_id', 'question_id', 'sort_order'])]
class AssessmentQuestion extends Model
{
    /** @use HasFactory<AssessmentQuestionFactory> */
    use HasFactory;

    /**
     * The assessment this pivot row belongs to.
     *
     * Inverse belongs-to: each row links one question to one assessment.
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * The question this pivot row references.
     *
     * Inverse belongs-to: which question is being asked.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * The student's response to this assessment question.
     *
     * One-to-one: each assessment question gets exactly one student answer.
     */
    public function response(): HasOne
    {
        return $this->hasOne(QuestionResponse::class);
    }
}
