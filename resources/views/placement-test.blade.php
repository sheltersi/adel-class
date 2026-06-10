<x-layouts::app :title="__('Placement Test')">
    <div class="flex h-full w-full flex-1 flex-col gap-8 rounded-xl">
        {{-- Hero Section with Gradient Background --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-8 text-white shadow-2xl dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 md:p-12">
            {{-- Decorative Background Elements --}}
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-blue-500/10 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-purple-500/10 blur-3xl"></div>
            <div class="absolute right-1/4 top-1/4 h-32 w-32 rounded-full bg-cyan-500/10 blur-2xl"></div>

            <div class="relative z-10 flex flex-col items-start gap-4 md:flex-row md:items-center md:justify-between">
                <div class="max-w-2xl">
                <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm font-medium text-cyan-300 ring-1 ring-white/20 backdrop-blur-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __('Self-Paced Assessment') }}
                </div>
                <flux:heading size="xl" class="text-3xl font-bold text-white md:text-4xl lg:text-5xl">
                    {{ __('Placement Test') }}
                </flux:heading>
                <flux:text class="mt-3 text-lg text-slate-300">
                    {{ __('Take one section at a time, at your own pace. Complete each section when you are ready and get your results immediately.') }}
                </flux:text>
                </div>

            {{-- Circular Progress Indicator --}}
            <div class="hidden shrink-0 flex-col items-center gap-2 md:flex">
                <div class="relative flex h-32 w-32 items-center justify-center">
                    <svg class="h-32 w-32 -rotate-90" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="54" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="8" />
                        <circle cx="60" cy="60" r="54" fill="none" stroke="currentColor" stroke-width="8" stroke-linecap="round" stroke-dasharray="339.292" stroke-dashoffset="0" class="text-cyan-400 transition-all duration-1000" />
                    </svg>
                    <div class="absolute flex flex-col items-center">
                        <span class="text-3xl font-bold text-white">4</span>
                        <span class="text-xs text-slate-400">{{ __('sections') }}</span>
                    </div>
                </div>
                <span class="text-sm font-medium text-slate-300">{{ __('Self-Paced') }}</span>
            </div>
            </div>
        </div>

        {{-- Stats Overview Bar --}}
        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            <div class="group rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
                <div class="mb-2 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.967 8.967 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div class="text-2xl font-bold text-slate-900 dark:text-white">4</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">{{ __('Sections') }}</div>
            </div>

            <div class="group rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
                <div class="mb-2 flex h-10 w-10 items-center justify-center rounded-lg bg-purple-50 text-purple-600 dark:bg-purple-900/20 dark:text-purple-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="text-2xl font-bold text-slate-900 dark:text-white">40</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">{{ __('Questions') }}</div>
            </div>

            <div class="group rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
                <div class="mb-2 flex h-10 w-10 items-center justify-center rounded-lg bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <div class="text-2xl font-bold text-slate-900 dark:text-white">75</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">{{ __('Total Marks') }}</div>
            </div>

        <div class="group rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
            <div class="mb-2 flex h-10 w-10 items-center justify-center rounded-lg bg-orange-50 text-orange-600 dark:bg-orange-900/20 dark:text-orange-400">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="text-2xl font-bold text-slate-900 dark:text-white">10–18</div>
            <div class="text-sm text-slate-500 dark:text-slate-400">{{ __('Min / Section') }}</div>
        </div>
        </div>

        {{-- Section Cards --}}
        <div>
            <div class="mb-5 flex items-center gap-3">
                <div class="h-8 w-1 rounded-full bg-gradient-to-b from-blue-500 to-purple-500"></div>
                <flux:heading size="lg" class="text-xl font-bold text-slate-900 dark:text-white">
                    {{ __('Test Sections') }}
                </flux:heading>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                {{-- Grammar Card --}}
                <div class="group relative overflow-hidden rounded-2xl border border-blue-100 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-lg dark:border-blue-900/30 dark:bg-slate-800">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-blue-500/5 blur-xl transition-all group-hover:bg-blue-500/10"></div>
                    <div class="relative z-10">
                        <div class="mb-4 flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500 text-white shadow-lg shadow-blue-500/25">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                </svg>
                            </div>
                            <div>
                                <flux:heading size="lg" class="text-lg font-bold text-slate-900 dark:text-white">{{ __('Section 1 — Grammar') }}</flux:heading>
                                <div class="flex items-center gap-2 text-sm text-blue-600 dark:text-blue-400">
                                    <span class="font-semibold">15</span>
                                    <span class="text-slate-400">{{ __('marks · 15 questions · ~12 min') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 h-1.5 w-full overflow-hidden rounded-full bg-blue-100 dark:bg-blue-900/20">
                            <div class="h-full rounded-full bg-blue-500 transition-all duration-500" style="width: 20%"></div>
                        </div>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('Error correction') }}
                            </li>
                            <li class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('Sentence transformation') }}
                            </li>
                            <li class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('Gap fill (contextual)') }}
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Vocabulary Card --}}
                <div class="group relative overflow-hidden rounded-2xl border border-purple-100 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-lg dark:border-purple-900/30 dark:bg-slate-800">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-purple-500/5 blur-xl transition-all group-hover:bg-purple-500/10"></div>
                    <div class="relative z-10">
                        <div class="mb-4 flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-500 text-white shadow-lg shadow-purple-500/25">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.967 8.967 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <div>
                                <flux:heading size="lg" class="text-lg font-bold text-slate-900 dark:text-white">{{ __('Section 2 — Vocabulary') }}</flux:heading>
                                <div class="flex items-center gap-2 text-sm text-purple-600 dark:text-purple-400">
                                    <span class="font-semibold">15</span>
                                    <span class="text-slate-400">{{ __('marks · 15 questions · ~10 min') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 h-1.5 w-full overflow-hidden rounded-full bg-purple-100 dark:bg-purple-900/20">
                            <div class="h-full rounded-full bg-purple-500 transition-all duration-500" style="width: 20%"></div>
                        </div>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('Word in context') }}
                            </li>
                            <li class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('Collocation & usage') }}
                            </li>
                            <li class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('Word formation') }}
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Reading Card --}}
                <div class="group relative overflow-hidden rounded-2xl border border-green-100 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-lg dark:border-green-900/30 dark:bg-slate-800">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-green-500/5 blur-xl transition-all group-hover:bg-green-500/10"></div>
                    <div class="relative z-10">
                        <div class="mb-4 flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-500 text-white shadow-lg shadow-green-500/25">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.967 8.967 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>
                            <div>
                                <flux:heading size="lg" class="text-lg font-bold text-slate-900 dark:text-white">{{ __('Section 3 — Reading') }}</flux:heading>
                                <div class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400">
                                    <span class="font-semibold">20</span>
                                    <span class="text-slate-400">{{ __('marks · 9 questions · ~18 min') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 h-1.5 w-full overflow-hidden rounded-full bg-green-100 dark:bg-green-900/20">
                            <div class="h-full rounded-full bg-green-500 transition-all duration-500" style="width: 26.7%"></div>
                        </div>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('Passage A — Narrative (~300 words)') }}
                            </li>
                            <li class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('Passage B — Argumentative (~220 words)') }}
                            </li>
                            <li class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('Literal, inferential & evaluative questions') }}
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Writing Card --}}
                <div class="group relative overflow-hidden rounded-2xl border border-orange-100 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-lg dark:border-orange-900/30 dark:bg-slate-800">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-orange-500/5 blur-xl transition-all group-hover:bg-orange-500/10"></div>
                    <div class="relative z-10">
                        <div class="mb-4 flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-500 text-white shadow-lg shadow-orange-500/25">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </div>
                            <div>
                                <flux:heading size="lg" class="text-lg font-bold text-slate-900 dark:text-white">{{ __('Section 4 — Writing') }}</flux:heading>
                                <div class="flex items-center gap-2 text-sm text-orange-600 dark:text-orange-400">
                                    <span class="font-semibold">25</span>
                                    <span class="text-slate-400">{{ __('marks · 1 essay · ~15 min') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 h-1.5 w-full overflow-hidden rounded-full bg-orange-100 dark:bg-orange-900/20">
                            <div class="h-full rounded-full bg-orange-500 transition-all duration-500" style="width: 33.3%"></div>
                        </div>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('150–200 word response') }}
                            </li>
                            <li class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('Assessed on content, organisation, vocabulary and accuracy') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Marks Distribution Visualization --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
            <div class="mb-4 flex items-center gap-3">
                <div class="h-8 w-1 rounded-full bg-gradient-to-b from-green-500 to-blue-500"></div>
                <flux:heading size="lg" class="text-lg font-bold text-slate-900 dark:text-white">{{ __('Marks Distribution') }}</flux:heading>
            </div>
            <div class="flex h-8 w-full overflow-hidden rounded-full">
                <div class="flex items-center justify-center bg-blue-500 text-xs font-bold text-white" style="width: 20%">20%</div>
                <div class="flex items-center justify-center bg-purple-500 text-xs font-bold text-white" style="width: 20%">20%</div>
                <div class="flex items-center justify-center bg-green-500 text-xs font-bold text-white" style="width: 26.7%">27%</div>
                <div class="flex items-center justify-center bg-orange-500 text-xs font-bold text-white" style="width: 33.3%">33%</div>
            </div>
            <div class="mt-4 flex flex-wrap gap-4">
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full bg-blue-500"></div>
                    <span class="text-sm text-slate-600 dark:text-slate-300">{{ __('Grammar') }} (15)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full bg-purple-500"></div>
                    <span class="text-sm text-slate-600 dark:text-slate-300">{{ __('Vocabulary') }} (15)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full bg-green-500"></div>
                    <span class="text-sm text-slate-600 dark:text-slate-300">{{ __('Reading') }} (20)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full bg-orange-500"></div>
                    <span class="text-sm text-slate-600 dark:text-slate-300">{{ __('Writing') }} (25)</span>
                </div>
            </div>
        </div>

        {{-- Important Notes --}}
        <div class="rounded-2xl border border-amber-100 bg-amber-50/50 p-6 dark:border-amber-900/30 dark:bg-amber-900/10">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <flux:heading size="lg" class="text-lg font-bold text-slate-900 dark:text-white">{{ __('Important Notes') }}</flux:heading>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
            <div class="flex items-start gap-3 rounded-xl bg-white p-4 shadow-sm dark:bg-slate-800">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <div class="font-medium text-slate-900 dark:text-white">{{ __('One Section at a Time') }}</div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">{{ __('Complete each section at your own pace. Your progress is saved automatically.') }}</div>
                </div>
            </div>
                <div class="flex items-start gap-3 rounded-xl bg-white p-4 shadow-sm dark:bg-slate-800">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                    <div>
                        <div class="font-medium text-slate-900 dark:text-white">{{ __('No External Help') }}</div>
                        <div class="text-sm text-slate-500 dark:text-slate-400">{{ __('Please do not use dictionaries, translators, or other resources during the test.') }}</div>
                    </div>
                </div>
                <div class="flex items-start gap-3 rounded-xl bg-white p-4 shadow-sm dark:bg-slate-800">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <div class="font-medium text-slate-900 dark:text-white">{{ __('Best Effort') }}</div>
                        <div class="text-sm text-slate-500 dark:text-slate-400">{{ __('Answer all questions to the best of your ability. There is no penalty for guessing.') }}</div>
                    </div>
                </div>
                <div class="flex items-start gap-3 rounded-xl bg-white p-4 shadow-sm dark:bg-slate-800">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                    </svg>
                    <div>
                        <div class="font-medium text-slate-900 dark:text-white">{{ __('Instant Results') }}</div>
                        <div class="text-sm text-slate-500 dark:text-slate-400">{{ __('Your results will be available immediately upon completion.') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA Section --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-8 text-center shadow-xl dark:from-blue-900 dark:via-indigo-900 dark:to-purple-900 md:p-12">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIvPjwvc3ZnPg==')] opacity-30"></div>
            <div class="relative z-10">
                <h3 class="mb-3 text-2xl font-bold text-white md:text-3xl">{{ __('Ready to Begin?') }}</h3>
                <p class="mb-8 text-lg text-blue-100">
                    {{ __('Total: 75 marks · 4 sections · Take at your own pace') }}
                </p>
                <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <flux:button variant="primary" class="min-w-[200px] !bg-white !px-8 !py-3 !text-base !font-semibold !text-slate-900 hover:!bg-slate-100">
                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                        </svg>
                        {{ __('Start Test Now') }}
                    </flux:button>
                    <flux:button variant="outline" class="min-w-[200px] !border-white/30 !px-8 !py-3 !text-base !font-semibold !text-white hover:!bg-white/10">
                        {{ __('Learn More') }}
                    </flux:button>
                </div>
                <p class="mt-4 text-sm text-blue-200">
                    {{ __('Scores are shown after each section. Each section has its own timer.') }}
                </p>
            </div>
        </div>
    </div>
</x-layouts::app>