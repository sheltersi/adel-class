<?php

namespace App\Livewire\Student;

use App\Models\DiagnosticReport;
use App\Models\SkillDomain;
use App\Models\StudentActivityLog;
use App\Models\StudentSubSkillScore;
use App\Models\SubmissionEvaluation;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Profile')]
class Profile extends Component
{
    public string $targetGrade = '';

    public ?int $weeklyStudyHours = null;

    public string $gradeLevel = '';

    public bool $editing = false;

    public function mount(): void
    {
        $profile = Auth::user()->studentProfile;

        $this->targetGrade = $profile->target_grade ?? '';
        $this->weeklyStudyHours = $profile->weekly_study_hours;
        $this->gradeLevel = $profile->grade_level ?? '';
    }

    public function updateGoals(): void
    {
        $validated = $this->validate([
            'targetGrade' => ['required', 'string', 'in:A*,A,B,C,D,E'],
            'weeklyStudyHours' => ['required', 'integer', 'min:1', 'max:40'],
            'gradeLevel' => ['required', 'string', 'in:O-Level,IGCSE,Secondary,Other'],
        ]);

        Auth::user()->studentProfile->update([
            'target_grade' => $validated['targetGrade'],
            'weekly_study_hours' => $validated['weeklyStudyHours'],
            'grade_level' => $validated['gradeLevel'],
        ]);

        $this->editing = false;

        Flux::toast(variant: 'success', text: __('Study goals updated.'));
    }

    #[Computed]
    public function profile()
    {
        return Auth::user()->studentProfile;
    }

    #[Computed]
    public function placementCompleted(): bool
    {
        return $this->profile->placement_completed;
    }

    #[Computed]
    public function estimatedGrade(): string
    {
        return $this->profile->current_estimated_grade ?? '—';
    }

    #[Computed]
    public function skillDomains(): array
    {
        if (!$this->placementCompleted) {
            return [];
        }

        $profileId = $this->profile->id;

        return SkillDomain::orderBy('display_order')->get()
            ->map(function (SkillDomain $domain) use ($profileId) {
                $scores = StudentSubSkillScore::where('student_profile_id', $profileId)
                    ->whereHas('subSkill', fn ($q) => $q->where('skill_domain_id', $domain->id))
                    ->get();

                $avg = $scores->isNotEmpty()
                    ? round($scores->avg('proficiency_score') * 100)
                    : null;

                $color = match (true) {
                    $avg === null => 'zinc',
                    $avg >= 80 => 'emerald',
                    $avg >= 60 => 'amber',
                    default => 'red',
                };

                return [
                    'name' => $domain->name,
                    'slug' => $domain->slug,
                    'proficiency' => $avg,
                    'color' => $color,
                    'sub_skills_count' => $scores->count(),
                ];
            })
            ->toArray();
    }

    #[Computed]
    public function stats(): array
    {
        $profileId = $this->profile->id;

        return [
            'assessments' => $this->profile->assessments()->count(),
            'activities' => StudentActivityLog::where('student_profile_id', $profileId)
                ->where('status', 'completed')->count(),
            'submissions' => $this->profile->writingSubmissions()->count(),
            'evaluations' => SubmissionEvaluation::whereHas(
                'writingSubmission',
                fn ($q) => $q->where('student_profile_id', $profileId)
            )->count(),
            'hours_studied' => $this->profile->studySessions()->sum('duration_seconds') > 0
                ? round($this->profile->studySessions()->sum('duration_seconds') / 3600, 1)
                : 0,
        ];
    }

    #[Computed]
    public function latestReport(): ?DiagnosticReport
    {
        return $this->profile->diagnosticReports()
            ->latest('generated_at')
            ->first();
    }

    #[Computed]
    public function activePlan()
    {
        return $this->profile->learningPlans()
            ->where('status', 'active')
            ->withCount('weeks')
            ->latest()
            ->first();
    }

    public function render()
    {
        return view('livewire.student.profile');
    }
}
