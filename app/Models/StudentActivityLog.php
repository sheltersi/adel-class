<?php

namespace App\Models;

use Database\Factories\StudentActivityLogFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
    'student_profile_id',
    'plan_activity_id',
    'activity_type',
    'activity_target_type',
    'activity_target_id',
    'status',
    'score',
    'time_spent_seconds',
    'hints_requested',
    'completed_at',
])]
class StudentActivityLog extends Model
{
    /** @use HasFactory<StudentActivityLogFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }

    /**
     * The student who performed this activity.
     *
     * Inverse belongs-to: every activity log entry belongs to one student.
     */
    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }

    /**
     * The plan activity that was completed (null if freestyle practice).
     *
     * Inverse belongs-to, nullable: links a log entry back to the plan
     * activity it fulfilled. Null when the student does unscheduled practice.
     */
    public function planActivity(): BelongsTo
    {
        return $this->belongsTo(PlanActivity::class);
    }

    /**
     * The polymorphic target (question, prompt, passage) of this activity.
     *
     * Polymorphic belongs-to: lets us link directly to what the student
     * actually worked on, regardless of whether it came from a plan.
     */
    public function target(): MorphTo
    {
        return $this->morphTo('activity_target');
    }
}
