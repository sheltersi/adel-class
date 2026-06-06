<?php

namespace App\Models;

use Database\Factories\SubSkillFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['skill_domain_id', 'parent_id', 'slug', 'name', 'description', 'display_order'])]
class SubSkill extends Model
{
    /** @use HasFactory<SubSkillFactory> */
    use HasFactory;

    /**
     * The parent skill domain (grammar, comprehension, vocabulary, writing).
     *
     * Inverse belongs-to: each sub-skill falls under one domain.
     */
    public function skillDomain(): BelongsTo
    {
        return $this->belongsTo(SkillDomain::class);
    }

    /**
     * Student proficiency scores for this sub-skill.
     *
     * One-to-many: each student has a score for this sub-skill.
     */
    public function studentScores(): HasMany
    {
        return $this->hasMany(StudentSubSkillScore::class);
    }

    /**
     * Questions that test this sub-skill.
     *
     * Many-to-many via question_tags pivot.
     * One question can test multiple sub-skills (e.g., a summary question tests
     * both comprehension and concision).
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'question_tags')
            ->withPivot('weight')
            ->withTimestamps();
    }

    /**
     * The parent sub-skill in the hierarchy (null for top-level sub-skills).
     *
     * Inverse belongs-to: self-referencing relationship.
     * Example: "Tense Accuracy" → parent is null (top-level).
     * "Present Tenses" → parent is "Tense Accuracy".
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(SubSkill::class, 'parent_id');
    }

    /**
     * Child sub-skills nested under this node.
     *
     * One-to-many: self-referencing relationship.
     * Example: "Tense Accuracy" has children: Present Tenses, Past Tenses, etc.
     */
    public function children(): HasMany
    {
        return $this->hasMany(SubSkill::class, 'parent_id');
    }

    /**
     * Hints in the fallback hint bank for common error patterns in this sub-skill.
     *
     * One-to-many: pre-authored hints organized by error pattern and hint level.
     */
    public function hints(): HasMany
    {
        return $this->hasMany(HintBank::class);
    }
}
