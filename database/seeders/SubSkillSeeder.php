<?php

namespace Database\Seeders;

use App\Models\SkillDomain;
use App\Models\SubSkill;
use Illuminate\Database\Seeder;

class SubSkillSeeder extends Seeder
{
    /**
     * Full Cambridge O Level English 1123 skill hierarchy (2024-2026 syllabus).
     * Each domain contains top-level sub-skills (parent_id = null),
     * each of which may contain leaf-node children.
     *
     * Mapped to assessment objectives:
     * R1 - Explicit meanings      R4 - Writer effects
     * R2 - Implicit meanings      R5 - Select & use information
     * R3 - Analyse & evaluate     W1-W5 - Writing objectives
     */
    private array $grammarSkills = [
        [
            'slug' => 'tense-accuracy', 'name' => 'Tense Accuracy', 'display_order' => 1,
            'description' => 'Correct formation and consistent use of verb tenses across sentences and paragraphs.',
            'children' => [
                ['slug' => 'present-tenses', 'name' => 'Present Tenses (simple, continuous, perfect)'],
                ['slug' => 'past-tenses', 'name' => 'Past Tenses (simple, continuous, perfect)'],
                ['slug' => 'future-forms', 'name' => 'Future Forms (will, going to, present continuous for future)'],
                ['slug' => 'tense-consistency', 'name' => 'Tense Consistency in Paragraphs'],
            ],
        ],
        [
            'slug' => 'subject-verb-agreement', 'name' => 'Subject-Verb Agreement', 'display_order' => 2,
            'description' => 'Ensuring the verb matches the subject in number and person.',
            'children' => [
                ['slug' => 'singular-plural-agreement', 'name' => 'Singular/Plural Agreement'],
                ['slug' => 'collective-nouns', 'name' => 'Collective Nouns (team, family, government)'],
                ['slug' => 'indefinite-pronouns', 'name' => 'Indefinite Pronouns (everyone, neither, each)'],
                ['slug' => 'intervening-phrases', 'name' => 'Intervening Phrases (the box of chocolates is/are)'],
            ],
        ],
        [
            'slug' => 'articles', 'name' => 'Articles', 'display_order' => 3,
            'description' => 'Correct use of definite, indefinite, and zero article.',
            'children' => [
                ['slug' => 'definite-article', 'name' => 'Definite Article (the)'],
                ['slug' => 'indefinite-articles', 'name' => 'Indefinite Articles (a/an)'],
                ['slug' => 'zero-article', 'name' => 'Zero Article (no article)'],
            ],
        ],
        [
            'slug' => 'prepositions', 'name' => 'Prepositions', 'display_order' => 4,
            'description' => 'Accurate use of prepositions for time, place, direction, and dependent combinations.',
            'children' => [
                ['slug' => 'time-prepositions', 'name' => 'Time Prepositions (at, on, in, since, for, during)'],
                ['slug' => 'place-prepositions', 'name' => 'Place Prepositions (at, on, in, above, between)'],
                ['slug' => 'direction-prepositions', 'name' => 'Direction Prepositions (to, toward, into, onto)'],
                ['slug' => 'dependent-prepositions', 'name' => 'Dependent Prepositions (good at, afraid of, interested in)'],
            ],
        ],
        [
            'slug' => 'modal-verbs', 'name' => 'Modal Verbs', 'display_order' => 5,
            'description' => 'Using modal verbs to express ability, obligation, possibility, and permission.',
            'children' => [
                ['slug' => 'ability-modals', 'name' => 'Ability (can, could, be able to)'],
                ['slug' => 'obligation-modals', 'name' => 'Obligation & Necessity (must, have to, should, ought to)'],
                ['slug' => 'possibility-modals', 'name' => 'Possibility & Probability (may, might, could, must)'],
                ['slug' => 'permission-modals', 'name' => 'Permission & Requests (can, could, may, would)'],
            ],
        ],
        [
            'slug' => 'conditional-sentences', 'name' => 'Conditional Sentences', 'display_order' => 6,
            'description' => 'Constructing zero, first, second, and third conditionals accurately.',
            'children' => [
                ['slug' => 'zero-conditional', 'name' => 'Zero Conditional (If + present, present)'],
                ['slug' => 'first-conditional', 'name' => 'First Conditional (If + present, will)'],
                ['slug' => 'second-conditional', 'name' => 'Second Conditional (If + past, would)'],
                ['slug' => 'third-conditional', 'name' => 'Third Conditional (If + past perfect, would have)'],
            ],
        ],
        [
            'slug' => 'passive-voice', 'name' => 'Passive Voice', 'display_order' => 7,
            'description' => 'Forming and using the passive voice when appropriate.',
            'children' => [
                ['slug' => 'present-past-passive', 'name' => 'Present & Past Passive'],
                ['slug' => 'passive-with-modals', 'name' => 'Passive with Modals (must be done, can be seen)'],
                ['slug' => 'active-passive-transformation', 'name' => 'Active-to-Passive Transformation'],
            ],
        ],
        [
            'slug' => 'reported-speech', 'name' => 'Reported Speech', 'display_order' => 8,
            'description' => 'Converting direct speech to reported speech with correct tense and pronoun shifts.',
            'children' => [
                ['slug' => 'reported-statements', 'name' => 'Reported Statements'],
                ['slug' => 'reported-questions', 'name' => 'Reported Questions'],
                ['slug' => 'reported-commands', 'name' => 'Reported Commands & Requests'],
            ],
        ],
        [
            'slug' => 'relative-clauses', 'name' => 'Relative Clauses', 'display_order' => 9,
            'description' => 'Using defining and non-defining relative clauses to add information.',
            'children' => [
                ['slug' => 'defining-clauses', 'name' => 'Defining Clauses (who, that, which, whose, where)'],
                ['slug' => 'non-defining-clauses', 'name' => 'Non-Defining Clauses'],
                ['slug' => 'relative-pronoun-omission', 'name' => 'Relative Pronoun Omission'],
            ],
        ],
        [
            'slug' => 'conjunctions-connectors', 'name' => 'Conjunctions & Connectors', 'display_order' => 10,
            'description' => 'Linking ideas with coordinating, subordinating, and transitional connectors.',
            'children' => [
                ['slug' => 'coordinating-conjunctions', 'name' => 'Coordinating (and, but, or, so, yet)'],
                ['slug' => 'subordinating-conjunctions', 'name' => 'Subordinating (because, although, while, unless)'],
                ['slug' => 'contrastive-connectors', 'name' => 'Contrastive (however, nevertheless, on the other hand)'],
                ['slug' => 'additive-connectors', 'name' => 'Additive (furthermore, moreover, in addition)'],
                ['slug' => 'sequential-connectors', 'name' => 'Sequential (firstly, subsequently, finally)'],
            ],
        ],
        [
            'slug' => 'sentence-structure', 'name' => 'Sentence Structure', 'display_order' => 11,
            'description' => 'Constructing simple, compound, and complex sentences without fragments or run-ons.',
            'children' => [
                ['slug' => 'simple-sentences', 'name' => 'Simple Sentences'],
                ['slug' => 'compound-sentences', 'name' => 'Compound Sentences'],
                ['slug' => 'complex-sentences', 'name' => 'Complex Sentences'],
                ['slug' => 'sentence-fragments', 'name' => 'Sentence Fragments (avoidance)'],
                ['slug' => 'run-on-sentences', 'name' => 'Run-on Sentences & Comma Splices (avoidance)'],
            ],
        ],
        [
            'slug' => 'punctuation', 'name' => 'Punctuation', 'display_order' => 12,
            'description' => 'Accurate use of all punctuation marks including commas, apostrophes, and quotation marks.',
            'children' => [
                ['slug' => 'end-punctuation', 'name' => 'Full Stops, Question Marks, Exclamation Marks'],
                ['slug' => 'commas', 'name' => 'Commas (lists, clauses, appositives)'],
                ['slug' => 'apostrophes', 'name' => 'Apostrophes (possession, contraction)'],
                ['slug' => 'quotation-marks', 'name' => 'Quotation Marks (direct speech)'],
                ['slug' => 'colons-semicolons', 'name' => 'Colons & Semicolons'],
                ['slug' => 'capitalisation', 'name' => 'Capitalisation'],
            ],
        ],
        [
            'slug' => 'word-order', 'name' => 'Word Order', 'display_order' => 13,
            'description' => 'Correct SVO structure, adverb placement, adjective ordering, and question formation.',
            'children' => [
                ['slug' => 'svo-structure', 'name' => 'SVO Structure (Subject-Verb-Object)'],
                ['slug' => 'adverb-placement', 'name' => 'Adverb Placement (frequency, manner, time)'],
                ['slug' => 'adjective-order', 'name' => 'Adjective Order'],
                ['slug' => 'question-formation', 'name' => 'Question Formation (inversion, do-support)'],
            ],
        ],
        [
            'slug' => 'comparatives-superlatives', 'name' => 'Comparatives & Superlatives', 'display_order' => 14,
            'description' => 'Forming and using comparative and superlative adjectives and adverbs.',
            'children' => [
                ['slug' => 'regular-comparatives', 'name' => 'Regular Forms (-er, -est)'],
                ['slug' => 'irregular-comparatives', 'name' => 'Irregular Forms (good/better/best)'],
                ['slug' => 'as-as-comparisons', 'name' => 'As...as Comparisons'],
                ['slug' => 'modifying-comparatives', 'name' => 'Modifying Comparatives (much better, slightly worse)'],
            ],
        ],
        [
            'slug' => 'determiners-quantifiers', 'name' => 'Determiners & Quantifiers', 'display_order' => 15,
            'description' => 'Correct use of determiners and quantifiers with countable and uncountable nouns.',
            'children' => [
                ['slug' => 'some-any-no', 'name' => 'some/any/no'],
                ['slug' => 'much-many', 'name' => 'much/many/a lot of'],
                ['slug' => 'few-a-few', 'name' => 'few/a few, little/a little'],
                ['slug' => 'each-every-all', 'name' => 'each/every/all/both/neither'],
            ],
        ],
        [
            'slug' => 'common-error-avoidance', 'name' => 'Common Error Avoidance', 'display_order' => 16,
            'description' => 'Identifying and avoiding frequent grammatical errors in extended writing.',
            'children' => [
                ['slug' => 'double-negatives', 'name' => 'Double Negatives'],
                ['slug' => 'dangling-modifiers', 'name' => 'Dangling Modifiers'],
                ['slug' => 'pronoun-agreement', 'name' => 'Pronoun Agreement & Reference'],
                ['slug' => 'parallel-structure', 'name' => 'Parallel Structure'],
            ],
        ],
    ];

    private array $vocabularySkills = [
        [
            'slug' => 'word-meaning-precision', 'name' => 'Word Meaning & Precision', 'display_order' => 1,
            'description' => 'Understanding precise meanings and choosing the most accurate word for context.',
            'children' => [
                ['slug' => 'synonyms', 'name' => 'Synonyms (precise word selection)'],
                ['slug' => 'antonyms', 'name' => 'Antonyms'],
                ['slug' => 'homonyms-homophones', 'name' => 'Homonyms & Homophones (there/their/they\'re)'],
                ['slug' => 'shades-of-meaning', 'name' => 'Shades of Meaning (walk vs stride vs stroll)'],
            ],
        ],
        [
            'slug' => 'context-clues', 'name' => 'Context Clues', 'display_order' => 2,
            'description' => 'Deducing word meaning from surrounding text rather than a dictionary.',
            'children' => [
                ['slug' => 'definition-clues', 'name' => 'Definition Clues'],
                ['slug' => 'example-clues', 'name' => 'Example Clues'],
                ['slug' => 'contrast-clues', 'name' => 'Contrast Clues (but, however, unlike)'],
                ['slug' => 'inference-from-context', 'name' => 'Inference from Surrounding Text'],
            ],
        ],
        [
            'slug' => 'collocations', 'name' => 'Collocations', 'display_order' => 3,
            'description' => 'Using natural word combinations that sound correct to native speakers.',
            'children' => [
                ['slug' => 'verb-noun-collocations', 'name' => 'Verb + Noun (make a decision, take a risk)'],
                ['slug' => 'adjective-noun-collocations', 'name' => 'Adjective + Noun (heavy rain, strong coffee)'],
                ['slug' => 'adverb-adjective-collocations', 'name' => 'Adverb + Adjective (bitterly cold, highly unlikely)'],
                ['slug' => 'verb-preposition-collocations', 'name' => 'Verb + Preposition (depend on, believe in)'],
            ],
        ],
        [
            'slug' => 'phrasal-verbs', 'name' => 'Phrasal Verbs', 'display_order' => 4,
            'description' => 'Understanding and correctly using multi-word verbs.',
            'children' => [
                ['slug' => 'separable-phrasal-verbs', 'name' => 'Separable (turn off, pick up, put away)'],
                ['slug' => 'inseparable-phrasal-verbs', 'name' => 'Inseparable (look after, run into, get over)'],
                ['slug' => 'three-part-phrasal-verbs', 'name' => 'Three-Part (put up with, look forward to)'],
            ],
        ],
        [
            'slug' => 'idiomatic-expressions', 'name' => 'Idiomatic Expressions', 'display_order' => 5,
            'description' => 'Understanding and appropriately using common idioms and proverbs.',
            'children' => [
                ['slug' => 'common-idioms', 'name' => 'Common Idioms (once in a blue moon, piece of cake)'],
                ['slug' => 'proverbs-sayings', 'name' => 'Proverbs & Sayings'],
                ['slug' => 'idiom-usage-context', 'name' => 'Contextually Appropriate Idiom Usage'],
            ],
        ],
        [
            'slug' => 'word-formation', 'name' => 'Word Formation', 'display_order' => 6,
            'description' => 'Building vocabulary through prefixes, suffixes, and understanding root words.',
            'children' => [
                ['slug' => 'prefixes', 'name' => 'Prefixes (un-, dis-, re-, pre-, mis-, over-)'],
                ['slug' => 'suffixes', 'name' => 'Suffixes (-tion, -ment, -ness, -able, -ful, -less)'],
                ['slug' => 'root-words', 'name' => 'Root Words'],
                ['slug' => 'converting-word-classes', 'name' => 'Converting Word Classes (noun → verb → adjective)'],
            ],
        ],
        [
            'slug' => 'register-formality', 'name' => 'Register & Formality', 'display_order' => 7,
            'description' => 'Selecting vocabulary appropriate to the formality of the context and audience.',
            'children' => [
                ['slug' => 'formal-register', 'name' => 'Formal Register (academic, official)'],
                ['slug' => 'informal-register', 'name' => 'Informal Register (conversational, personal)'],
                ['slug' => 'neutral-register', 'name' => 'Neutral Register'],
                ['slug' => 'register-shifting', 'name' => 'Register Shifting (adjusting tone for audience)'],
            ],
        ],
        [
            'slug' => 'figurative-language', 'name' => 'Figurative Language', 'display_order' => 8,
            'description' => 'Recognising and using simile, metaphor, personification, and hyperbole.',
            'children' => [
                ['slug' => 'simile', 'name' => 'Simile (as brave as a lion)'],
                ['slug' => 'metaphor', 'name' => 'Metaphor (the world is a stage)'],
                ['slug' => 'personification', 'name' => 'Personification (the wind whispered)'],
                ['slug' => 'hyperbole', 'name' => 'Hyperbole'],
                ['slug' => 'literal-figurative', 'name' => 'Recognising Literal vs Figurative Meaning'],
            ],
        ],
        [
            'slug' => 'connotation', 'name' => 'Connotation', 'display_order' => 9,
            'description' => 'Understanding the positive, negative, or neutral associations of words.',
            'children' => [
                ['slug' => 'positive-connotation', 'name' => 'Positive Connotation (slim vs skinny)'],
                ['slug' => 'negative-connotation', 'name' => 'Negative Connotation (stubborn vs determined)'],
                ['slug' => 'neutral-connotation', 'name' => 'Neutral Connotation'],
            ],
        ],
        [
            'slug' => 'topic-vocabulary', 'name' => 'Topic-Specific Vocabulary', 'display_order' => 10,
            'description' => 'Building vocabulary across common 1123 topic areas.',
            'children' => [
                ['slug' => 'environment-nature', 'name' => 'Environment & Nature'],
                ['slug' => 'technology-media', 'name' => 'Technology & Media'],
                ['slug' => 'education-learning', 'name' => 'Education & Learning'],
                ['slug' => 'health-lifestyle', 'name' => 'Health & Lifestyle'],
                ['slug' => 'travel-culture', 'name' => 'Travel & Culture'],
                ['slug' => 'society-relationships', 'name' => 'Society & Relationships'],
            ],
        ],
        [
            'slug' => 'descriptive-vocabulary', 'name' => 'Descriptive Vocabulary', 'display_order' => 11,
            'description' => 'Using precise sensory and descriptive words for vivid writing.',
            'children' => [
                ['slug' => 'sensory-words', 'name' => 'Sensory Words (sight, sound, smell, taste, touch)'],
                ['slug' => 'character-adjectives', 'name' => 'Character Adjectives (personality, appearance)'],
                ['slug' => 'setting-adjectives', 'name' => 'Setting Adjectives (atmosphere, mood)'],
                ['slug' => 'emotion-words', 'name' => 'Emotion Words (joy, anxiety, frustration, relief)'],
            ],
        ],
        [
            'slug' => 'transitional-linking-words', 'name' => 'Transitional & Linking Words', 'display_order' => 12,
            'description' => 'Using discourse markers to connect ideas and guide the reader.',
            'children' => [
                ['slug' => 'addition-transitions', 'name' => 'Addition (furthermore, moreover, also, besides)'],
                ['slug' => 'contrast-transitions', 'name' => 'Contrast (however, nevertheless, on the contrary)'],
                ['slug' => 'cause-effect-transitions', 'name' => 'Cause & Effect (therefore, consequently)'],
                ['slug' => 'sequencing-transitions', 'name' => 'Sequencing (firstly, subsequently, eventually)'],
                ['slug' => 'conclusion-transitions', 'name' => 'Conclusion (in conclusion, to summarise, overall)'],
            ],
        ],
        [
            'slug' => 'spelling-patterns', 'name' => 'Spelling Patterns', 'display_order' => 13,
            'description' => 'Mastering common spelling rules, British spelling conventions, and commonly misspelt words.',
            'children' => [
                ['slug' => 'spelling-rules', 'name' => 'Common Spelling Rules (i before e)'],
                ['slug' => 'british-vs-american', 'name' => 'British vs American Spelling (colour/color)'],
                ['slug' => 'silent-letters', 'name' => 'Silent Letters (knife, doubt, psychology)'],
                ['slug' => 'commonly-misspelt', 'name' => 'Commonly Misspelt Words (accommodate, necessary)'],
            ],
        ],
    ];

    private array $readingSkills = [
        [
            'slug' => 'comprehension-explicit', 'name' => 'Explicit Meaning (R1)', 'display_order' => 1,
            'description' => 'Demonstrating understanding of explicit meanings by locating stated facts, ideas and information.',
            'children' => [
                ['slug' => 'locating-information', 'name' => 'Locating Explicit Information in a Text'],
                ['slug' => 'identifying-facts', 'name' => 'Identifying Facts & Figures'],
                ['slug' => 'key-details', 'name' => 'Recognising Key Details'],
                ['slug' => 'wh-questions', 'name' => 'Answering Who/What/Where/When Questions'],
            ],
        ],
        [
            'slug' => 'implicit-meaning-attitudes', 'name' => 'Implicit Meaning & Attitudes (R2)', 'display_order' => 2,
            'description' => 'Demonstrating understanding of implicit meanings and writer\'s attitudes. Reading between the lines.',
            'children' => [
                ['slug' => 'drawing-conclusions', 'name' => 'Drawing Conclusions from Evidence'],
                ['slug' => 'reading-between-lines', 'name' => 'Reading Between the Lines'],
                ['slug' => 'predicting-outcomes', 'name' => 'Predicting Outcomes'],
                ['slug' => 'inferring-character', 'name' => 'Inferring Character Feelings & Motivations'],
                ['slug' => 'inferring-cause-effect', 'name' => 'Inferring Cause from Effect'],
            ],
        ],
        [
            'slug' => 'analyse-evaluate', 'name' => 'Analysis & Evaluation (R3)', 'display_order' => 3,
            'description' => 'Analysing, evaluating and developing facts, ideas and opinions using support from the text.',
            'children' => [
                ['slug' => 'evaluating-arguments', 'name' => 'Evaluating Arguments'],
                ['slug' => 'assessing-evidence', 'name' => 'Assessing Strength of Evidence'],
                ['slug' => 'logical-fallacies', 'name' => 'Identifying Logical Fallacies'],
                ['slug' => 'generalisations', 'name' => 'Recognising Generalisations'],
                ['slug' => 'evaluating-persuasiveness', 'name' => 'Evaluating Persuasiveness'],
                ['slug' => 'fact-vs-opinion', 'name' => 'Distinguishing Fact from Opinion'],
            ],
        ],
        [
            'slug' => 'writer-effects', 'name' => 'Writer Effects & Influence (R4)', 'display_order' => 4,
            'description' => 'Demonstrating understanding of how writers achieve effects and influence readers. Analysing language choices.',
            'children' => [
                ['slug' => 'linguistic-devices', 'name' => 'Recognising Linguistic Devices'],
                ['slug' => 'word-choice-effect', 'name' => 'Analysing Word Choice and Its Effect'],
                ['slug' => 'sentence-structure-effect', 'name' => 'How Sentence Structure Creates Effect'],
                ['slug' => 'rhetorical-questions', 'name' => 'Rhetorical Questions'],
                ['slug' => 'repetition-emphasis', 'name' => 'Repetition & Emphasis'],
                ['slug' => 'emotive-language', 'name' => 'Emotive Language'],
                ['slug' => 'imagery-in-reading', 'name' => 'Imagery & Descriptive Language in Reading'],
                ['slug' => 'tone-detection', 'name' => 'Identifying Tone & How It Is Created'],
                ['slug' => 'figurative-language-reading', 'name' => 'Recognising Figurative Language in Reading'],
            ],
        ],
        [
            'slug' => 'select-use-information', 'name' => 'Select & Use Information (R5)', 'display_order' => 5,
            'description' => 'Selecting and using information for specific purposes. Key for summary and directed writing.',
            'children' => [
                ['slug' => 'identifying-key-points', 'name' => 'Identifying Key Points in Source Text'],
                ['slug' => 'relevant-vs-irrelevant', 'name' => 'Distinguishing Relevant from Irrelevant Information'],
                ['slug' => 'selecting-evidence', 'name' => 'Selecting Evidence to Support a Point'],
                ['slug' => 'synthesising-information', 'name' => 'Synthesising Information from Multiple Sources'],
            ],
        ],
        [
            'slug' => 'main-idea-purpose', 'name' => 'Main Idea & Purpose', 'display_order' => 6,
            'description' => 'Identifying the central argument, distinguishing main ideas from details, and understanding author\'s purpose.',
            'children' => [
                ['slug' => 'central-argument', 'name' => 'Identifying the Central Argument'],
                ['slug' => 'main-idea-vs-detail', 'name' => 'Distinguishing Main Idea from Supporting Detail'],
                ['slug' => 'authors-purpose', 'name' => 'Author\'s Purpose (inform, persuade, entertain, describe)'],
                ['slug' => 'summarising', 'name' => 'Summarising a Passage in Own Words'],
            ],
        ],
        [
            'slug' => 'text-structure', 'name' => 'Text Structure & Organisation', 'display_order' => 7,
            'description' => 'Recognising how texts are organised and how paragraphs function.',
            'children' => [
                ['slug' => 'paragraph-structure', 'name' => 'Recognising Paragraph Structure'],
                ['slug' => 'topic-sentences', 'name' => 'Identifying Topic Sentences'],
                ['slug' => 'chronological-order', 'name' => 'Understanding Chronological Order'],
                ['slug' => 'problem-solution', 'name' => 'Recognising Problem-Solution Pattern'],
                ['slug' => 'compare-contrast', 'name' => 'Recognising Compare-Contrast Pattern'],
            ],
        ],
        [
            'slug' => 'vocabulary-in-context-reading', 'name' => 'Vocabulary in Context (Reading)', 'display_order' => 8,
            'description' => 'Deducing word meanings from reading contexts and understanding pronoun references.',
            'children' => [
                ['slug' => 'deducing-word-meaning', 'name' => 'Deducing Word Meaning from Context'],
                ['slug' => 'pronoun-references', 'name' => 'Understanding Pronoun References'],
                ['slug' => 'synonyms-in-text', 'name' => 'Identifying Synonyms Used in the Text'],
                ['slug' => 'ambiguous-words', 'name' => 'Recognising Ambiguous or Multi-Meaning Words'],
            ],
        ],
        [
            'slug' => 'writers-tone-attitude', 'name' => 'Writer\'s Tone & Attitude', 'display_order' => 9,
            'description' => 'Identifying tone, bias, and implied attitude in texts.',
            'children' => [
                ['slug' => 'identifying-tone', 'name' => 'Identifying Tone (formal, sarcastic, optimistic, critical)'],
                ['slug' => 'recognising-bias', 'name' => 'Recognising Bias'],
                ['slug' => 'implied-attitude', 'name' => 'Understanding Implied Attitude'],
            ],
        ],
        [
            'slug' => 'comparison-contrast', 'name' => 'Comparison & Contrast', 'display_order' => 10,
            'description' => 'Comparing and contrasting information, perspectives, and viewpoints across texts.',
            'children' => [
                ['slug' => 'similarities', 'name' => 'Identifying Similarities Across Passages'],
                ['slug' => 'differences', 'name' => 'Identifying Differences Across Passages'],
                ['slug' => 'comparing-perspectives', 'name' => 'Comparing Author Perspectives'],
                ['slug' => 'contrasting-viewpoints', 'name' => 'Analysing Contrasting Viewpoints'],
            ],
        ],
        [
            'slug' => 'cause-effect-reading', 'name' => 'Cause & Effect Relationships', 'display_order' => 11,
            'description' => 'Tracing cause-effect chains and distinguishing correlation from causation in texts.',
            'children' => [
                ['slug' => 'signal-words', 'name' => 'Identifying Cause-Effect Signal Words'],
                ['slug' => 'tracing-events', 'name' => 'Tracing Chains of Events'],
                ['slug' => 'cause-vs-correlation', 'name' => 'Distinguishing Cause from Correlation'],
            ],
        ],
        [
            'slug' => 'reading-efficiency', 'name' => 'Reading Speed & Efficiency', 'display_order' => 12,
            'description' => 'Skimming, scanning, and selective reading under timed exam conditions.',
            'children' => [
                ['slug' => 'skimming', 'name' => 'Skimming for Gist'],
                ['slug' => 'scanning', 'name' => 'Scanning for Specific Information'],
                ['slug' => 'selective-reading', 'name' => 'Selective Reading for Detail'],
                ['slug' => 'timed-reading', 'name' => 'Timed Reading Under Exam Conditions'],
            ],
        ],
        [
            'slug' => 'extended-response-reading', 'name' => 'Extended Response (Reading)', 'display_order' => 13,
            'description' => 'Constructing effective written answers to reading comprehension questions.',
            'children' => [
                ['slug' => 'full-sentence-answers', 'name' => 'Answering in Full Sentences'],
                ['slug' => 'using-own-words', 'name' => 'Using Own Words (not lifting from text)'],
                ['slug' => 'textual-evidence', 'name' => 'Providing Textual Evidence'],
                ['slug' => 'word-limit-responses', 'name' => 'Answering Within Word Limits'],
            ],
        ],
    ];

    private array $writingSkills = [
        [
            'slug' => 'summary-writing', 'name' => 'Summary Writing (Paper 1 Q3a)', 'display_order' => 1,
            'description' => 'Selecting key points and writing a concise summary of ≤150 words in continuous prose.',
            'children' => [
                ['slug' => 'identifying-summary-points', 'name' => 'Identifying Key Points from Source Text'],
                ['slug' => 'distinguishing-main-ideas', 'name' => 'Distinguishing Main Ideas from Examples'],
                ['slug' => 'paraphrasing', 'name' => 'Paraphrasing (using own words)'],
                ['slug' => 'condensing-information', 'name' => 'Condensing Information Concisely'],
                ['slug' => 'maintaining-meaning', 'name' => 'Maintaining Original Meaning'],
                ['slug' => 'sequencing-summary', 'name' => 'Sequencing Points Logically'],
                ['slug' => 'linking-points', 'name' => 'Linking Points with Connectors'],
                ['slug' => 'continuous-writing', 'name' => 'Writing Continuously (not in note form)'],
                ['slug' => 'summary-word-limit', 'name' => 'Staying Within 150-Word Limit'],
            ],
        ],
        [
            'slug' => 'directed-writing', 'name' => 'Directed Writing (Paper 2 SA)', 'display_order' => 2,
            'description' => 'Reading stimulus text(s) and writing a discursive/argumentative/persuasive response of 250-350 words.',
            'children' => [
                ['slug' => 'understanding-directed-task', 'name' => 'Understanding the Task & Stimulus Material'],
                ['slug' => 'selecting-content-points', 'name' => 'Selecting Relevant Content Points'],
                ['slug' => 'developing-content-points', 'name' => 'Developing Content Points with Detail'],
                ['slug' => 'adapting-for-purpose', 'name' => 'Adapting Content for Purpose & Audience'],
                ['slug' => 'directed-type-conventions', 'name' => 'Text Type Conventions'],
                ['slug' => 'directed-format', 'name' => 'Format & Layout Conventions'],
                ['slug' => 'directed-register', 'name' => 'Appropriate Register & Tone'],
                ['slug' => 'directed-word-limit', 'name' => 'Staying Within 250-350 Word Limit'],
            ],
        ],
        [
            'slug' => 'directed-text-types', 'name' => 'Directed Writing — Text Types', 'display_order' => 3,
            'description' => 'Specific conventions for each directed writing text type: speech, email, report, letter, article.',
            'children' => [
                ['slug' => 'speech', 'name' => 'Speech/Talk'],
                ['slug' => 'email', 'name' => 'Email'],
                ['slug' => 'report', 'name' => 'Report'],
                ['slug' => 'letter', 'name' => 'Letter (formal or informal)'],
                ['slug' => 'article', 'name' => 'Article'],
            ],
        ],
        [
            'slug' => 'narrative-writing', 'name' => 'Narrative Writing (Paper 2 SB)', 'display_order' => 4,
            'description' => 'Telling a story with connected events (real or imaginary), 350-450 words.',
            'children' => [
                ['slug' => 'plot-development', 'name' => 'Plot Development'],
                ['slug' => 'narrative-structure', 'name' => 'Creating Clear Beginning, Middle, End'],
                ['slug' => 'building-tension', 'name' => 'Building Tension & Suspense'],
                ['slug' => 'climax', 'name' => 'Using a Climax Effectively'],
                ['slug' => 'satisfying-ending', 'name' => 'Crafting a Satisfying Ending'],
                ['slug' => 'character-development', 'name' => 'Character Development'],
                ['slug' => 'creating-characters', 'name' => 'Creating Believable Characters'],
                ['slug' => 'character-through-action', 'name' => 'Revealing Character Through Action & Dialogue'],
                ['slug' => 'character-motivation', 'name' => 'Character Motivation & Change'],
                ['slug' => 'setting-atmosphere', 'name' => 'Setting & Atmosphere'],
                ['slug' => 'describing-time-place', 'name' => 'Describing Time & Place'],
                ['slug' => 'creating-mood', 'name' => 'Creating Mood Through Setting'],
                ['slug' => 'sensory-details', 'name' => 'Using Sensory Details'],
                ['slug' => 'narrative-perspective', 'name' => 'Narrative Perspective'],
                ['slug' => 'first-person', 'name' => 'First Person Narration'],
                ['slug' => 'third-person', 'name' => 'Third Person Narration'],
                ['slug' => 'consistent-pov', 'name' => 'Maintaining Consistent Point of View'],
                ['slug' => 'dialogue', 'name' => 'Dialogue'],
                ['slug' => 'formatting-dialogue', 'name' => 'Formatting Dialogue Correctly'],
                ['slug' => 'natural-dialogue', 'name' => 'Making Dialogue Sound Natural'],
                ['slug' => 'dialogue-advancement', 'name' => 'Using Dialogue to Advance Plot'],
                ['slug' => 'pacing', 'name' => 'Pacing'],
                ['slug' => 'varied-sentence-length', 'name' => 'Varying Sentence Length for Effect'],
                ['slug' => 'flashbacks', 'name' => 'Using Flashbacks or Flash-forwards'],
                ['slug' => 'balancing-elements', 'name' => 'Balancing Action, Description & Reflection'],
                ['slug' => 'narrative-word-limit', 'name' => 'Staying Within 350-450 Word Limit'],
            ],
        ],
        [
            'slug' => 'descriptive-writing', 'name' => 'Descriptive Writing (Paper 2 SB)', 'display_order' => 5,
            'description' => 'Describing a person, place or situation in vivid detail, 350-450 words.',
            'children' => [
                ['slug' => 'sensory-description', 'name' => 'Sensory Description'],
                ['slug' => 'visual-details', 'name' => 'Visual Details (colour, shape, size, movement)'],
                ['slug' => 'auditory-details', 'name' => 'Auditory Details (sounds, silence, rhythm)'],
                ['slug' => 'olfactory-details', 'name' => 'Olfactory Details (smells, scents)'],
                ['slug' => 'tactile-details', 'name' => 'Tactile Details (texture, temperature)'],
                ['slug' => 'imagery-figurative', 'name' => 'Imagery & Figurative Language in Writing'],
                ['slug' => 'using-similes', 'name' => 'Using Similes'],
                ['slug' => 'using-metaphors', 'name' => 'Using Metaphors'],
                ['slug' => 'using-personification', 'name' => 'Using Personification'],
                ['slug' => 'avoiding-cliches', 'name' => 'Avoiding Clichéd Imagery'],
                ['slug' => 'descriptive-structure', 'name' => 'Structure & Focus'],
                ['slug' => 'dominant-impression', 'name' => 'Creating a Dominant Impression'],
                ['slug' => 'spatial-temporal-order', 'name' => 'Organising Description Logically'],
                ['slug' => 'wide-close-focus', 'name' => 'Moving Between Wide and Close Focus'],
                ['slug' => 'avoiding-list-description', 'name' => 'Avoiding List-Like Description'],
                ['slug' => 'descriptive-vocab-choice', 'name' => 'Precise Adjectives & Adverbs'],
                ['slug' => 'strong-verbs', 'name' => 'Strong, Specific Verbs'],
                ['slug' => 'avoiding-vague-language', 'name' => 'Avoiding Vague Language'],
                ['slug' => 'descriptive-word-limit', 'name' => 'Staying Within 350-450 Word Limit'],
            ],
        ],
        [
            'slug' => 'paragraph-organisation', 'name' => 'Paragraph Organisation', 'display_order' => 6,
            'description' => 'Structuring paragraphs with clear topic sentences, support, and transitions.',
            'children' => [
                ['slug' => 'topic-sentences-writing', 'name' => 'Topic Sentences'],
                ['slug' => 'supporting-sentences', 'name' => 'Supporting Sentences with Examples'],
                ['slug' => 'concluding-transitions', 'name' => 'Concluding/Transitional Sentences'],
                ['slug' => 'paragraph-sequencing', 'name' => 'Logical Paragraph Sequencing'],
                ['slug' => 'paragraph-length', 'name' => 'Appropriate Paragraph Length'],
            ],
        ],
        [
            'slug' => 'cohesion-coherence', 'name' => 'Cohesion & Coherence', 'display_order' => 7,
            'description' => 'Using cohesive devices to ensure writing flows logically from one idea to the next.',
            'children' => [
                ['slug' => 'cohesive-devices', 'name' => 'Using Cohesive Devices'],
                ['slug' => 'pronoun-referencing', 'name' => 'Pronoun Referencing (clear antecedents)'],
                ['slug' => 'lexical-cohesion', 'name' => 'Lexical Cohesion (repetition, synonyms, collocation)'],
                ['slug' => 'thematic-progression', 'name' => 'Thematic Progression (old → new information)'],
            ],
        ],
        [
            'slug' => 'sentence-variety-writing', 'name' => 'Sentence Variety (W3)', 'display_order' => 8,
            'description' => 'Using a range of sentence types and structures for deliberate effect.',
            'children' => [
                ['slug' => 'varying-openings', 'name' => 'Varying Sentence Openings'],
                ['slug' => 'mixing-sentence-types', 'name' => 'Mixing Simple, Compound & Complex Sentences'],
                ['slug' => 'short-sentences-impact', 'name' => 'Using Short Sentences for Impact'],
                ['slug' => 'avoiding-repetitive-starts', 'name' => 'Avoiding Repetitive Sentence Starts'],
            ],
        ],
        [
            'slug' => 'content-development-writing', 'name' => 'Content Development (W1)', 'display_order' => 9,
            'description' => 'Articulating experience and expressing ideas with relevant development.',
            'children' => [
                ['slug' => 'generating-ideas', 'name' => 'Generating Relevant Ideas'],
                ['slug' => 'selecting-best-ideas', 'name' => 'Selecting the Best Ideas'],
                ['slug' => 'elaborating-detail', 'name' => 'Elaborating with Detail & Examples'],
                ['slug' => 'avoiding-irrelevant', 'name' => 'Avoiding Irrelevant Content'],
                ['slug' => 'engaging-reader', 'name' => 'Engaging the Reader\'s Interest'],
            ],
        ],
        [
            'slug' => 'task-fulfillment', 'name' => 'Task Fulfillment', 'display_order' => 10,
            'description' => 'Addressing all parts of the question, maintaining focus, and meeting requirements.',
            'children' => [
                ['slug' => 'addressing-all-parts', 'name' => 'Addressing All Parts of the Question'],
                ['slug' => 'understanding-scenario', 'name' => 'Understanding the Given Scenario'],
                ['slug' => 'maintaining-focus', 'name' => 'Maintaining Focus Throughout'],
                ['slug' => 'meeting-word-limits', 'name' => 'Meeting Word Limit Requirements'],
            ],
        ],
        [
            'slug' => 'grammar-mechanics-writing', 'name' => 'Grammar & Mechanics in Writing (W5)', 'display_order' => 11,
            'description' => 'Making accurate use of spelling, punctuation, and grammar throughout written work.',
            'children' => [
                ['slug' => 'accurate-sentences', 'name' => 'Accurate Sentence Construction'],
                ['slug' => 'punctuation-in-context', 'name' => 'Correct Punctuation in Context'],
                ['slug' => 'accurate-spelling', 'name' => 'Accurate Spelling Throughout'],
                ['slug' => 'capitalisation-writing', 'name' => 'Correct Capitalisation'],
                ['slug' => 'consistent-tense-writing', 'name' => 'Consistent Tense Usage Across Paragraphs'],
            ],
        ],
        [
            'slug' => 'vocabulary-range-writing', 'name' => 'Vocabulary Range in Writing (W3)', 'display_order' => 12,
            'description' => 'Using a varied and precise vocabulary appropriate to the writing context.',
            'children' => [
                ['slug' => 'precise-word-choice', 'name' => 'Using Precise, Varied Word Choice'],
                ['slug' => 'avoiding-repetition-writing', 'name' => 'Avoiding Repetition'],
                ['slug' => 'topic-appropriate-vocab', 'name' => 'Using Topic-Appropriate Vocabulary'],
                ['slug' => 'idiomatic-language-writing', 'name' => 'Demonstrating Idiomatic Language'],
            ],
        ],
        [
            'slug' => 'writing-process', 'name' => 'Writing Process', 'display_order' => 13,
            'description' => 'Planning, drafting, revising, and editing under timed exam conditions.',
            'children' => [
                ['slug' => 'planning', 'name' => 'Planning (brainstorming, outlining)'],
                ['slug' => 'drafting', 'name' => 'Drafting'],
                ['slug' => 'revising-content', 'name' => 'Revising for Content & Structure'],
                ['slug' => 'editing-grammar', 'name' => 'Editing for Grammar & Spelling'],
                ['slug' => 'time-management-writing', 'name' => 'Time Management Across All Stages'],
            ],
        ],
        [
            'slug' => 'exam-strategy-writing', 'name' => 'Exam Strategy', 'display_order' => 14,
            'description' => 'Strategic approach to performing well under 1123 exam conditions.',
            'children' => [
                ['slug' => 'reading-question-carefully', 'name' => 'Reading the Question Carefully'],
                ['slug' => 'identifying-keywords', 'name' => 'Identifying Keywords in the Prompt'],
                ['slug' => 'allocating-time', 'name' => 'Allocating Time Per Section'],
                ['slug' => 'checking-work', 'name' => 'Checking Work Before Submission'],
                ['slug' => 'handling-unfamiliar', 'name' => 'Handling Unfamiliar Topics or Prompts'],
            ],
        ],
    ];

    public function run(): void
    {
        $domains = SkillDomain::all()->keyBy('slug');

        $this->seedDomain($domains['grammar'], $this->grammarSkills);
        $this->seedDomain($domains['vocabulary'], $this->vocabularySkills);
        $this->seedDomain($domains['reading'], $this->readingSkills);
        $this->seedDomain($domains['writing'], $this->writingSkills);

        $this->command?->info('Sub-skill hierarchy seeded: ' . SubSkill::count() . ' sub-skills.');
    }

    private function seedDomain(SkillDomain $domain, array $topLevelSkills): void
    {
        foreach ($topLevelSkills as $skillData) {
            $children = $skillData['children'] ?? [];
            unset($skillData['children']);

            $parent = SubSkill::firstOrCreate(
                ['slug' => $skillData['slug']],
                [
                    'skill_domain_id' => $domain->id,
                    'parent_id' => null,
                    ...$skillData,
                ]
            );

            foreach ($children as $childData) {
                SubSkill::firstOrCreate(
                    ['slug' => $childData['slug']],
                    [
                        'skill_domain_id' => $domain->id,
                        'parent_id' => $parent->id,
                        ...$childData,
                    ]
                );
            }
        }
    }
}
