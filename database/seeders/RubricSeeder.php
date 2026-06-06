<?php

namespace Database\Seeders;

use App\Models\MarkingCriterion;
use App\Models\Rubric;
use Illuminate\Database\Seeder;

class RubricSeeder extends Seeder
{
    /**
     * Cambridge O Level 1123 question-specific rubrics.
     * Each rubric maps to a specific question type in the exam,
     * with criteria aligned to the actual assessment objectives.
     */

    private array $rubrics = [];

    private function defineRubrics(): void
    {
        // Paper 1 Q1: Comprehension (16 marks: R1, R2)
        $this->rubrics['p1q1_comprehension'] = [
            'rubric' => [
                'name' => 'Paper 1 Q1 — Comprehension',
                'rubric_type' => 'comprehension',
                'description' => 'Short-answer comprehension questions on Text A (~900-word narrative). Tests explicit meaning (R1) and implicit meaning/attitudes (R2).',
                'total_marks' => 16,
                'is_active' => true,
            ],
            'criteria' => [
                ['criterion_name' => 'Explicit Meaning (R1)', 'max_marks' => 8, 'display_order' => 1],
                ['criterion_name' => 'Implicit Meaning & Attitudes (R2)', 'max_marks' => 8, 'display_order' => 2],
            ],
            'descriptors' => [
                1 => [['band' => 'A', 'min_score' => 7, 'max_score' => 8, 'descriptor' => 'Locates and retrieves explicit information accurately and fully. Shows precise understanding.'],
                      ['band' => 'B', 'min_score' => 5, 'max_score' => 6, 'descriptor' => 'Locates most explicit information correctly. Minor omissions.'],
                      ['band' => 'C', 'min_score' => 3, 'max_score' => 4, 'descriptor' => 'Identifies some explicit information. Some misunderstandings.'],
                      ['band' => 'D', 'min_score' => 1, 'max_score' => 2, 'descriptor' => 'Struggles to locate information. Frequent inaccuracies.'],
                      ['band' => 'E', 'min_score' => 0, 'max_score' => 0, 'descriptor' => 'Unable to locate explicit information.']],
                2 => [['band' => 'A', 'min_score' => 7, 'max_score' => 8, 'descriptor' => 'Perceptive understanding of implicit meaning and writer\'s attitudes. Insightful interpretation.'],
                      ['band' => 'B', 'min_score' => 5, 'max_score' => 6, 'descriptor' => 'Understands most implicit meanings. Some interpretation is plausible but not full.'],
                      ['band' => 'C', 'min_score' => 3, 'max_score' => 4, 'descriptor' => 'Identifies some implicit meanings. Occasional misreading.'],
                      ['band' => 'D', 'min_score' => 1, 'max_score' => 2, 'descriptor' => 'Rarely identifies implicit meaning. Responses are largely literal.'],
                      ['band' => 'E', 'min_score' => 0, 'max_score' => 0, 'descriptor' => 'No evidence of understanding implicit meaning.']],
            ],
        ];

        // Paper 1 Q2: Use of Language (9 marks: R4)
        $this->rubrics['p1q2_use_of_language'] = [
            'rubric' => [
                'name' => 'Paper 1 Q2 — Use of Language',
                'rubric_type' => 'use_of_language',
                'description' => 'Analyses how writers achieve effects through language choices. Tests R4 only.',
                'total_marks' => 9,
                'is_active' => true,
            ],
            'criteria' => [
                ['criterion_name' => 'Analysis of Language & Effect (R4)', 'max_marks' => 9, 'display_order' => 1],
            ],
            'descriptors' => [
                1 => [['band' => 'A', 'min_score' => 8, 'max_score' => 9, 'descriptor' => 'Perceptive analysis of language choices. Explains how specific words, phrases, and devices achieve their effect. Uses technical terminology accurately.'],
                      ['band' => 'B', 'min_score' => 6, 'max_score' => 7, 'descriptor' => 'Clear analysis of language with some explanation of effect. Identifies devices and attempts to explain how they work.'],
                      ['band' => 'C', 'min_score' => 4, 'max_score' => 5, 'descriptor' => 'Identifies language features but explanation of effect is limited or vague.'],
                      ['band' => 'D', 'min_score' => 2, 'max_score' => 3, 'descriptor' => 'Identifies basic language features with little or no explanation of effect.'],
                      ['band' => 'E', 'min_score' => 0, 'max_score' => 1, 'descriptor' => 'Unable to identify or analyse language features.']],
            ],
        ];

        // Paper 1 Q3a: Summary (20 marks: 10R + 10W)
        $this->rubrics['p1q3a_summary'] = [
            'rubric' => [
                'name' => 'Paper 1 Q3a — Summary',
                'rubric_type' => 'summary',
                'description' => 'Summary of Text B (~550-600 words) in ≤150 words. Tests content selection (R1+R5, 10 marks) and writing quality (W2+W3, 10 marks).',
                'total_marks' => 20,
                'is_active' => true,
            ],
            'criteria' => [
                ['criterion_name' => 'Reading: Content (R1, R5)', 'max_marks' => 10, 'display_order' => 1],
                ['criterion_name' => 'Writing: Organisation & Language (W2, W3)', 'max_marks' => 10, 'display_order' => 2],
            ],
            'descriptors' => [
                1 => [['band' => 'A', 'min_score' => 9, 'max_score' => 10, 'descriptor' => 'Selects all relevant content points. Concise and accurate. No lifting.'],
                      ['band' => 'B', 'min_score' => 7, 'max_score' => 8, 'descriptor' => 'Selects most relevant points. Some minor omissions or slight over-detail.'],
                      ['band' => 'C', 'min_score' => 5, 'max_score' => 6, 'descriptor' => 'Selects some key points. May include irrelevant detail or miss important points.'],
                      ['band' => 'D', 'min_score' => 3, 'max_score' => 4, 'descriptor' => 'Few relevant points selected. Much irrelevant material included.'],
                      ['band' => 'E', 'min_score' => 0, 'max_score' => 2, 'descriptor' => 'Very limited or no relevant content selected.']],
                2 => [['band' => 'A', 'min_score' => 9, 'max_score' => 10, 'descriptor' => 'Well-organised, continuous prose. Wide vocabulary. Effective sentence structures. Clear own words throughout.'],
                      ['band' => 'B', 'min_score' => 7, 'max_score' => 8, 'descriptor' => 'Organised, mostly continuous prose. Good vocabulary range. Mostly own words.'],
                      ['band' => 'C', 'min_score' => 5, 'max_score' => 6, 'descriptor' => 'Some organisation. Adequate vocabulary. Some reliance on text wording.'],
                      ['band' => 'D', 'min_score' => 3, 'max_score' => 4, 'descriptor' => 'List-like or disorganised. Limited vocabulary. Heavily reliant on text words.'],
                      ['band' => 'E', 'min_score' => 0, 'max_score' => 2, 'descriptor' => 'Incoherent. Very limited vocabulary. Largely copied from the text.']],
            ],
        ];

        // Paper 1 Q3b: Short Response (5 marks: R2)
        $this->rubrics['p1q3b_short_response'] = [
            'rubric' => [
                'name' => 'Paper 1 Q3b — Short Response',
                'rubric_type' => 'short_response',
                'description' => 'Short response testing implicit meanings and attitudes in Text B. Tests R2 only.',
                'total_marks' => 5,
                'is_active' => true,
            ],
            'criteria' => [
                ['criterion_name' => 'Implicit Meaning & Attitudes (R2)', 'max_marks' => 5, 'display_order' => 1],
            ],
            'descriptors' => [
                1 => [['band' => 'A', 'min_score' => 5, 'max_score' => 5, 'descriptor' => 'Perceptive understanding. Insightful response fully supported by implicit evidence.'],
                      ['band' => 'B', 'min_score' => 4, 'max_score' => 4, 'descriptor' => 'Clear understanding of implicit meaning with some support.'],
                      ['band' => 'C', 'min_score' => 3, 'max_score' => 3, 'descriptor' => 'Some understanding but not fully developed or only partially supported.'],
                      ['band' => 'D', 'min_score' => 2, 'max_score' => 2, 'descriptor' => 'Limited understanding. Response is largely superficial.'],
                      ['band' => 'E', 'min_score' => 0, 'max_score' => 1, 'descriptor' => 'Little or no understanding of implicit meaning.']],
            ],
        ];

        // Paper 2 SA: Directed Writing (25 marks: 15W + 10R)
        $this->rubrics['p2sa_directed_writing'] = [
            'rubric' => [
                'name' => 'Paper 2 SA — Directed Writing',
                'rubric_type' => 'directed_writing',
                'description' => 'Discursive/argumentative/persuasive response to stimulus text(s). 250-350 words. Tests W1-W5 (15 marks) and R3+R5 (10 marks).',
                'total_marks' => 25,
                'is_active' => true,
            ],
            'criteria' => [
                ['criterion_name' => 'Reading: Content & Ideas (R3, R5)', 'max_marks' => 10, 'display_order' => 1],
                ['criterion_name' => 'Writing: Content & Structure (W1, W2)', 'max_marks' => 10, 'display_order' => 2],
                ['criterion_name' => 'Writing: Style & Accuracy (W3, W4, W5)', 'max_marks' => 5, 'display_order' => 3],
            ],
            'descriptors' => [
                1 => [['band' => 'A', 'min_score' => 9, 'max_score' => 10, 'descriptor' => 'Analyses, evaluates and develops facts, ideas and opinions fully. Well-selected support from text(s).'],
                      ['band' => 'B', 'min_score' => 7, 'max_score' => 8, 'descriptor' => 'Good analysis and development of ideas. Relevant support from text(s).'],
                      ['band' => 'C', 'min_score' => 5, 'max_score' => 6, 'descriptor' => 'Some analysis. Uses text(s) with partial development. Some ideas underdeveloped.'],
                      ['band' => 'D', 'min_score' => 3, 'max_score' => 4, 'descriptor' => 'Limited analysis. Relies heavily on text with little development or evaluation.'],
                      ['band' => 'E', 'min_score' => 0, 'max_score' => 2, 'descriptor' => 'Very limited or no analysis. Does not use text(s) effectively.']],
                2 => [['band' => 'A', 'min_score' => 9, 'max_score' => 10, 'descriptor' => 'Ideas are well-articulated and engaging. Strong, deliberate structure. Effective paragraphing and cohesion.'],
                      ['band' => 'B', 'min_score' => 7, 'max_score' => 8, 'descriptor' => 'Ideas clearly expressed. Good structure. Appropriate paragraphing.'],
                      ['band' => 'C', 'min_score' => 5, 'max_score' => 6, 'descriptor' => 'Adequate expression and structure. Some lapses in organisation.'],
                      ['band' => 'D', 'min_score' => 3, 'max_score' => 4, 'descriptor' => 'Limited organisation. Ideas are unclear or poorly sequenced.'],
                      ['band' => 'E', 'min_score' => 0, 'max_score' => 2, 'descriptor' => 'Disorganised. Ideas are difficult to follow.']],
                3 => [['band' => 'A', 'min_score' => 5, 'max_score' => 5, 'descriptor' => 'Wide vocabulary and varied sentence structures. Register is consistently appropriate. Accurate spelling, punctuation and grammar.'],
                      ['band' => 'B', 'min_score' => 4, 'max_score' => 4, 'descriptor' => 'Good vocabulary range. Some sentence variety. Appropriate register. Mostly accurate.'],
                      ['band' => 'C', 'min_score' => 3, 'max_score' => 3, 'descriptor' => 'Adequate vocabulary. Some variety. Register is sometimes inconsistent. Errors do not impede communication.'],
                      ['band' => 'D', 'min_score' => 2, 'max_score' => 2, 'descriptor' => 'Limited vocabulary and sentence range. Frequent errors may impede clarity.'],
                      ['band' => 'E', 'min_score' => 0, 'max_score' => 1, 'descriptor' => 'Very limited vocabulary. Persistent errors impede understanding.']],
            ],
        ];

        // Paper 2 SB: Narrative Composition (25 marks: W1, W2, W3, W5)
        $this->rubrics['p2sb_narrative'] = [
            'rubric' => [
                'name' => 'Paper 2 SB — Narrative Composition',
                'rubric_type' => 'narrative',
                'description' => 'Narrative composition (350-450 words). Tells a story with connected events. Tests W1, W2, W3, W5.',
                'total_marks' => 25,
                'is_active' => true,
            ],
            'criteria' => [
                ['criterion_name' => 'Content & Structure (W1, W2)', 'max_marks' => 15, 'display_order' => 1],
                ['criterion_name' => 'Style & Accuracy (W3, W5)', 'max_marks' => 10, 'display_order' => 2],
            ],
            'descriptors' => [
                1 => [['band' => 'A', 'min_score' => 13, 'max_score' => 15, 'descriptor' => 'Engaging plot with clear structure. Believable characters and setting. Effective use of narrative techniques (dialogue, pacing, point of view).'],
                      ['band' => 'B', 'min_score' => 10, 'max_score' => 12, 'descriptor' => 'Interesting plot with some development. Characters are established. Clear sequence of events.'],
                      ['band' => 'C', 'min_score' => 7, 'max_score' => 9, 'descriptor' => 'Adequate plot. Events are connected but may lack development. Limited characterisation.'],
                      ['band' => 'D', 'min_score' => 4, 'max_score' => 6, 'descriptor' => 'Simple plot, loosely connected. Characters are flat. Events may be listed rather than developed.'],
                      ['band' => 'E', 'min_score' => 0, 'max_score' => 3, 'descriptor' => 'Very limited plot or no clear narrative structure. No character development.']],
                2 => [['band' => 'A', 'min_score' => 9, 'max_score' => 10, 'descriptor' => 'Wide vocabulary and varied sentence structures for deliberate effect. Precise descriptive language. Highly accurate.'],
                      ['band' => 'B', 'min_score' => 7, 'max_score' => 8, 'descriptor' => 'Good vocabulary range. Some sentence variety. Mostly accurate with occasional errors.'],
                      ['band' => 'C', 'min_score' => 5, 'max_score' => 6, 'descriptor' => 'Adequate vocabulary. Some sentence variety. Errors do not impede communication.'],
                      ['band' => 'D', 'min_score' => 3, 'max_score' => 4, 'descriptor' => 'Limited vocabulary. Simple sentence structures. Frequent errors.'],
                      ['band' => 'E', 'min_score' => 0, 'max_score' => 2, 'descriptor' => 'Very limited vocabulary. Persistent errors impede understanding.']],
            ],
        ];

        // Paper 2 SB: Descriptive Composition (25 marks: W1, W2, W3, W5)
        $this->rubrics['p2sb_descriptive'] = [
            'rubric' => [
                'name' => 'Paper 2 SB — Descriptive Composition',
                'rubric_type' => 'descriptive',
                'description' => 'Descriptive composition (350-450 words). Describes a person, place or situation in detail. Tests W1, W2, W3, W5.',
                'total_marks' => 25,
                'is_active' => true,
            ],
            'criteria' => [
                ['criterion_name' => 'Content & Structure (W1, W2)', 'max_marks' => 15, 'display_order' => 1],
                ['criterion_name' => 'Style & Accuracy (W3, W5)', 'max_marks' => 10, 'display_order' => 2],
            ],
            'descriptors' => [
                1 => [['band' => 'A', 'min_score' => 13, 'max_score' => 15, 'descriptor' => 'Vivid, detailed description creating a strong dominant impression. Effective use of sensory detail. Well-organised with deliberate focus shifts.'],
                      ['band' => 'B', 'min_score' => 10, 'max_score' => 12, 'descriptor' => 'Clear description with good detail. Appropriate sensory elements. Reasonably well-organised.'],
                      ['band' => 'C', 'min_score' => 7, 'max_score' => 9, 'descriptor' => 'Adequate description. Some sensory detail but may be list-like. Basic organisation.'],
                      ['band' => 'D', 'min_score' => 4, 'max_score' => 6, 'descriptor' => 'Limited description. Few sensory details. Weak organisation.'],
                      ['band' => 'E', 'min_score' => 0, 'max_score' => 3, 'descriptor' => 'Very limited or no description. Disorganised or irrelevant.']],
                2 => [['band' => 'A', 'min_score' => 9, 'max_score' => 10, 'descriptor' => 'Wide vocabulary with precise sensory and descriptive words. Varied sentence structures for deliberate effect. Highly accurate.'],
                      ['band' => 'B', 'min_score' => 7, 'max_score' => 8, 'descriptor' => 'Good vocabulary range with some imagery. Some sentence variety. Mostly accurate.'],
                      ['band' => 'C', 'min_score' => 5, 'max_score' => 6, 'descriptor' => 'Adequate vocabulary. Some descriptive words. Errors do not impede communication.'],
                      ['band' => 'D', 'min_score' => 3, 'max_score' => 4, 'descriptor' => 'Limited vocabulary with few descriptive words. Simple sentence structures. Frequent errors.'],
                      ['band' => 'E', 'min_score' => 0, 'max_score' => 2, 'descriptor' => 'Very limited vocabulary. Persistent errors impede understanding.']],
            ],
        ];
    }

    public function run(): void
    {
        $this->defineRubrics();

        foreach ($this->rubrics as $data) {
            $rubric = Rubric::firstOrCreate(
                ['rubric_type' => $data['rubric']['rubric_type']],
                $data['rubric']
            );

            if ($rubric->markingCriteria()->count() === 0) {
                $criteriaOrder = 1;
                foreach ($data['criteria'] as $criterionData) {
                    $criterion = $rubric->markingCriteria()->create($criterionData);

                    if (isset($data['descriptors'][$criteriaOrder])) {
                        foreach ($data['descriptors'][$criteriaOrder] as $descriptorData) {
                            $criterion->markingDescriptors()->create($descriptorData);
                        }
                    }
                    $criteriaOrder++;
                }
            }
        }

        $this->command?->info('Rubrics seeded: ' . Rubric::count() . ' rubrics.');
    }
}
