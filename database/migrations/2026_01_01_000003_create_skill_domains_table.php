<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The four core skill domains for 1123 English:
     * grammar, comprehension, vocabulary, writing.
     * Each contains multiple sub-skills.
     */
    public function up(): void
    {
        Schema::create('skill_domains', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 50)->unique();
            $table->string('name', 100);
            $table->unsignedTinyInteger('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_domains');
    }
};
