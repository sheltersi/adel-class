<?php

namespace App\Livewire\Student;

use App\Models\DiagnosticReport;
use App\Models\SkillDomain;
use App\Models\StudentActivityLog;
use App\Models\StudentSubSkillScore;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
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
    public function targetGrade(): string
    {
        return $this->profile->target_grade ?? '—';
    }

    #[Computed]
    public function stats(): array
    {
        $profileId = $this->profile->id;

        $totalSeconds = $this->profile->studySessions()->sum('duration_seconds');
        $hoursStudied = $totalSeconds > 0 ? round($totalSeconds / 3600, 1) : 0;

        $activitiesCompleted = StudentActivityLog::where('student_profile_id', $profileId)
            ->where('status', 'completed')
            ->count();

        $assessmentsCount = $this->profile->assessments()->count();

        $writingCount = $this->profile->writingSubmissions()->count();

        $latestSnapshot = $this->profile->progressSnapshots()
            ->latest('captured_at')
            ->first();

        $weeklyStudyHours = $this->profile->weekly_study_hours ?? 0;

        return [
            'hours_studied' => $hoursStudied,
            'activities_completed' => $activitiesCompleted,
            'assessments_taken' => $assessmentsCount,
            'writing_submissions' => $writingCount,
            'estimated_grade' => $this->estimatedGrade,
            'target_grade' => $this->targetGrade,
            'weekly_study_hours' => $weeklyStudyHours,
            'latest_snapshot' => $latestSnapshot,
        ];
    }

    #[Computed]
    public function skillDomains(): array
    {
        if (! $this->placementCompleted) {
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
    public function latestReport(): ?DiagnosticReport
    {
        if (! $this->placementCompleted) {
            return null;
        }

        return $this->profile->diagnosticReports()
            ->latest('generated_at')
            ->first();
    }

    #[Computed]
    public function activePlan()
    {
        if (! $this->placementCompleted) {
            return null;
        }

        return $this->profile->learningPlans()
            ->where('status', 'active')
            ->withCount('weeks')
            ->latest()
            ->first();
    }

    #[Computed]
    public function recentActivity(): array
    {
        if (! $this->placementCompleted) {
            return [];
        }

        $activities = StudentActivityLog::where('student_profile_id', $this->profile->id)
            ->where('status', 'completed')
            ->latest('completed_at')
            ->take(5)
            ->get();

        return $activities->map(function ($activity) {
            $type = match ($activity->activity_type) {
                'question' => 'Question answered',
                'writing' => 'Writing submitted',
                'exercise' => 'Exercise completed',
                'plan' => 'Plan activity done',
                default => 'Activity completed',
            };

            return [
                'type' => $type,
                'score' => $activity->score,
                'time_spent' => $activity->time_spent_seconds > 0
                    ? round($activity->time_spent_seconds / 60, 1)
                    : null,
                'date' => $activity->completed_at?->diffForHumans(),
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
