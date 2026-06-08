<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Tutoring') }} — Master English with Confidence</title>
        <meta name="description" content="Personalized English tutoring powered by smart placement tests. Assess your level and build a custom learning path.">

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* === Core Animations === */
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(40px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes scaleIn {
                from { opacity: 0; transform: scale(0.9); }
                to { opacity: 1; transform: scale(1); }
            }
            @keyframes slideFromLeft {
                from { opacity: 0; transform: translateX(-60px); }
                to { opacity: 1; transform: translateX(0); }
            }
            @keyframes slideFromRight {
                from { opacity: 0; transform: translateX(60px); }
                to { opacity: 1; transform: translateX(0); }
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(2deg); }
            }
            @keyframes floatSlow {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-15px) rotate(-2deg); }
            }
            @keyframes pulse-glow {
                0%, 100% { box-shadow: 0 0 20px rgba(37, 99, 235, 0.3); }
                50% { box-shadow: 0 0 40px rgba(37, 99, 235, 0.6); }
            }
            @keyframes gradient-shift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            @keyframes shimmer {
                0% { transform: translateX(-100%) rotate(0deg); }
                100% { transform: translateX(100%) rotate(0deg); }
            }
            @keyframes rotate-slow {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            @keyframes morph {
                0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
                50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
            }
            @keyframes typing {
                from { width: 0; }
                to { width: 100%; }
            }
            @keyframes blink {
                50% { border-color: transparent; }
            }
            @keyframes bounce-subtle {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-5px); }
            }
            @keyframes orbit {
                from { transform: rotate(0deg) translateX(120px) rotate(0deg); }
                to { transform: rotate(360deg) translateX(120px) rotate(-360deg); }
            }
            @keyframes orbit-reverse {
                from { transform: rotate(360deg) translateX(100px) rotate(-360deg); }
                to { transform: rotate(0deg) translateX(100px) rotate(0deg); }
            }

            /* === Animation Classes === */
            .anim-fade-in { animation: fadeIn 0.8s ease-out both; }
            .anim-fade-up { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both; }
            .anim-scale-in { animation: scaleIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }
            .anim-slide-left { animation: slideFromLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) both; }
            .anim-slide-right { animation: slideFromRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) both; }
            
            .delay-100 { animation-delay: 0.1s; }
            .delay-200 { animation-delay: 0.2s; }
            .delay-300 { animation-delay: 0.3s; }
            .delay-400 { animation-delay: 0.4s; }
            .delay-500 { animation-delay: 0.5s; }
            .delay-600 { animation-delay: 0.6s; }
            .delay-700 { animation-delay: 0.7s; }
            .delay-800 { animation-delay: 0.8s; }
            .delay-1000 { animation-delay: 1s; }

            /* === Scroll Reveal === */
            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .reveal.visible {
                opacity: 1;
                transform: translateY(0);
            }
            .reveal-left {
                opacity: 0;
                transform: translateX(-40px);
                transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .reveal-left.visible {
                opacity: 1;
                transform: translateX(0);
            }
            .reveal-right {
                opacity: 0;
                transform: translateX(40px);
                transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .reveal-right.visible {
                opacity: 1;
                transform: translateX(0);
            }
            .reveal-scale {
                opacity: 0;
                transform: scale(0.9);
                transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .reveal-scale.visible {
                opacity: 1;
                transform: scale(1);
            }

            /* === Gradient Text === */
            .text-gradient {
                background: linear-gradient(135deg, #2563EB 0%, #7C3AED 50%, #2563EB 100%);
                background-size: 200% auto;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                animation: gradient-shift 5s ease infinite;
            }
            .text-gradient-2 {
                background: linear-gradient(135deg, #06B6D4 0%, #3B82F6 50%, #8B5CF6 100%);
                background-size: 200% auto;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                animation: gradient-shift 6s ease infinite;
            }

            /* === Glassmorphism === */
            .glass {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(20px) saturate(180%);
                -webkit-backdrop-filter: blur(20px) saturate(180%);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }
            .dark .glass {
                background: rgba(15, 23, 42, 0.7);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }
            .glass-strong {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(30px) saturate(200%);
                -webkit-backdrop-filter: blur(30px) saturate(200%);
                border: 1px solid rgba(255, 255, 255, 0.4);
            }
            .dark .glass-strong {
                background: rgba(15, 23, 42, 0.85);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            /* === Hero Background === */
            .hero-bg {
                background: 
                    radial-gradient(ellipse at 20% 50%, rgba(37, 99, 235, 0.08) 0%, transparent 50%),
                    radial-gradient(ellipse at 80% 20%, rgba(124, 58, 237, 0.06) 0%, transparent 50%),
                    radial-gradient(ellipse at 50% 80%, rgba(6, 182, 212, 0.05) 0%, transparent 50%);
            }
            .dark .hero-bg {
                background: 
                    radial-gradient(ellipse at 20% 50%, rgba(37, 99, 235, 0.12) 0%, transparent 50%),
                    radial-gradient(ellipse at 80% 20%, rgba(124, 58, 237, 0.08) 0%, transparent 50%),
                    radial-gradient(ellipse at 50% 80%, rgba(6, 182, 212, 0.06) 0%, transparent 50%);
            }

            /* === Grid Pattern === */
            .grid-pattern {
                background-image: 
                    linear-gradient(rgba(37, 99, 235, 0.04) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(37, 99, 235, 0.04) 1px, transparent 1px);
                background-size: 80px 80px;
            }
            .dark .grid-pattern {
                background-image: 
                    linear-gradient(rgba(37, 99, 235, 0.08) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(37, 99, 235, 0.08) 1px, transparent 1px);
            }

            /* === Floating Elements === */
            .float-1 { animation: float 8s ease-in-out infinite; }
            .float-2 { animation: floatSlow 10s ease-in-out infinite; }
            .float-3 { animation: float 12s ease-in-out infinite 2s; }

            /* === Gradient Border === */
            .gradient-border {
                position: relative;
                background: white;
            }
            .dark .gradient-border {
                background: #1E293B;
            }
            .gradient-border::before {
                content: '';
                position: absolute;
                inset: -1px;
                border-radius: inherit;
                padding: 1px;
                background: linear-gradient(135deg, rgba(37, 99, 235, 0.3), rgba(124, 58, 237, 0.3), rgba(6, 182, 212, 0.3));
                -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
                mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
                -webkit-mask-composite: xor;
                mask-composite: exclude;
                opacity: 0;
                transition: opacity 0.4s ease;
            }
            .gradient-border:hover::before {
                opacity: 1;
            }

            /* === Shimmer Button === */
            .btn-shimmer {
                position: relative;
                overflow: hidden;
            }
            .btn-shimmer::after {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transform: translateX(-100%);
                transition: transform 0.5s;
            }
            .btn-shimmer:hover::after {
                transform: translateX(100%);
            }

            /* === Glow Effect === */
            .glow-blue {
                box-shadow: 0 0 30px rgba(37, 99, 235, 0.15);
                transition: box-shadow 0.3s ease;
            }
            .glow-blue:hover {
                box-shadow: 0 0 50px rgba(37, 99, 235, 0.25);
            }

            /* === Card Hover === */
            .card-hover {
                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .card-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            }

            /* === Morph Blob === */
            .morph-blob {
                animation: morph 10s ease-in-out infinite;
            }

            /* === Orbit === */
            .orbit-1 {
                animation: orbit 20s linear infinite;
            }
            .orbit-2 {
                animation: orbit-reverse 25s linear infinite;
            }
            .orbit-3 {
                animation: orbit 18s linear infinite 5s;
            }

            /* === Smooth Scroll === */
            html {
                scroll-behavior: smooth;
            }

            /* === Noise Texture === */
            .noise-overlay::before {
                content: '';
                position: absolute;
                inset: 0;
                background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.015'/%3E%3C/svg%3E");
                pointer-events: none;
                z-index: 1;
            }

            /* === Custom Scrollbar === */
            ::-webkit-scrollbar {
                width: 8px;
            }
            ::-webkit-scrollbar-track {
                background: transparent;
            }
            ::-webkit-scrollbar-thumb {
                background: rgba(37, 99, 235, 0.3);
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: rgba(37, 99, 235, 0.5);
            }
        </style>
    </head>
    <body class="bg-white dark:bg-[#0B0F19] text-slate-600 dark:text-slate-300 antialiased overflow-x-hidden">

        {{-- === NAVIGATION === --}}
        <nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-slate-200/50 dark:border-slate-800/50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <div class="flex items-center justify-center size-9 rounded-xl bg-gradient-to-br from-blue-500 to-violet-500 shadow-lg shadow-blue-500/20 group-hover:shadow-blue-500/40 transition-all duration-300">
                            <svg class="size-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                            </svg>
                        </div>
                        <span class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">{{ config('app.name', 'Tutoring') }}</span>
                    </a>
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#features" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-blue-500 dark:hover:text-blue-400 transition-colors relative group">
                            Features
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-500 rounded-full transition-all group-hover:w-full"></span>
                        </a>
                        <a href="#how-it-works" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-blue-500 dark:hover:text-blue-400 transition-colors relative group">
                            How It Works
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-500 rounded-full transition-all group-hover:w-full"></span>
                        </a>
                        <a href="#testimonials" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-blue-500 dark:hover:text-blue-400 transition-colors relative group">
                            Testimonials
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-500 rounded-full transition-all group-hover:w-full"></span>
                        </a>
                        <a href="#pricing" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-blue-500 dark:hover:text-blue-400 transition-colors relative group">
                            Pricing
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-500 rounded-full transition-all group-hover:w-full"></span>
                        </a>
                    </div>
                    <div class="flex items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 transition-all shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-slate-100 transition-all shadow-lg">
                                        Get Started
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        {{-- === HERO SECTION === --}}
        <section class="relative min-h-screen flex items-center pt-20 hero-bg grid-pattern overflow-hidden">
            {{-- Floating Decorative Elements --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-[20%] left-[10%] w-72 h-72 bg-blue-500/10 rounded-full blur-3xl float-1"></div>
                <div class="absolute top-[40%] right-[15%] w-96 h-96 bg-violet-500/10 rounded-full blur-3xl float-2"></div>
                <div class="absolute bottom-[20%] left-[30%] w-64 h-64 bg-cyan-500/10 rounded-full blur-3xl float-3"></div>
                
                {{-- Floating Orbs --}}
                <div class="absolute top-[30%] left-[20%] size-3 bg-blue-400/30 rounded-full float-1"></div>
                <div class="absolute top-[25%] right-[25%] size-4 bg-violet-400/20 rounded-full float-2"></div>
                <div class="absolute top-[60%] left-[15%] size-2 bg-cyan-400/30 rounded-full float-3"></div>
                <div class="absolute bottom-[35%] right-[20%] size-3 bg-blue-300/20 rounded-full float-1"></div>
                <div class="absolute top-[50%] left-[40%] size-2 bg-violet-300/20 rounded-full float-2"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-20 lg:py-32">
                <div class="max-w-4xl mx-auto text-center">
                    {{-- Badge --}}
                    <div class="anim-fade-up inline-flex items-center gap-2 px-4 py-2 rounded-full border border-blue-200/50 dark:border-blue-800/50 bg-blue-50/50 dark:bg-blue-900/20 backdrop-blur-sm mb-8">
                        <span class="relative flex size-2">
                            <span class="absolute inline-flex h-full w-full rounded-full bg-blue-500 animate-ping opacity-60"></span>
                            <span class="relative inline-flex rounded-full size-2 bg-blue-500"></span>
                        </span>
                        <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Now enrolling for 2026</span>
                        <span class="px-2 py-0.5 rounded-full bg-blue-100 dark:bg-blue-800 text-xs font-semibold text-blue-700 dark:text-blue-300">Free</span>
                    </div>

                    {{-- Heading --}}
                    <h1 class="anim-fade-up delay-100 text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-[1.1] text-slate-900 dark:text-white mb-8">
                        Master English
                        <br>
                        with <span class="text-gradient">Confidence</span>
                    </h1>

                    {{-- Subtitle --}}
                    <p class="anim-fade-up delay-200 text-xl text-slate-500 dark:text-slate-400 max-w-2xl mx-auto mb-12 leading-relaxed">
                        Personalized tutoring powered by AI-driven placement tests. We assess your exact level and build a custom learning path that evolves with you.
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="anim-fade-up delay-300 flex flex-col sm:flex-row items-center justify-center gap-4 mb-20">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center px-8 py-4 text-base font-semibold rounded-2xl bg-gradient-to-r from-blue-500 via-blue-600 to-violet-600 text-white hover:from-blue-600 hover:via-blue-700 hover:to-violet-700 transition-all shadow-2xl shadow-blue-500/25 hover:shadow-blue-500/40 overflow-hidden">
                                <span class="relative z-10 flex items-center">
                                    Start Learning Free
                                    <svg class="ml-2 size-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                            </a>
                        @endif
                        <a href="#how-it-works" class="group inline-flex items-center justify-center px-8 py-4 text-base font-semibold rounded-2xl border-2 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-blue-300 dark:hover:border-blue-700 hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all">
                            <svg class="mr-2 size-5 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z"/>
                            </svg>
                            See How It Works
                        </a>
                    </div>

                    {{-- Hero Visual — Bento Dashboard Preview --}}
                    <div class="anim-scale-in delay-500 relative">
                        <div class="relative rounded-3xl border border-slate-200/80 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl shadow-2xl shadow-blue-500/10 overflow-hidden">
                            {{-- Dashboard Header --}}
                            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/50 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex gap-1.5">
                                        <div class="size-3 rounded-full bg-red-400"></div>
                                        <div class="size-3 rounded-full bg-amber-400"></div>
                                        <div class="size-3 rounded-full bg-green-400"></div>
                                    </div>
                                    <div class="h-4 w-px bg-slate-200 dark:bg-slate-700 mx-2"></div>
                                    <span class="text-xs font-medium text-slate-400 dark:text-slate-500">Placement Test Dashboard</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-400 dark:text-slate-500">
                                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    55 min remaining
                                </div>
                            </div>
                            
                            {{-- Bento Grid Content --}}
                            <div class="p-6 lg:p-8">
                                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                    {{-- Grammar Card --}}
                                    <div class="group relative rounded-2xl border border-blue-200/50 dark:border-blue-800/30 bg-gradient-to-br from-blue-50/80 to-white dark:from-blue-900/20 dark:to-slate-800/50 p-5 text-center hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <div class="relative">
                                            <div class="inline-flex items-center justify-center size-12 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 text-white shadow-lg shadow-blue-500/25 mb-3 group-hover:scale-110 transition-transform duration-300">
                                                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div class="text-base font-bold text-slate-900 dark:text-white">Grammar</div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400 mt-1">15 Questions</div>
                                            <div class="mt-3 h-1.5 w-full rounded-full bg-blue-100 dark:bg-blue-900/30 overflow-hidden">
                                                <div class="h-full rounded-full bg-gradient-to-r from-blue-400 to-blue-600 w-[75%]"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Vocabulary Card --}}
                                    <div class="group relative rounded-2xl border border-emerald-200/50 dark:border-emerald-800/30 bg-gradient-to-br from-emerald-50/80 to-white dark:from-emerald-900/20 dark:to-slate-800/50 p-5 text-center hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <div class="relative">
                                            <div class="inline-flex items-center justify-center size-12 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 text-white shadow-lg shadow-emerald-500/25 mb-3 group-hover:scale-110 transition-transform duration-300">
                                                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.967 8.967 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                                </svg>
                                            </div>
                                            <div class="text-base font-bold text-slate-900 dark:text-white">Vocabulary</div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400 mt-1">15 Questions</div>
                                            <div class="mt-3 h-1.5 w-full rounded-full bg-emerald-100 dark:bg-emerald-900/30 overflow-hidden">
                                                <div class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-emerald-600 w-[60%]"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Reading Card --}}
                                    <div class="group relative rounded-2xl border border-amber-200/50 dark:border-amber-800/30 bg-gradient-to-br from-amber-50/80 to-white dark:from-amber-900/20 dark:to-slate-800/50 p-5 text-center hover:shadow-lg hover:shadow-amber-500/10 transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <div class="relative">
                                            <div class="inline-flex items-center justify-center size-12 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 text-white shadow-lg shadow-amber-500/25 mb-3 group-hover:scale-110 transition-transform duration-300">
                                                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </div>
                                            <div class="text-base font-bold text-slate-900 dark:text-white">Reading</div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400 mt-1">9 Passages</div>
                                            <div class="mt-3 h-1.5 w-full rounded-full bg-amber-100 dark:bg-amber-900/30 overflow-hidden">
                                                <div class="h-full rounded-full bg-gradient-to-r from-amber-400 to-amber-600 w-[40%]"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Writing Card --}}
                                    <div class="group relative rounded-2xl border border-rose-200/50 dark:border-rose-800/30 bg-gradient-to-br from-rose-50/80 to-white dark:from-rose-900/20 dark:to-slate-800/50 p-5 text-center hover:shadow-lg hover:shadow-rose-500/10 transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-rose-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <div class="relative">
                                            <div class="inline-flex items-center justify-center size-12 rounded-xl bg-gradient-to-br from-rose-400 to-rose-600 text-white shadow-lg shadow-rose-500/25 mb-3 group-hover:scale-110 transition-transform duration-300">
                                                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                                </svg>
                                            </div>
                                            <div class="text-base font-bold text-slate-900 dark:text-white">Writing</div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400 mt-1">1 Essay</div>
                                            <div class="mt-3 h-1.5 w-full rounded-full bg-rose-100 dark:bg-rose-900/30 overflow-hidden">
                                                <div class="h-full rounded-full bg-gradient-to-r from-rose-400 to-rose-600 w-[0%]"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Bottom Stats Bar --}}
                                <div class="mt-6 flex items-center justify-center gap-6 text-sm text-slate-400 dark:text-slate-500">
                                    <span class="flex items-center gap-2">
                                        <svg class="size-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        55 minutes total
                                    </span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                    <span class="flex items-center gap-2">
                                        <svg class="size-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                                        </svg>
                                        75 marks
                                    </span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                    <span class="flex items-center gap-2">
                                        <svg class="size-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        One sitting
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Glow Effect Behind --}}
                        <div class="absolute -inset-4 bg-gradient-to-r from-blue-500/10 via-violet-500/10 to-cyan-500/10 rounded-[2rem] blur-2xl -z-10"></div>
                    </div>
                </div>
            </div>

            {{-- Scroll Indicator --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-slate-400 dark:text-slate-500 animate-bounce">
                <span class="text-xs font-medium">Scroll to explore</span>
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </section>

        {{-- === SOCIAL PROOF / TRUST BAR === --}}
        <section class="py-16 border-y border-slate-200/50 dark:border-slate-800/50 bg-slate-50/50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <p class="text-center text-sm font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-10">Trusted by students preparing for</p>
                <div class="flex flex-wrap justify-center items-center gap-12 lg:gap-16">
                    <div class="flex items-center gap-2 text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.312 5.841c.823.231 1.647.483 2.658.813m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
                        </svg>
                        <span class="text-lg font-bold">Oxford</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.967 8.967 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                        <span class="text-lg font-bold">Cambridge</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3v6m0-6H3m18 0v6m0-6h-6m-3.75-11.25l5.25 11.25"/>
                        </svg>
                        <span class="text-lg font-bold">IELTS</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                        </svg>
                        <span class="text-lg font-bold">TOEFL</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-lg font-bold">SAT English</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- === STATS SECTION === --}}
        <section class="py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-900/50"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-blue-500/5 rounded-full blur-3xl"></div>
            
            <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                    <div class="reveal text-center group">
                        <div class="text-5xl lg:text-6xl font-black text-slate-900 dark:text-white tracking-tight mb-2">
                            2,500<span class="text-blue-500">+</span>
                        </div>
                        <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Students Enrolled</div>
                        <div class="mt-3 h-1 w-12 mx-auto rounded-full bg-gradient-to-r from-blue-400 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <div class="reveal text-center group" style="transition-delay: 0.1s;">
                        <div class="text-5xl lg:text-6xl font-black text-slate-900 dark:text-white tracking-tight mb-2">
                            98<span class="text-emerald-500">%</span>
                        </div>
                        <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Satisfaction Rate</div>
                        <div class="mt-3 h-1 w-12 mx-auto rounded-full bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <div class="reveal text-center group" style="transition-delay: 0.2s;">
                        <div class="text-5xl lg:text-6xl font-black text-slate-900 dark:text-white tracking-tight mb-2">
                            5
                        </div>
                        <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Placement Levels</div>
                        <div class="mt-3 h-1 w-12 mx-auto rounded-full bg-gradient-to-r from-amber-400 to-amber-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <div class="reveal text-center group" style="transition-delay: 0.3s;">
                        <div class="text-5xl lg:text-6xl font-black text-slate-900 dark:text-white tracking-tight mb-2">
                            24<span class="text-violet-500">/7</span>
                        </div>
                        <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Learning Access</div>
                        <div class="mt-3 h-1 w-12 mx-auto rounded-full bg-gradient-to-r from-violet-400 to-violet-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- === FEATURES SECTION === --}}
        <section id="features" class="py-24 lg:py-32 relative">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-20">
                    <div class="reveal inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 dark:bg-blue-900/20 border border-blue-200/50 dark:border-blue-800/50 text-sm font-semibold text-blue-600 dark:text-blue-400 mb-6">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                        </svg>
                        Powerful Features
                    </div>
                    <h2 class="reveal text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-6">
                        Everything you need to <span class="text-gradient-2">excel</span>
                    </h2>
                    <p class="reveal text-lg text-slate-500 dark:text-slate-400" style="transition-delay: 0.1s;">
                        Our platform adapts to your learning style, identifies your weak spots, and accelerates your progress.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Feature 1 — Large Card (Smart Placement) --}}
                    <div class="reveal md:col-span-2 lg:col-span-2 group relative rounded-3xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-slate-50 to-white dark:from-slate-800 dark:to-slate-900 p-8 lg:p-10 overflow-hidden card-hover">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-500/10 to-violet-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                        <div class="relative flex flex-col lg:flex-row lg:items-start gap-8">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center size-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-xl shadow-blue-500/25">
                                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">Smart Placement Tests</h3>
                                <p class="text-slate-500 dark:text-slate-400 leading-relaxed mb-6">
                                    Our AI-powered assessment engine pinpoints your exact proficiency level across grammar, vocabulary, reading, and writing — all in under 55 minutes. No more guessing where to start.
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-sm font-medium">
                                        <span class="size-2 rounded-full bg-blue-500"></span>
                                        Grammar
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-sm font-medium">
                                        <span class="size-2 rounded-full bg-emerald-500"></span>
                                        Vocabulary
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-sm font-medium">
                                        <span class="size-2 rounded-full bg-amber-500"></span>
                                        Reading
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 text-sm font-medium">
                                        <span class="size-2 rounded-full bg-rose-500"></span>
                                        Writing
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Feature 2 — Personalized Learning --}}
                    <div class="reveal group relative rounded-3xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-slate-50 to-white dark:from-slate-800 dark:to-slate-900 p-8 overflow-hidden card-hover" style="transition-delay: 0.1s;">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
                        <div class="relative">
                            <div class="inline-flex items-center justify-center size-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 text-white shadow-lg shadow-emerald-500/20 mb-6">
                                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Personalized Learning</h3>
                            <p class="text-slate-500 dark:text-slate-400 leading-relaxed">
                                A tailored curriculum that evolves with you. Focus on your weak areas while reinforcing your strengths with adaptive exercises.
                            </p>
                        </div>
                    </div>

                    {{-- Feature 3 — Progress Tracking --}}
                    <div class="reveal group relative rounded-3xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-slate-50 to-white dark:from-slate-800 dark:to-slate-900 p-8 overflow-hidden card-hover" style="transition-delay: 0.2s;">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
                        <div class="relative">
                            <div class="inline-flex items-center justify-center size-14 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 text-white shadow-lg shadow-blue-500/20 mb-6">
                                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Visual Analytics</h3>
                            <p class="text-slate-500 dark:text-slate-400 leading-relaxed">
                                Track your improvement with detailed charts and clear milestones. See exactly how far you've come.
                            </p>
                        </div>
                    </div>

                    {{-- Feature 4 — Content Library --}}
                    <div class="reveal group relative rounded-3xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-slate-50 to-white dark:from-slate-800 dark:to-slate-900 p-8 overflow-hidden card-hover" style="transition-delay: 0.3s;">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
                        <div class="relative">
                            <div class="inline-flex items-center justify-center size-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-white shadow-lg shadow-amber-500/20 mb-6">
                                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.967 8.967 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Rich Content Library</h3>
                            <p class="text-slate-500 dark:text-slate-400 leading-relaxed">
                                Hundreds of exercises, passages, and writing prompts curated by expert educators. Always fresh, always challenging.
                            </p>
                        </div>
                    </div>

                    {{-- Feature 5 — Expert Tutors (Large Card) --}}
                    <div class="reveal md:col-span-2 lg:col-span-2 group relative rounded-3xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-slate-50 to-white dark:from-slate-800 dark:to-slate-900 p-8 lg:p-10 overflow-hidden card-hover" style="transition-delay: 0.4s;">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-violet-500/10 to-emerald-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                        <div class="relative flex flex-col lg:flex-row lg:items-start gap-8">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center size-16 rounded-2xl bg-gradient-to-br from-violet-500 to-violet-600 text-white shadow-xl shadow-violet-500/25">
                                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">Expert Tutors & Multi-Device</h3>
                                <p class="text-slate-500 dark:text-slate-400 leading-relaxed mb-6">
                                    Connect with certified English tutors who provide personalized feedback on your writing and speaking. Access your courses on any device — your progress syncs seamlessly across phone, tablet, and desktop.
                                </p>
                                <div class="flex items-center gap-4">
                                    <div class="flex -space-x-2">
                                        <div class="size-8 rounded-full bg-blue-500 border-2 border-white dark:border-slate-800 flex items-center justify-center text-white text-xs font-bold">JD</div>
                                        <div class="size-8 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-800 flex items-center justify-center text-white text-xs font-bold">MK</div>
                                        <div class="size-8 rounded-full bg-amber-500 border-2 border-white dark:border-slate-800 flex items-center justify-center text-white text-xs font-bold">SA</div>
                                        <div class="size-8 rounded-full bg-violet-500 border-2 border-white dark:border-slate-800 flex items-center justify-center text-white text-xs font-bold">LP</div>
                                        <div class="size-8 rounded-full bg-slate-200 dark:bg-slate-700 border-2 border-white dark:border-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 text-xs font-bold">+12</div>
                                    </div>
                                    <span class="text-sm text-slate-500 dark:text-slate-400">Expert tutors available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- === HOW IT WORKS === --}}
        <section id="how-it-works" class="py-24 lg:py-32 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-white via-slate-50/50 to-white dark:from-slate-900 dark:via-slate-800/30 dark:to-slate-900"></div>
            <div class="absolute top-1/2 left-0 w-[500px] h-[500px] bg-blue-500/5 rounded-full blur-3xl -translate-y-1/2"></div>
            <div class="absolute top-1/2 right-0 w-[500px] h-[500px] bg-violet-500/5 rounded-full blur-3xl -translate-y-1/2"></div>
            
            <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-20">
                    <div class="reveal inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200/50 dark:border-emerald-800/50 text-sm font-semibold text-emerald-600 dark:text-emerald-400 mb-6">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        </svg>
                        Simple Process
                    </div>
                    <h2 class="reveal text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-6">
                        Three steps to <span class="text-gradient">fluency</span>
                    </h2>
                    <p class="reveal text-lg text-slate-500 dark:text-slate-400" style="transition-delay: 0.1s;">
                        Getting started is simple. Your journey begins in minutes, not days.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                    {{-- Step 1 --}}
                    <div class="reveal relative text-center group">
                        <div class="relative inline-flex items-center justify-center mb-8">
                            <div class="absolute inset-0 bg-blue-500/20 rounded-3xl blur-xl group-hover:bg-blue-500/30 transition-all"></div>
                            <div class="relative inline-flex items-center justify-center size-20 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white text-3xl font-black shadow-2xl shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                                1
                            </div>
                            {{-- Connector --}}
                            <div class="hidden md:block absolute top-1/2 left-[calc(100%+24px)] w-[calc(100%+24px)] h-0.5">
                                <div class="h-full bg-gradient-to-r from-blue-500/50 to-emerald-500/50 rounded-full"></div>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Create Your Account</h3>
                        <p class="text-slate-500 dark:text-slate-400 leading-relaxed">
                            Sign up in seconds with just your email. No credit card required. No complicated forms.
                        </p>
                    </div>

                    {{-- Step 2 --}}
                    <div class="reveal relative text-center group" style="transition-delay: 0.15s;">
                        <div class="relative inline-flex items-center justify-center mb-8">
                            <div class="absolute inset-0 bg-emerald-500/20 rounded-3xl blur-xl group-hover:bg-emerald-500/30 transition-all"></div>
                            <div class="relative inline-flex items-center justify-center size-20 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white text-3xl font-black shadow-2xl shadow-emerald-500/30 group-hover:scale-110 transition-transform duration-300">
                                2
                            </div>
                            <div class="hidden md:block absolute top-1/2 left-[calc(100%+24px)] w-[calc(100%+24px)] h-0.5">
                                <div class="h-full bg-gradient-to-r from-emerald-500/50 to-violet-500/50 rounded-full"></div>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Take the Placement Test</h3>
                        <p class="text-slate-500 dark:text-slate-400 leading-relaxed">
                            Complete our 55-minute assessment covering all four skills. Get your exact level instantly.
                        </p>
                    </div>

                    {{-- Step 3 --}}
                    <div class="reveal relative text-center group" style="transition-delay: 0.3s;">
                        <div class="relative inline-flex items-center justify-center mb-8">
                            <div class="absolute inset-0 bg-violet-500/20 rounded-3xl blur-xl group-hover:bg-violet-500/30 transition-all"></div>
                            <div class="relative inline-flex items-center justify-center size-20 rounded-2xl bg-gradient-to-br from-violet-500 to-violet-600 text-white text-3xl font-black shadow-2xl shadow-violet-500/30 group-hover:scale-110 transition-transform duration-300">
                                3
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Start Your Journey</h3>
                        <p class="text-slate-500 dark:text-slate-400 leading-relaxed">
                            Get your personalized learning path and start improving immediately. Track every milestone.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- === TESTIMONIALS === --}}
        <section id="testimonials" class="py-24 lg:py-32 relative">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-20">
                    <div class="reveal inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-50 dark:bg-amber-900/20 border border-amber-200/50 dark:border-amber-800/50 text-sm font-semibold text-amber-600 dark:text-amber-400 mb-6">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                        </svg>
                        Student Stories
                    </div>
                    <h2 class="reveal text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-6">
                        Loved by <span class="text-gradient-2">learners</span> worldwide
                    </h2>
                    <p class="reveal text-lg text-slate-500 dark:text-slate-400" style="transition-delay: 0.1s;">
                        Hear from students who transformed their English skills with us.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    {{-- Testimonial 1 --}}
                    <div class="reveal group relative rounded-3xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 p-8 overflow-hidden card-hover">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full blur-2xl"></div>
                        <div class="relative">
                            <div class="flex items-center gap-1 mb-6">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="size-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-slate-600 dark:text-slate-300 leading-relaxed mb-8">
                                "The placement test was incredibly accurate. Within weeks of following my personalized plan, I could feel my grammar improving dramatically. I went from intermediate to advanced in just 3 months."
                            </p>
                            <div class="flex items-center gap-4 pt-6 border-t border-slate-200 dark:border-slate-700">
                                <div class="size-12 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-blue-500/20">
                                    SA
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 dark:text-white">Sarah Anderson</div>
                                    <div class="text-sm text-slate-500 dark:text-slate-400">University Student</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Testimonial 2 --}}
                    <div class="reveal group relative rounded-3xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 p-8 overflow-hidden card-hover" style="transition-delay: 0.15s;">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-2xl"></div>
                        <div class="relative">
                            <div class="flex items-center gap-1 mb-6">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="size-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-slate-600 dark:text-slate-300 leading-relaxed mb-8">
                                "I loved how the platform identified exactly where I needed help. The writing feedback was like having a personal tutor available 24/7. My IELTS score improved by a full band."
                            </p>
                            <div class="flex items-center gap-4 pt-6 border-t border-slate-200 dark:border-slate-700">
                                <div class="size-12 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-emerald-500/20">
                                    MK
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 dark:text-white">Michael Kim</div>
                                    <div class="text-sm text-slate-500 dark:text-slate-400">Marketing Professional</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Testimonial 3 --}}
                    <div class="reveal group relative rounded-3xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 p-8 overflow-hidden card-hover" style="transition-delay: 0.3s;">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-violet-500/5 rounded-full blur-2xl"></div>
                        <div class="relative">
                            <div class="flex items-center gap-1 mb-6">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="size-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-slate-600 dark:text-slate-300 leading-relaxed mb-8">
                                "From intermediate to advanced in just 3 months. The progress tracking kept me motivated and the content was always challenging but achievable. Best investment in my education."
                            </p>
                            <div class="flex items-center gap-4 pt-6 border-t border-slate-200 dark:border-slate-700">
                                <div class="size-12 rounded-2xl bg-gradient-to-br from-violet-400 to-violet-600 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-violet-500/20">
                                    LP
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 dark:text-white">Lisa Park</div>
                                    <div class="text-sm text-slate-500 dark:text-slate-400">High School Student</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- === PRICING SECTION === --}}
        <section id="pricing" class="py-24 lg:py-32 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-900/50"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-r from-blue-500/5 to-violet-500/5 rounded-full blur-3xl"></div>
            
            <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-20">
                    <div class="reveal inline-flex items-center gap-2 px-4 py-2 rounded-full bg-violet-50 dark:bg-violet-900/20 border border-violet-200/50 dark:border-violet-800/50 text-sm font-semibold text-violet-600 dark:text-violet-400 mb-6">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pricing
                    </div>
                    <h2 class="reveal text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-6">
                        Start free, <span class="text-gradient">upgrade</span> anytime
                    </h2>
                    <p class="reveal text-lg text-slate-500 dark:text-slate-400" style="transition-delay: 0.1s;">
                        Begin with a free placement test. Unlock your full potential with premium features.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    {{-- Free Plan --}}
                    <div class="reveal group relative rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-8 card-hover">
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Free</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Perfect for getting started</p>
                        </div>
                        <div class="mb-6">
                            <span class="text-4xl font-black text-slate-900 dark:text-white">$0</span>
                            <span class="text-slate-500 dark:text-slate-400">/month</span>
                        </div>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="size-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Placement test
                            </li>
                            <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="size-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Basic level report
                            </li>
                            <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="size-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                5 practice exercises
                            </li>
                            <li class="flex items-center gap-3 text-sm text-slate-400 dark:text-slate-500">
                                <svg class="size-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Tutor feedback
                            </li>
                        </ul>
                        <a href="{{ route('register') }}" class="block w-full text-center px-6 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-semibold hover:border-slate-300 dark:hover:border-slate-500 transition-colors">
                            Get Started
                        </a>
                    </div>

                    {{-- Pro Plan — Featured --}}
                    <div class="reveal group relative rounded-3xl border-2 border-blue-500 dark:border-blue-500 bg-gradient-to-b from-blue-50/50 to-white dark:from-blue-900/20 dark:to-slate-800 p-8 card-hover shadow-xl shadow-blue-500/10" style="transition-delay: 0.1s;">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                            <span class="inline-flex items-center gap-1 px-4 py-1 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-semibold shadow-lg shadow-blue-500/30">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                                </svg>
                                Most Popular
                            </span>
                        </div>
                        <div class="mb-6 pt-2">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Pro</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">For serious learners</p>
                        </div>
                        <div class="mb-6">
                            <span class="text-4xl font-black text-slate-900 dark:text-white">$29</span>
                            <span class="text-slate-500 dark:text-slate-400">/month</span>
                        </div>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="size-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Everything in Free
                            </li>
                            <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="size-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Full learning path
                            </li>
                            <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="size-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Unlimited exercises
                            </li>
                            <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="size-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Tutor feedback (2x/month)
                            </li>
                            <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="size-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Progress analytics
                            </li>
                        </ul>
                        <a href="{{ route('register') }}" class="block w-full text-center px-6 py-3 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold hover:from-blue-600 hover:to-blue-700 transition-all shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40">
                            Start Pro Trial
                        </a>
                    </div>

                    {{-- Premium Plan --}}
                    <div class="reveal group relative rounded-3xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-8 card-hover" style="transition-delay: 0.2s;">
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Premium</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Maximum results</p>
                        </div>
                        <div class="mb-6">
                            <span class="text-4xl font-black text-slate-900 dark:text-white">$79</span>
                            <span class="text-slate-500 dark:text-slate-400">/month</span>
                        </div>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="size-5 text-violet-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Everything in Pro
                            </li>
                            <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="size-5 text-violet-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Weekly 1-on-1 tutoring
                            </li>
                            <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="size-5 text-violet-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Speaking practice
                            </li>
                            <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="size-5 text-violet-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Exam preparation
                            </li>
                            <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                <svg class="size-5 text-violet-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Priority support
                            </li>
                        </ul>
                        <a href="{{ route('register') }}" class="block w-full text-center px-6 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-semibold hover:border-slate-300 dark:hover:border-slate-500 transition-colors">
                            Go Premium
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- === CTA SECTION === --}}
        <section class="py-24 lg:py-32 relative overflow-hidden">
            <div class="absolute inset-0 bg-slate-900"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-blue-900/50 via-slate-900 to-slate-900"></div>
            <div class="absolute inset-0">
                <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-violet-500/20 rounded-full blur-3xl"></div>
            </div>
            
            {{-- Floating particles --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-[20%] left-[15%] size-2 bg-blue-400/30 rounded-full float-1"></div>
                <div class="absolute top-[40%] right-[20%] size-3 bg-violet-400/20 rounded-full float-2"></div>
                <div class="absolute bottom-[30%] left-[25%] size-2 bg-cyan-400/30 rounded-full float-3"></div>
                <div class="absolute top-[60%] right-[30%] size-2 bg-blue-300/20 rounded-full float-1"></div>
            </div>

            <div class="relative max-w-4xl mx-auto px-6 lg:px-8 text-center">
                <div class="reveal">
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight mb-8">
                        Ready to transform
                        <br>
                        <span class="text-gradient">your English?</span>
                    </h2>
                    <p class="text-xl text-white/60 max-w-2xl mx-auto mb-12 leading-relaxed">
                        Join thousands of students who have already taken the first step. Start with a free placement test today — no credit card required.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center px-10 py-5 text-lg font-bold rounded-2xl bg-white text-slate-900 hover:bg-slate-100 transition-all shadow-2xl shadow-white/20 overflow-hidden">
                                <span class="relative z-10 flex items-center">
                                    Get Started Free
                                    <svg class="ml-2 size-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-slate-200/50 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                            </a>
                        @endif
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-10 py-5 text-lg font-semibold rounded-2xl border-2 border-white/20 text-white hover:bg-white/10 transition-all">
                                Sign In
                            </a>
                        @endif
                    </div>
                    <p class="mt-8 text-sm text-white/40">
                        Free placement test · No credit card required · Cancel anytime
                    </p>
                </div>
            </div>
        </section>

        {{-- === FOOTER === --}}
        <footer class="py-12 border-t border-slate-200/50 dark:border-slate-800/50 bg-white dark:bg-slate-900">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center size-8 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600">
                            <svg class="size-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                            </svg>
                        </div>
                        <span class="text-base font-bold text-slate-900 dark:text-white">{{ config('app.name', 'Tutoring') }}</span>
                    </div>
                    <div class="flex items-center gap-8 text-sm text-slate-500 dark:text-slate-400">
                        <a href="#features" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors">Features</a>
                        <a href="#how-it-works" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors">How It Works</a>
                        <a href="#testimonials" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors">Testimonials</a>
                        <a href="#pricing" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors">Pricing</a>
                    </div>
                    <div class="text-sm text-slate-400 dark:text-slate-500">
                        &copy; {{ date('Y') }} {{ config('app.name', 'Tutoring') }}. All rights reserved.
                    </div>
                </div>
            </div>
        </footer>

        {{-- === SCROLL REVEAL SCRIPT === --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
                
                const revealOnScroll = () => {
                    reveals.forEach(element => {
                        const windowHeight = window.innerHeight;
                        const elementTop = element.getBoundingClientRect().top;
                        const elementVisible = 100;
                        
                        if (elementTop < windowHeight - elementVisible) {
                            element.classList.add('visible');
                        }
                    });
                };
                
                window.addEventListener('scroll', revealOnScroll);
                revealOnScroll(); // Trigger on load
            });
        </script>
    </body>
</html>
