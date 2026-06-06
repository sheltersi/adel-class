<?php

namespace App\Models;

use Database\Factories\PassageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['title', 'content', 'passage_type', 'word_count', 'difficulty', 'source', 'is_active'])]
class Passage extends Model
{
    /** @use HasFactory<PassageFactory> */
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
     * Questions that reference this passage.
     *
     * Many-to-many via question_passage pivot.
     * A passage can be used by multiple questions (e.g., multiple
     * comprehension questions on the same text).
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'question_passage')
            ->withPivot('sort_order')
            ->withTimestamps();
    }
}
