<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        {{-- Header --}}
        <div class="flex items-start justify-between">
            <div>
                <flux:heading size="xl">{{ auth()->user()->name }}</flux:heading>
                <flux:text class="mt-1 text-zinc-500">{{ auth()->user()->email }}</flux:text>
            </div>
            @if ($this->placementCompleted)
                <div class="flex flex-col items-center rounded-xl border border-zinc-200 bg-zinc-50 px-5 py-3 dark:border-zinc-700 dark:bg-zinc-800">
                    <flux:text class="text-xs uppercase tracking-wider text-zinc-400">{{ __('Estimated Grade') }}</flux:text>
                    <flux:heading size="xl" class="mt-0.5">{{ $this->estimatedGrade }}</flux:heading>
                </div>
            @endif
        </div>

        @if (!$this->placementCompleted)
            <div class="flex flex-col items-center justify-center gap-4 rounded-xl border-2 border-dashed border-amber-300 bg-amber-50 p-10 dark:border-amber-700 dark:bg-amber-950">
                <flux:icon.clipboard-document-check class="size-10 text-amber-500" />
                <flux:heading size="lg">{{ __('Complete your placement test') }}</flux:heading>
                <flux:text class="max-w-md text-center text-zinc-500">
                    {{ __('Your skill profile and learning plan will appear here once you finish the placement test.') }}
                </flux:text>
                <flux:button variant="primary" :href="route('placement-test')" wire:navigate>
                    {{ __('Take Placement Test') }}
                </flux:button>
            </div>
        @endif

        {{-- Academic Goals --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between">
                <flux:heading size="lg">{{ __('Study Goals') }}</flux:heading>
                @if (!$this->editing)
                    <flux:button variant="ghost" size="sm" wire:click="$set('editing', true)">
                        {{ __('Edit') }}
                    </flux:button>
                @endif
            </div>
            <flux:separator class="my-4" />

            @if ($this->editing)
                <form wire:submit="updateGoals" class="flex flex-col gap-4">
                    <div class="grid gap-4 md:grid-cols-3">
                        <flux:select wire:model="targetGrade" label="{{ __('Target Grade') }}">
                            <option value="">{{ __('Select a grade') }}</option>
                            <option value="A*">A*</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </flux:select>

                        <flux:input
                            wire:model="weeklyStudyHours"
                            label="{{ __('Hours per week') }}"
                            type="number"
                            min="1"
                            max="40"
                        />

                        <flux:select wire:model="gradeLevel" label="{{ __('Level') }}">
                            <option value="">{{ __('Select your level') }}</option>
                            <option value="O-Level">{{ __('O-Level') }}</option>
                            <option value="IGCSE">{{ __('IGCSE') }}</option>
                            <option value="Secondary">{{ __('Secondary') }}</option>
                            <option value="Other">{{ __('Other') }}</option>
                        </flux:select>
                    </div>
                    <div class="flex items-center gap-3">
                        <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>
                        <flux:button variant="ghost" wire:click="$set('editing', false)">{{ __('Cancel') }}</flux:button>
                    </div>
                </form>
            @else
                <dl class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <dt class="text-sm text-zinc-400">{{ __('Target Grade') }}</dt>
                        <dd class="mt-0.5 text-lg font-semibold">
                            {{ $this->profile->target_grade ?? '—' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-zinc-400">{{ __('Study Hours / Week') }}</dt>
                        <dd class="mt-0.5 text-lg font-semibold">
                            {{ $this->profile->weekly_study_hours ? $this->profile->weekly_study_hours . 'h' : '—' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-zinc-400">{{ __('Level') }}</dt>
                        <dd class="mt-0.5 text-lg font-semibold">
                            {{ $this->profile->grade_level ?? '—' }}
                        </dd>
                    </div>
                </dl>
            @endif
        </div>

        @if ($this->placementCompleted)
            {{-- Skill Overview --}}
            <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="lg">{{ __('Skill Overview') }}</flux:heading>
                <flux:separator class="my-4" />

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($this->skillDomains as $domain)
                        <div class="rounded-lg border border-zinc-100 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800">
                            <flux:text class="text-sm text-zinc-400">{{ $domain['name'] }}</flux:text>
                            @if ($domain['proficiency'] !== null)
                                <div class="mt-2 flex items-baseline gap-2">
                                    <span class="text-2xl font-bold text-{{ $domain['color'] }}-600">
                                        {{ $domain['proficiency'] }}%
                                    </span>
                                </div>
                                <div class="mt-2 h-2 w-full rounded-full bg-zinc-200 dark:bg-zinc-700">
                                    <div
                                        class="h-2 rounded-full bg-{{ $domain['color'] }}-500 transition-all"
                                        style="width: {{ $domain['proficiency'] }}%"
                                    ></div>
                                </div>
                                <flux:text class="mt-1 text-xs text-zinc-400">
                                    {{ $domain['sub_skills_count'] }} {{ __('sub-skills tracked') }}
                                </flux:text>
                            @else
                                <flux:text class="mt-2 text-zinc-400">{{ __('No data yet') }}</flux:text>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Stats --}}
            <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="lg">{{ __('Activity Summary') }}</flux:heading>
                <flux:separator class="my-4" />

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-5">
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $this->stats['assessments'] }}</div>
                        <div class="text-sm text-zinc-400">{{ __('Tests Taken') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $this->stats['activities'] }}</div>
                        <div class="text-sm text-zinc-400">{{ __('Exercises Done') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $this->stats['submissions'] }}</div>
                        <div class="text-sm text-zinc-400">{{ __('Essays Written') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $this->stats['evaluations'] }}</div>
                        <div class="text-sm text-zinc-400">{{ __('Evaluations') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $this->stats['hours_studied'] }}h</div>
                        <div class="text-sm text-zinc-400">{{ __('Study Time') }}</div>
                    </div>
                </div>
            </div>

            {{-- Active Plan --}}
            @if ($this->activePlan)
                <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <flux:heading size="lg">{{ __('Active Learning Plan') }}</flux:heading>
                            <flux:text class="mt-1 text-sm text-zinc-500">{{ $this->activePlan->title }}</flux:text>
                        </div>
                        <flux:badge variant="solid" color="emerald">{{ __('Active') }}</flux:badge>
                    </div>
                    <flux:separator class="my-4" />
                    <dl class="grid gap-4 sm:grid-cols-3">
                        <div>
                            <dt class="text-sm text-zinc-400">{{ __('Weeks') }}</dt>
                            <dd class="mt-0.5 font-semibold">{{ $this->activePlan->weeks_count ?? $this->activePlan->total_weeks }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-zinc-400">{{ __('Started') }}</dt>
                            <dd class="mt-0.5 font-semibold">{{ $this->activePlan->started_at?->format('d M Y') ?? $this->activePlan->generated_at->format('d M Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-zinc-400">{{ __('Status') }}</dt>
                            <dd class="mt-0.5 font-semibold capitalize">{{ $this->activePlan->status }}</dd>
                        </div>
                    </dl>
                </div>
            @endif

            {{-- Diagnostic Report --}}
            @if ($this->latestReport)
                <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                    <flux:heading size="lg">{{ __('Placement Report') }}</flux:heading>
                    <flux:text class="mt-1 text-sm text-zinc-400">
                        {{ __('Generated') }} {{ $this->latestReport->generated_at->format('d M Y') }}
                    </flux:text>
                    <flux:separator class="my-4" />

                    <div class="prose prose-sm max-w-none text-zinc-600 dark:text-zinc-300">
                        {!! nl2br(e($this->latestReport->summary)) !!}
                    </div>

                    @if ($this->latestReport->strengths_json || $this->latestReport->weaknesses_json)
                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            @if ($this->latestReport->strengths_json)
                                <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-3 dark:border-emerald-800 dark:bg-emerald-950">
                                    <flux:text class="text-sm font-medium text-emerald-700 dark:text-emerald-300">{{ __('Strengths') }}</flux:text>
                                </div>
                            @endif
                            @if ($this->latestReport->weaknesses_json)
                                <div class="rounded-lg border border-amber-200 bg-amber-50 p-3 dark:border-amber-800 dark:bg-amber-950">
                                    <flux:text class="text-sm font-medium text-amber-700 dark:text-amber-300">{{ __('Areas to Improve') }}</flux:text>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        @endif
    </div>
</div>
