<?php

namespace App\Models;

use Database\Factories\QuestionPassageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable(['question_id', 'passage_id', 'sort_order'])]
class QuestionPassage extends Pivot
{
    /** @use HasFactory<QuestionPassageFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'question_passage';
}
