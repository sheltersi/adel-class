<?php

namespace App\Models;

use Database\Factories\PlanActivityFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
    'plan_week_id',
    'activity_type',
    'activity_target_type',
    'activity_target_id',
    'sort_order',
    'is_optional',
    'scheduled_date',
])]
class PlanActivity extends Model
{
    /** @use HasFactory<PlanActivityFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'is_optional' => 'boolean',
            'scheduled_date' => 'date',
        ];
    }

    /**
     * The plan week this activity belongs to.
     *
     * Inverse belongs-to: each activity is scheduled in one week of a plan.
     */
    public function planWeek(): BelongsTo
    {
        return $this->belongsTo(PlanWeek::class);
    }

    /**
     * The target resource for this activity (question, writing prompt, or passage).
     *
     * Polymorphic belongs-to: an activity can point to a Question,
     * a WritingPrompt, or a Passage depending on activity_target_type.
     */
    public function target(): MorphTo
    {
        return $this->morphTo('activity_target');
    }

    /**
     * The student's log entry for completing this activity.
     *
     * One-to-one: each plan activity gets one completion log entry.
     */
    public function activityLog(): HasOne
    {
        return $this->hasOne(StudentActivityLog::class);
    }
}
