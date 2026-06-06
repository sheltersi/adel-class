<?php

namespace App\Models;

use Database\Factories\RubricFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'rubric_type', 'description', 'total_marks', 'is_active'])]
class Rubric extends Model
{
    /** @use HasFactory<RubricFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * The criteria within this rubric.
     *
     * One-to-many: the 1123 essay rubric contains criteria:
     * Content (15 marks), Language (15 marks), Task Fulfillment (10 marks),
     * Organization (10 marks).
     */
    public function markingCriteria(): HasMany
    {
        return $this->hasMany(MarkingCriterion::class);
    }

    /**
     * Questions that use this rubric for AI scoring.
     *
     * One-to-many: subjective questions reference a rubric
     * to guide the AI evaluation prompt.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Writing prompts that use this rubric.
     *
     * One-to-many: each prompt type (narrative, descriptive, directed)
     * references its applicable rubric.
     */
    public function writingPrompts(): HasMany
    {
        return $this->hasMany(WritingPrompt::class);
    }

    /**
     * Evaluations performed using this rubric.
     *
     * One-to-many: every AI-generated essay evaluation references
     * the rubric it was scored against.
     */
    public function submissionEvaluations(): HasMany
    {
        return $this->hasMany(SubmissionEvaluation::class);
    }
}
