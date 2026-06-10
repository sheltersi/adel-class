<div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
    {{-- Header --}}
    <div class="flex flex-col gap-1">
        <flux:heading size="xl">{{ __('Welcome back, :name', ['name' => auth()->user()->name]) }}</flux:heading>
        <flux:text class="text-[#64748B] dark:text-[#94A3B8]">
            @if ($this->placementCompleted)
                {{ __('Here is your learning progress overview.') }}
            @else
                {{ __('Complete your placement test to unlock your personalised dashboard.') }}
            @endif
        </flux:text>
    </div>
{{-- <h1>Hello World</h1> --}}
    @if (!$this->placementCompleted)
        {{-- Placement Test CTA --}}
        <div class="flex flex-col items-center justify-center gap-4 rounded-xl border-2 border-dashed border-[#F59E0B]/50 bg-[#F59E0B]/5 p-12 dark:border-[#F59E0B]/30 dark:bg-[#F59E0B]/10">
            <flux:icon.clipboard-document-check class="size-12 text-[#F59E0B]" />
            <flux:heading size="lg">{{ __('Placement test required') }}</flux:heading>
            <flux:text class="max-w-md text-center text-[#334155] dark:text-[#94A3B8]">
                {{ __('Take a short placement test so we can understand your current level and create a learning plan tailored to you.') }}
            </flux:text>
            <flux:button variant="primary" :href="route('placement-test')" wire:navigate>
                {{ __('Take Placement Test') }}
            </flux:button>
        </div>
    @else
        @php
            $stats = $this->stats;
        @endphp

        {{-- Stats Cards --}}
        <div class="grid auto-rows-min gap-4 md:grid-cols-2 lg:grid-cols-4">
            {{-- Study Time --}}
            <div class="flex flex-col gap-2 rounded-xl border border-[#E2E8F0] bg-white p-5 dark:border-[#334155] dark:bg-[#1E293B]">
                <div class="flex items-center gap-2">
                    <div class="flex size-9 items-center justify-center rounded-lg bg-[#3B82F6]/10">
                        <flux:icon.clock class="size-5 text-[#3B82F6]" />
                    </div>
                    <flux:text class="text-sm font-medium text-[#64748B] dark:text-[#94A3B8]">{{ __('Study Time') }}</flux:text>
                </div>
                <div class="flex items-baseline gap-1">
                    <flux:heading size="xl" class="text-[#0F172A] dark:text-[#F1F5F9]">{{ $stats['hours_studied'] }}</flux:heading>
                    <flux:text class="text-sm text-[#64748B]">hrs</flux:text>
                </div>
                <flux:text class="text-xs text-[#94A3B8]">
                    {{ __('Goal: :hours hrs/week', ['hours' => $stats['weekly_study_hours']]) }}
                </flux:text>
            </div>

            {{-- Activities Completed --}}
            <div class="flex flex-col gap-2 rounded-xl border border-[#E2E8F0] bg-white p-5 dark:border-[#334155] dark:bg-[#1E293B]">
                <div class="flex items-center gap-2">
                    <div class="flex size-9 items-center justify-center rounded-lg bg-[#10B981]/10">
                        <flux:icon.check-circle class="size-5 text-[#10B981]" />
                    </div>
                    <flux:text class="text-sm font-medium text-[#64748B] dark:text-[#94A3B8]">{{ __('Activities') }}</flux:text>
                </div>
                <div class="flex items-baseline gap-1">
                    <flux:heading size="xl" class="text-[#0F172A] dark:text-[#F1F5F9]">{{ $stats['activities_completed'] }}</flux:heading>
                    <flux:text class="text-sm text-[#64748B]">done</flux:text>
                </div>
                <flux:text class="text-xs text-[#94A3B8]">
                    {{ __('Completed exercises & questions') }}
                </flux:text>
            </div>

            {{-- Current Grade --}}
            <div class="flex flex-col gap-2 rounded-xl border border-[#E2E8F0] bg-white p-5 dark:border-[#334155] dark:bg-[#1E293B]">
                <div class="flex items-center gap-2">
                    <div class="flex size-9 items-center justify-center rounded-lg bg-[#F59E0B]/10">
                        <flux:icon.academic-cap class="size-5 text-[#F59E0B]" />
                    </div>
                    <flux:text class="text-sm font-medium text-[#64748B] dark:text-[#94A3B8]">{{ __('Current Grade') }}</flux:text>
                </div>
                <div class="flex items-baseline gap-1">
                    <flux:heading size="xl" class="text-[#0F172A] dark:text-[#F1F5F9]">{{ $stats['estimated_grade'] }}</flux:heading>
                </div>
                <flux:text class="text-xs text-[#94A3B8]">
                    {{ __('Target: :grade', ['grade' => $stats['target_grade']]) }}
                </flux:text>
            </div>

            {{-- Assessments --}}
            <div class="flex flex-col gap-2 rounded-xl border border-[#E2E8F0] bg-white p-5 dark:border-[#334155] dark:bg-[#1E293B]">
                <div class="flex items-center gap-2">
                    <div class="flex size-9 items-center justify-center rounded-lg bg-[#8B5CF6]/10">
                        <flux:icon.document-text class="size-5 text-[#8B5CF6]" />
                    </div>
                    <flux:text class="text-sm font-medium text-[#64748B] dark:text-[#94A3B8]">{{ __('Assessments') }}</flux:text>
                </div>
                <div class="flex items-baseline gap-1">
                    <flux:heading size="xl" class="text-[#0F172A] dark:text-[#F1F5F9]">{{ $stats['assessments_taken'] }}</flux:heading>
                    <flux:text class="text-sm text-[#64748B]">taken</flux:text>
                </div>
                <flux:text class="text-xs text-[#94A3B8]">
                    {{ __('Tests & mock exams completed') }}
                </flux:text>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid auto-rows-min gap-4 lg:grid-cols-3">
            {{-- Left Column: Skill Domains --}}
            <div class="flex flex-col gap-4 rounded-xl border border-[#E2E8F0] bg-white p-6 dark:border-[#334155] dark:bg-[#1E293B] lg:col-span-2">
                <div class="flex items-center justify-between">
                    <flux:heading size="lg">{{ __('Skill Breakdown') }}</flux:heading>
                    <flux:button variant="ghost" size="sm" :href="route('profile')" wire:navigate>
                        {{ __('View full profile') }}
                    </flux:button>
                </div>

                <div class="flex flex-col gap-4">
                    @foreach ($this->skillDomains as $domain)
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    @if ($domain['slug'] === 'grammar')
                                        <flux:icon.language class="size-4 text-[#3B82F6]" />
                                    @elseif ($domain['slug'] === 'comprehension')
                                        <flux:icon.book-open class="size-4 text-[#8B5CF6]" />
                                    @elseif ($domain['slug'] === 'vocabulary')
                                        <flux:icon.sparkles class="size-4 text-[#F59E0B]" />
                                    @elseif ($domain['slug'] === 'writing')
                                        <flux:icon.pencil class="size-4 text-[#10B981]" />
                                    @else
                                        <flux:icon.bolt class="size-4 text-[#64748B]" />
                                    @endif
                                    <flux:text class="text-sm font-medium text-[#334155] dark:text-[#CBD5E1]">{{ $domain['name'] }}</flux:text>
                                </div>
                                <flux:text class="text-sm font-medium text-[#334155] dark:text-[#CBD5E1]">
                                    {{ $domain['proficiency'] !== null ? $domain['proficiency'] . '%' : '—' }}
                                </flux:text>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-[#F1F5F9] dark:bg-[#334155]">
                                <div class="h-full rounded-full transition-all duration-500
                                    @if ($domain['proficiency'] === null) bg-[#94A3B8]
                                    @elseif ($domain['proficiency'] >= 80) bg-[#10B981]
                                    @elseif ($domain['proficiency'] >= 60) bg-[#F59E0B]
                                    @else bg-[#EF4444]
                                    @endif"
                                    style="width: {{ $domain['proficiency'] ?? 0 }}%">
                                </div>
                            </div>
                            <flux:text class="text-xs text-[#94A3B8]">
                                {{ $domain['sub_skills_count'] }} {{ __('sub-skills tracked') }}
                            </flux:text>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Right Column: Active Plan + Recent Activity --}}
            <div class="flex flex-col gap-4">
                {{-- Active Plan --}}
                @if ($this->activePlan)
                    <div class="flex flex-col gap-4 rounded-xl border border-[#E2E8F0] bg-white p-6 dark:border-[#334155] dark:bg-[#1E293B]">
                        <div class="flex items-center gap-2">
                            <div class="flex size-9 items-center justify-center rounded-lg bg-[#10B981]/10">
                                <flux:icon.map class="size-5 text-[#10B981]" />
                            </div>
                            <flux:heading size="lg">{{ __('Active Plan') }}</flux:heading>
                        </div>
                        <div class="flex flex-col gap-1">
                            <flux:text class="text-sm font-medium text-[#334155] dark:text-[#CBD5E1]">
                                {{ $this->activePlan->title }}
                            </flux:text>
                            <flux:text class="text-sm text-[#64748B]">
                                {{ $this->activePlan->weeks_count }} {{ __('weeks') }}
                            </flux:text>
                        </div>
                        <flux:button variant="primary" size="sm" :href="route('profile')" wire:navigate class="w-full">
                            {{ __('Continue Learning') }}
                        </flux:button>
                    </div>
                @endif

                {{-- Recent Activity --}}
                <div class="flex flex-col gap-4 rounded-xl border border-[#E2E8F0] bg-white p-6 dark:border-[#334155] dark:bg-[#1E293B]">
                    <div class="flex items-center gap-2">
                        <div class="flex size-9 items-center justify-center rounded-lg bg-[#3B82F6]/10">
                            <flux:icon.bolt class="size-5 text-[#3B82F6]" />
                        </div>
                        <flux:heading size="lg">{{ __('Recent Activity') }}</flux:heading>
                    </div>

                    @if (count($this->recentActivity) > 0)
                        <div class="flex flex-col gap-3">
                            @foreach ($this->recentActivity as $activity)
                                <div class="flex items-center justify-between rounded-lg bg-[#F8FAFC] p-3 dark:bg-[#1E293B]/50">
                                    <div class="flex flex-col gap-0.5">
                                        <flux:text class="text-sm font-medium text-[#334155] dark:text-[#CBD5E1]">
                                            {{ $activity['type'] }}
                                        </flux:text>
                                        @if ($activity['time_spent'])
                                            <flux:text class="text-xs text-[#94A3B8]">
                                                {{ $activity['time_spent'] }} min
                                            </flux:text>
                                        @endif
                                    </div>
                                    <div class="flex flex-col items-end gap-0.5">
                                        @if ($activity['score'] !== null)
                                            <flux:text class="text-sm font-medium text-[#10B981]">
                                                {{ $activity['score'] }}%
                                            </flux:text>
                                        @endif
                                        <flux:text class="text-xs text-[#94A3B8]">
                                            {{ $activity['date'] }}
                                        </flux:text>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <flux:text class="text-sm text-[#64748B]">
                            {{ __('No activity yet. Start your learning plan to see progress here.') }}
                        </flux:text>
                    @endif
                </div>
            </div>
        </div>

        {{-- Diagnostic Report --}}
        @if ($this->latestReport)
            <div class="flex flex-col gap-4 rounded-xl border border-[#E2E8F0] bg-white p-6 dark:border-[#334155] dark:bg-[#1E293B]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="flex size-9 items-center justify-center rounded-lg bg-[#8B5CF6]/10">
                            <flux:icon.document-text class="size-5 text-[#8B5CF6]" />
                        </div>
                        <flux:heading size="lg">{{ __('Latest Diagnostic Report') }}</flux:heading>
                    </div>
                    <flux:text class="text-xs text-[#94A3B8]">
                        {{ $this->latestReport->generated_at?->diffForHumans() }}
                    </flux:text>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    @if ($this->latestReport->strengths_json)
                        <div class="flex flex-col gap-2 rounded-lg bg-[#ECFDF5] p-4 dark:bg-[#064E3B]/20">
                            <div class="flex items-center gap-2">
                                <flux:icon.check-circle class="size-5 text-[#10B981]" />
                                <flux:text class="text-sm font-semibold text-[#065F46] dark:text-[#6EE7B7]">{{ __('Strengths') }}</flux:text>
                            </div>
                            <ul class="flex flex-col gap-1">
                                @foreach ($this->latestReport->strengths_json as $strength)
                                    <li class="flex items-start gap-2 text-sm text-[#047857] dark:text-[#6EE7B7]">
                                        <span class="mt-1.5 size-1.5 shrink-0 rounded-full bg-[#10B981]"></span>
                                        {{ $strength }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($this->latestReport->weaknesses_json)
                        <div class="flex flex-col gap-2 rounded-lg bg-[#FEF2F2] p-4 dark:bg-[#7F1D1D]/20">
                            <div class="flex items-center gap-2">
                                <flux:icon.exclamation-triangle class="size-5 text-[#EF4444]" />
                                <flux:text class="text-sm font-semibold text-[#991B1B] dark:text-[#FCA5A5]">{{ __('Areas to Improve') }}</flux:text>
                            </div>
                            <ul class="flex flex-col gap-1">
                                @foreach ($this->latestReport->weaknesses_json as $weakness)
                                    <li class="flex items-start gap-2 text-sm text-[#B91C1C] dark:text-[#FCA5A5]">
                                        <span class="mt-1.5 size-1.5 shrink-0 rounded-full bg-[#EF4444]"></span>
                                        {{ $weakness }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                @if ($this->latestReport->summary)
                    <div class="rounded-lg bg-[#F8FAFC] p-4 dark:bg-[#1E293B]/50">
                        <flux:text class="text-sm text-[#334155] dark:text-[#CBD5E1]">
                            {{ $this->latestReport->summary }}
                        </flux:text>
                    </div>
                @endif
            </div>
        @endif

        {{-- Quick Actions --}}
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="flex flex-col gap-3 rounded-xl border border-[#E2E8F0] bg-white p-5 dark:border-[#334155] dark:bg-[#1E293B]">
                <div class="flex items-center gap-2">
                    <div class="flex size-9 items-center justify-center rounded-lg bg-[#3B82F6]/10">
                        <flux:icon.clipboard-document-check class="size-5 text-[#3B82F6]" />
                    </div>
                    <flux:heading size="md">{{ __('Take Assessment') }}</flux:heading>
                </div>
                <flux:text class="text-sm text-[#64748B]">
                    {{ __('Measure your progress with a new practice test or mock exam.') }}
                </flux:text>
                <flux:button variant="primary" size="sm" :href="route('profile')" wire:navigate class="w-full">
                    {{ __('Start Test') }}
                </flux:button>
            </div>

            <div class="flex flex-col gap-3 rounded-xl border border-[#E2E8F0] bg-white p-5 dark:border-[#334155] dark:bg-[#1E293B]">
                <div class="flex items-center gap-2">
                    <div class="flex size-9 items-center justify-center rounded-lg bg-[#10B981]/10">
                        <flux:icon.pencil class="size-5 text-[#10B981]" />
                    </div>
                    <flux:heading size="md">{{ __('Writing Practice') }}</flux:heading>
                </div>
                <flux:text class="text-sm text-[#64748B]">
                    {{ __('Submit an essay or summary and get AI-powered feedback.') }}
                </flux:text>
                <flux:button variant="primary" size="sm" :href="route('profile')" wire:navigate class="w-full">
                    {{ __('Write Now') }}
                </flux:button>
            </div>

            <div class="flex flex-col gap-3 rounded-xl border border-[#E2E8F0] bg-white p-5 dark:border-[#334155] dark:bg-[#1E293B]">
                <div class="flex items-center gap-2">
                    <div class="flex size-9 items-center justify-center rounded-lg bg-[#F59E0B]/10">
                        <flux:icon.cog class="size-5 text-[#F59E0B]" />
                    </div>
                    <flux:heading size="md">{{ __('Study Goals') }}</flux:heading>
                </div>
                <flux:text class="text-sm text-[#64748B]">
                    {{ __('Update your target grade and weekly study hours.') }}
                </flux:text>
                <flux:button variant="primary" size="sm" :href="route('profile')" wire:navigate class="w-full">
                    {{ __('Edit Goals') }}
                </flux:button>
            </div>
        </div>
    @endif
</div>
