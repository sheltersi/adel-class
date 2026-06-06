<?php

namespace App\Models;

use Database\Factories\PlagiarismReportFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'writing_submission_id',
    'similarity_score',
    'matched_submission_id',
    'matched_source',
    'details_json',
    'checked_at',
])]
class PlagiarismReport extends Model
{
    /** @use HasFactory<PlagiarismReportFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'details_json' => 'array',
            'checked_at' => 'datetime',
        ];
    }

    /**
     * The writing submission that was checked for plagiarism.
     *
     * Inverse one-to-one: each submission gets one similarity check.
     */
    public function writingSubmission(): BelongsTo
    {
        return $this->belongsTo(WritingSubmission::class);
    }

    /**
     * The prior submission that was matched (if internal match).
     *
     * Inverse belongs-to, nullable: points to a previous student submission
     * that showed high similarity. Null if matched to external source.
     */
    public function matchedSubmission(): BelongsTo
    {
        return $this->belongsTo(WritingSubmission::class, 'matched_submission_id');
    }
}
