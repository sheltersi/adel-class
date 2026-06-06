<?php

namespace App\Models;

use Database\Factories\MarkingCriterionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['rubric_id', 'criterion_name', 'max_marks', 'display_order'])]
class MarkingCriterion extends Model
{
    /** @use HasFactory<MarkingCriterionFactory> */
    use HasFactory;

    /**
     * The rubric this criterion belongs to.
     *
     * Inverse belongs-to: "Content" criterion belongs to the 1123 Essay rubric.
     */
    public function rubric(): BelongsTo
    {
        return $this->belongsTo(Rubric::class);
    }

    /**
     * The band descriptors for this criterion.
     *
     * One-to-many: for "Content" (max 15), descriptors define what
     * Band 1 (13-15), Band 2 (10-12), Band 3 (7-9), Band 4 (0-6) look like.
     */
    public function markingDescriptors(): HasMany
    {
        return $this->hasMany(MarkingDescriptor::class);
    }
}
