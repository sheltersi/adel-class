<?php

namespace App\Models;

use Database\Factories\QuestionTagFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable(['question_id', 'sub_skill_id', 'weight'])]
class QuestionTag extends Pivot
{
    /** @use HasFactory<QuestionTagFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'question_tags';
}
