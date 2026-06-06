<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adds a self-referencing parent_id column to sub_skills,
     * enabling a nested skill hierarchy.
     *
     * Level 1: skill_domains (4 rows)
     * Level 2: sub_skills with parent_id = null (top-level sub-skills)
     * Level 3+: sub_skills with parent_id pointing to their parent (leaf nodes)
     *
     * SET NULL on delete: deleting a parent sub-skill unparents its
     * children rather than cascading, preserving the taxonomy data.
     */
    public function up(): void
    {
        Schema::table('sub_skills', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('skill_domain_id')
                ->constrained('sub_skills')->nullOnDelete();
            $table->index('parent_id');
        });
    }

    public function down(): void
    {
        Schema::table('sub_skills', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
