<?php

namespace App\Models;

use Database\Factories\ProgressSnapshotFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'student_profile_id',
    'snapshot_type',
    'skill_scores_json',
    'estimated_grade',
    'activities_completed',
    'total_time_minutes',
    'ai_insight',
    'ai_interaction_id',
    'captured_at',
])]
class ProgressSnapshot extends Model
{
    /** @use HasFactory<ProgressSnapshotFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'skill_scores_json' => 'array',
            'captured_at' => 'datetime',
        ];
    }

    /**
     * The student this snapshot belongs to.
     *
     * Inverse belongs-to: snapshots form a time series per student.
     */
    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }

    /**
     * The AI interaction that generated the insight comment.
     *
     * Inverse belongs-to: links to ai_interaction_log for
     * the weekly progress analyst engine call.
     */
    public function aiInteraction(): BelongsTo
    {
        return $this->belongsTo(AiInteractionLog::class, 'ai_interaction_id');
    }

    /**
     * The grade prediction calculated from this snapshot.
     *
     * One-to-one: each snapshot produces one grade prediction
     * showing trajectory toward the target.
     */
    public function gradePrediction(): HasOne
    {
        return $this->hasOne(GradePrediction::class);
    }
}
