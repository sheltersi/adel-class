<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'topic_id',
    'question_type',
    'difficulty',
    'marks',
    'stem',
    'explanation',
    'is_ai_scored',
    'rubric_id',
    'estimated_time_seconds',
    'is_active',
    'version',
])]
class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'is_ai_scored' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * The topic this question belongs to.
     *
     * Inverse belongs-to: every question is categorized under one topic.
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * MCQ options for this question.
     *
     * One-to-many: only populated for question_type = 'mcq'.
     */
    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }

    /**
     * Sub-skills tested by this question.
     *
     * Many-to-many via question_tags pivot with a weight column.
     * A question like "inference MCQ" tests both the inference sub-skill
     * and vocabulary sub-skill with different weights.
     */
    public function subSkills(): BelongsToMany
    {
        return $this->belongsToMany(SubSkill::class, 'question_tags')
            ->withPivot('weight')
            ->withTimestamps();
    }

    /**
     * Reading passages linked to this question.
     *
     * Many-to-many via question_passage pivot.
     * Reading comprehension questions reference one or more passages.
     */
    public function passages(): BelongsToMany
    {
        return $this->belongsToMany(Passage::class, 'question_passage')
            ->withPivot('sort_order')
            ->withTimestamps();
    }

    /**
     * The marking rubric for this question (if subjective/AI-scored).
     *
     * Inverse belongs-to: subjective questions reference a rubric
     * for consistent AI evaluation.
     */
    public function rubric(): BelongsTo
    {
        return $this->belongsTo(Rubric::class);
    }

    /**
     * Model answers for this question (if applicable).
     *
     * One-to-many: reference answers used as comparison during AI evaluation.
     */
    public function modelAnswers(): HasMany
    {
        return $this->hasMany(ModelAnswer::class);
    }

    /**
     * Assessment appearances of this question.
     *
     * Many-to-many via assessment_questions pivot.
     * Tracks which assessments included this question.
     */
    public function assessments(): BelongsToMany
    {
        return $this->belongsToMany(Assessment::class, 'assessment_questions')
            ->withPivot('sort_order')
            ->withTimestamps();
    }
}
