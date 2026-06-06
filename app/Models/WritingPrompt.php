<?php

namespace App\Models;

use Database\Factories\WritingPromptFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'topic_id',
    'prompt_type',
    'title',
    'scenario',
    'word_limit_min',
    'word_limit_max',
    'suggested_time_minutes',
    'difficulty',
    'rubric_id',
    'mark_scheme_json',
    'is_active',
])]
class WritingPrompt extends Model
{
    /** @use HasFactory<WritingPromptFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'mark_scheme_json' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * The topic this writing prompt falls under.
     *
     * Inverse belongs-to: a narrative essay prompt belongs to a writing topic.
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * The marking rubric for this prompt type.
     *
     * Inverse belongs-to: directed writing uses a different rubric than
     * narrative/descriptive essay prompts.
     */
    public function rubric(): BelongsTo
    {
        return $this->belongsTo(Rubric::class);
    }

    /**
     * Model answers exemplifying different band scores for this prompt.
     *
     * One-to-many: reference essays at A, B, C bands for AI comparison.
     */
    public function modelAnswers(): HasMany
    {
        return $this->hasMany(ModelAnswer::class);
    }

    /**
     * Student writing submissions in response to this prompt.
     *
     * One-to-many: tracks how many students have attempted this prompt.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(WritingSubmission::class);
    }
}
