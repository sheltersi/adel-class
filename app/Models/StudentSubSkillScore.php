<?php

namespace App\Models;

use Database\Factories\StudentSubSkillScoreFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['student_profile_id', 'sub_skill_id', 'proficiency_score', 'confidence_score', 'last_updated_at'])]
class StudentSubSkillScore extends Model
{
    /** @use HasFactory<StudentSubSkillScoreFactory> */
    use HasFactory;

    /**
     * The student profile this score belongs to.
     *
     * Inverse belongs-to: each score row belongs to one student profile.
     */
    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }

    /**
     * The sub-skill this score measures.
     *
     * Inverse belongs-to: each score maps to a specific sub-skill
     * (e.g., "subject-verb agreement" or "inference").
     */
    public function subSkill(): BelongsTo
    {
        return $this->belongsTo(SubSkill::class);
    }
}
