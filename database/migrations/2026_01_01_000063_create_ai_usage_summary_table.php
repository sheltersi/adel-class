<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Daily rollup of AI usage per student for rate limiting and billing.
     * Unique on (student_profile_id, usage_date): one row per student per day.
     */
    public function up(): void
    {
        Schema::create('ai_usage_summary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_profile_id')->constrained()->cascadeOnDelete();
            $table->date('usage_date');
            $table->unsignedInteger('call_count')->default(0);
            $table->unsignedInteger('total_input_tokens')->default(0);
            $table->unsignedInteger('total_output_tokens')->default(0);
            $table->decimal('total_cost_usd', 10, 6)->default(0);
            $table->timestamps();

            $table->unique(['student_profile_id', 'usage_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_usage_summary');
    }
};
