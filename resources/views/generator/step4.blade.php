@extends('layouts.artisan')

@section('content')
<div class="flex flex-col w-full pb-space-xl">
    <!-- Header Banner & Pipeline Strip -->
    <div class="relative overflow-hidden bg-surface-container-low px-6 md:px-8 lg:px-10 py-5 border-b border-surface-container-high shadow-sm">
        <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-primary-container/10 blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/3 -bottom-20 w-80 h-80 rounded-full bg-secondary-container/15 blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col gap-4 max-w-7xl mx-auto">
            <!-- Row 1: Unified Step Header & Nav Buttons -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md">
                <div class="flex items-start gap-space-sm">
                    <div class="w-11 h-11 rounded-xl bg-surface-container-high border border-surface-container-highest flex items-center justify-center font-code-inline text-headline-sm font-bold text-primary shadow-sm shrink-0">04</div>
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-space-xs flex-wrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-surface-container-highest text-primary font-label-sm text-label-sm font-semibold uppercase tracking-wider">
                                <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                                Pipeline Step 04 / 05
                            </span>
                            <span class="text-outline font-code-inline text-label-sm">|</span>
                            <span class="text-secondary font-code-inline text-label-sm">UI Design System &amp; Theme Studio</span>
                        </div>
                        <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold tracking-tight">Theme Presets Gallery &amp; Color System</h1>
                        <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">
                            เลือกสไตล์สีและโหมดการแสดงผลของระบบ สลับพรีวิวดูตัวอย่างหน้าจอจริงแบบสด พร้อมส่งออกชุด CSS Custom Properties สู่โปรเจกต์อัตโนมัติ
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('generator.step3') }}" class="px-space-md py-2 rounded-lg bg-surface-container text-on-surface hover:bg-surface-container-high font-body-sm text-body-sm transition-all border border-surface-container-highest text-decoration-none flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                        <span>ย้อนกลับ Step 3</span>
                    </a>
                    <button type="button" onclick="submitThemeForm()" class="px-space-lg py-2 rounded-lg bg-primary hover:bg-inverse-primary text-on-primary font-body-sm text-body-sm font-semibold transition-all shadow-md flex items-center gap-1.5 cursor-pointer">
                        <span>ถัดไป Step 5: Build &amp; Export</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </div>
            </div>

            <!-- Row 2: Project Summary Strip -->
            <div class="flex flex-wrap items-center justify-between gap-space-sm pt-2 border-t border-surface-container-high/40 text-label-sm font-code-inline">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="px-2.5 py-1 rounded-md bg-surface-container text-on-surface font-semibold border border-surface-container-highest">{{ session('project.slug', 'artisan-pos-system') }}</span>
                    <span class="px-2 py-0.5 rounded bg-surface-container text-primary">PHP {{ session('project.php_version', config('generator.default_php', '8.4')) }}</span>
                    <span class="px-2 py-0.5 rounded bg-surface-container text-secondary">Laravel {{ session('project.laravel_version', config('generator.default_laravel', '13.x')) }}</span>
                    <span class="px-2 py-0.5 rounded bg-surface-container text-tertiary">{{ strtoupper(session('project.db_connection', 'mysql')) }}</span>
                    <span class="px-2 py-0.5 rounded bg-surface-container text-on-surface-variant">BS 5.3.3</span>
                </div>
                <div class="flex items-center gap-1 px-2.5 py-1 rounded bg-surface-container text-tertiary font-label-sm text-label-sm border border-tertiary/20">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    <span>20 Curated Themes • AA/AAA WCAG 2.1</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="px-6 md:px-8 lg:px-10 py-space-lg flex flex-col gap-space-lg max-w-7xl mx-auto w-full">

        <!-- FORM WRAPPER FOR SUBMISSION -->
        <form id="theme-selection-form" method="POST" action="{{ route('generator.step4.save') }}">
            @csrf
            <input type="hidden" name="theme_key" id="selected-theme-key" value="{{ $selectedThemeKey }}">
            <input type="hidden" name="theme_mode" id="selected-theme-mode" value="{{ $selectedMode }}">

            <!-- SECTION: INTERACTIVE LIVE SANDBOX PREVIEW -->
            <div class="bg-surface-container-low rounded-2xl p-space-lg border border-surface-container-high shadow-lg flex flex-col gap-space-md">
                <div class="flex flex-wrap items-center justify-between gap-space-md border-b border-surface-container-highest pb-space-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-primary/15 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined text-[22px]">preview</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold" id="sandbox-theme-name">{{ $activeTheme['name'] }}</h3>
                                <span class="px-2 py-0.5 rounded font-label-sm text-label-sm font-bold uppercase" id="sandbox-mode-badge" style="background-color: {{ $selectedMode === 'dark' ? '#1E293B' : '#E2E8F0' }}; color: {{ $selectedMode === 'dark' ? '#38BDF8' : '#0F172A' }};">
                                    {{ strtoupper($selectedMode) }} MODE
                                </span>
                                <span class="px-2 py-0.5 rounded font-label-sm text-label-sm font-bold bg-emerald-500/15 text-emerald-400 border border-emerald-500/30" id="sandbox-wcag-badge">
                                    {{ $activeTheme['wcag'] }}
                                </span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant max-w-2xl" id="sandbox-theme-desc">{{ $activeTheme['desc'] }}</p>
                        </div>
                    </div>

                    <!-- Sandbox Mode Switcher Buttons -->
                    <div class="flex items-center gap-1.5 p-1 rounded-xl bg-surface-container-highest border border-surface-container-high">
                        <button type="button" onclick="switchThemeMode('light')" id="btn-mode-light"
                                class="px-3 py-1.5 rounded-lg font-label-md text-label-md flex items-center gap-1.5 transition-all {{ $selectedMode === 'light' ? 'bg-amber-500/20 text-amber-300 font-bold shadow-sm border border-amber-500/30' : 'text-on-surface-variant hover:text-on-surface' }}">
                            <span class="material-symbols-outlined text-[16px]">light_mode</span>
                            <span>Light Mode (10)</span>
                        </button>
                        <button type="button" onclick="switchThemeMode('dark')" id="btn-mode-dark"
                                class="px-3 py-1.5 rounded-lg font-label-md text-label-md flex items-center gap-1.5 transition-all {{ $selectedMode === 'dark' ? 'bg-indigo-500/20 text-indigo-300 font-bold shadow-sm border border-indigo-500/30' : 'text-on-surface-variant hover:text-on-surface' }}">
                            <span class="material-symbols-outlined text-[16px]">dark_mode</span>
                            <span>Dark Mode (10)</span>
                        </button>
                    </div>
                </div>

                <!-- Live Stage Sandbox Canvas -->
                <div class="relative w-full rounded-xl p-space-lg transition-all duration-300 overflow-hidden border"
                     id="sandbox-stage"
                     style="background-color: {{ $activeTheme['bg'] }}; border-color: rgba(255,255,255,0.1);">
                    
                    <!-- Simulated Navbar in Sandbox -->
                    <div class="flex items-center justify-between pb-space-md border-b mb-space-md" id="sandbox-navbar" style="border-color: rgba(128,128,128,0.2);">
                        <div class="flex items-center gap-3">
                            <span class="font-headline-sm text-headline-sm font-bold tracking-tight" id="sandbox-logo" style="color: {{ $activeTheme['primary'] }};">
                                {{ session('project.slug', 'artisan-app') }}
                            </span>
                            <span class="font-code-inline text-[11px] px-2 py-0.5 rounded opacity-80" id="sandbox-app-id" style="background-color: rgba(128,128,128,0.15); color: {{ $activeTheme['subtext'] }};">
                                {{ $activeTheme['appId'] }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full font-label-sm text-label-sm font-semibold" id="sandbox-status-chip" style="background-color: {{ $activeTheme['primary'] }}; color: {{ $selectedMode === 'dark' ? '#000000' : '#FFFFFF' }};">
                                Online • Uptime 99.98%
                            </span>
                        </div>
                    </div>

                    <!-- Simulated Grid: Card, Graph & Form Input inside Stage -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-space-md">
                        <!-- Card 1: Metric KPI Box -->
                        <div class="p-space-md rounded-xl shadow-sm border transition-all duration-200" id="sandbox-card-1" style="background-color: {{ $activeTheme['card'] }}; color: {{ $activeTheme['text'] }}; border-color: rgba(128,128,128,0.2);">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-label-sm text-label-sm font-medium" id="sandbox-metric-label" style="color: {{ $activeTheme['subtext'] }};">System Velocity</span>
                                <span class="material-symbols-outlined text-[18px]" style="color: {{ $activeTheme['primary'] }};">speed</span>
                            </div>
                            <div class="font-display text-2xl font-bold tracking-tight mb-1" id="sandbox-metric-val" style="color: {{ $activeTheme['primary'] }};">
                                {{ $activeTheme['metric'] }}
                            </div>
                            <div class="font-body-sm text-[12px]" id="sandbox-subtext" style="color: {{ $activeTheme['subtext'] }};">
                                +14.8% growth vs last period
                            </div>
                        </div>

                        <!-- Card 2: Interactive SVG Sparkline -->
                        <div class="p-space-md rounded-xl shadow-sm border transition-all duration-200 flex flex-col justify-between" id="sandbox-card-2" style="background-color: {{ $activeTheme['card'] }}; color: {{ $activeTheme['text'] }}; border-color: rgba(128,128,128,0.2);">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-label-sm text-label-sm font-medium" style="color: {{ $activeTheme['subtext'] }};">Active Telemetry</span>
                                <span class="font-label-sm text-[11px] font-bold" id="sandbox-accent-badge" style="color: {{ $activeTheme['accent'] }};">REAL-TIME</span>
                            </div>
                            <div class="w-full h-12 my-1">
                                <svg class="w-full h-full overflow-visible" preserveAspectRatio="none" viewBox="0 0 100 40">
                                    <defs>
                                        <linearGradient id="sandbox-grad" x1="0" x2="0" y1="0" y2="1">
                                            <stop id="sandbox-grad-0" offset="0%" stop-color="{{ $activeTheme['primary'] }}" stop-opacity="0.35"></stop>
                                            <stop id="sandbox-grad-1" offset="100%" stop-color="{{ $activeTheme['primary'] }}" stop-opacity="0.0"></stop>
                                        </linearGradient>
                                    </defs>
                                    <polygon id="sandbox-poly" points="0,35 15,22 30,26 45,12 60,18 75,6 90,14 100,4 100,40 0,40" fill="url(#sandbox-grad)"></polygon>
                                    <polyline id="sandbox-line" fill="none" stroke="{{ $activeTheme['primary'] }}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" points="0,35 15,22 30,26 45,12 60,18 75,6 90,14 100,4"></polyline>
                                </svg>
                            </div>
                            <div class="flex items-center justify-between font-label-sm text-[11px]" style="color: {{ $activeTheme['subtext'] }};">
                                <span>Zero Bottlenecks</span>
                                <span class="font-bold" style="color: {{ $activeTheme['secondary'] }};">0.14ms Latency</span>
                            </div>
                        </div>

                        <!-- Card 3: Form Controls & Action Buttons -->
                        <div class="p-space-md rounded-xl shadow-sm border transition-all duration-200 flex flex-col justify-between gap-2" id="sandbox-card-3" style="background-color: {{ $activeTheme['card'] }}; color: {{ $activeTheme['text'] }}; border-color: rgba(128,128,128,0.2);">
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-label-sm font-medium" style="color: {{ $activeTheme['subtext'] }};">Sample Form Control</span>
                                <span class="font-code-inline text-[11px]" style="color: {{ $activeTheme['subtext'] }};">Input Prepend</span>
                            </div>
                            <div class="flex items-center rounded-lg px-2.5 py-1.5 border" style="background-color: rgba(128,128,128,0.08); border-color: rgba(128,128,128,0.25);">
                                <span class="material-symbols-outlined text-[16px] me-2" style="color: {{ $activeTheme['primary'] }};">person</span>
                                <span class="font-body-sm text-body-sm opacity-70">pantakarn@buu.ac.th</span>
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <button type="button" class="flex-1 py-1.5 rounded-lg font-label-sm text-label-sm font-semibold transition-all shadow-sm" id="sandbox-btn-primary" style="background-color: {{ $activeTheme['primary'] }}; color: {{ $selectedMode === 'dark' ? '#000000' : '#FFFFFF' }};">
                                    Primary Action
                                </button>
                                <button type="button" class="px-3 py-1.5 rounded-lg font-label-sm text-label-sm font-medium border" id="sandbox-btn-ghost" style="background-color: transparent; border-color: rgba(128,128,128,0.3); color: {{ $activeTheme['text'] }};">
                                    Secondary
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Token Palette Strip under stage -->
                    <div class="mt-space-md pt-space-sm border-t flex flex-wrap items-center justify-between gap-2" style="border-color: rgba(128,128,128,0.2);">
                        <div class="flex flex-wrap items-center gap-space-md">
                            <span class="font-label-sm text-[11px] font-bold uppercase tracking-wider" style="color: {{ $activeTheme['subtext'] }};">Token Palette Specs:</span>
                            <div class="flex items-center gap-1.5">
                                <span class="w-3.5 h-3.5 rounded-full border border-black/20" id="dot-primary" style="background-color: {{ $activeTheme['primary'] }};"></span>
                                <span class="font-code-inline text-[11px]" id="hex-primary" style="color: {{ $activeTheme['text'] }};">Primary: {{ $activeTheme['primary'] }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-3.5 h-3.5 rounded-full border border-black/20" id="dot-secondary" style="background-color: {{ $activeTheme['secondary'] }};"></span>
                                <span class="font-code-inline text-[11px]" id="hex-secondary" style="color: {{ $activeTheme['text'] }};">Secondary: {{ $activeTheme['secondary'] }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-3.5 h-3.5 rounded-full border border-black/20" id="dot-accent" style="background-color: {{ $activeTheme['accent'] }};"></span>
                                <span class="font-code-inline text-[11px]" id="hex-accent" style="color: {{ $activeTheme['text'] }};">Accent: {{ $activeTheme['accent'] }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-3.5 h-3.5 rounded-full border border-black/20" id="dot-bg" style="background-color: {{ $activeTheme['bg'] }};"></span>
                                <span class="font-code-inline text-[11px]" id="hex-bg" style="color: {{ $activeTheme['text'] }};">BG: {{ $activeTheme['bg'] }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-3.5 h-3.5 rounded-full border border-black/20" id="dot-card" style="background-color: {{ $activeTheme['card'] }};"></span>
                                <span class="font-code-inline text-[11px]" id="hex-card" style="color: {{ $activeTheme['text'] }};">Card: {{ $activeTheme['card'] }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="font-label-sm text-[11px] text-tertiary font-semibold">✓ Current Active Selection</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEARCH AND FILTER BAR -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-space-md mt-space-lg mb-space-sm">
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <span class="font-headline-sm text-headline-sm text-on-surface font-bold tracking-tight">Theme Catalog</span>
                    <span class="px-2 py-0.5 rounded bg-surface-container font-label-sm text-label-sm text-outline">20 Presets</span>
                </div>

                <div class="relative w-full md:w-80">
                    <span class="material-symbols-outlined text-[18px] text-outline absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">search</span>
                    <input type="text" id="theme-search-input" oninput="filterThemes(this.value)"
                           placeholder="ค้นหาชื่อธีม หรือ รหัสสี Hex..."
                           class="w-full bg-surface-container-low text-on-surface placeholder:text-outline pl-9 pr-space-md py-1.5 rounded-lg font-body-sm text-body-sm border border-surface-container-high focus:outline-none focus:border-primary">
                </div>
            </div>

            <!-- SECTION 1: 10 LIGHT MODE THEMES (DEFAULT) -->
            <div id="section-light-catalog" class="{{ $selectedMode === 'light' ? 'block' : 'hidden' }}">
                <div class="flex items-center gap-2 mb-space-sm">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">☀️ Curated Light Mode Themes (10 Presets)</h3>
                    <span class="font-body-sm text-body-sm text-outline">• ค่าเริ่มต้นสำหรับการใช้งานองค์กร สบายตา คมชัด</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-space-md">
                    @foreach($lightThemes as $key => $theme)
                    @php $isSelected = ($selectedThemeKey === $key); @endphp
                    <div class="theme-card bg-surface-container-low rounded-xl p-space-md flex flex-col justify-between border transition-all cursor-pointer hover:shadow-md group {{ $isSelected ? 'border-primary ring-2 ring-primary/30 shadow-lg' : 'border-surface-container-high hover:border-outline' }}"
                         data-theme-key="{{ $key }}" data-mode="light" data-name="{{ strtolower($theme['name']) }}" data-hex="{{ strtolower($theme['primary'].' '.$theme['secondary'].' '.$theme['bg']) }}"
                         onclick="selectAndPreviewTheme('{{ $key }}')">
                        
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-2 py-0.5 rounded font-label-sm text-[10px] font-bold uppercase tracking-wider bg-amber-500/15 text-amber-600 dark:text-amber-300">
                                    Light
                                </span>
                                <span class="px-1.5 py-0.5 rounded font-label-sm text-[10px] font-bold bg-emerald-500/15 text-emerald-600 dark:text-emerald-400">
                                    {{ $theme['wcag'] }}
                                </span>
                            </div>

                            <h4 class="font-headline-sm text-headline-sm text-on-surface font-bold tracking-tight mb-1 group-hover:text-primary transition-colors">
                                {{ $theme['name'] }}
                            </h4>
                            <p class="font-body-sm text-[12px] text-on-surface-variant line-clamp-2 mb-3">
                                {{ $theme['desc'] }}
                            </p>

                            <!-- Color Palette Swatches -->
                            <div class="flex items-center gap-1.5 mb-3 p-1.5 rounded-lg bg-surface-container-lowest border border-surface-container-highest">
                                <span class="w-5 h-5 rounded-md border border-black/10 shadow-inner" style="background-color: {{ $theme['primary'] }};" title="Primary: {{ $theme['primary'] }}"></span>
                                <span class="w-5 h-5 rounded-md border border-black/10 shadow-inner" style="background-color: {{ $theme['secondary'] }};" title="Secondary: {{ $theme['secondary'] }}"></span>
                                <span class="w-5 h-5 rounded-md border border-black/10 shadow-inner" style="background-color: {{ $theme['accent'] }};" title="Accent: {{ $theme['accent'] }}"></span>
                                <span class="w-5 h-5 rounded-md border border-black/10 shadow-inner" style="background-color: {{ $theme['bg'] }};" title="Background: {{ $theme['bg'] }}"></span>
                                <span class="w-5 h-5 rounded-md border border-black/10 shadow-inner" style="background-color: {{ $theme['card'] }};" title="Card: {{ $theme['card'] }}"></span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2 border-t border-surface-container-high">
                            <span class="font-code-inline text-[11px] text-outline font-medium">{{ $theme['primary'] }}</span>
                            <div class="theme-check-icon flex items-center justify-center w-6 h-6 rounded-full {{ $isSelected ? 'bg-primary text-on-primary' : 'bg-surface-container text-transparent' }}">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- SECTION 2: 10 DARK MODE THEMES -->
            <div id="section-dark-catalog" class="{{ $selectedMode === 'dark' ? 'block' : 'hidden' }}">
                <div class="flex items-center gap-2 mb-space-sm">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-400"></span>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">🌙 Curated Dark Mode Themes (10 Presets)</h3>
                    <span class="font-body-sm text-body-sm text-outline">• โทนดาร์กสไตล์ Forge Artisan / Cyberpunk / Dev Studio</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-space-md">
                    @foreach($darkThemes as $key => $theme)
                    @php $isSelected = ($selectedThemeKey === $key); @endphp
                    <div class="theme-card bg-surface-container-low rounded-xl p-space-md flex flex-col justify-between border transition-all cursor-pointer hover:shadow-md group {{ $isSelected ? 'border-primary ring-2 ring-primary/30 shadow-lg' : 'border-surface-container-high hover:border-outline' }}"
                         data-theme-key="{{ $key }}" data-mode="dark" data-name="{{ strtolower($theme['name']) }}" data-hex="{{ strtolower($theme['primary'].' '.$theme['secondary'].' '.$theme['bg']) }}"
                         onclick="selectAndPreviewTheme('{{ $key }}')">
                        
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-2 py-0.5 rounded font-label-sm text-[10px] font-bold uppercase tracking-wider bg-indigo-500/15 text-indigo-400">
                                    Dark
                                </span>
                                <span class="px-1.5 py-0.5 rounded font-label-sm text-[10px] font-bold bg-emerald-500/15 text-emerald-400">
                                    {{ $theme['wcag'] }}
                                </span>
                            </div>

                            <h4 class="font-headline-sm text-headline-sm text-on-surface font-bold tracking-tight mb-1 group-hover:text-primary transition-colors">
                                {{ $theme['name'] }}
                            </h4>
                            <p class="font-body-sm text-[12px] text-on-surface-variant line-clamp-2 mb-3">
                                {{ $theme['desc'] }}
                            </p>

                            <!-- Color Palette Swatches -->
                            <div class="flex items-center gap-1.5 mb-3 p-1.5 rounded-lg bg-surface-container-lowest border border-surface-container-highest">
                                <span class="w-5 h-5 rounded-md border border-white/10 shadow-inner" style="background-color: {{ $theme['primary'] }};" title="Primary: {{ $theme['primary'] }}"></span>
                                <span class="w-5 h-5 rounded-md border border-white/10 shadow-inner" style="background-color: {{ $theme['secondary'] }};" title="Secondary: {{ $theme['secondary'] }}"></span>
                                <span class="w-5 h-5 rounded-md border border-white/10 shadow-inner" style="background-color: {{ $theme['accent'] }};" title="Accent: {{ $theme['accent'] }}"></span>
                                <span class="w-5 h-5 rounded-md border border-white/10 shadow-inner" style="background-color: {{ $theme['bg'] }};" title="Background: {{ $theme['bg'] }}"></span>
                                <span class="w-5 h-5 rounded-md border border-white/10 shadow-inner" style="background-color: {{ $theme['card'] }};" title="Card: {{ $theme['card'] }}"></span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2 border-t border-surface-container-high">
                            <span class="font-code-inline text-[11px] text-outline font-medium">{{ $theme['primary'] }}</span>
                            <div class="theme-check-icon flex items-center justify-center w-6 h-6 rounded-full {{ $isSelected ? 'bg-primary text-on-primary' : 'bg-surface-container text-transparent' }}">
                                <span class="material-symbols-outlined text-[16px]">check</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Bottom Navigation Bar -->
            <div class="flex items-center justify-between pt-space-lg border-t border-surface-container-high mt-space-xl">
                <a href="{{ route('generator.step3') }}" class="btn-artisan-back px-space-lg py-2.5 rounded-lg bg-surface-container text-on-surface hover:bg-surface-container-high font-body-md text-body-md transition-all border border-surface-container-highest text-decoration-none flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span>Previous: 3. Modules &amp; Schema</span>
                </a>

                <div class="flex items-center gap-space-md">
                    <div class="text-right hidden sm:block">
                        <div class="font-body-sm text-body-sm font-semibold text-on-surface" id="selected-theme-summary">
                            ธีมที่เลือก: {{ $activeTheme['name'] }} ({{ ucfirst($selectedMode) }})
                        </div>
                        <div class="font-label-sm text-label-sm text-outline">บันทึกค่าและพร้อมพรีวิวโค้ดจริงใน Step 5</div>
                    </div>
                    <button type="submit" class="btn-artisan-continue px-space-xl py-2.5 rounded-lg bg-primary-container hover:bg-inverse-primary text-on-primary font-headline-sm text-headline-sm font-medium transition-all shadow-[0_0_20px_rgba(255,85,66,0.3)] flex items-center justify-center gap-space-xs cursor-pointer">
                        <span>Continue: 5. Code Preview &amp; Export</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- CLIENT JAVASCRIPT FOR THEME STUDIO -->
<script>
    const THEME_DATABASE = @json($allThemes);
    let currentThemeKey = "{{ $selectedThemeKey }}";
    let currentThemeMode = "{{ $selectedMode }}";

    function selectAndPreviewTheme(key) {
        const theme = THEME_DATABASE[key];
        if (!theme) return;

        currentThemeKey = key;
        currentThemeMode = theme.mode;

        // Update hidden inputs
        document.getElementById('selected-theme-key').value = key;
        document.getElementById('selected-theme-mode').value = theme.mode;

        // Update Card Selection UI
        document.querySelectorAll('.theme-card').forEach(card => {
            const cardKey = card.getAttribute('data-theme-key');
            const checkIcon = card.querySelector('.theme-check-icon');
            if (cardKey === key) {
                card.classList.add('border-primary', 'ring-2', 'ring-primary/30', 'shadow-lg');
                card.classList.remove('border-surface-container-high');
                if (checkIcon) {
                    checkIcon.className = 'theme-check-icon flex items-center justify-center w-6 h-6 rounded-full bg-primary text-on-primary';
                }
            } else {
                card.classList.remove('border-primary', 'ring-2', 'ring-primary/30', 'shadow-lg');
                card.classList.add('border-surface-container-high');
                if (checkIcon) {
                    checkIcon.className = 'theme-check-icon flex items-center justify-center w-6 h-6 rounded-full bg-surface-container text-transparent';
                }
            }
        });

        // Update Sandbox Stage
        updateSandboxStage(theme);

        // Update Summary Text
        const summary = document.getElementById('selected-theme-summary');
        if (summary) {
            summary.innerText = `ธีมที่เลือก: ${theme.name} (${theme.mode === 'light' ? 'Light' : 'Dark'})`;
        }
    }

    function updateSandboxStage(theme) {
        document.getElementById('sandbox-theme-name').innerText = theme.name;
        document.getElementById('sandbox-theme-desc').innerText = theme.desc;
        document.getElementById('sandbox-wcag-badge').innerText = theme.wcag;

        const modeBadge = document.getElementById('sandbox-mode-badge');
        modeBadge.innerText = `${theme.mode.toUpperCase()} MODE`;
        modeBadge.style.backgroundColor = theme.mode === 'dark' ? '#1E293B' : '#E2E8F0';
        modeBadge.style.color = theme.mode === 'dark' ? '#38BDF8' : '#0F172A';

        // Stage frame
        const stage = document.getElementById('sandbox-stage');
        stage.style.backgroundColor = theme.bg;

        // Logo & App ID
        document.getElementById('sandbox-logo').style.color = theme.primary;
        const appId = document.getElementById('sandbox-app-id');
        appId.innerText = theme.appId;
        appId.style.color = theme.subtext;

        // Status chip
        const chip = document.getElementById('sandbox-status-chip');
        chip.style.backgroundColor = theme.primary;
        chip.style.color = theme.mode === 'dark' ? '#000000' : '#FFFFFF';

        // Cards inside stage
        ['sandbox-card-1', 'sandbox-card-2', 'sandbox-card-3'].forEach(id => {
            const card = document.getElementById(id);
            if (card) {
                card.style.backgroundColor = theme.card;
                card.style.color = theme.text;
            }
        });

        // Text & metrics
        document.getElementById('sandbox-metric-val').style.color = theme.primary;
        document.getElementById('sandbox-metric-val').innerText = theme.metric;
        document.getElementById('sandbox-metric-label').style.color = theme.subtext;
        document.getElementById('sandbox-subtext').style.color = theme.subtext;
        document.getElementById('sandbox-accent-badge').style.color = theme.accent;

        // SVG Sparkline
        document.getElementById('sandbox-line').setAttribute('stroke', theme.primary);
        document.getElementById('sandbox-grad-0').setAttribute('stop-color', theme.primary);
        document.getElementById('sandbox-grad-1').setAttribute('stop-color', theme.primary);

        // Buttons
        const btnPri = document.getElementById('sandbox-btn-primary');
        btnPri.style.backgroundColor = theme.primary;
        btnPri.style.color = theme.mode === 'dark' ? '#000000' : '#FFFFFF';

        const btnGhost = document.getElementById('sandbox-btn-ghost');
        btnGhost.style.color = theme.text;

        // Palette specs
        document.getElementById('dot-primary').style.backgroundColor = theme.primary;
        document.getElementById('hex-primary').innerText = `Primary: ${theme.primary}`;
        document.getElementById('hex-primary').style.color = theme.text;

        document.getElementById('dot-secondary').style.backgroundColor = theme.secondary;
        document.getElementById('hex-secondary').innerText = `Secondary: ${theme.secondary}`;
        document.getElementById('hex-secondary').style.color = theme.text;

        document.getElementById('dot-accent').style.backgroundColor = theme.accent;
        document.getElementById('hex-accent').innerText = `Accent: ${theme.accent}`;
        document.getElementById('hex-accent').style.color = theme.text;

        document.getElementById('dot-bg').style.backgroundColor = theme.bg;
        document.getElementById('hex-bg').innerText = `BG: ${theme.bg}`;
        document.getElementById('hex-bg').style.color = theme.text;

        document.getElementById('dot-card').style.backgroundColor = theme.card;
        document.getElementById('hex-card').innerText = `Card: ${theme.card}`;
        document.getElementById('hex-card').style.color = theme.text;
    }

    const THEME_PAIRS = {
        'emerald-enterprise': 'emerald-matrix',
        'emerald-matrix': 'emerald-enterprise',
        'nordic-clean': 'monolith-obsidian',
        'monolith-obsidian': 'nordic-clean',
        'horizon-sky': 'deep-oceanic',
        'deep-oceanic': 'horizon-sky',
        'sunset-horizon': 'crimson-voltage',
        'crimson-voltage': 'sunset-horizon',
        'rose-quartz': 'royal-amethyst',
        'royal-amethyst': 'rose-quartz',
        'forest-moss': 'slate-executive',
        'slate-executive': 'forest-moss',
        'solar-amber': 'solar-eclipse',
        'solar-eclipse': 'solar-amber',
        'lavande-provence': 'vapor-synthwave',
        'vapor-synthwave': 'lavande-provence',
        'swiss-monolith': 'midnight-cyberpunk',
        'midnight-cyberpunk': 'swiss-monolith',
        'sand-terracotta': 'nord-twilight',
        'nord-twilight': 'sand-terracotta'
    };

    function switchThemeMode(mode) {
        currentThemeMode = mode;
        const btnLight = document.getElementById('btn-mode-light');
        const btnDark = document.getElementById('btn-mode-dark');
        const secLight = document.getElementById('section-light-catalog');
        const secDark = document.getElementById('section-dark-catalog');

        if (mode === 'light') {
            btnLight.className = 'px-3 py-1.5 rounded-lg font-label-md text-label-md flex items-center gap-1.5 transition-all bg-amber-500/20 text-amber-300 font-bold shadow-sm border border-amber-500/30';
            btnDark.className = 'px-3 py-1.5 rounded-lg font-label-md text-label-md flex items-center gap-1.5 transition-all text-on-surface-variant hover:text-on-surface';
            secLight.classList.remove('hidden');
            secLight.classList.add('block');
            secDark.classList.add('hidden');
            secDark.classList.remove('block');

            // If current theme is dark, switch to corresponding light theme pair or fallback
            if (THEME_DATABASE[currentThemeKey]?.mode !== 'light') {
                const targetLight = THEME_PAIRS[currentThemeKey] || 'nordic-clean';
                selectAndPreviewTheme(targetLight);
            }
        } else {
            btnDark.className = 'px-3 py-1.5 rounded-lg font-label-md text-label-md flex items-center gap-1.5 transition-all bg-indigo-500/20 text-indigo-300 font-bold shadow-sm border border-indigo-500/30';
            btnLight.className = 'px-3 py-1.5 rounded-lg font-label-md text-label-md flex items-center gap-1.5 transition-all text-on-surface-variant hover:text-on-surface';
            secDark.classList.remove('hidden');
            secDark.classList.add('block');
            secLight.classList.add('hidden');
            secLight.classList.remove('block');

            // If current theme is light, switch to corresponding dark theme pair or fallback
            if (THEME_DATABASE[currentThemeKey]?.mode !== 'dark') {
                const targetDark = THEME_PAIRS[currentThemeKey] || 'midnight-cyberpunk';
                selectAndPreviewTheme(targetDark);
            }
        }
    }

    function filterThemes(query) {
        query = query.toLowerCase().trim();
        document.querySelectorAll('.theme-card').forEach(card => {
            const name = card.getAttribute('data-name') || '';
            const hex = card.getAttribute('data-hex') || '';
            const key = card.getAttribute('data-theme-key') || '';
            if (!query || name.includes(query) || hex.includes(query) || key.includes(query)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function submitThemeForm() {
        document.getElementById('theme-selection-form').submit();
    }
</script>
@endsection
