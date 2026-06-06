<?php

namespace App\Models;

use Database\Factories\SkillDomainFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['slug', 'name', 'display_order'])]
class SkillDomain extends Model
{
    /** @use HasFactory<SkillDomainFactory> */
    use HasFactory;

    /**
     * Sub-skills that belong to this domain.
     *
     * One-to-many: grammar → [subject-verb-agreement, tense-consistency, ...].
     * Each domain (grammar, comprehension, vocabulary, writing) contains many sub-skills.
     */
    public function subSkills(): HasMany
    {
        return $this->hasMany(SubSkill::class);
    }
}
