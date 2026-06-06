<?php

namespace App\Models;

use Database\Factories\SyllabusSectionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['paper', 'section_number', 'section_name', 'description', 'max_marks', 'display_order'])]
class SyllabusSection extends Model
{
    /** @use HasFactory<SyllabusSectionFactory> */
    use HasFactory;

    /**
     * Topics grouped under this syllabus section.
     *
     * One-to-many: Paper 1 Section 1 (Reading Comprehension) contains
     * topics like "Literal Comprehension", "Inference", "Vocabulary in Context".
     */
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
}
