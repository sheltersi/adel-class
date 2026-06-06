<?php

namespace App\Models;

use Database\Factories\PlanWeekFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['learning_plan_id', 'week_number', 'theme', 'target_sub_skill_ids'])]
class PlanWeek extends Model
{
    /** @use HasFactory<PlanWeekFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'target_sub_skill_ids' => 'array',
        ];
    }

    /**
     * The learning plan this week belongs to.
     *
     * Inverse belongs-to: each week is part of one student's learning plan.
     */
    public function learningPlan(): BelongsTo
    {
        return $this->belongsTo(LearningPlan::class);
    }

    /**
     * Activities scheduled for this week.
     *
     * One-to-many: typically 5-7 activities per week,
     * ordered by day (sort_order).
     */
    public function activities(): HasMany
    {
        return $this->hasMany(PlanActivity::class);
    }
}
