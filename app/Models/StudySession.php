<?php

namespace App\Models;

use Database\Factories\StudySessionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['student_profile_id', 'session_start', 'session_end', 'duration_seconds', 'activities_completed'])]
class StudySession extends Model
{
    /** @use HasFactory<StudySessionFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'session_start' => 'datetime',
            'session_end' => 'datetime',
        ];
    }

    /**
     * The student who had this study session.
     *
     * Inverse belongs-to: tracks study frequency and duration per student
     * for engagement analytics.
     */
    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }
}
