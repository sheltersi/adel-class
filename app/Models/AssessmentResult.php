<?php

namespace App\Models;

use Database\Factories\AssessmentResultFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'assessment_id',
    'total_score',
    'total_marks',
    'percentage',
    'band_score',
    'ai_generated_summary',
    'is_overridden',
    'overridden_by',
    'completed_at',
])]
class AssessmentResult extends Model
{
    /** @use HasFactory<AssessmentResultFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'is_overridden' => 'boolean',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * The assessment this result belongs to.
     *
     * Inverse one-to-one: each assessment yields exactly one result.
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * The admin who overrode this result (if applicable).
     *
     * Inverse belongs-to: for low-confidence AI scores that an admin
     * manually corrected.
     */
    public function overriddenBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'overridden_by');
    }
}
