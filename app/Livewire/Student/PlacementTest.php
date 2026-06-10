<?php

namespace App\Livewire\Student;

use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentResult;
use App\Models\Passage;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionResponse;
use App\Models\SkillDomain;
use App\Models\StudentSubSkillScore;
use App\Models\Topic;
use App\Models\WritingPrompt;
use App\Models\WritingSubmission;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Placement Test')]
class PlacementTest extends Component
{
    public string $view = 'overview';

    public array $answers = [];

    public ?int $assessmentId = null;

    public ?array $questions = null;

    public ?array $passage = null;

    public ?array $writingPrompt = null;

    public string $essayContent = '';

    public int $timeRemaining = 0;

    public int $sectionTimeLimit = 0;

    public array $sectionsCompleted = [];

    public array $lastResults = [];

    private const SECTIONS = [
        'grammar' => ['name' => 'Grammar', 'step' => 1, 'max_score' => 15, 'time_seconds' => 720],
        'vocabulary' => ['name' => 'Vocabulary', 'step' => 2, 'max_score' => 15, 'time_seconds' => 600],
        'reading' => ['name' => 'Reading', 'step' => 3, 'max_score' => 20, 'time_seconds' => 1080],
        'writing' => ['name' => 'Writing', 'step' => 4, 'max_score' => 25, 'time_seconds' => 900],
    ];

    public function mount(): void
    {
        $profile = Auth::user()->studentProfile;
        $this->sectionsCompleted = $profile->placement_sections_completed ?? [];

        if (count(array_intersect(array_keys($this->sectionsCompleted), array_keys(self::SECTIONS))) === count(self::SECTIONS)) {
            $this->redirect(route('profile'), navigate: true);

            return;
        }

        $inProgress = $this->findInProgressSection();
        if ($inProgress) {
            $this->resumeSection($inProgress);

            return;
        }
    }

    private function findInProgressSection(): ?string
    {
        $profileId = Auth::user()->studentProfile->id;

        foreach (array_keys(self::SECTIONS) as $section) {
            if (isset($this->sectionsCompleted[$section])) {
                continue;
            }

            $assessment = Assessment::where('student_profile_id', $profileId)
                ->where('assessment_type', 'diagnostic')
                ->where('paper', 'Placement '.ucfirst($section))
                ->where('status', 'in_progress')
                ->first();

            if ($assessment) {
                $this->assessmentId = $assessment->id;
                $this->timeRemaining = $assessment->time_remaining_seconds ?? self::SECTIONS[$section]['time_seconds'];
                $this->sectionTimeLimit = self::SECTIONS[$section]['time_seconds'];

                return $section;
            }
        }

        return null;
    }

    private function resumeSection(string $section): void
    {
        $this->view = $section;
        $this->loadQuestionsForSection($section);

        $answers = QuestionResponse::whereHas('assessmentQuestion', function ($q) {
            $q->where('assessment_id', $this->assessmentId);
        })->get();

        foreach ($answers as $resp) {
            $this->answers[$resp->assessmentQuestion->question_id] = $resp->student_answer;
        }
    }

    public function startSection(string $section): void
    {
        if (! $this->canStartSection($section)) {
            return;
        }

        $profile = Auth::user()->studentProfile;

        $assessment = Assessment::create([
            'student_profile_id' => $profile->id,
            'assessment_type' => 'diagnostic',
            'paper' => 'Placement '.ucfirst($section),
            'status' => 'in_progress',
            'started_at' => now(),
            'time_limit_seconds' => self::SECTIONS[$section]['time_seconds'],
            'time_remaining_seconds' => self::SECTIONS[$section]['time_seconds'],
            'total_marks' => self::SECTIONS[$section]['max_score'],
        ]);

        $this->assessmentId = $assessment->id;
        $this->answers = [];
        $this->essayContent = '';
        $this->passage = null;
        $this->writingPrompt = null;
        $this->lastResults = [];
        $this->sectionTimeLimit = self::SECTIONS[$section]['time_seconds'];
        $this->timeRemaining = self::SECTIONS[$section]['time_seconds'];
        $this->view = $section;

        $this->loadQuestionsForSection($section);
    }

    private function canStartSection(string $section): bool
    {
        if (isset($this->sectionsCompleted[$section])) {
            return false;
        }

        $sectionDef = self::SECTIONS[$section];
        $step = $sectionDef['step'];

        foreach (self::SECTIONS as $key => $def) {
            if ($def['step'] >= $step) {
                continue;
            }
            if (! isset($this->sectionsCompleted[$key])) {
                return false;
            }
        }

        return true;
    }

    public function getNextAvailableSection(): ?string
    {
        foreach (self::SECTIONS as $key => $def) {
            if (! isset($this->sectionsCompleted[$key])) {
                return $key;
            }
        }

        return null;
    }

    public function isSectionCompleted(string $section): bool
    {
        return isset($this->sectionsCompleted[$section]);
    }

    public function isSectionAvailable(string $section): bool
    {
        if ($this->isSectionCompleted($section)) {
            return false;
        }

        return $this->getNextAvailableSection() === $section;
    }

    public function getSectionLabel(string $section): string
    {
        return self::SECTIONS[$section]['name'];
    }

    public function getSectionMaxScore(string $section): int
    {
        return self::SECTIONS[$section]['max_score'];
    }

    public function getSectionTime(string $section): int
    {
        return self::SECTIONS[$section]['time_seconds'];
    }

    public function getSectionScore(string $section): ?int
    {
        return $this->sectionsCompleted[$section]['score'] ?? null;
    }

    public function getSectionPercentage(string $section): ?float
    {
        return $this->sectionsCompleted[$section]['percentage'] ?? null;
    }

    public function getOverallScore(): int
    {
        $total = 0;
        foreach ($this->sectionsCompleted as $data) {
            $total += $data['score'] ?? 0;
        }

        return $total;
    }

    public function getOverallPercentage(): float
    {
        $totalMarks = array_sum(array_column(self::SECTIONS, 'max_score'));

        return round(($this->getOverallScore() / $totalMarks) * 100, 1);
    }

    private function loadQuestionsForSection(string $section): void
    {
        match ($section) {
            'grammar' => $this->loadGrammarQuestions(),
            'vocabulary' => $this->loadVocabularyQuestions(),
            'reading' => $this->loadReadingSection(),
            'writing' => $this->loadWritingPrompt(),
            default => null,
        };
    }

    private function loadGrammarQuestions(): void
    {
        $questions = $this->placementQuestions()->where('question_type', '!=', 'essay')
            ->take(15)->get();

        $this->questions = $questions->map(fn ($q) => $this->formatQuestion($q))->toArray();
    }

    private function loadVocabularyQuestions(): void
    {
        $questions = $this->placementQuestions()
            ->where('question_type', '!=', 'essay')
            ->skip(15)->take(15)->get();

        $this->questions = $questions->map(fn ($q) => $this->formatQuestion($q))->toArray();
    }

    private function loadReadingSection(): void
    {
        $passage = Passage::where('passage_type', 'narrative')
            ->where('is_active', true)
            ->inRandomOrder()
            ->first();

        $questions = Question::where('topic_id', $this->placementTopic()->id)
            ->where('question_type', '!=', 'essay')
            ->skip(30)->take(4)->get();

        if ($questions->count() < 4) {
            $questions = $this->placementQuestions()
                ->whereNotIn('id', Question::where('topic_id', $this->placementTopic()->id)
                    ->where('question_type', '!=', 'essay')
                    ->take(30)->pluck('id'))
                ->take(4)->get();
        }

        $this->questions = $questions->map(fn ($q) => $this->formatQuestion($q))->toArray();

        if ($passage) {
            $this->passage = [
                'id' => $passage->id,
                'title' => $passage->title,
                'content' => $passage->content,
                'type' => 'narrative',
            ];
        }
    }

    private function loadWritingPrompt(): void
    {
        $preScore = $this->calculatePreScore();

        $difficulty = match (true) {
            $preScore <= 12 => 2,
            $preScore <= 21 => 3,
            default => 4,
        };

        $prompt = WritingPrompt::where('difficulty', $difficulty)
            ->where('is_active', true)
            ->inRandomOrder()
            ->first();

        if (! $prompt) {
            $prompt = WritingPrompt::where('is_active', true)->first();
        }

        if ($prompt) {
            $this->writingPrompt = [
                'id' => $prompt->id,
                'title' => $prompt->title,
                'scenario' => $prompt->scenario,
                'word_limit_min' => $prompt->word_limit_min,
                'word_limit_max' => $prompt->word_limit_max,
                'prompt_type' => $prompt->prompt_type,
            ];
        }
    }

    private function placementQuestions()
    {
        return Question::where('topic_id', $this->placementTopic()->id)
            ->where('is_active', true)
            ->orderBy('question_type')
            ->orderBy('difficulty');
    }

    private function placementTopic()
    {
        return Topic::where('slug', 'placement-test')->firstOrFail();
    }

    private function formatQuestion(Question $q): array
    {
        $options = $q->question_type === 'mcq' || $q->question_type === 'fill_blank'
            ? $q->options->map(fn ($opt) => [
                'id' => $opt->id,
                'text' => $opt->option_text,
                'sort_order' => $opt->sort_order,
            ])->toArray()
            : [];

        return [
            'id' => $q->id,
            'stem' => $q->stem,
            'type' => $q->question_type,
            'marks' => $q->marks,
            'difficulty' => $q->difficulty,
            'options' => $options,
        ];
    }

    private function calculatePreScore(): float
    {
        $score = 0;

        if (isset($this->sectionsCompleted['grammar'])) {
            $score += $this->sectionsCompleted['grammar']['score'];
        }

        if (isset($this->sectionsCompleted['vocabulary'])) {
            $score += $this->sectionsCompleted['vocabulary']['score'];
        }

        return $score;
    }

    public function answerQuestion(int $questionId, $value): void
    {
        $this->answers[$questionId] = $value;
    }

    public function submit(): void
    {
        $section = $this->view;

        if (! in_array($section, array_keys(self::SECTIONS))) {
            return;
        }

        DB::transaction(function () use ($section) {
            $this->saveAnswersForSection($section);

            $results = $this->gradeSection($section);

            $assessment = Assessment::find($this->assessmentId);
            $assessment->update([
                'status' => 'completed',
                'completed_at' => now(),
                'time_remaining_seconds' => max(0, $this->timeRemaining),
            ]);

            AssessmentResult::create([
                'assessment_id' => $this->assessmentId,
                'total_score' => $results['score'],
                'total_marks' => $results['max_score'],
                'percentage' => $results['percentage'],
                'band_score' => $results['classification'],
                'completed_at' => now(),
            ]);

            $this->sectionsCompleted[$section] = [
                'assessment_id' => $this->assessmentId,
                'score' => $results['score'],
                'max_score' => $results['max_score'],
                'percentage' => $results['percentage'],
                'completed_at' => now()->toIso8601String(),
            ];

            $profile = Auth::user()->studentProfile;
            $profile->update([
                'placement_sections_completed' => $this->sectionsCompleted,
            ]);

            $this->lastResults = [
                'section' => $section,
                'section_name' => self::SECTIONS[$section]['name'],
                'score' => $results['score'],
                'max_score' => $results['max_score'],
                'percentage' => $results['percentage'],
                'classification' => $results['classification'],
                'estimated_grade' => $results['estimated_grade'],
            ];

            if (count(array_intersect(array_keys($this->sectionsCompleted), array_keys(self::SECTIONS))) === count(self::SECTIONS)) {
                $this->finalizePlacement($profile);
            }
        });

        $this->view = 'results';
        $this->answers = [];
        $this->questions = null;
        $this->passage = null;
        $this->writingPrompt = null;
        $this->essayContent = '';

        Flux::toast(variant: 'success', text: __('Section completed!'));
    }

    private function saveAnswersForSection(string $section): void
    {
        $questions = $this->questions ?? [];

        if ($section === 'writing') {
            if ($this->essayContent && $this->writingPrompt) {
                WritingSubmission::create([
                    'student_profile_id' => Auth::user()->studentProfile->id,
                    'writing_prompt_id' => $this->writingPrompt['id'],
                    'assessment_id' => $this->assessmentId,
                    'content' => $this->essayContent,
                    'word_count' => str_word_count($this->essayContent),
                    'status' => 'submitted',
                    'submitted_at' => now(),
                ]);
            }

            return;
        }

        foreach ($questions as $q) {
            $answer = $this->answers[$q['id']] ?? null;

            $aq = AssessmentQuestion::firstOrCreate(
                ['assessment_id' => $this->assessmentId, 'question_id' => $q['id']],
                ['sort_order' => 0]
            );

            $score = null;
            $maxScore = $q['marks'];
            $isCorrect = null;
            $selectedOptionId = null;

            if ($q['type'] === 'mcq') {
                $option = QuestionOption::find($answer);
                if ($option) {
                    $selectedOptionId = $option->id;
                    $isCorrect = $option->is_correct;
                    $score = $isCorrect ? $q['marks'] : 0;
                }
            } elseif ($q['type'] === 'fill_blank') {
                $correctOptions = QuestionOption::where('question_id', $q['id'])
                    ->where('is_correct', true)->pluck('id')->toArray();
                $isCorrect = in_array((int) $answer, $correctOptions);
                $score = $isCorrect ? $q['marks'] : 0;
            } else {
                $isCorrect = ! empty(trim($answer ?? ''));
                $score = $isCorrect ? $q['marks'] : 0;
            }

            QuestionResponse::create([
                'assessment_question_id' => $aq->id,
                'student_answer' => is_array($answer) ? json_encode($answer) : (string) ($answer ?? ''),
                'selected_option_id' => $selectedOptionId,
                'score' => $score,
                'max_score' => $maxScore,
                'is_correct' => $isCorrect,
                'answered_at' => now(),
            ]);
        }
    }

    private function gradeSection(string $section): array
    {
        if ($section === 'writing') {
            return $this->gradeWriting();
        }

        $score = 0;
        $maxScore = 0;

        foreach ($this->questions ?? [] as $q) {
            $maxScore += $q['marks'];
            $answer = $this->answers[$q['id']] ?? null;
            $score += $this->scoreAnswer($q, $answer);
        }

        $percentage = $maxScore > 0 ? round(($score / $maxScore) * 100, 1) : 0;
        $classification = $this->classifyScore($percentage);

        return [
            'score' => $score,
            'max_score' => $maxScore,
            'percentage' => $percentage,
            'classification' => $classification['band'],
            'estimated_grade' => $classification['grade'],
        ];
    }

    private function gradeWriting(): array
    {
        $maxScore = 25;
        $score = 0;

        if ($this->essayContent) {
            $wordCount = str_word_count($this->essayContent);
            $score = $wordCount >= 50 ? 12 : max(0, (int) ($wordCount / 4));
        }

        $percentage = round(($score / $maxScore) * 100, 1);
        $classification = $this->classifyScore($percentage);

        return [
            'score' => $score,
            'max_score' => $maxScore,
            'percentage' => $percentage,
            'classification' => $classification['band'],
            'estimated_grade' => $classification['grade'],
        ];
    }

    private function scoreAnswer(array $question, $answer): float
    {
        if ($answer === null) {
            return 0;
        }

        if ($question['type'] === 'mcq') {
            $option = QuestionOption::find($answer);

            return $option && $option->is_correct ? $question['marks'] : 0;
        }

        if ($question['type'] === 'fill_blank') {
            $correctOptions = QuestionOption::where('question_id', $question['id'])
                ->where('is_correct', true)->pluck('id')->toArray();

            return in_array((int) $answer, $correctOptions) ? $question['marks'] : 0;
        }

        return ! empty(trim($answer ?? '')) ? $question['marks'] : 0;
    }

    private function classifyScore(float $percentage): array
    {
        return match (true) {
            $percentage <= 24 => ['band' => 'Beginner', 'grade' => 'U'],
            $percentage <= 44 => ['band' => 'Elementary', 'grade' => 'E'],
            $percentage <= 64 => ['band' => 'Intermediate', 'grade' => 'D'],
            $percentage <= 84 => ['band' => 'Advanced', 'grade' => 'C'],
            default => ['band' => 'Exam Ready', 'grade' => 'B'],
        };
    }

    private function finalizePlacement($profile): void
    {
        $totalScore = 0;
        foreach ($this->sectionsCompleted as $data) {
            $totalScore += $data['score'] ?? 0;
        }

        $totalMarks = array_sum(array_column(self::SECTIONS, 'max_score'));
        $percentage = round(($totalScore / $totalMarks) * 100, 1);
        $classification = $this->classifyScore($percentage);

        $profile->update([
            'placement_completed' => true,
            'current_estimated_grade' => $classification['grade'],
        ]);

        $this->seedInitialSkillScores();
    }

    private function seedInitialSkillScores(): void
    {
        $profileId = Auth::user()->studentProfile->id;

        $grammarRatio = ($this->sectionsCompleted['grammar']['score'] ?? 0) / 15;
        $vocabRatio = ($this->sectionsCompleted['vocabulary']['score'] ?? 0) / 15;
        $readingRatio = ($this->sectionsCompleted['reading']['score'] ?? 0) / 19;
        $writingRatio = ($this->sectionsCompleted['writing']['score'] ?? 0) / 25;

        $domainRatios = [
            'grammar' => max(0, min(1, $grammarRatio)),
            'vocabulary' => max(0, min(1, $vocabRatio)),
            'reading' => max(0, min(1, $readingRatio)),
            'writing' => max(0, min(1, $writingRatio)),
        ];

        foreach ($domainRatios as $domainSlug => $ratio) {
            $domain = SkillDomain::where('slug', $domainSlug)->first();
            if (! $domain) {
                continue;
            }

            $subSkills = $domain->subSkills()->whereNull('parent_id')->get();
            foreach ($subSkills as $ss) {
                $proficiency = round(max(0.05, min(1.0, $ratio + (mt_rand(-15, 15) / 100))), 4);
                StudentSubSkillScore::updateOrCreate(
                    ['student_profile_id' => $profileId, 'sub_skill_id' => $ss->id],
                    [
                        'proficiency_score' => $proficiency,
                        'confidence_score' => 0.5,
                        'last_updated_at' => now(),
                    ]
                );
            }
        }
    }

    public function backToOverview(): void
    {
        $this->view = 'overview';
        $this->answers = [];
        $this->questions = null;
        $this->passage = null;
        $this->writingPrompt = null;
        $this->essayContent = '';
        $this->assessmentId = null;
        $this->timeRemaining = 0;
        $this->sectionTimeLimit = 0;
        $this->lastResults = [];
    }

    public function getSectionProgressPercent(): int
    {
        $questions = $this->questions ?? [];

        if ($this->view === 'writing') {
            return $this->essayContent ? 100 : 0;
        }

        if (empty($questions)) {
            return 0;
        }

        $answered = 0;
        foreach ($questions as $q) {
            if (! empty($this->answers[$q['id']] ?? null)) {
                $answered++;
            }
        }

        return round(($answered / count($questions)) * 100);
    }

    public function getCompletedCount(): int
    {
        return count($this->sectionsCompleted);
    }

    public function getTotalSections(): int
    {
        return count(self::SECTIONS);
    }

    public function render()
    {
        return view('livewire.student.placement-test');
    }
}
