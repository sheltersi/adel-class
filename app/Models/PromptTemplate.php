<?php

namespace App\Models;

use Database\Factories\PromptTemplateFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'slug',
    'engine_type',
    'system_prompt',
    'user_prompt_template',
    'output_schema',
    'model',
    'temperature',
    'max_tokens',
    'version',
    'is_active',
])]
class PromptTemplate extends Model
{
    /** @use HasFactory<PromptTemplateFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'output_schema' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * AI interactions that used this prompt template.
     *
     * One-to-many: each call to the AI engine references the prompt
     * template version that was active at the time, for debugging
     * and A/B testing of prompt effectiveness.
     */
    public function aiInteractionLogs(): HasMany
    {
        return $this->hasMany(AiInteractionLog::class);
    }
}
