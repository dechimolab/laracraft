<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ArtisanCraft Engine') - Laravel Generator</title>

    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <!-- Immediate Theme Initialization to Prevent FOUC -->
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('artisan_theme') || 'dark';
                if (savedTheme === 'light') {
                    document.documentElement.classList.remove('dark');
                } else {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {}
        })();
    </script>

    <!-- Forge Artisan Theme Tokens (CSS Custom Properties) -->
    <style>
        :root {
            /* Light Theme Tokens */
            --surface: 248 250 252;                   /* #f8fafc */
            --surface-dim: 241 245 249;               /* #f1f5f9 */
            --surface-bright: 255 255 255;            /* #ffffff */
            --surface-container-lowest: 255 255 255;  /* #ffffff */
            --surface-container-low: 255 255 255;     /* #ffffff */
            --surface-container: 241 245 249;         /* #f1f5f9 */
            --surface-container-high: 226 232 240;    /* #e2e8f0 */
            --surface-container-highest: 203 213 225; /* #cbd5e1 */
            --on-surface: 15 23 42;                   /* #0f172a */
            --on-surface-variant: 71 85 105;          /* #475569 */
            --inverse-surface: 15 23 42;
            --inverse-on-surface: 248 250 252;
            --outline: 148 163 184;                   /* #94a3b8 */
            --outline-variant: 226 232 240;           /* #e2e8f0 */
            --surface-tint: 225 29 72;
            --primary: 225 29 72;                     /* Crimson #e11d48 */
            --on-primary: 255 255 255;                /* #ffffff */
            --primary-container: 225 29 72;           /* Crimson Action */
            --on-primary-container: 255 255 255;      /* #ffffff */
            --inverse-primary: 255 180 168;
            --secondary: 37 99 235;                   /* Indigo / Blue #2563eb */
            --on-secondary: 255 255 255;              /* #ffffff */
            --secondary-container: 219 234 254;       /* #dbeafe */
            --on-secondary-container: 30 58 138;      /* #1e3a8a */
            --tertiary: 5 150 105;                    /* Emerald #059669 */
            --on-tertiary: 255 255 255;               /* #ffffff */
            --tertiary-container: 209 250 229;        /* #d1fae5 */
            --on-tertiary-container: 6 78 59;         /* #064e3b */
            --error: 220 38 38;                       /* #dc2626 */
            --on-error: 255 255 255;                  /* #ffffff */
            --error-container: 254 226 226;           /* #fee2e2 */
            --on-error-container: 153 27 27;          /* #991b1b */
            --background: 248 250 252;                /* #f8fafc */
            --on-background: 15 23 42;                /* #0f172a */
            --surface-variant: 241 245 249;           /* #f1f5f9 */
            --primary-fixed: 255 228 230;
            --primary-fixed-dim: 254 205 211;
            --on-primary-fixed: 136 19 55;
            --on-primary-fixed-variant: 190 18 60;
            --secondary-fixed: 219 234 254;
            --secondary-fixed-dim: 191 219 254;
            --on-secondary-fixed: 30 58 138;
            --on-secondary-fixed-variant: 29 78 216;
            --tertiary-fixed: 209 250 229;
            --tertiary-fixed-dim: 167 243 208;
            --on-tertiary-fixed: 6 78 59;
            --on-tertiary-fixed-variant: 4 120 87;
        }

        html.dark {
            /* Dark Slate Theme Tokens */
            --surface: 11 19 38;                      /* #0b1326 */
            --surface-dim: 11 19 38;                  /* #0b1326 */
            --surface-bright: 49 57 77;               /* #31394d */
            --surface-container-lowest: 6 14 32;      /* #060e20 */
            --surface-container-low: 19 27 46;        /* #131b2e */
            --surface-container: 23 31 51;            /* #171f33 */
            --surface-container-high: 34 42 61;       /* #222a3d */
            --surface-container-highest: 45 52 73;    /* #2d3449 */
            --on-surface: 218 226 253;                /* #dae2fd */
            --on-surface-variant: 232 188 182;        /* #e8bcb6 */
            --inverse-surface: 218 226 253;           /* #dae2fd */
            --inverse-on-surface: 40 48 68;           /* #283044 */
            --outline: 175 135 129;                   /* #af8781 */
            --outline-variant: 94 63 58;              /* #5e3f3a */
            --surface-tint: 255 180 168;              /* #ffb4a8 */
            --primary: 255 180 168;                   /* #ffb4a8 */
            --on-primary: 105 0 1;                    /* #690001 */
            --primary-container: 255 85 66;           /* #ff5542 */
            --on-primary-container: 92 0 0;           /* #5c0000 */
            --inverse-primary: 192 0 3;               /* #c00003 */
            --secondary: 173 198 255;                 /* #adc6ff */
            --on-secondary: 0 46 106;                 /* #002e6a */
            --secondary-container: 5 102 217;         /* #0566d9 */
            --on-secondary-container: 230 236 255;    /* #e6ecff */
            --tertiary: 78 222 163;                   /* #4edea3 */
            --on-tertiary: 0 56 36;                   /* #003824 */
            --tertiary-container: 0 165 114;          /* #00a572 */
            --on-tertiary-container: 0 49 31;         /* #00311f */
            --error: 255 180 171;                     /* #ffb4ab */
            --on-error: 105 0 5;                      /* #690005 */
            --error-container: 147 0 10;              /* #93000a */
            --on-error-container: 255 218 214;        /* #ffdad6 */
            --background: 11 19 38;                   /* #0b1326 */
            --on-background: 218 226 253;             /* #dae2fd */
            --surface-variant: 45 52 73;              /* #2d3449 */
            --primary-fixed: 255 218 213;             /* #ffdad5 */
            --primary-fixed-dim: 255 180 168;         /* #ffb4a8 */
            --on-primary-fixed: 65 0 0;               /* #410000 */
            --on-primary-fixed-variant: 147 0 1;      /* #930001 */
            --secondary-fixed: 216 226 255;           /* #d8e2ff */
            --secondary-fixed-dim: 173 198 255;       /* #adc6ff */
            --on-secondary-fixed: 0 26 66;            /* #001a42 */
            --on-secondary-fixed-variant: 0 67 149;   /* #004395 */
            --tertiary-fixed: 111 251 190;            /* #6ffbbe */
            --tertiary-fixed-dim: 78 222 163;         /* #4edea3 */
            --on-tertiary-fixed: 0 33 19;             /* #002113 */
            --on-tertiary-fixed-variant: 0 82 54;     /* #005236 */
        }

        body, header, aside {
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.15s ease;
        }
    </style>

    <!-- Tailwind Play CDN configured with Forge Artisan Dynamic Tokens -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface": "rgb(var(--surface) / <alpha-value>)",
                        "surface-dim": "rgb(var(--surface-dim) / <alpha-value>)",
                        "surface-bright": "rgb(var(--surface-bright) / <alpha-value>)",
                        "surface-container-lowest": "rgb(var(--surface-container-lowest) / <alpha-value>)",
                        "surface-container-low": "rgb(var(--surface-container-low) / <alpha-value>)",
                        "surface-container": "rgb(var(--surface-container) / <alpha-value>)",
                        "surface-container-high": "rgb(var(--surface-container-high) / <alpha-value>)",
                        "surface-container-highest": "rgb(var(--surface-container-highest) / <alpha-value>)",
                        "on-surface": "rgb(var(--on-surface) / <alpha-value>)",
                        "on-surface-variant": "rgb(var(--on-surface-variant) / <alpha-value>)",
                        "inverse-surface": "rgb(var(--inverse-surface) / <alpha-value>)",
                        "inverse-on-surface": "rgb(var(--inverse-on-surface) / <alpha-value>)",
                        "outline": "rgb(var(--outline) / <alpha-value>)",
                        "outline-variant": "rgb(var(--outline-variant) / <alpha-value>)",
                        "surface-tint": "rgb(var(--surface-tint) / <alpha-value>)",
                        "primary": "rgb(var(--primary) / <alpha-value>)",
                        "on-primary": "rgb(var(--on-primary) / <alpha-value>)",
                        "primary-container": "rgb(var(--primary-container) / <alpha-value>)",
                        "on-primary-container": "rgb(var(--on-primary-container) / <alpha-value>)",
                        "inverse-primary": "rgb(var(--inverse-primary) / <alpha-value>)",
                        "secondary": "rgb(var(--secondary) / <alpha-value>)",
                        "on-secondary": "rgb(var(--on-secondary) / <alpha-value>)",
                        "secondary-container": "rgb(var(--secondary-container) / <alpha-value>)",
                        "on-secondary-container": "rgb(var(--on-secondary-container) / <alpha-value>)",
                        "tertiary": "rgb(var(--tertiary) / <alpha-value>)",
                        "on-tertiary": "rgb(var(--on-tertiary) / <alpha-value>)",
                        "tertiary-container": "rgb(var(--tertiary-container) / <alpha-value>)",
                        "on-tertiary-container": "rgb(var(--on-tertiary-container) / <alpha-value>)",
                        "error": "rgb(var(--error) / <alpha-value>)",
                        "on-error": "rgb(var(--on-error) / <alpha-value>)",
                        "error-container": "rgb(var(--error-container) / <alpha-value>)",
                        "on-error-container": "rgb(var(--on-error-container) / <alpha-value>)",
                        "background": "rgb(var(--background) / <alpha-value>)",
                        "on-background": "rgb(var(--on-background) / <alpha-value>)",
                        "surface-variant": "rgb(var(--surface-variant) / <alpha-value>)",
                        "primary-fixed": "rgb(var(--primary-fixed) / <alpha-value>)",
                        "primary-fixed-dim": "rgb(var(--primary-fixed-dim) / <alpha-value>)",
                        "on-primary-fixed": "rgb(var(--on-primary-fixed) / <alpha-value>)",
                        "on-primary-fixed-variant": "rgb(var(--on-primary-fixed-variant) / <alpha-value>)",
                        "secondary-fixed": "rgb(var(--secondary-fixed) / <alpha-value>)",
                        "secondary-fixed-dim": "rgb(var(--secondary-fixed-dim) / <alpha-value>)",
                        "on-secondary-fixed": "rgb(var(--on-secondary-fixed) / <alpha-value>)",
                        "on-secondary-fixed-variant": "rgb(var(--on-secondary-fixed-variant) / <alpha-value>)",
                        "tertiary-fixed": "rgb(var(--tertiary-fixed) / <alpha-value>)",
                        "tertiary-fixed-dim": "rgb(var(--tertiary-fixed-dim) / <alpha-value>)",
                        "on-tertiary-fixed": "rgb(var(--on-tertiary-fixed) / <alpha-value>)",
                        "on-tertiary-fixed-variant": "rgb(var(--on-tertiary-fixed-variant) / <alpha-value>)"
                    },
                    borderRadius: {
                        DEFAULT: "0.125rem",
                        lg: "0.25rem",
                        xl: "0.5rem",
                        full: "0.75rem"
                    },
                    spacing: {
                        margin: "1rem",
                        gutter: "1rem",
                        "space-md": "1rem",
                        "space-xs": "0.25rem",
                        "space-sm": "0.5rem",
                        "space-lg": "1.5rem",
                        "margin-lg": "3rem",
                        "space-xl": "2.5rem",
                        "margin-md": "2rem",
                        "gutter-md": "1.5rem",
                        "gutter-lg": "2rem"
                    },
                    fontFamily: {
                        "code-block": ["JetBrains Mono", "monospace"],
                        "body-lg": ["Inter", "sans-serif"],
                        "body-sm": ["Inter", "sans-serif"],
                        "code-inline": ["JetBrains Mono", "monospace"],
                        "headline-md": ["Inter", "sans-serif"],
                        "label-sm": ["JetBrains Mono", "monospace"],
                        "headline-sm": ["Inter", "sans-serif"],
                        "display-hero": ["Inter", "sans-serif"],
                        "headline-lg": ["Inter", "sans-serif"],
                        "label-md": ["JetBrains Mono", "monospace"],
                        "headline-lg-mobile": ["Inter", "sans-serif"],
                        "body-md": ["Inter", "sans-serif"],
                        "display-hero-mobile": ["Inter", "sans-serif"]
                    },
                    fontSize: {
                        "code-block": ["12px", { lineHeight: "20px", letterSpacing: "0em", fontWeight: "400" }],
                        "body-lg": ["16px", { lineHeight: "26px", letterSpacing: "-0.005em", fontWeight: "400" }],
                        "body-sm": ["12px", { lineHeight: "18px", letterSpacing: "0.005em", fontWeight: "400" }],
                        "code-inline": ["13px", { lineHeight: "20px", letterSpacing: "-0.01em", fontWeight: "400" }],
                        "headline-md": ["20px", { lineHeight: "28px", letterSpacing: "-0.015em", fontWeight: "600" }],
                        "label-sm": ["10px", { lineHeight: "14px", letterSpacing: "0.05em", fontWeight: "600" }],
                        "headline-sm": ["16px", { lineHeight: "24px", letterSpacing: "-0.01em", fontWeight: "600" }],
                        "display-hero": ["40px", { lineHeight: "48px", letterSpacing: "-0.025em", fontWeight: "700" }],
                        "headline-lg": ["28px", { lineHeight: "36px", letterSpacing: "-0.02em", fontWeight: "600" }],
                        "label-md": ["12px", { lineHeight: "16px", letterSpacing: "0.02em", fontWeight: "500" }],
                        "headline-lg-mobile": ["22px", { lineHeight: "30px", letterSpacing: "-0.015em", fontWeight: "600" }],
                        "body-md": ["14px", { lineHeight: "22px", letterSpacing: "0em", fontWeight: "400" }],
                        "display-hero-mobile": ["30px", { lineHeight: "38px", letterSpacing: "-0.02em", fontWeight: "700" }]
                    }
                }
            }
        };
    </script>

    <!-- SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/js/app.js'])
    @endif
    <!-- Global ArtisanCraft Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body class="bg-surface font-body-md text-on-surface antialiased selection:bg-primary-container selection:text-on-primary-container">

    @hasSection('layout_content')
        @yield('layout_content')
    @else
        <!-- Standard App Scaffold with Left Sidebar & Top Header -->
        <aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-low z-50 flex flex-col justify-between border-r border-surface-container-high shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
            <div class="flex flex-col">
                <!-- Branding Header -->
                <div class="px-space-md pt-space-lg pb-space-md">
                    <a href="{{ url('/') }}" class="flex items-center gap-space-sm text-decoration-none">
                        <div class="w-9 h-9 rounded-xl bg-primary-container flex items-center justify-center shadow-[0_0_16px_rgba(255,85,66,0.35)]">
                            <span class="material-symbols-outlined text-on-primary-container text-[20px]">deployed_code</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-headline-sm text-headline-sm text-on-surface tracking-tight leading-none">ArtisanCraft</span>
                            <div class="flex items-center gap-space-xs mt-1">
                                <span class="inline-block px-1 py-0.2 rounded bg-surface-container-high text-primary font-label-sm text-label-sm uppercase tracking-wider">PHP 8.4</span>
                                <span class="inline-block px-1 py-0.2 rounded bg-surface-container-high text-secondary font-label-sm text-label-sm uppercase tracking-wider">BS 5.3</span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Pipeline Section Label -->
                <div class="px-space-md pt-space-md pb-space-xs">
                    <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Scaffold Pipeline</span>
                </div>

                <!-- Navigation Links -->
                @php
                    $currentStep = $activeStep ?? request()->segment(2) ?? '1';
                    $stepProgress = (int) session('project.step_completed', 0);
                    $canStep2 = $stepProgress >= 1;
                    $canStep3 = $stepProgress >= 2;
                    $canStep4 = $stepProgress >= 3;
                    $canStep5 = $stepProgress >= 4;
                @endphp
                <nav class="flex flex-col gap-1 px-space-sm">
                    <a href="{{ route('generator.step1') }}"
                       class="group flex items-center justify-between px-space-md py-space-sm rounded-xl transition-colors {{ $currentStep == '1' || $currentStep == 'project-setup' ? 'bg-surface-container-highest text-primary font-semibold shadow-inner' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                        <div class="flex items-center gap-space-sm">
                            <span class="material-symbols-outlined text-[18px] text-outline group-hover:text-primary transition-colors">tune</span>
                            <span class="font-body-md text-body-md">1. Project Setup</span>
                        </div>
                        <span class="font-label-sm text-label-sm text-outline-variant font-code-inline">CONFIG</span>
                    </a>

                    @if ($canStep2)
                        <a href="{{ route('generator.step2') }}"
                           class="group flex items-center justify-between px-space-md py-space-sm rounded-xl transition-colors {{ $currentStep == '2' || $currentStep == 'packages' ? 'bg-surface-container-highest text-primary font-semibold shadow-inner' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-[18px] text-outline group-hover:text-primary transition-colors">inventory_2</span>
                                <span class="font-body-md text-body-md">2. Packages &amp; Libs</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline-variant font-code-inline">COMPOSER</span>
                        </a>
                    @else
                        <div class="flex items-center justify-between px-space-md py-space-sm rounded-xl text-outline/50 cursor-not-allowed select-none opacity-60" title="ต้องทำขั้นตอนที่ 1 ให้เสร็จก่อน">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-[18px] text-outline/40">lock</span>
                                <span class="font-body-md text-body-md">2. Packages &amp; Libs</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline/40 font-code-inline">LOCKED</span>
                        </div>
                    @endif

                    @if ($canStep3)
                        <a href="{{ route('generator.step3') }}"
                           class="group flex items-center justify-between px-space-md py-space-sm rounded-xl transition-colors {{ $currentStep == '3' || $currentStep == 'modules' ? 'bg-surface-container-highest text-primary font-semibold shadow-inner' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-[18px] text-outline group-hover:text-primary transition-colors">dataset</span>
                                <span class="font-body-md text-body-md">3. Modules &amp; Schema</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline-variant font-code-inline">MODELS</span>
                        </a>
                    @else
                        <div class="flex items-center justify-between px-space-md py-space-sm rounded-xl text-outline/50 cursor-not-allowed select-none opacity-60" title="ต้องทำขั้นตอนที่ 2 ให้เสร็จก่อน">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-[18px] text-outline/40">lock</span>
                                <span class="font-body-md text-body-md">3. Modules &amp; Schema</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline/40 font-code-inline">LOCKED</span>
                        </div>
                    @endif

                    @if ($canStep4)
                        <a href="{{ route('generator.step4') }}"
                           class="group flex items-center justify-between px-space-md py-space-sm rounded-xl transition-colors {{ $currentStep == '4' || $currentStep == 'theme' ? 'bg-surface-container-highest text-primary font-semibold shadow-inner' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-[18px] text-outline group-hover:text-primary transition-colors">palette</span>
                                <span class="font-body-md text-body-md">4. UI &amp; Theme</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline-variant font-code-inline">THEMES</span>
                        </a>
                    @else
                        <div class="flex items-center justify-between px-space-md py-space-sm rounded-xl text-outline/50 cursor-not-allowed select-none opacity-60" title="ต้องทำขั้นตอนที่ 3 ให้เสร็จก่อน">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-[18px] text-outline/40">lock</span>
                                <span class="font-body-md text-body-md">4. UI &amp; Theme</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline/40 font-code-inline">LOCKED</span>
                        </div>
                    @endif

                    @if ($canStep5)
                        <a href="{{ route('generator.step5') }}"
                           class="group flex items-center justify-between px-space-md py-space-sm rounded-xl transition-colors {{ $currentStep == '5' || $currentStep == 'build' ? 'bg-surface-container-highest text-primary font-semibold shadow-inner' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-[18px] text-outline group-hover:text-primary transition-colors">terminal</span>
                                <span class="font-body-md text-body-md">5. Build &amp; Export</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline-variant font-code-inline">CLI/ZIP</span>
                        </a>
                    @else
                        <div class="flex items-center justify-between px-space-md py-space-sm rounded-xl text-outline/50 cursor-not-allowed select-none opacity-60" title="ต้องทำขั้นตอนที่ 4 ให้เสร็จก่อน">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-[18px] text-outline/40">lock</span>
                                <span class="font-body-md text-body-md">5. Build &amp; Export</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline/40 font-code-inline">LOCKED</span>
                        </div>
                    @endif

                    <div class="my-space-xs mx-space-sm h-px bg-surface-container-high"></div>
                    <div class="px-space-sm py-space-xs">
                        <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Preferences</span>
                    </div>

                    <a href="{{ route('profile') }}"
                       class="flex items-center justify-between px-space-md py-space-sm rounded-xl transition-colors {{ request()->routeIs('profile') ? 'bg-surface-container-highest text-primary font-semibold shadow-inner' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} font-body-md text-body-md">
                        <div class="flex items-center gap-space-sm">
                            <span class="material-symbols-outlined text-[18px] text-outline">account_circle</span>
                            <span>Account Settings</span>
                        </div>
                        <span class="font-label-sm text-label-sm text-outline-variant font-code-inline">USER</span>
                    </a>

                    @if(Auth::check() && Auth::user()->isAdmin())
                        <div class="my-space-xs mx-space-sm h-px bg-surface-container-high"></div>
                        <div class="px-space-sm py-space-xs">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Administration</span>
                        </div>

                        <a href="{{ route('admin.setting') }}"
                           class="flex items-center justify-between px-space-md py-space-sm rounded-xl transition-colors {{ request()->routeIs('admin.setting*') ? 'bg-surface-container-highest text-primary font-semibold shadow-inner' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} font-body-md text-body-md">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-[18px] text-tertiary">settings_suggest</span>
                                <span>System Settings</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline-variant font-code-inline">ADMIN</span>
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                           class="flex items-center justify-between px-space-md py-space-sm rounded-xl transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-surface-container-highest text-primary font-semibold shadow-inner' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} font-body-md text-body-md">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-[18px] text-secondary">manage_accounts</span>
                                <span>User Management</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline-variant font-code-inline">ADMIN</span>
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center justify-between px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-error-container/20 hover:text-error transition-colors font-body-md text-body-md text-left cursor-pointer">
                            <div class="flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                                <span>ออกจากระบบ</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline-variant font-code-inline">LOGOUT</span>
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Target Matrix Card -->
            <div class="p-space-md m-space-sm rounded-xl bg-surface-container-lowest/80">
                <div class="flex items-center justify-between pb-space-xs">
                    <div class="flex items-center gap-space-xs">
                        <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-code-block tracking-wider">Target Matrix</span>
                    </div>
                    <span class="font-label-sm text-label-sm text-tertiary font-code-inline">STABLE</span>
                </div>
                <div class="flex flex-col gap-0.5 pt-space-xs font-code-block text-code-block text-on-surface-variant">
                    <div class="flex justify-between"><span class="text-outline">Engine</span><span class="text-on-surface">PHP 8.4.x</span></div>
                    <div class="flex justify-between"><span class="text-outline">Core</span><span class="text-on-surface">Laravel 13.x</span></div>
                    <div class="flex justify-between"><span class="text-outline">Database</span><span class="text-on-surface">MySQL 8.4</span></div>
                    <div class="flex justify-between"><span class="text-outline">Toolkit</span><span class="text-on-surface">Bootstrap 5.3.3</span></div>
                </div>
            </div>
        </aside>

        <!-- Right Content Body -->
        <div class="pl-72">
            <!-- Top App Bar -->
            <header class="fixed top-0 left-72 right-0 h-16 bg-surface/85 backdrop-blur-xl z-40 shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
                <div class="h-16 w-full px-space-lg flex items-center justify-between">
                    <div class="flex items-center gap-space-md">
                        <!-- 1. Project Switcher Dropdown -->
                        <div class="relative" id="project-dropdown-wrapper">
                            <button id="project-dropdown-btn" onclick="toggleProjectDropdown()" type="button" class="flex items-center gap-space-xs px-space-sm py-1 rounded bg-surface-container-high hover:bg-surface-bright transition-colors cursor-pointer text-left">
                                <span class="material-symbols-outlined text-secondary text-[18px]">folder_zip</span>
                                <span class="font-headline-sm text-headline-sm text-on-surface tracking-tight max-w-[200px] truncate">{{ session('project.name', 'Artisan Pos System') }}</span>
                                <span class="px-1.5 py-0.5 rounded bg-surface-container text-tertiary font-label-sm text-label-sm font-code-inline">v1.0.0-dev</span>
                                <span class="material-symbols-outlined text-outline text-[16px] transition-transform" id="project-dropdown-arrow">unfold_more</span>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="project-dropdown-menu" class="hidden absolute left-0 mt-2 w-72 rounded-xl bg-surface-container-low border border-surface-container-high shadow-2xl p-2 z-50 flex flex-col gap-1">
                                <div class="px-3 py-1.5 flex items-center justify-between border-b border-surface-container-high/60">
                                    <span class="font-label-sm text-label-sm text-outline uppercase font-code-inline">PROJECT WORKSPACE</span>
                                    <span class="px-1.5 py-0.2 rounded bg-tertiary/15 text-tertiary font-label-sm text-label-sm font-code-inline">DRAFT ACTIVE</span>
                                </div>
                                <div class="p-2 rounded-lg bg-surface-container flex items-center justify-between mt-1">
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-body-sm text-body-sm font-semibold text-on-surface truncate">{{ session('project.name', 'Artisan Pos System') }}</span>
                                        <span class="font-code-block text-code-block text-outline text-[11px] truncate">slug: {{ session('project.slug', 'artisan-pos-system') }}</span>
                                    </div>
                                    <span class="material-symbols-outlined text-tertiary text-[18px]">check_circle</span>
                                </div>
                                <a href="{{ route('generator.new') }}" class="p-2 rounded-lg hover:bg-surface-container text-primary font-body-sm text-body-sm flex items-center gap-2 transition-colors text-decoration-none mt-1">
                                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                                    <span>สร้างโปรเจกต์ใหม่ (+ New Project)</span>
                                </a>
                            </div>
                        </div>

                        <!-- 2. Quick Command Palette Trigger (Ctrl+K) -->
                        <button type="button" onclick="openCommandPalette()" class="hidden xl:flex items-center gap-space-xs px-space-sm py-1 rounded bg-surface-container-low hover:bg-surface-container text-outline hover:text-on-surface font-label-sm text-label-sm transition-colors cursor-pointer border border-transparent hover:border-surface-container-high">
                            <span class="material-symbols-outlined text-[14px]">keyboard_command_key</span>
                            <span>Quick Palette</span>
                            <kbd class="px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface font-code-inline text-[11px]">Ctrl+K</kbd>
                        </button>
                    </div>

                    <div class="flex items-center gap-space-md">
                        <!-- 3. Docs Modal Trigger -->
                        <button type="button" onclick="openDocsModal()" class="text-on-surface-variant hover:text-on-surface transition-colors font-body-sm text-body-sm flex items-center gap-1 cursor-pointer bg-transparent border-0 p-0">
                            <span class="material-symbols-outlined text-[16px]">menu_book</span>
                            <span>Docs</span>
                        </button>

                        <!-- 4. Theme Mode Dark / Light Toggle -->
                        <button id="theme-toggle-btn" onclick="toggleThemeMode()" aria-label="Theme Mode" class="p-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface transition-colors cursor-pointer" type="button" title="สลับโหมดสี Dark / Light">
                            <span class="material-symbols-outlined text-[18px]" id="theme-toggle-icon">dark_mode</span>
                        </button>
                        <a href="{{ route('profile') }}" aria-label="User Profile" class="w-8 h-8 rounded-full bg-primary flex items-center justify-center hover:opacity-90 transition-opacity ring-2 ring-primary-container/40">
                            <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0 inline-flex">
                            @csrf
                            <button type="submit" title="ออกจากระบบ (Logout)" aria-label="ออกจากระบบ" class="p-1.5 rounded-lg bg-surface-container hover:bg-error-container/20 hover:text-error text-on-surface-variant transition-colors flex items-center justify-center cursor-pointer">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="w-full pt-16 bg-surface min-h-screen">
                @if (session('step_warning'))
                    <div class="max-w-7xl mx-auto px-space-md pt-4">
                        <div class="p-3.5 rounded-xl bg-amber-500/15 border border-amber-500/30 text-amber-300 flex items-center justify-between gap-3 shadow-lg">
                            <div class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-[20px] text-amber-400">warning</span>
                                <span class="font-body-sm text-body-sm font-medium">{{ session('step_warning') }}</span>
                            </div>
                            <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-amber-400/80 hover:text-amber-300 cursor-pointer">
                                <span class="material-symbols-outlined text-[18px]">close</span>
                            </button>
                        </div>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    @endif

    <!-- ========================================================= -->
    <!-- 1. Quick Command Palette Modal (Ctrl+K) -->
    <!-- ========================================================= -->
    <div id="palette-modal" class="fixed inset-0 z-50 hidden flex items-start justify-center pt-24 px-4 bg-black/60 backdrop-blur-sm" onclick="closePaletteOnBackdrop(event)">
        <div class="w-full max-w-2xl rounded-2xl bg-surface-container-low border border-surface-container-high shadow-2xl overflow-hidden flex flex-col" onclick="event.stopPropagation()">
            <!-- Palette Search Header -->
            <div class="p-3 bg-surface-container flex items-center gap-3 border-b border-surface-container-high">
                <span class="material-symbols-outlined text-primary text-[22px]">search</span>
                <input id="palette-input" type="text" placeholder="พิมพ์ค้นหาคำสั่ง หน้าจอ หรือแพ็กเกจ (เช่น Step 1, Profile, Docker, Breeze)..."
                       class="w-full bg-transparent border-0 outline-none text-on-surface placeholder:text-outline font-body-md text-body-md"
                       oninput="filterPaletteResults(this.value)">
                <kbd class="px-2 py-0.5 rounded bg-surface-container-highest text-outline font-code-inline text-[12px] border border-surface-container-high">ESC</kbd>
            </div>

            <!-- Palette Results List -->
            <div id="palette-results" class="max-h-96 overflow-y-auto p-2 flex flex-col gap-1 font-body-sm text-body-sm">
                <div class="px-3 py-1.5 text-outline uppercase font-code-inline text-[11px] tracking-wider">Scaffold Pipeline Stages</div>
                <a href="{{ route('generator.step1') }}" class="palette-item flex items-center justify-between p-2.5 rounded-lg hover:bg-surface-container transition-colors text-on-surface text-decoration-none group">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-primary text-[20px]">tune</span>
                        <div class="flex flex-col">
                            <span class="font-semibold text-on-surface">1. Project Setup &amp; Environment</span>
                            <span class="text-outline text-[12px]">ตั้งค่า PHP 8.4, Database, .env และ Docker Run</span>
                        </div>
                    </div>
                    <span class="text-outline font-code-inline text-[11px] group-hover:text-primary">/generator/step1</span>
                </a>
                <a href="{{ route('generator.step2') }}" class="palette-item flex items-center justify-between p-2.5 rounded-lg hover:bg-surface-container transition-colors text-on-surface text-decoration-none group">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-secondary text-[20px]">widgets</span>
                        <div class="flex flex-col">
                            <span class="font-semibold text-on-surface">2. Packages &amp; Dependencies</span>
                            <span class="text-outline text-[12px]">เลือก Breeze, Debugbar, Pest, Pint, Livewire</span>
                        </div>
                    </div>
                    <span class="text-outline font-code-inline text-[11px] group-hover:text-secondary">/generator/step2</span>
                </a>
                <a href="{{ route('generator.step3') }}" class="palette-item flex items-center justify-between p-2.5 rounded-lg hover:bg-surface-container transition-colors text-on-surface text-decoration-none group">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-tertiary text-[20px]">view_in_ar</span>
                        <div class="flex flex-col">
                            <span class="font-semibold text-on-surface">3. Modules &amp; Visual Schema</span>
                            <span class="text-outline text-[12px]">ออกแบบ Models, Migrations, CRUD Schema</span>
                        </div>
                    </div>
                    <span class="text-outline font-code-inline text-[11px] group-hover:text-tertiary">/generator/step3</span>
                </a>
                <a href="{{ route('generator.step4') }}" class="palette-item flex items-center justify-between p-2.5 rounded-lg hover:bg-surface-container transition-colors text-on-surface text-decoration-none group">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-secondary text-[20px]">palette</span>
                        <div class="flex flex-col">
                            <span class="font-semibold text-on-surface">4. UI Design System &amp; Theme Studio</span>
                            <span class="text-outline text-[12px]">เลือกธีมสี Light / Dark 20 รูปแบบ พร้อม Live Preview</span>
                        </div>
                    </div>
                    <span class="text-outline font-code-inline text-[11px] group-hover:text-secondary">/generator/step4</span>
                </a>
                <a href="{{ route('generator.step5') }}" class="palette-item flex items-center justify-between p-2.5 rounded-lg hover:bg-surface-container transition-colors text-on-surface text-decoration-none group">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-primary text-[20px]">terminal</span>
                        <div class="flex flex-col">
                            <span class="font-semibold text-on-surface">5. Live Preview &amp; Export</span>
                            <span class="text-outline text-[12px]">พรีวิวโค้ด Blade, ตรวจสอบ Virtual Tree, ดาวน์โหลด .ZIP</span>
                        </div>
                    </div>
                    <span class="text-outline font-code-inline text-[11px] group-hover:text-primary">/generator/step5</span>
                </a>

                <div class="px-3 pt-2 pb-1 text-outline uppercase font-code-inline text-[11px] tracking-wider border-t border-surface-container-high/60 mt-1">Account &amp; Security</div>
                <a href="{{ route('profile') }}" class="palette-item flex items-center justify-between p-2.5 rounded-lg hover:bg-surface-container transition-colors text-on-surface text-decoration-none group">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-tertiary text-[20px]">manage_accounts</span>
                        <div class="flex flex-col">
                            <span class="font-semibold text-on-surface">ข้อมูลส่วนตัวและโปรไฟล์</span>
                            <span class="text-outline text-[12px]">ชื่อ-นามสกุล, Git Signature, ไทม์โซน, Scaffolding Defaults</span>
                        </div>
                    </div>
                    <span class="text-outline font-code-inline text-[11px]">/profile</span>
                </a>
                <a href="{{ route('profile') }}#security" onclick="closeCommandPalette(); setTimeout(() => switchProfileTab('security'), 100);" class="palette-item flex items-center justify-between p-2.5 rounded-lg hover:bg-surface-container transition-colors text-on-surface text-decoration-none group">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-secondary text-[20px]">key</span>
                        <div class="flex flex-col">
                            <span class="font-semibold text-on-surface">รหัสผ่านและความปลอดภัย (Passkey)</span>
                            <span class="text-outline text-[12px]">สแกนลายนิ้วมือ WebAuthn, ประวัติ log_login, รหัสผ่าน AD</span>
                        </div>
                    </div>
                    <span class="text-outline font-code-inline text-[11px]">/profile#security</span>
                </a>
            </div>

            <!-- Palette Footer -->
            <div class="p-2.5 bg-surface-container flex items-center justify-between text-outline font-label-sm text-label-sm border-t border-surface-container-high">
                <span class="flex items-center gap-1">กด <kbd class="px-1 py-0.2 rounded bg-surface-container-highest text-on-surface font-code-inline">Enter</kbd> เพื่อเลือก หรือคลิกรายการ</span>
                <span class="font-code-inline text-[11px]">ArtisanCraft Spotlight</span>
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- 2. Documentation Modal (Docs) -->
    <!-- ========================================================= -->
    <div id="docs-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" onclick="closeDocsModal(event)">
        <div class="w-full max-w-3xl rounded-2xl bg-surface-container-low border border-surface-container-high shadow-2xl overflow-hidden flex flex-col max-h-[85vh]" onclick="event.stopPropagation()">
            <!-- Docs Header -->
            <div class="p-4 bg-surface-container flex items-center justify-between border-b border-surface-container-high">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-primary-container flex items-center justify-center text-on-primary-container">
                        <span class="material-symbols-outlined text-[18px]">menu_book</span>
                    </div>
                    <div>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface font-semibold">ArtisanCraft Engine • คู่มือระบบ</h2>
                        <span class="font-label-sm text-label-sm text-outline font-code-inline">Laravel 13.x • PHP 8.4 LTS Specification</span>
                    </div>
                </div>
                <button type="button" onclick="closeDocsModal()" class="p-1 rounded-lg hover:bg-surface-container-highest text-outline hover:text-on-surface transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <!-- Docs Body Content -->
            <div class="p-6 overflow-y-auto flex flex-col gap-5 font-body-sm text-body-sm leading-relaxed text-on-surface-variant">
                <div class="p-3 rounded-xl bg-surface-container flex flex-col gap-1 border-l-4 border-primary">
                    <span class="font-body-md text-body-md font-semibold text-on-surface">เป้าหมายระบบ (System Purpose)</span>
                    <p class="m-0 text-on-surface-variant">
                        ArtisanCraft คือระบบ Web-based Scaffolding &amp; Project Generator สำหรับสร้างโครงสร้างระบบ Laravel 13.x พร้อมเชื่อมต่อ Active Directory (LDAP), Bootstrap 5.3 และสภาพแวดล้อม Docker แบบสำเร็จรูป
                    </p>
                </div>

                <div class="flex flex-col gap-2">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold flex items-center gap-1.5 text-primary">
                        <span class="material-symbols-outlined text-[20px]">flowsheet</span>
                        ขั้นตอนการสร้างโปรเจกต์ 5 ขั้นตอน (Scaffold Pipeline)
                    </h3>
                    <ul class="list-none p-0 m-0 flex flex-col gap-2">
                        <li class="p-2.5 rounded-lg bg-surface-container">
                            <span class="font-semibold text-on-surface">Step 1: Project Core &amp; Environment</span> — ตั้งชื่อโปรเจกต์, เชื่อมต่อฐานข้อมูล (MySQL 8.4, PostgreSQL, SQLite, OCI8, Custom), กำหนดค่า .env สด, เลือกคู่เวอร์ชัน Laravel 13.x/PHP 8.4 และคอนฟิก Docker Run Hub (พอร์ต HTTPS 443 / SSH 22)
                        </li>
                        <li class="p-2.5 rounded-lg bg-surface-container">
                            <span class="font-semibold text-on-surface">Step 2: Packages &amp; Dependencies Marketplace</span> — เลือกสรรแพ็กเกจ PHP Composer &amp; NPM (DataTables, SweetAlert2, Blade Icons, AutoNumeric, Debugbar, Pest, Larastan ฯลฯ) พร้อม Tabbed Code Inspector สลับพรีวิว composer.json และ package.json สด
                        </li>
                        <li class="p-2.5 rounded-lg bg-surface-container">
                            <span class="font-semibold text-on-surface">Step 3: Pre-built Enterprise Modules</span> — สวิตช์เปิด/ปิดโมดูลระบบองค์กร (BUU LDAP &amp; Active Directory พร้อม Passkey WebAuthn, Audit Trail 5 Mandatory Stamps, ศูนย์แจ้งเตือน Notifications Engine) พร้อม Core Roles (Superadmin/Admin/User) &amp; RBAC ประจำระบบ
                        </li>
                        <li class="p-2.5 rounded-lg bg-surface-container">
                            <span class="font-semibold text-on-surface">Step 4: UI Design System &amp; Theme Studio</span> — คัดสรร 20 ธีมระดับองค์กร (10 Light Themes, 10 Dark Themes) ตามมาตรฐาน WCAG 2.1 AA/AAA พร้อมค้นหาเรียลไทม์ และ Live Sandbox Preview Stage
                        </li>
                        <li class="p-2.5 rounded-lg bg-surface-container">
                            <span class="font-semibold text-on-surface">Step 5: Code Preview &amp; ZIP Export Pipeline</span> — สำรวจ Workspace Dynamic File Tree (50+ ไฟล์), Live Blade UI Emulation, ตรวจสอบไวยากรณ์ Dry-Run, Export โครงสร้าง Laravel ตัวเต็มเป็นไฟล์ .ZIP Production Ready และ Quickstart Commands
                        </li>
                    </ul>
                </div>

                <!-- Post-Export Step-by-Step Execution Guide -->
                <div class="flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold flex items-center gap-1.5 text-secondary">
                            <span class="material-symbols-outlined text-[20px]">terminal</span>
                            ขั้นตอนและคำสั่งเริ่มต้นใช้งานหลัง Export .ZIP (Post-Export 1 2 3...)
                        </h3>
                        <span class="px-2 py-0.5 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[11px] font-bold">BUCC Docker Standard</span>
                    </div>

                    <div class="flex flex-col gap-2.5">
                        <!-- Step 1 -->
                        <div class="p-3 rounded-xl bg-surface-container flex flex-col gap-1.5 border border-surface-container-high">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs">1</span>
                                <span class="font-semibold text-on-surface">แตกไฟล์ ZIP และเข้าไปยังโฟลเดอร์โปรเจกต์</span>
                            </div>
                            <pre class="m-0 p-2.5 rounded-lg bg-surface-container-highest text-slate-200 font-mono text-[12px] overflow-x-auto"><code>unzip {{ session('project.slug', '{project-slug}') }}.zip -d {{ session('project.slug', '{project-slug}') }}
cd {{ session('project.slug', '{project-slug}') }}</code></pre>
                        </div>

                        <!-- Step 2 -->
                        <div class="p-3 rounded-xl bg-surface-container flex flex-col gap-1.5 border border-surface-container-high">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs">2</span>
                                <span class="font-semibold text-on-surface">สตาร์ตคอนเทนเนอร์ Docker (เลือกได้ 2 โหมดตามสไตล์การทำงาน)</span>
                            </div>
                            <p class="m-0 text-outline text-xs">สคริปต์จะตั้งค่าคอนเทนเนอร์, คอนฟิก Apache SSL Redirect, ตั้งสิทธิ์ Storage (775/www-data) และรัน composer install ให้อัตโนมัติ:</p>
                            
                            <!-- Mode 1: Volume -->
                            <div class="mt-1 p-2.5 rounded-lg bg-surface-container-low border border-surface-container-high/80 flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-primary text-xs flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px]">database</span> โหมด 1: Docker Named Volume (+ SSH/SFTP พอร์ต {{ session('project.docker_ssh_port', 22) }})
                                    </span>
                                    <span class="text-[10px] px-1.5 py-0.2 rounded bg-primary/10 text-primary font-mono">RECOMMENDED</span>
                                </div>
                                <p class="m-0 text-outline text-[11px]">เหมาะสำหรับ Dev ที่เชื่อมต่อ Remote ผ่าน SSH/SFTP บน Volume ประสิทธิภาพสูง:</p>
                                <pre class="m-0 p-2 rounded bg-surface-container-highest text-slate-200 font-mono text-[11px] overflow-x-auto"><code># Windows: .\docker-run-volume.bat
# Linux / macOS: bash docker-run-volume.sh</code></pre>
                            </div>

                            <!-- Mode 2: Bind Mount -->
                            <div class="p-2.5 rounded-lg bg-surface-container-low border border-surface-container-high/80 flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-emerald-400 text-xs flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px]">folder_copy</span> โหมด 2: Docker Bind Mount (แก้ไขโค้ดสดบนโฟลเดอร์เครื่อง Host)
                                    </span>
                                    <span class="text-[10px] px-1.5 py-0.2 rounded bg-emerald-500/10 text-emerald-400 font-mono">LOCAL-FIRST</span>
                                </div>
                                <p class="m-0 text-outline text-[11px]">เหมาะสำหรับแก้ไขโค้ดผ่าน VS Code บนเครื่อง Host ได้ทันที ไม่ต้องพึ่งพา SSH Server:</p>
                                <pre class="m-0 p-2 rounded bg-surface-container-highest text-slate-200 font-mono text-[11px] overflow-x-auto"><code># Windows: .\docker-run-bind.bat
# Linux / macOS: bash docker-run-bind.sh</code></pre>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="p-3 rounded-xl bg-surface-container flex flex-col gap-1.5 border border-surface-container-high">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs">3</span>
                                <span class="font-semibold text-on-surface">สร้าง Application Key และรัน Database Migration พร้อม Seed ข้อมูล</span>
                            </div>
                            <pre class="m-0 p-2.5 rounded-lg bg-surface-container-highest text-slate-200 font-mono text-[12px] overflow-x-auto"><code># สร้าง Application Key และรัน Migration
docker exec {{ session('project.slug', '{project-slug}') }}-web php artisan key:generate
docker exec {{ session('project.slug', '{project-slug}') }}-web php artisan migrate --seed

# กรณีต้องการล้างตารางทั้งหมดและเริ่มต้นใหม่ (Fresh Reset & Re-seed):
docker exec {{ session('project.slug', '{project-slug}') }}-web php artisan migrate:fresh --seed</code></pre>
                        </div>

                        <!-- Step 4 -->
                        <div class="p-3 rounded-xl bg-surface-container flex flex-col gap-1.5 border border-surface-container-high">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs">4</span>
                                <span class="font-semibold text-on-surface">ตรวจสอบสิทธิ์ Storage &amp; Cache (หากมีการสร้างไฟล์ใหม่)</span>
                            </div>
                            <pre class="m-0 p-2.5 rounded-lg bg-surface-container-highest text-slate-200 font-mono text-[12px] overflow-x-auto"><code>docker exec {{ session('project.slug', '{project-slug}') }}-web chown -R www-data:www-data storage bootstrap/cache</code></pre>
                        </div>

                        <!-- Step 5 -->
                        <div class="p-3 rounded-xl bg-surface-container flex flex-col gap-1.5 border border-surface-container-high">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full bg-tertiary-container text-on-tertiary-container flex items-center justify-center font-bold text-xs">5</span>
                                <span class="font-semibold text-on-surface">เปิดเว็บเบราว์เซอร์เข้าใช้งานระบบ</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                <span class="text-on-surface">URL เว็บไซต์:</span>
                                <code class="text-tertiary font-mono">https://localhost:{{ session('project.docker_https_port', 443) }}</code>
                            </div>
                            <div class="p-2.5 rounded-lg bg-surface-container-highest text-xs text-on-surface-variant flex flex-col gap-1 mt-1 border border-surface-container-high">
                                <span class="font-semibold text-white flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">key</span> ข้อมูลการเข้าสู่ระบบเริ่มต้น:
                                </span>
                                <div>• ผู้ดูแลระบบเครื่องทดสอบ (Local Dev): <code class="text-primary font-mono font-semibold">admin</code> / รหัสผ่าน: <code class="text-primary font-mono font-semibold">password</code></div>
                                <div>• บุคลากรและนิสิต ม.บูรพา: เข้าสู่ระบบด้วย <code class="text-tertiary font-mono font-semibold">BUU Account</code> ผ่านระบบ Active Directory (LDAP)</div>
                                <div>• รหัสผ่าน SSH/SFTP (เฉพาะโหมด Volume): User <code class="text-secondary font-mono font-semibold">root</code> / Password <code class="text-secondary font-mono font-semibold">dockerpwd</code></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Docs Footer -->
            <div class="p-3 bg-surface-container flex items-center justify-between border-t border-surface-container-high">
                <span class="font-label-sm text-label-sm text-outline font-code-inline">Built with Forge Artisan Engine</span>
                <button type="button" onclick="closeDocsModal()" class="px-space-md py-1.5 rounded-lg bg-surface-container-highest hover:bg-surface-bright text-on-surface font-body-sm text-body-sm transition-colors cursor-pointer">
                    ปิดหน้าต่าง
                </button>
            </div>
        </div>
    </div>

    <!-- Global ArtisanCraft Javascript Utilities -->
    <script src="{{ asset('js/function.js') }}"></script>
    @stack('scripts')
</body>
</html>
