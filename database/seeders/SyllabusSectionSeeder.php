<?php

namespace Database\Seeders;

use App\Models\SyllabusSection;
use Illuminate\Database\Seeder;

class SyllabusSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'paper' => 'Paper 1',
                'section_number' => 'A',
                'section_name' => 'Comprehension and Use of Language',
                'description' => 'Q1: Comprehension (16 marks, R1+R2) based on Text A (~900-word narrative). Q2: Use of Language (9 marks, R4) analysing writer\'s language choices and effects.',
                'max_marks' => 25,
                'display_order' => 1,
            ],
            [
                'paper' => 'Paper 1',
                'section_number' => 'B',
                'section_name' => 'Summary and Short Response',
                'description' => 'Q3a: Summary (20 marks: 10R+10W, R1+R5+W2+W3) based on Text B (~550-600 words), 150 words max. Q3b: Short Response (5 marks, R2) testing implicit meanings and attitudes.',
                'max_marks' => 25,
                'display_order' => 2,
            ],
            [
                'paper' => 'Paper 2',
                'section_number' => 'A',
                'section_name' => 'Directed Writing',
                'description' => 'Compulsory question (25 marks: 15W+10R, W1-W5+R3+R5). Candidates read stimulus text(s) (~400-450 words) and write a discursive/argumentative/persuasive speech, email, report, letter or article. 250-350 words.',
                'max_marks' => 25,
                'display_order' => 3,
            ],
            [
                'paper' => 'Paper 2',
                'section_number' => 'B1',
                'section_name' => 'Composition — Descriptive',
                'description' => 'Choose 1 of 4 questions (2 descriptive, 2 narrative). Descriptive composition (25 marks, W1+W2+W3+W5). Describes a person, place or situation in detail. 350-450 words.',
                'max_marks' => 25,
                'display_order' => 4,
            ],
            [
                'paper' => 'Paper 2',
                'section_number' => 'B2',
                'section_name' => 'Composition — Narrative',
                'description' => 'Choose 1 of 4 questions (2 descriptive, 2 narrative). Narrative composition (25 marks, W1+W2+W3+W5). Tells a story with connected events, real or imaginary. 350-450 words.',
                'max_marks' => 25,
                'display_order' => 5,
            ],
        ];

        foreach ($sections as $section) {
            SyllabusSection::firstOrCreate(
                ['paper' => $section['paper'], 'section_number' => $section['section_number']],
                $section
            );
        }
    }
}
