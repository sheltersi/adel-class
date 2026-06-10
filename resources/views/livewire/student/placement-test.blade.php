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
}" class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
    {{-- Header with timer --}}
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">{{ __('Placement Test') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-500">
                {{ __('Step :current of :total', ['current' => $currentStep, 'total' => $totalSteps]) }}
            </flux:text>
        </div>
        <div class="flex items-center gap-3">
            <flux:badge :color="$timeRemaining < 600 ? 'red' : ($timeRemaining < 1800 ? 'amber' : 'zinc')" variant="solid" x-text="timerDisplay">55:00</flux:badge>
        </div>
    </div>

    {{-- Step indicator --}}
    <div class="flex gap-2">
        @foreach (range(1, $totalSteps) as $step)
            <button
                wire:click="goToStep({{ $step }})"
                @class([
                    'flex-1 rounded-lg px-3 py-2 text-center text-sm font-medium transition',
                    'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' => $step === $currentStep,
                    'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300' => $step < $currentStep,
                    'bg-zinc-100 text-zinc-400 dark:bg-zinc-800' => $step > $currentStep,
                ])
            >
                <span class="block text-xs uppercase tracking-wider">
                    @switch($step)
                        @case(1) {{ __('Grammar') }} @break
                        @case(2) {{ __('Vocabulary') }} @break
                        @case(3) {{ __('Reading') }} @break
                        @case(4) {{ __('Writing') }} @break
                    @endswitch
                </span>
                <span class="block text-[10px] opacity-60">{{ $this->getSectionProgress($step) }}%</span>
            </button>
        @endforeach
    </div>

    <div class="flex-1 overflow-y-auto">
        {{-- Step 1: Grammar --}}
        @if ($currentStep === 1)
            <div class="space-y-6">
                <flux:heading size="lg">{{ __('Grammar') }}</flux:heading>
                <flux:text class="text-zinc-500">{{ __('15 marks · Answer all questions below.') }}</flux:text>

                @foreach ($grammarQuestions as $index => $q)
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
                                                <input
                                                    type="radio"
                                                    name="q_{{ $q['id'] }}"
                                                    value="{{ $opt['id'] }}"
                                                    wire:model.change="answers.{{ $q['id'] }}"
                                                    class="sr-only"
                                                >
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
                                        <flux:input
                                            wire:model.blur="answers.{{ $q['id'] }}"
                                            placeholder="{{ __('Type the correct word...') }}"
                                        />
                                    </div>
                                @else
                                    <div class="mt-3">
                                        <flux:textarea
                                            wire:model.blur="answers.{{ $q['id'] }}"
                                            rows="2"
                                            placeholder="{{ __('Type your answer...') }}"
                                        />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Step 2: Vocabulary --}}
        @if ($currentStep === 2)
            <div class="space-y-6">
                <flux:heading size="lg">{{ __('Vocabulary') }}</flux:heading>
                <flux:text class="text-zinc-500">{{ __('15 marks · Answer all questions below.') }}</flux:text>

                @foreach ($vocabQuestions as $index => $q)
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
                                                <input
                                                    type="radio"
                                                    name="q_{{ $q['id'] }}"
                                                    value="{{ $opt['id'] }}"
                                                    wire:model.change="answers.{{ $q['id'] }}"
                                                    class="sr-only"
                                                >
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
                                        <flux:input
                                            wire:model.blur="answers.{{ $q['id'] }}"
                                            placeholder="{{ __('Type your answer...') }}"
                                        />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Step 3: Reading --}}
        @if ($currentStep === 3)
            <div class="space-y-6">
                <flux:heading size="lg">{{ __('Reading Comprehension') }}</flux:heading>
                <flux:text class="text-zinc-500">{{ __('19 marks · Read the passage and answer the questions.') }}</flux:text>

                @if ($passages)
                    @foreach ($passages as $passage)
                        <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-6 dark:border-zinc-700 dark:bg-zinc-800">
                            <flux:heading size="base" class="mb-3">{{ $passage['title'] }}</flux:heading>
                            <div class="prose prose-sm max-w-none text-zinc-600 dark:text-zinc-300 whitespace-pre-line">
                                {{ $passage['content'] }}
                            </div>
                        </div>
                    @endforeach
                @endif

                @foreach ($readingQuestions as $index => $q)
                    <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                        <div class="flex items-start gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-sm font-medium text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300">
                                {{ $index + 1 }}
                            </span>
                            <div class="flex-1">
                                <flux:text class="font-medium">{{ $q['stem'] }}</flux:text>
                                <div class="mt-3">
                                    <flux:textarea
                                        wire:model.blur="answers.{{ $q['id'] }}"
                                        rows="3"
                                        placeholder="{{ __('Write your answer...') }}"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Step 4: Writing --}}
        @if ($currentStep === 4)
            <div class="space-y-6">
                <flux:heading size="lg">{{ __('Writing') }}</flux:heading>
                <flux:text class="text-zinc-500">
                    {{ __('25 marks · Write 150–200 words. You have about 15 minutes.') }}
                </flux:text>

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
                        <flux:text class="text-zinc-500">{{ __('Please complete the previous sections first.') }}</flux:text>
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- Navigation --}}
    <div class="flex items-center justify-between border-t border-zinc-200 pt-4 dark:border-zinc-700">
        <div>
            @if ($currentStep > 1)
                <flux:button variant="ghost" wire:click="previousStep">
                    {{ __('Back') }}
                </flux:button>
            @endif
        </div>

        <div class="flex items-center gap-3">
            @if ($currentStep < $totalSteps)
                <flux:button variant="primary" wire:click="nextStep">
                    {{ __('Next') }}
                </flux:button>
            @else
                <flux:button
                    variant="primary"
                    wire:click="submit"
                    :disabled="!$essayContent"
                >
                    {{ __('Submit Test') }}
                </flux:button>
            @endif
        </div>
    </div>
</div>
