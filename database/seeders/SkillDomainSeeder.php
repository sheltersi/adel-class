<?php

namespace Database\Seeders;

use App\Models\SkillDomain;
use Illuminate\Database\Seeder;

class SkillDomainSeeder extends Seeder
{
    public function run(): void
    {
        $domains = [
            [
                'slug' => 'grammar',
                'name' => 'Grammar',
                'display_order' => 1,
            ],
            [
                'slug' => 'vocabulary',
                'name' => 'Vocabulary',
                'display_order' => 2,
            ],
            [
                'slug' => 'reading',
                'name' => 'Reading Comprehension',
                'display_order' => 3,
            ],
            [
                'slug' => 'writing',
                'name' => 'Writing',
                'display_order' => 4,
            ],
        ];

        foreach ($domains as $domain) {
            SkillDomain::firstOrCreate(['slug' => $domain['slug']], $domain);
        }
    }
}
