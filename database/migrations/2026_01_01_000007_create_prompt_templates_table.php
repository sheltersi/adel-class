<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Prompt templates are versioned system prompts for each AI engine.
     * Storing them in the database (not config files) lets admins tune
     * prompts and output schemas without redeploying.
     * The output_schema column defines the expected JSON structure
     * for validating AI responses before storing.
     */
    public function up(): void
    {
        Schema::create('prompt_templates', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('engine_type', 50);
            $table->text('system_prompt');
            $table->text('user_prompt_template');
            $table->json('output_schema')->nullable();
            $table->string('model', 50);
            $table->decimal('temperature', 3, 2)->default(0.30);
            $table->unsignedInteger('max_tokens')->default(2000);
            $table->unsignedSmallInteger('version')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prompt_templates');
    }
};
