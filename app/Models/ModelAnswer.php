<?php

namespace App\Models;

use Database\Factories\ModelAnswerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['writing_prompt_id', 'question_id', 'content', 'band_score'])]
class ModelAnswer extends Model
{
    /** @use HasFactory<ModelAnswerFactory> */
    use HasFactory;

    /**
     * The writing prompt this model answer is for (essays).
     *
     * Inverse belongs-to, nullable: only set for essay/creative writing prompts.
     */
    public function writingPrompt(): BelongsTo
    {
        return $this->belongsTo(WritingPrompt::class);
    }

    /**
     * The question this model answer is for (short-answer/subjective).
     *
     * Inverse belongs-to, nullable: only set for non-essay subjective questions.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
