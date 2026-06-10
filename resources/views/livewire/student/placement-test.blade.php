<div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
    {{-- OVERVIEW STATE --}}
    @if ($view === 'overview')
        <div>
            <flux:heading size="xl">{{ __('Placement Test') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-500">
                {{ __('Complete each section at your own pace. Scores are shown after each section.') }}
            </flux:text>
        </div>

        {{-- Progress summary --}}
        <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <flux:text class="text-sm font-medium">
                        {{ __(':done of :total sections completed', ['done' => $this->getCompletedCount(), 'total' => $this->getTotalSections()]) }}
                    </flux:text>
                    @if ($this->getCompletedCount() > 0)
                        <flux:text class="mt-1 text-sm text-zinc-500">
                            {{ __('Overall score: :score / :total (:pct%)', [
                                'score' => $this->getOverallScore(),
                                'total' => 75,
                                'pct' => $this->getOverallPercentage(),
                            ]) }}
                        </flux:text>
                    @endif
                </div>
                <div class="h-3 w-48 overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-600">
                    <div class="h-full rounded-full bg-emerald-500 transition-all duration-500"
                         style="width: {{ ($this->getCompletedCount() / $this->getTotalSections()) * 100 }}%">
                    </div>
                </div>
            </div>
        </div>

        {{-- Section cards --}}
        <div class="grid gap-4 md:grid-cols-2">
            @foreach (['grammar', 'vocabulary', 'reading', 'writing'] as $section)
                @php
                    $completed = $this->isSectionCompleted($section);
                    $available = $this->isSectionAvailable($section);
                    $colors = [
                        'grammar' => 'blue',
                        'vocabulary' => 'purple',
                        'reading' => 'green',
                        'writing' => 'orange',
                    ];
                    $color = $colors[$section];
                    $icons = [
                        'grammar' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>',
                        'vocabulary' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.967 8.967 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>',
                        'reading' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.967 8.967 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>',
                        'writing' => '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>',
                    ];
                @endphp

                <div @class([
                    'relative overflow-hidden rounded-2xl border p-6 shadow-sm transition-all',
                    'border-emerald-200 bg-emerald-50/50 dark:border-emerald-800 dark:bg-emerald-950/30' => $completed,
                    'border-'.$color.'-200 bg-white dark:border-'.$color.'-800 dark:bg-zinc-900' => !$completed && $available,
                    'border-zinc-200 bg-zinc-50/50 dark:border-zinc-700 dark:bg-zinc-800/50 opacity-60' => !$completed && !$available,
                ])>
                    @if ($completed)
                        <div class="absolute right-4 top-4 flex h-8 w-8 items-center justify-center rounded-full bg-emerald-500 text-white">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                    @elseif (!$available)
                        <div class="absolute right-4 top-4 flex h-8 w-8 items-center justify-center rounded-full bg-zinc-200 text-zinc-400 dark:bg-zinc-600 dark:text-zinc-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                    @endif

                    <div class="mb-4 flex items-center gap-3">
                        <div @class([
                            'flex h-10 w-10 items-center justify-center rounded-xl text-white shadow-lg',
                            'bg-emerald-500 shadow-emerald-500/25' => $completed,
                            'bg-'.$color.'-500' => !$completed && $available,
                            'bg-zinc-400 dark:bg-zinc-600' => !$completed && !$available,
                            'shadow-'.$color.'-500/25' => !$completed,
                        ])>
                            {!! $icons[$section] !!}
                        </div>
                        <div>
                            <flux:heading size="base" class="font-bold">
                                {{ __('Section :step — :name', ['step' => $loop->iteration, 'name' => $this->getSectionLabel($section)]) }}
                            </flux:heading>
                            <div class="flex items-center gap-2 text-sm text-zinc-500">
                                <span class="font-semibold">{{ $this->getSectionMaxScore($section) }}</span>
                                <span>{{ __('marks') }}</span>
                                <span>·</span>
                                <span>~{{ round($this->getSectionTime($section) / 60) }} {{ __('min') }}</span>
                            </div>
                        </div>
                    </div>

                    @if ($completed)
                        <div class="rounded-lg bg-white/70 p-3 dark:bg-zinc-800/70">
                            <div class="flex items-center justify-between">
                                <flux:text class="text-sm font-medium">{{ __('Score') }}</flux:text>
                                <flux:text class="text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                    {{ $this->getSectionScore($section) }} / {{ $this->getSectionMaxScore($section) }}
                                    ({{ $this->getSectionPercentage($section) }}%)
                                </flux:text>
                            </div>
                        </div>
                    @elseif ($available)
                        <flux:button variant="primary" wire:click="startSection('{{ $section }}')" class="w-full">
                            {{ __('Start Section') }}
                        </flux:button>
                    @else
                        <flux:text class="text-sm text-zinc-400">
                            {{ __('Complete the previous section first.') }}
                        </flux:text>
                    @endif
                </div>
            @endforeach
        </div>

        <flux:text class="text-center text-sm text-zinc-400">
            {{ __('Take your time. Complete each section when you are ready. Each section has its own timer.') }}
        </flux:text>

    {{-- TESTING STATE --}}
    @elseif (in_array($view, ['grammar', 'vocabulary', 'reading', 'writing']))
        <div x-data="{
            timer: {{ $timeRemaining }},
            timerDisplay: '',
            init() {
                this.updateDisplay();
                const interval = setInterval(() => {
                    if (this.timer <= 0) {
                        clearInterval(interval);
                        @this.submit();
                        return;
                    }
                    this.timer--;
                    @this.timeRemaining = this.timer;
                    this.updateDisplay();
                }, 1000);
            },
            updateDisplay() {
                const m = Math.floor(this.timer / 60);
                const s = this.timer % 60;
                this.timerDisplay = m + ':' + String(s).padStart(2, '0');
            }
        }">
            {{-- Header with timer --}}
            <div class="flex items-center justify-between">
                <div>
                    <flux:heading size="xl">{{ __($this->getSectionLabel($view)) }}</flux:heading>
                    <flux:text class="mt-1 text-zinc-500">
                        {{ __(':marks marks · :qty questions', [
                            'marks' => $this->getSectionMaxScore($view),
                            'qty' => $view === 'writing' ? '1 essay' : count($questions ?? []),
                        ]) }}
                    </flux:text>
                </div>
                <div class="flex items-center gap-3">
                    <flux:badge :color="$timeRemaining < 120 ? 'red' : ($timeRemaining < 300 ? 'amber' : 'zinc')" variant="solid" x-text="timerDisplay">
                        {{ round($sectionTimeLimit / 60) }}:00
                    </flux:badge>
                </div>
            </div>

            {{-- Progress bar --}}
            <div class="h-1.5 w-full overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-700">
                <div class="h-full rounded-full bg-zinc-900 transition-all duration-300 dark:bg-zinc-100"
                     style="width: {{ $this->getSectionProgressPercent() }}%">
                </div>
            </div>

            <div class="flex-1 overflow-y-auto">
                {{-- Grammar Section --}}
                @if ($view === 'grammar')
                    <div class="space-y-6">
                        @foreach ($questions as $index => $q)
                            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                                <div class="flex items-start gap-3">
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-sm font-medium text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex-1">
                                        <flux:text class="font-medium">{{ $q['stem'] }}</flux:text>

                                        @if ($q['type'] === 'mcq')
                                            <div class="mt-3 space-y-2">
                                                @foreach ($q['options'] as $opt)
                                                    <label class="flex cursor-pointer items-center gap-3 rounded-lg border p-3 transition hover:border-zinc-400 dark:hover:border-zinc-500"
                                                           :class="{ 'border-zinc-900 bg-zinc-50 dark:border-zinc-100 dark:bg-zinc-800': $wire.answers[{{ $q['id'] }}] == {{ $opt['id'] }}, 'border-zinc-200 dark:border-zinc-700': $wire.answers[{{ $q['id'] }}] != {{ $opt['id'] }} }">
                                                        <input type="radio" name="q_{{ $q['id'] }}" value="{{ $opt['id'] }}" wire:model.change="answers.{{ $q['id'] }}" class="sr-only">
                                                        <div class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border-2"
                                                             :class="$wire.answers[{{ $q['id'] }}] == {{ $opt['id'] }} ? 'border-zinc-900 dark:border-zinc-100' : 'border-zinc-300 dark:border-zinc-600'">
                                                            <div class="h-2.5 w-2.5 rounded-full" x-show="$wire.answers[{{ $q['id'] }}] == {{ $opt['id'] }}"
                                                                 :class="$wire.answers[{{ $q['id'] }}] == {{ $opt['id'] }} ? 'bg-zinc-900 dark:bg-zinc-100' : ''"
                                                                 style="display: none"></div>
                                                        </div>
                                                        <span class="text-sm">{{ $opt['text'] }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @elseif ($q['type'] === 'fill_blank' && !empty($q['options']))
                                            <div class="mt-3">
                                                <flux:select wire:model.change="answers.{{ $q['id'] }}" placeholder="{{ __('Select...') }}">
                                                    <option value="">{{ __('Select...') }}</option>
                                                    @foreach ($q['options'] as $opt)
                                                        <option value="{{ $opt['id'] }}">{{ $opt['text'] }}</option>
                                                    @endforeach
                                                </flux:select>
                                            </div>
                                        @elseif ($q['type'] === 'fill_blank')
                                            <div class="mt-3">
                                                <flux:input wire:model.blur="answers.{{ $q['id'] }}" placeholder="{{ __('Type the correct word...') }}" />
                                            </div>
                                        @else
                                            <div class="mt-3">
                                                <flux:textarea wire:model.blur="answers.{{ $q['id'] }}" rows="2" placeholder="{{ __('Type your answer...') }}" />
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Vocabulary Section --}}
                @if ($view === 'vocabulary')
                    <div class="space-y-6">
                        @foreach ($questions as $index => $q)
                            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                                <div class="flex items-start gap-3">
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-sm font-medium text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex-1">
                                        <flux:text class="font-medium">{{ $q['stem'] }}</flux:text>

                                        @if ($q['type'] === 'mcq')
                                            <div class="mt-3 space-y-2">
                                                @foreach ($q['options'] as $opt)
                                                    <label class="flex cursor-pointer items-center gap-3 rounded-lg border p-3 transition hover:border-zinc-400 dark:hover:border-zinc-500"
                                                           :class="{ 'border-zinc-900 bg-zinc-50 dark:border-zinc-100 dark:bg-zinc-800': $wire.answers[{{ $q['id'] }}] == {{ $opt['id'] }}, 'border-zinc-200 dark:border-zinc-700': $wire.answers[{{ $q['id'] }}] != {{ $opt['id'] }} }">
                                                        <input type="radio" name="q_{{ $q['id'] }}" value="{{ $opt['id'] }}" wire:model.change="answers.{{ $q['id'] }}" class="sr-only">
                                                        <div class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border-2"
                                                             :class="$wire.answers[{{ $q['id'] }}] == {{ $opt['id'] }} ? 'border-zinc-900 dark:border-zinc-100' : 'border-zinc-300 dark:border-zinc-600'">
                                                            <div class="h-2.5 w-2.5 rounded-full" x-show="$wire.answers[{{ $q['id'] }}] == {{ $opt['id'] }}"
                                                                 :class="$wire.answers[{{ $q['id'] }}] == {{ $opt['id'] }} ? 'bg-zinc-900 dark:bg-zinc-100' : ''"
                                                                 style="display: none"></div>
                                                        </div>
                                                        <span class="text-sm">{{ $opt['text'] }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="mt-3">
                                                <flux:input wire:model.blur="answers.{{ $q['id'] }}" placeholder="{{ __('Type your answer...') }}" />
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Reading Section --}}
                @if ($view === 'reading')
                    <div class="space-y-6">
                        @if ($passage)
                            <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-6 dark:border-zinc-700 dark:bg-zinc-800">
                                <flux:heading size="base" class="mb-3">{{ $passage['title'] }}</flux:heading>
                                <div class="prose prose-sm max-w-none text-zinc-600 dark:text-zinc-300 whitespace-pre-line">
                                    {{ $passage['content'] }}
                                </div>
                            </div>
                        @endif

                        @foreach ($questions as $index => $q)
                            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                                <div class="flex items-start gap-3">
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-sm font-medium text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex-1">
                                        <flux:text class="font-medium">{{ $q['stem'] }}</flux:text>
                                        <div class="mt-3">
                                            <flux:textarea wire:model.blur="answers.{{ $q['id'] }}" rows="3" placeholder="{{ __('Write your answer...') }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Writing Section --}}
                @if ($view === 'writing')
                    <div class="space-y-6">
                        @if ($writingPrompt)
                            <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-6 dark:border-zinc-700 dark:bg-zinc-800">
                                <flux:heading size="base" class="mb-3">{{ $writingPrompt['title'] }}</flux:heading>
                                <div class="prose prose-sm max-w-none text-zinc-600 dark:text-zinc-300 whitespace-pre-line">
                                    {{ $writingPrompt['scenario'] }}
                                </div>
                            </div>

                            <div>
                                <div class="mb-2 flex items-center justify-between">
                                    <flux:label>{{ __('Your response') }}</flux:label>
                                    <flux:text class="text-sm text-zinc-400">
                                        {{ str_word_count($essayContent) }} / {{ $writingPrompt['word_limit_max'] ?? 200 }} {{ __('words') }}
                                    </flux:text>
                                </div>
                                <flux:textarea
                                    wire:model.live="essayContent"
                                    rows="12"
                                    class="font-mono text-sm"
                                    placeholder="{{ __('Write your essay here...') }}"
                                />
                            </div>
                        @else
                            <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-6 text-center dark:border-zinc-700 dark:bg-zinc-800">
                                <flux:text class="text-zinc-500">{{ __('Please complete Grammar and Vocabulary sections first.') }}</flux:text>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Navigation --}}
            <div class="flex items-center justify-between border-t border-zinc-200 pt-4 dark:border-zinc-700">
                <flux:button variant="ghost" wire:click="backToOverview">
                    {{ __('Back to Overview') }}
                </flux:button>

                <flux:button variant="primary" wire:click="submit">
                    {{ __('Submit Section') }}
                </flux:button>
            </div>
        </div>

    {{-- RESULTS STATE --}}
    @elseif ($view === 'results')
        <div class="flex flex-1 flex-col items-center justify-center gap-6">
            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                <svg class="h-10 w-10 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <div class="text-center">
                <flux:heading size="xl">{{ __('Section Completed!') }}</flux:heading>
                <flux:text class="mt-1 text-zinc-500">
                    {{ $lastResults['section_name'] ?? '' }}
                </flux:text>
            </div>

            <div class="grid w-full max-w-md grid-cols-3 gap-4">
                <div class="rounded-xl border border-zinc-200 bg-white p-4 text-center dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="text-2xl font-bold">{{ $lastResults['score'] ?? 0 }}</div>
                    <div class="text-xs text-zinc-400">{{ __('Score') }}</div>
                </div>
                <div class="rounded-xl border border-zinc-200 bg-white p-4 text-center dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="text-2xl font-bold">{{ $lastResults['max_score'] ?? 0 }}</div>
                    <div class="text-xs text-zinc-400">{{ __('Max') }}</div>
                </div>
                <div class="rounded-xl border border-zinc-200 bg-white p-4 text-center dark:border-zinc-700 dark:bg-zinc-900">
                    <div class="text-2xl font-bold">{{ $lastResults['percentage'] ?? 0 }}%</div>
                    <div class="text-xs text-zinc-400">{{ __('Percentage') }}</div>
                </div>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-white p-4 text-center dark:border-zinc-700 dark:bg-zinc-900">
                <flux:text class="text-sm text-zinc-500">{{ __('Estimated Level') }}</flux:text>
                <flux:heading size="lg" class="mt-1">{{ $lastResults['estimated_grade'] ?? '—' }}</flux:heading>
                <flux:badge variant="solid" color="zinc" class="mt-1">{{ $lastResults['classification'] ?? '' }}</flux:badge>
            </div>

            @if ($this->getCompletedCount() < $this->getTotalSections())
                <flux:text class="text-sm text-zinc-400">
                    {{ __(':remaining section(s) remaining', ['remaining' => $this->getTotalSections() - $this->getCompletedCount()]) }}
                </flux:text>
                <flux:button variant="primary" wire:click="backToOverview">
                    {{ __('Continue') }}
                </flux:button>
            @else
                <div class="text-center">
                    <flux:heading size="lg" class="mb-2">{{ __('Placement Test Complete!') }}</flux:heading>
                    <flux:text class="text-zinc-500">
                        {{ __('Your overall score: :score / 75 (:pct%)', [
                            'score' => $this->getOverallScore(),
                            'pct' => $this->getOverallPercentage(),
                        ]) }}
                    </flux:text>
                </div>
                <flux:button variant="primary" href="{{ route('profile') }}" wire:navigate>
                    {{ __('View My Profile') }}
                </flux:button>
            @endif
        </div>
    @endif
</div>
