<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Order matters: foundational data first, then dependent data.
     */
    public function run(): void
    {
        $this->call([
            // Foundation
            RoleSeeder::class,
            SkillDomainSeeder::class,
            SubSkillSeeder::class,

            // Curriculum
            SyllabusSectionSeeder::class,
            RubricSeeder::class,
        ]);
    }
}
