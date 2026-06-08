<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:heading size="xl">{{ __('Welcome back, :name', ['name' => auth()->user()->name]) }}</flux:heading>

        @if (!auth()->user()->studentProfile?->placement_completed)
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
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-[#E2E8F0] dark:border-[#334155] bg-white dark:bg-[#1E293B]">
                    <x-placeholder-pattern class="absolute inset-0 size-full stroke-[#334155]/20 dark:stroke-[#CBD5E1]/20" />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-[#E2E8F0] dark:border-[#334155] bg-white dark:bg-[#1E293B]">
                    <x-placeholder-pattern class="absolute inset-0 size-full stroke-[#334155]/20 dark:stroke-[#CBD5E1]/20" />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-[#E2E8F0] dark:border-[#334155] bg-white dark:bg-[#1E293B]">
                    <x-placeholder-pattern class="absolute inset-0 size-full stroke-[#334155]/20 dark:stroke-[#CBD5E1]/20" />
                </div>
            </div>
            <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-[#E2E8F0] dark:border-[#334155] bg-white dark:bg-[#1E293B]">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-[#334155]/20 dark:stroke-[#CBD5E1]/20" />
            </div>
        @endif
    </div>
</x-layouts::app>
