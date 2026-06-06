<?php

namespace App\Models;

use Database\Factories\MarkingDescriptorFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['marking_criterion_id', 'band', 'min_score', 'max_score', 'descriptor'])]
class MarkingDescriptor extends Model
{
    /** @use HasFactory<MarkingDescriptorFactory> */
    use HasFactory;

    /**
     * The marking criterion this descriptor defines a band for.
     *
     * Inverse belongs-to: describes what a Band 1 "Language" essay looks like.
     */
    public function markingCriterion(): BelongsTo
    {
        return $this->belongsTo(MarkingCriterion::class);
    }
}
