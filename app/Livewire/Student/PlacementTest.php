<?php

namespace App\Livewire\Student;

use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentResult;
use App\Models\Passage;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionResponse;
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
    public int $currentStep = 1;

    public int $totalSteps = 4;

    public array $answers = [];

    public ?int $assessmentId = null;

    public ?array $passages = null;

    public ?array $grammarQuestions = null;

    public ?array $vocabQuestions = null;

    public ?array $readingQuestions = null;

    public ?array $writingPrompt = null;

    public string $essayContent = '';

    public int $timeRemaining = 3300;

    public function mount(): void
    {
        $studentProfile = Auth::user()->studentProfile;

        $assessment = Assessment::create([
            'student_profile_id' => $studentProfile->id,
            'assessment_type' => 'diagnostic',
            'paper' => 'Full',
            'status' => 'in_progress',
            'started_at' => now(),
            'time_limit_seconds' => 3300,
            'time_remaining_seconds' => 3300,
            'total_marks' => 75,
        ]);

        $this->assessmentId = $assessment->id;

        $this->loadGrammarQuestions();
        $this->loadVocabularyQuestions();
        $this->loadPassageA();
    }

    private function loadGrammarQuestions(): void
    {
        $questions = $this->placementQuestions()->where('question_type', '!=', 'essay')
            ->take(15)->get();

        $this->grammarQuestions = $questions->map(fn ($q) => $this->formatQuestion($q))->toArray();
    }

    private function loadVocabularyQuestions(): void
    {
        $questions = $this->placementQuestions()
            ->where('question_type', '!=', 'essay')
            ->skip(15)->take(15)->get();

        $this->vocabQuestions = $questions->map(fn ($q) => $this->formatQuestion($q))->toArray();
    }

    private function loadPassageA(): void
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
                ->whereNotIn('id', collect($this->grammarQuestions)->pluck('id'))
                ->whereNotIn('id', collect($this->vocabQuestions)->pluck('id'))
                ->take(4)->get();
        }

        $this->readingQuestions = $questions->map(fn ($q) => $this->formatQuestion($q))->toArray();

        if ($passage) {
            $this->passages = [[
                'id' => $passage->id,
                'title' => $passage->title,
                'content' => $passage->content,
                'type' => 'narrative',
            ]];
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

        if (!$prompt) {
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

        $tags = $q->subSkills->pluck('id')->toArray();

        return [
            'id' => $q->id,
            'stem' => $q->stem,
            'type' => $q->question_type,
            'marks' => $q->marks,
            'difficulty' => $q->difficulty,
            'options' => $options,
            'tags' => $tags,
        ];
    }

    public function answerQuestion(int $questionId, $value): void
    {
        $this->answers[$questionId] = $value;
    }

    public function goToStep(int $step): void
    {
        if ($step < 1 || $step > $this->totalSteps) return;
        if ($step > $this->currentStep) return; // Can't skip forward

        if ($step === 4 && !$this->writingPrompt) {
            $this->loadWritingPrompt();
        }

        $this->currentStep = $step;
    }

    public function nextStep(): void
    {
        if ($this->currentStep === 1) {
            $this->saveSectionAnswers('grammar', $this->grammarQuestions);
        }
        if ($this->currentStep === 2) {
            $this->saveSectionAnswers('vocabulary', $this->vocabQuestions);
        }
        if ($this->currentStep === 3) {
            $this->saveSectionAnswers('reading', $this->readingQuestions);
            $this->loadWritingPrompt();
        }

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    private function saveSectionAnswers(string $section, array $questions): void
    {
        foreach ($questions as $q) {
            $answer = $this->answers[$q['id']] ?? null;
            if ($answer === null) continue;

            AssessmentQuestion::firstOrCreate(
                ['assessment_id' => $this->assessmentId, 'question_id' => $q['id']],
                ['sort_order' => 0]
            );
        }
    }

    public function submit(): void
    {
        DB::transaction(function () {
            // Save all answers
            $allQuestions = array_merge(
                $this->grammarQuestions ?? [],
                $this->vocabQuestions ?? [],
                $this->readingQuestions ?? []
            );

            foreach ($allQuestions as $q) {
                $answer = $this->answers[$q['id']] ?? null;
                $this->recordAnswer($q, $answer);
            }

            // Save essay
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

            // Compute scores
            $results = $this->gradeTest();

            // Update assessment
            $assessment = Assessment::find($this->assessmentId);
            $assessment->update([
                'status' => 'completed',
                'completed_at' => now(),
                'time_remaining_seconds' => max(0, $this->timeRemaining),
            ]);

            // Save result
            AssessmentResult::create([
                'assessment_id' => $this->assessmentId,
                'total_score' => $results['total_score'],
                'total_marks' => 75,
                'percentage' => $results['percentage'],
                'band_score' => $results['classification'],
                'completed_at' => now(),
            ]);

            // Update student profile
            Auth::user()->studentProfile->update([
                'placement_completed' => true,
                'current_estimated_grade' => $results['estimated_grade'],
            ]);

            // Seed skill scores from placement test
            $this->seedInitialSkillScores($results);
        });

        Flux::toast(variant: 'success', text: __('Placement test completed! Your learning plan is ready.'));

        $this->redirect(route('profile'), navigate: true);
    }

    private function recordAnswer(array $question, $answer): void
    {
        $aq = AssessmentQuestion::firstOrCreate(
            ['assessment_id' => $this->assessmentId, 'question_id' => $question['id']],
            ['sort_order' => 0]
        );

        $score = null;
        $maxScore = $question['marks'];
        $isCorrect = null;
        $selectedOptionId = null;

        if ($question['type'] === 'mcq') {
            $option = QuestionOption::find($answer);
            if ($option) {
                $selectedOptionId = $option->id;
                $isCorrect = $option->is_correct;
                $score = $isCorrect ? $question['marks'] : 0;
            }
        } elseif ($question['type'] === 'fill_blank') {
            $correctOptions = QuestionOption::where('question_id', $question['id'])
                ->where('is_correct', true)->pluck('id')->toArray();
            $isCorrect = in_array((int) $answer, $correctOptions);
            $score = $isCorrect ? $question['marks'] : 0;
        } else {
            $isCorrect = !empty(trim($answer ?? ''));
            $score = $isCorrect ? $question['marks'] : 0;
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

    private function gradeTest(): array
    {
        $grammarScore = 0;
        $vocabScore = 0;
        $readingScore = 0;
        $writingScore = 0;

        foreach ($this->grammarQuestions ?? [] as $q) {
            $answer = $this->answers[$q['id']] ?? null;
            $grammarScore += $this->scoreAnswer($q, $answer);
        }

        foreach ($this->vocabQuestions ?? [] as $q) {
            $answer = $this->answers[$q['id']] ?? null;
            $vocabScore += $this->scoreAnswer($q, $answer);
        }

        foreach ($this->readingQuestions ?? [] as $q) {
            $answer = $this->answers[$q['id']] ?? null;
            $readingScore += $this->scoreAnswer($q, $answer);
        }

        // Writing: placeholder score based on word count until AI evaluation runs
        if ($this->essayContent) {
            $wordCount = str_word_count($this->essayContent);
            $writingScore = $wordCount >= 50 ? 12 : max(0, $wordCount / 4);
        }

        $totalScore = $grammarScore + $vocabScore + $readingScore + $writingScore;
        $percentage = round(($totalScore / 75) * 100, 1);
        $classification = $this->classifyScore($percentage);

        return [
            'grammar_score' => $grammarScore,
            'vocab_score' => $vocabScore,
            'reading_score' => $readingScore,
            'writing_score' => $writingScore,
            'total_score' => $totalScore,
            'percentage' => $percentage,
            'classification' => $classification['band'],
            'estimated_grade' => $classification['grade'],
        ];
    }

    private function scoreAnswer(array $question, $answer): float
    {
        if ($answer === null) return 0;

        if ($question['type'] === 'mcq') {
            $option = QuestionOption::find($answer);
            return $option && $option->is_correct ? $question['marks'] : 0;
        }

        if ($question['type'] === 'fill_blank') {
            $correctOptions = QuestionOption::where('question_id', $question['id'])
                ->where('is_correct', true)->pluck('id')->toArray();
            return in_array((int) $answer, $correctOptions) ? $question['marks'] : 0;
        }

        return !empty(trim($answer ?? '')) ? $question['marks'] : 0;
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

    private function calculatePreScore(): float
    {
        $score = 0;
        foreach ($this->grammarQuestions ?? [] as $q) {
            $answer = $this->answers[$q['id']] ?? null;
            $score += $this->scoreAnswer($q, $answer);
        }
        foreach ($this->vocabQuestions ?? [] as $q) {
            $answer = $this->answers[$q['id']] ?? null;
            $score += $this->scoreAnswer($q, $answer);
        }
        return $score;
    }

    private function seedInitialSkillScores(array $results): void
    {
        $profileId = Auth::user()->studentProfile->id;
        $grammarRatio = $results['grammar_score'] / 15;
        $vocabRatio = $results['vocab_score'] / 15;
        $readingRatio = $results['reading_score'] / 19;

        $domainRatios = [
            'grammar' => $grammarRatio,
            'vocabulary' => $vocabRatio,
            'reading' => $readingRatio,
            'writing' => $results['writing_score'] / 25,
        ];

        foreach ($domainRatios as $domainSlug => $ratio) {
            $domain = \App\Models\SkillDomain::where('slug', $domainSlug)->first();
            if (!$domain) continue;

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

    public function getSectionProgress(int $step): int
    {
        $questions = match ($step) {
            1 => $this->grammarQuestions ?? [],
            2 => $this->vocabQuestions ?? [],
            3 => $this->readingQuestions ?? [],
            4 => [['id' => 'essay']],
            default => [],
        };

        if ($step === 4) {
            return $this->essayContent ? 100 : 0;
        }

        $answered = 0;
        foreach ($questions as $q) {
            if (!empty($this->answers[$q['id']] ?? null)) $answered++;
        }

        return count($questions) > 0 ? round(($answered / count($questions)) * 100) : 0;
    }

    public function render()
    {
        return view('livewire.student.placement-test');
    }
}
