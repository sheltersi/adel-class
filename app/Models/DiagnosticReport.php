<?php

namespace App\Models;

use Database\Factories\DiagnosticReportFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'student_profile_id',
    'assessment_id',
    'summary',
    'strengths_json',
    'weaknesses_json',
    'ai_interaction_id',
    'generated_at',
])]
class DiagnosticReport extends Model
{
    /** @use HasFactory<DiagnosticReportFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'strengths_json' => 'array',
            'weaknesses_json' => 'array',
            'generated_at' => 'datetime',
        ];
    }

    /**
     * The student this diagnostic report is for.
     *
     * Inverse belongs-to: each report summarizes one student's placement test.
     */
    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }

    /**
     * The diagnostic assessment that generated this report.
     *
     * Inverse one-to-one: each diagnostic test produces one report.
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * The AI interaction that generated this report.
     *
     * Inverse belongs-to: links to ai_interaction_log for audit.
     */
    public function aiInteraction(): BelongsTo
    {
        return $this->belongsTo(AiInteractionLog::class, 'ai_interaction_id');
    }
}
