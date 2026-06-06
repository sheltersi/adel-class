<?php

namespace App\Models;

use Database\Factories\LearningPlanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'student_profile_id',
    'title',
    'description',
    'status',
    'total_weeks',
    'generated_at',
    'ai_interaction_id',
    'started_at',
    'completed_at',
])]
class LearningPlan extends Model
{
    /** @use HasFactory<LearningPlanFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'generated_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * The student this learning plan was generated for.
     *
     * Inverse belongs-to: each plan is tailored to one student's skill profile.
     */
    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }

    /**
     * The AI interaction that generated this plan.
     *
     * Inverse belongs-to: links to the ai_interaction_log for auditing
     * which prompt and context produced this plan.
     */
    public function aiInteraction(): BelongsTo
    {
        return $this->belongsTo(AiInteractionLog::class, 'ai_interaction_id');
    }

    /**
     * The weekly breakdowns within this plan.
     *
     * One-to-many: each plan week has its own set of activities
     * targeting specific sub-skills.
     */
    public function weeks(): HasMany
    {
        return $this->hasMany(PlanWeek::class);
    }
}
