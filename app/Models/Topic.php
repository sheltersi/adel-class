<?php

namespace App\Models;

use Database\Factories\TopicFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['syllabus_section_id', 'slug', 'name', 'description', 'display_order', 'is_active'])]
class Topic extends Model
{
    /** @use HasFactory<TopicFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * The syllabus section this topic belongs to.
     *
     * Inverse belongs-to: a topic like "Inference" belongs to
     * a syllabus section like "Reading Comprehension".
     */
    public function syllabusSection(): BelongsTo
    {
        return $this->belongsTo(SyllabusSection::class);
    }

    /**
     * Questions under this topic.
     *
     * One-to-many: a topic contains many questions of varying difficulty.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Writing prompts under this topic.
     *
     * One-to-many: essay and directed writing prompts tagged to this topic.
     */
    public function writingPrompts(): HasMany
    {
        return $this->hasMany(WritingPrompt::class);
    }
}
