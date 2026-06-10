<?php

namespace Database\Seeders;

use App\Models\Passage;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\SubSkill;
use App\Models\SyllabusSection;
use App\Models\Topic;
use App\Models\WritingPrompt;
use Illuminate\Database\Seeder;

class PlacementTestSeeder extends Seeder
{
    public function run(): void
    {
        $section = SyllabusSection::where('section_number', 'A')->first();
        $topic = Topic::firstOrCreate(
            ['slug' => 'placement-test'],
            [
                'syllabus_section_id' => $section->id,
                'name' => 'Placement Test',
                'description' => 'Questions used exclusively for the diagnostic placement test.',
                'display_order' => 0,
                'is_active' => true,
            ]
        );

        $this->seedGrammarQuestions($topic);
        $this->seedVocabularyQuestions($topic);
        $this->seedReadingPassages();
        $this->seedWritingPrompts($topic);

        $this->command?->info('Placement test content seeded.');
    }

    private function seedGrammarQuestions(Topic $topic): void
    {
        $questions = [
            // Part A: Error Correction (5 items × 1 mark, MCQ)
            [
                'question_type' => 'mcq', 'difficulty' => 2, 'marks' => 1,
                'stem' => 'Choose the correct version: "The list of items ____ long."',
                'options' => [
                    ['text' => 'were', 'correct' => false],
                    ['text' => 'was', 'correct' => true],
                    ['text' => 'are', 'correct' => false],
                    ['text' => 'have been', 'correct' => false],
                ],
                'tags' => ['intervening-phrases'],
            ],
            [
                'question_type' => 'mcq', 'difficulty' => 2, 'marks' => 1,
                'stem' => 'Choose the correct version: "She was walking home when she ____ an old friend."',
                'options' => [
                    ['text' => 'sees', 'correct' => false],
                    ['text' => 'seen', 'correct' => false],
                    ['text' => 'saw', 'correct' => true],
                    ['text' => 'is seeing', 'correct' => false],
                ],
                'tags' => ['tense-consistency'],
            ],
            [
                'question_type' => 'mcq', 'difficulty' => 3, 'marks' => 1,
                'stem' => 'Choose the correct version: "She is good ____ mathematics."',
                'options' => [
                    ['text' => 'in', 'correct' => false],
                    ['text' => 'at', 'correct' => true],
                    ['text' => 'on', 'correct' => false],
                    ['text' => 'for', 'correct' => false],
                ],
                'tags' => ['dependent-prepositions'],
            ],
            [
                'question_type' => 'mcq', 'difficulty' => 3, 'marks' => 1,
                'stem' => 'Choose the correct version: "The man ____ lives next door is a doctor."',
                'options' => [
                    ['text' => 'which', 'correct' => false],
                    ['text' => 'who', 'correct' => true],
                    ['text' => 'what', 'correct' => false],
                    ['text' => 'whose', 'correct' => false],
                ],
                'tags' => ['defining-clauses'],
            ],
            [
                'question_type' => 'mcq', 'difficulty' => 4, 'marks' => 1,
                'stem' => 'Choose the correct version: "If I ____ known, I would have come earlier."',
                'options' => [
                    ['text' => 'would have', 'correct' => false],
                    ['text' => 'had', 'correct' => true],
                    ['text' => 'have', 'correct' => false],
                    ['text' => 'knew', 'correct' => false],
                ],
                'tags' => ['third-conditional'],
            ],
            // Part B: Sentence Transformation (5 items × 1 mark)
            [
                'question_type' => 'short_answer', 'difficulty' => 3, 'marks' => 1,
                'stem' => "Rewrite using the word 'unless': \"You will not succeed if you do not work hard.\"",
                'explanation' => 'Expected: You will not succeed unless you work hard.',
                'tags' => ['first-conditional'],
            ],
            [
                'question_type' => 'short_answer', 'difficulty' => 3, 'marks' => 1,
                'stem' => "Rewrite using the word 'despite': \"Although it was raining, they continued the match.\"",
                'explanation' => 'Expected: Despite the rain, they continued the match.',
                'tags' => ['subordinating-conjunctions'],
            ],
            [
                'question_type' => 'short_answer', 'difficulty' => 2, 'marks' => 1,
                'stem' => "Rewrite using the word 'been': \"Someone has stolen my bicycle.\"",
                'explanation' => 'Expected: My bicycle has been stolen.',
                'tags' => ['present-past-passive'],
            ],
            [
                'question_type' => 'short_answer', 'difficulty' => 3, 'marks' => 1,
                'stem' => "Rewrite using the word 'wished': \"I should have studied harder for the exam.\"",
                'explanation' => 'Expected: I wished I had studied harder for the exam.',
                'tags' => ['reported-statements'],
            ],
            [
                'question_type' => 'short_answer', 'difficulty' => 3, 'marks' => 1,
                'stem' => "Rewrite as one sentence using 'so...that': \"The noise was very loud. We could not hear each other speak.\"",
                'explanation' => 'Expected: The noise was so loud that we could not hear each other speak.',
                'tags' => ['complex-sentences'],
            ],
            // Part C: Gap Fill (5 items × 1 mark)
            [
                'question_type' => 'fill_blank', 'difficulty' => 2, 'marks' => 1,
                'stem' => "Complete the text:\n\n\"Last summer, my family decided to visit ____ old castle near the coast. It was ____ most interesting place we had seen in years. ____ we arrived, we found the gates were locked.\"",
                'options' => [
                    ['text' => 'an', 'correct' => true, 'sort_order' => 'Q1'],
                    ['text' => 'the', 'correct' => true, 'sort_order' => 'Q2'],
                    ['text' => 'When', 'correct' => true, 'sort_order' => 'Q3'],
                    ['text' => 'a', 'correct' => false, 'sort_order' => 'Q1b'],
                    ['text' => 'a', 'correct' => false, 'sort_order' => 'Q2b'],
                    ['text' => 'Since', 'correct' => false, 'sort_order' => 'Q3b'],
                ],
                'explanation' => 'Correct: an old castle (first mention), the most interesting (superlative), when we arrived (time clause).',
                'tags' => ['indefinite-articles', 'definite-article', 'subordinating-conjunctions'],
            ],
            [
                'question_type' => 'fill_blank', 'difficulty' => 2, 'marks' => 1,
                'stem' => 'Complete: "The students were tired ____ they had been studying all night. ____ they decided to take ____ short break before continuing."',
                'options' => [
                    ['text' => 'because', 'correct' => true, 'sort_order' => 'Q1'],
                    ['text' => 'Therefore', 'correct' => true, 'sort_order' => 'Q2'],
                    ['text' => 'a', 'correct' => true, 'sort_order' => 'Q3'],
                    ['text' => 'but', 'correct' => false, 'sort_order' => 'Q1b'],
                    ['text' => 'However', 'correct' => false, 'sort_order' => 'Q2b'],
                    ['text' => 'the', 'correct' => false, 'sort_order' => 'Q3b'],
                ],
                'explanation' => 'Correct: because (reason), Therefore (result), a short break.',
                'tags' => ['subordinating-conjunctions', 'contrastive-connectors', 'indefinite-articles'],
            ],
            [
                'question_type' => 'fill_blank', 'difficulty' => 3, 'marks' => 1,
                'stem' => 'Complete: "You ____ submit the assignment by Friday. The teacher said we ____ ask for an extension if we ____ a valid reason."',
                'options' => [
                    ['text' => 'must', 'correct' => true, 'sort_order' => 'Q1'],
                    ['text' => 'could', 'correct' => true, 'sort_order' => 'Q2'],
                    ['text' => 'have', 'correct' => true, 'sort_order' => 'Q3'],
                    ['text' => 'should', 'correct' => false, 'sort_order' => 'Q1b'],
                    ['text' => 'can', 'correct' => false, 'sort_order' => 'Q2b'],
                    ['text' => 'had', 'correct' => false, 'sort_order' => 'Q3b'],
                ],
                'explanation' => 'Correct: must submit (obligation), could ask (reported possibility), have a valid reason.',
                'tags' => ['obligation-modals', 'possibility-modals'],
            ],
            [
                'question_type' => 'fill_blank', 'difficulty' => 2, 'marks' => 1,
                'stem' => 'Complete: "Neither the teacher nor the students ____ happy with the decision. Everyone ____ asked to share ____ opinion."',
                'options' => [
                    ['text' => 'were', 'correct' => true, 'sort_order' => 'Q1'],
                    ['text' => 'was', 'correct' => true, 'sort_order' => 'Q2'],
                    ['text' => 'their', 'correct' => true, 'sort_order' => 'Q3'],
                    ['text' => 'was', 'correct' => false, 'sort_order' => 'Q1b'],
                    ['text' => 'were', 'correct' => false, 'sort_order' => 'Q2b'],
                    ['text' => 'his', 'correct' => false, 'sort_order' => 'Q3b'],
                ],
                'explanation' => 'Correct: were (nearest subject = students, plural), was (everyone = singular), their (neutral/plural possessive).',
                'tags' => ['singular-plural-agreement', 'pronoun-agreement'],
            ],
            [
                'question_type' => 'fill_blank', 'difficulty' => 3, 'marks' => 1,
                'stem' => 'Complete: "This book is ____ more interesting ____ the one we read last term. It is one of ____ best novels I have ever read."',
                'options' => [
                    ['text' => 'much', 'correct' => true, 'sort_order' => 'Q1'],
                    ['text' => 'than', 'correct' => true, 'sort_order' => 'Q2'],
                    ['text' => 'the', 'correct' => true, 'sort_order' => 'Q3'],
                    ['text' => 'more', 'correct' => false, 'sort_order' => 'Q1b'],
                    ['text' => 'then', 'correct' => false, 'sort_order' => 'Q2b'],
                    ['text' => 'a', 'correct' => false, 'sort_order' => 'Q3b'],
                ],
                'explanation' => 'Correct: much more (modifying comparative), than (comparison), the best (superlative).',
                'tags' => ['modifying-comparatives', 'irregular-comparatives'],
            ],
        ];

        foreach ($questions as $index => $q) {
            $options = $q['options'] ?? [];
            $tags = $q['tags'] ?? [];
            unset($q['options'], $q['tags']);

            $question = Question::firstOrCreate(
                ['topic_id' => $topic->id, 'stem' => $q['stem']],
                ['is_active' => true, 'version' => 1, 'is_ai_scored' => false, ...$q]
            );

            foreach ($options as $optIndex => $opt) {
                QuestionOption::firstOrCreate(
                    ['question_id' => $question->id, 'sort_order' => $opt['sort_order'] ?? chr(65 + $optIndex)],
                    ['option_text' => $opt['text'], 'is_correct' => $opt['correct']],
                );
            }

            foreach ($tags as $tagSlug) {
                $subSkill = SubSkill::where('slug', $tagSlug)->first();
                if ($subSkill) {
                    $question->subSkills()->syncWithoutDetaching([$subSkill->id => ['weight' => 1]]);
                }
            }
        }
    }

    private function seedVocabularyQuestions(Topic $topic): void
    {
        $questions = [
            // Part A: Word in Context (5 items)
            [
                'question_type' => 'mcq', 'difficulty' => 2, 'marks' => 1,
                'stem' => 'The manager decided to relinquish control of the project to her deputy. What does "relinquish" mean?',
                'options' => [
                    ['text' => 'Give up', 'correct' => true],
                    ['text' => 'Increase', 'correct' => false],
                    ['text' => 'Discuss', 'correct' => false],
                    ['text' => 'Delay', 'correct' => false],
                ],
                'tags' => ['synonyms'],
            ],
            [
                'question_type' => 'mcq', 'difficulty' => 3, 'marks' => 1,
                'stem' => 'Dark clouds gathered overhead and the wind began to howl. The storm was imminent. What does "imminent" mean?',
                'options' => [
                    ['text' => 'About to happen', 'correct' => true],
                    ['text' => 'Very powerful', 'correct' => false],
                    ['text' => 'Far away', 'correct' => false],
                    ['text' => 'Unlikely', 'correct' => false],
                ],
                'tags' => ['inference-from-context'],
            ],
            [
                'question_type' => 'mcq', 'difficulty' => 3, 'marks' => 1,
                'stem' => 'The government introduced measures to mitigate the effects of the recession. What does "mitigate" mean?',
                'options' => [
                    ['text' => 'Reduce the severity of', 'correct' => true],
                    ['text' => 'Explain the causes of', 'correct' => false],
                    ['text' => 'Ignore completely', 'correct' => false],
                    ['text' => 'Publicise widely', 'correct' => false],
                ],
                'tags' => ['synonyms', 'definition-clues'],
            ],
            [
                'question_type' => 'mcq', 'difficulty' => 3, 'marks' => 1,
                'stem' => 'The reviewer dismissed the film as "entertaining but ultimately superficial." What does "superficial" suggest about the film?',
                'options' => [
                    ['text' => 'It lacks depth or serious meaning', 'correct' => true],
                    ['text' => 'It is extremely long', 'correct' => false],
                    ['text' => 'It has excellent special effects', 'correct' => false],
                    ['text' => 'It is suitable for all ages', 'correct' => false],
                ],
                'tags' => ['negative-connotation', 'contrast-clues'],
            ],
            [
                'question_type' => 'mcq', 'difficulty' => 4, 'marks' => 1,
                'stem' => 'People who procrastinate invariably find themselves rushing to meet deadlines. What does "invariably" mean?',
                'options' => [
                    ['text' => 'Always, without exception', 'correct' => true],
                    ['text' => 'Occasionally', 'correct' => false],
                    ['text' => 'Deliberately', 'correct' => false],
                    ['text' => 'Regretfully', 'correct' => false],
                ],
                'tags' => ['inference-from-context'],
            ],
            // Part B: Collocation & Usage (5 items)
            [
                'question_type' => 'mcq', 'difficulty' => 2, 'marks' => 1,
                'stem' => 'The scientists plan to ____ research into renewable energy.',
                'options' => [
                    ['text' => 'conduct', 'correct' => true],
                    ['text' => 'make', 'correct' => false],
                    ['text' => 'do', 'correct' => false],
                    ['text' => 'create', 'correct' => false],
                ],
                'tags' => ['verb-noun-collocations'],
            ],
            [
                'question_type' => 'mcq', 'difficulty' => 2, 'marks' => 1,
                'stem' => 'She presented a ____ argument that convinced the entire committee.',
                'options' => [
                    ['text' => 'strong', 'correct' => true],
                    ['text' => 'powerful', 'correct' => false],
                    ['text' => 'heavy', 'correct' => false],
                    ['text' => 'hard', 'correct' => false],
                ],
                'tags' => ['adjective-noun-collocations'],
            ],
            [
                'question_type' => 'mcq', 'difficulty' => 3, 'marks' => 1,
                'stem' => 'He is capable ____ handling the responsibility.',
                'options' => [
                    ['text' => 'of', 'correct' => true],
                    ['text' => 'to', 'correct' => false],
                    ['text' => 'for', 'correct' => false],
                    ['text' => 'in', 'correct' => false],
                ],
                'tags' => ['verb-preposition-collocations'],
            ],
            [
                'question_type' => 'mcq', 'difficulty' => 3, 'marks' => 1,
                'stem' => 'The company will ____ out a survey to understand customer preferences.',
                'options' => [
                    ['text' => 'carry', 'correct' => true],
                    ['text' => 'bring', 'correct' => false],
                    ['text' => 'take', 'correct' => false],
                    ['text' => 'put', 'correct' => false],
                ],
                'tags' => ['separable-phrasal-verbs'],
            ],
            [
                'question_type' => 'mcq', 'difficulty' => 4, 'marks' => 1,
                'stem' => 'In a formal report, which word is most appropriate? "The committee will ____ its findings next week."',
                'options' => [
                    ['text' => 'present', 'correct' => true],
                    ['text' => 'hand in', 'correct' => false],
                    ['text' => 'give out', 'correct' => false],
                    ['text' => 'show off', 'correct' => false],
                ],
                'tags' => ['formal-register', 'register-shifting'],
            ],
            // Part C: Word Formation (5 items)
            [
                'question_type' => 'fill_blank', 'difficulty' => 2, 'marks' => 1,
                'stem' => 'The committee could not reach a ____ (DECIDE).',
                'explanation' => 'Expected: decision.',
                'tags' => ['suffixes'],
            ],
            [
                'question_type' => 'fill_blank', 'difficulty' => 3, 'marks' => 1,
                'stem' => 'Despite her efforts, the attempt was ____ (SUCCESS).',
                'explanation' => 'Expected: unsuccessful.',
                'tags' => ['prefixes', 'suffixes'],
            ],
            [
                'question_type' => 'fill_blank', 'difficulty' => 3, 'marks' => 1,
                'stem' => 'Pollution continues to ____ (DANGER) many species of wildlife.',
                'explanation' => 'Expected: endanger.',
                'tags' => ['prefixes'],
            ],
            [
                'question_type' => 'fill_blank', 'difficulty' => 2, 'marks' => 1,
                'stem' => 'The performance was truly ____ (IMPRESS).',
                'explanation' => 'Expected: impressive.',
                'tags' => ['suffixes'],
            ],
            [
                'question_type' => 'fill_blank', 'difficulty' => 2, 'marks' => 1,
                'stem' => 'Travel can ____ (BROAD) your understanding of other cultures.',
                'explanation' => 'Expected: broaden.',
                'tags' => ['suffixes'],
            ],
        ];

        foreach ($questions as $q) {
            $options = $q['options'] ?? [];
            $tags = $q['tags'] ?? [];
            unset($q['options'], $q['tags']);

            $question = Question::firstOrCreate(
                ['topic_id' => $topic->id, 'stem' => $q['stem']],
                ['is_active' => true, 'version' => 1, 'is_ai_scored' => false, ...$q]
            );

            foreach ($options as $optIndex => $opt) {
                QuestionOption::firstOrCreate(
                    ['question_id' => $question->id, 'sort_order' => $opt['sort_order'] ?? chr(65 + $optIndex)],
                    ['option_text' => $opt['text'], 'is_correct' => $opt['correct']],
                );
            }

            foreach ($tags as $tagSlug) {
                $subSkill = SubSkill::where('slug', $tagSlug)->first();
                if ($subSkill) {
                    $question->subSkills()->syncWithoutDetaching([$subSkill->id => ['weight' => 1]]);
                }
            }
        }
    }

    private function seedReadingPassages(): void
    {
        // Passage A — Narrative (Tier 1: easier, for lower scorers)
        $passageA1 = Passage::firstOrCreate(
            ['title' => 'The Open Door (Easy)'],
            [
                'content' => "Maya stood outside her grandmother's house, her hand hovering over the doorbell. She had not visited in three years — not since the argument that had split the family apart. The garden looked smaller now, the roses untended, the paint on the front door peeling in long strips.\n\nTaking a deep breath, she pressed the bell. From inside came the familiar shuffling footsteps she remembered from childhood. The door opened.\n\n'Maya,' her grandmother said, her voice barely above a whisper. For a long moment, neither of them spoke. Then the old woman's face broke into a smile, and she reached out a trembling hand. 'I knew you would come back,' she said. 'I always knew.'\n\nMaya felt the tears begin to fall. 'I'm sorry, Grandma,' she said. 'I'm so sorry it took so long.'",
                'passage_type' => 'narrative',
                'difficulty' => 2,
                'is_active' => true,
            ]
        );

        // Passage A — Narrative (Tier 2: standard, for higher scorers)
        $passageA2 = Passage::firstOrCreate(
            ['title' => 'The Open Door (Standard)'],
            [
                'content' => "Maya hesitated at the wrought-iron gate, her fingers tracing the familiar pattern of rust and ivy. Three years had passed since she had last stood here — three years since the dinner-table argument that had cleaved the family into silence. The garden, once her grandmother's pride, had surrendered to neglect; the rose bushes had grown wild, their untrimmed branches snagging at her coat as she passed.\n\nShe pressed the brass doorbell and heard its echo through the hallway — the same chime that had announced her arrival a thousand times as a child. The footsteps that followed were slower now, more deliberate. When the door swung open, the face that greeted her was not the one she remembered: it was thinner, more lined, but the eyes — those sharp, knowing eyes — had not changed at all.\n\n'Maya.' Her grandmother spoke her name as though tasting a word she had feared might be forgotten. Silence stretched between them, heavy with three years of unspoken words. Then, unexpectedly, the old woman laughed — a short, wet sound that was half-sob. 'You took your time,' she said, and pulled Maya into an embrace that smelled of lavender and forgiveness.",
                'passage_type' => 'narrative',
                'difficulty' => 3,
                'is_active' => true,
            ]
        );

        // Passage B — Argumentative (Tier 1: easier)
        Passage::firstOrCreate(
            ['title' => 'Screen Time Debate (Easy)'],
            [
                'content' => "Dear Editor,\n\nI am writing to express my concern about the amount of time young people spend on their phones. Every day I see teenagers staring at screens instead of talking to each other. They miss what is happening around them.\n\nSome people say technology helps students learn. This may be true, but too much screen time causes problems. Studies show that children who spend more than three hours a day on devices have trouble sleeping. They also find it harder to concentrate in class.\n\nIn my opinion, schools should have strict rules about phone use. Students should be encouraged to read books, play sports, and spend time outdoors. Technology is a useful tool, but it should not control our lives.\n\nYours faithfully,\nA concerned parent",
                'passage_type' => 'argumentative',
                'difficulty' => 2,
                'is_active' => true,
            ]
        );

        // Passage B — Argumentative (Tier 2: standard)
        Passage::firstOrCreate(
            ['title' => 'Screen Time Debate (Standard)'],
            [
                'content' => "Dear Editor,\n\nI am writing in response to the recent debate regarding smartphone usage among adolescents. While I acknowledge that digital technology has transformed education — providing instant access to information and enabling collaborative learning — I believe we must confront the mounting evidence of its detrimental effects.\n\nThe argument that technology is neutral is, in my view, disingenuous. A tool that is designed to capture attention and maximise engagement cannot be considered neutral, particularly when its target audience is still developing the self-regulation skills necessary to resist such manipulation. Research published in the Journal of Child Psychology indicates that adolescents who exceed three hours of daily screen time demonstrate measurably reduced attention spans and poorer sleep quality compared to their peers.\n\nFurthermore, the social cost is significant. When young people interact primarily through screens, they lose opportunities to develop the nuanced communication skills — reading facial expressions, interpreting tone, navigating uncomfortable silences — that are essential for adulthood.\n\nI am not advocating for a complete ban on technology. Rather, I am suggesting that we approach it with the same caution we apply to other powerful influences in young people's lives. Schools should implement clear policies, and parents should model healthy digital habits at home.\n\nYours faithfully,\nDr. Sarah Chen, Child Psychologist",
                'passage_type' => 'argumentative',
                'difficulty' => 4,
                'is_active' => true,
            ]
        );
    }

    private function seedWritingPrompts(Topic $topic): void
    {
        // Tier 1: Descriptive (for lower scorers)
        WritingPrompt::firstOrCreate(
            ['title' => 'Placement Test — Descriptive (Tier 1)'],
            [
                'topic_id' => $topic->id,
                'prompt_type' => 'descriptive',
                'scenario' => 'Describe a place where you feel calm and relaxed. What do you see, hear, and feel there? Write 150–200 words.',
                'word_limit_min' => 150,
                'word_limit_max' => 200,
                'suggested_time_minutes' => 15,
                'difficulty' => 2,
                'is_active' => true,
            ]
        );

        // Tier 2: Narrative (for mid scorers)
        WritingPrompt::firstOrCreate(
            ['title' => 'Placement Test — Narrative (Tier 2)'],
            [
                'topic_id' => $topic->id,
                'prompt_type' => 'narrative',
                'scenario' => 'Write a story about a time when something unexpected happened. Describe what led up to it and how you reacted. Write 150–200 words.',
                'word_limit_min' => 150,
                'word_limit_max' => 200,
                'suggested_time_minutes' => 15,
                'difficulty' => 3,
                'is_active' => true,
            ]
        );

        // Tier 3: Directed Writing (for higher scorers)
        WritingPrompt::firstOrCreate(
            ['title' => 'Placement Test — Directed Writing (Tier 3)'],
            [
                'topic_id' => $topic->id,
                'prompt_type' => 'directed',
                'scenario' => "Read the following opinion:\n\n\"Schools should not assign homework. Students already spend six hours a day in class, and they need time after school for sports, hobbies, and family. Homework causes unnecessary stress without proven benefits.\"\n\nWrite an email to your school newspaper responding to this opinion. Explain whether you agree or disagree and why. Use your own ideas and ideas from the text. Write 150–200 words.",
                'word_limit_min' => 150,
                'word_limit_max' => 200,
                'suggested_time_minutes' => 15,
                'difficulty' => 4,
                'is_active' => true,
            ]
        );
    }
}
