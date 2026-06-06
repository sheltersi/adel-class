<?php

namespace App\Models;

use Database\Factories\GradePredictionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'progress_snapshot_id',
    'predicted_grade',
    'confidence',
    'score_needed_for_a',
    'trajectory',
    'weeks_to_target',
])]
class GradePrediction extends Model
{
    /** @use HasFactory<GradePredictionFactory> */
    use HasFactory;

    /**
     * The progress snapshot this prediction is based on.
     *
     * Inverse one-to-one: each snapshot gets one grade prediction.
     */
    public function progressSnapshot(): BelongsTo
    {
        return $this->belongsTo(ProgressSnapshot::class);
    }
}
