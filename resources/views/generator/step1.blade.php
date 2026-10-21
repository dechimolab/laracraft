@extends('layouts.artisan')

@section('title', 'Step 1: Project Setup & Environment Configurator')

@section('content')
<div class="flex flex-col w-full">
    <!-- Hero Banner -->
    <div class="relative w-full overflow-hidden bg-surface-container-low px-space-lg py-space-xl border-b border-surface-container-high">
        <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-primary/5 blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/3 -bottom-20 w-80 h-80 rounded-full bg-secondary-container/10 blur-3xl pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto flex flex-col gap-space-md">
            <div class="flex flex-wrap items-center justify-between gap-space-sm">
                <div class="flex items-start gap-space-sm">
                    <div class="w-11 h-11 rounded-xl bg-surface-container-high border border-surface-container-highest flex items-center justify-center font-code-inline text-headline-sm font-bold text-primary shadow-sm shrink-0">01</div>
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-space-xs flex-wrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-surface-container-highest text-primary font-label-sm text-label-sm font-semibold uppercase tracking-wider">
                                <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                                Pipeline Step 01 / 05
                            </span>
                            <span class="text-outline font-code-inline text-label-sm">|</span>
                            <span class="text-secondary font-code-inline text-label-sm">Project Core &amp; Environment Setup</span>
                        </div>
                        <span class="font-headline-lg text-headline-lg text-on-surface font-bold tracking-tight">Project Core &amp; Environment Setup</span>
                    </div>
                </div>
                <div class="flex items-center gap-space-sm flex-wrap">
                    <div id="hero-active-preset-badge" class="flex items-center gap-2 bg-surface-container-high px-space-md py-1.5 rounded-full border border-tertiary/30 shadow-sm">
                        <span class="w-2.5 h-2.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(78,222,163,0.8)] animate-pulse"></span>
                        <span class="font-label-sm text-label-sm text-outline uppercase">Active Preset:</span>
                        <span id="hero-active-preset-name" class="font-code-inline text-code-inline text-tertiary font-semibold truncate max-w-[220px]">{{ !empty($activePreset['name']) ? $activePreset['name'] : 'None (Custom)' }}</span>
                    </div>
                    <div class="flex items-center gap-2 bg-surface-container-high px-space-md py-1.5 rounded-full border border-surface-container-highest/40">
                        <span class="font-label-sm text-label-sm text-outline uppercase">Progress</span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-primary shadow-[0_0_8px_rgba(255,85,66,0.6)]"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-surface-container-highest"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-surface-container-highest"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-surface-container-highest"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-surface-container-highest"></span>
                        </div>
                        <span class="font-code-block text-code-block text-on-surface font-semibold ml-1">Step 1 of 5</span>
                    </div>
                </div>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant max-w-3xl">
                ตั้งค่าแกนกลางระบบ สภาพแวดล้อมรันไทม์ PHP 8.4 สถาปัตยกรรมโมดูล และการเชื่อมต่อฐานข้อมูลสำหรับโปรเจกต์ Laravel 13.x ใหม่ พร้อมคอมไพเลอร์ Bootstrap 5.3
            </p>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-space-sm pt-space-xs">
                <div class="flex items-center gap-space-sm bg-surface-container p-space-sm rounded-lg border border-surface-container-highest/50 shadow-sm">
                    <span class="material-symbols-outlined text-primary text-[20px]">bolt</span>
                    <div class="flex flex-col min-w-0">
                        <span class="font-label-sm text-label-sm text-outline uppercase truncate">Runtime Target</span>
                        <span class="font-code-inline text-code-inline text-on-surface font-medium truncate">PHP 8.4.1 (JIT Enabled)</span>
                    </div>
                </div>
                <div class="flex items-center gap-space-sm bg-surface-container p-space-sm rounded-lg border border-surface-container-highest/50 shadow-sm">
                    <span class="material-symbols-outlined text-secondary text-[20px]">layers</span>
                    <div class="flex flex-col min-w-0">
                        <span class="font-label-sm text-label-sm text-outline uppercase truncate">Framework Foundation</span>
                        <span class="font-code-inline text-code-inline text-on-surface font-medium truncate">Laravel 13.x Slim Core</span>
                    </div>
                </div>
                <div class="flex items-center gap-space-sm bg-surface-container p-space-sm rounded-lg border border-surface-container-highest/50 shadow-sm">
                    <span class="material-symbols-outlined text-tertiary text-[20px]">palette</span>
                    <div class="flex flex-col min-w-0">
                        <span class="font-label-sm text-label-sm text-outline uppercase truncate">Frontend Bundle</span>
                        <span class="font-code-inline text-code-inline text-on-surface font-medium truncate">BS 5.3.3 + Vite Sass</span>
                    </div>
                </div>
                <div class="flex items-center gap-space-sm bg-surface-container p-space-sm rounded-lg border border-surface-container-highest/50 shadow-sm">
                    <span class="material-symbols-outlined text-tertiary-fixed-dim text-[20px]">database</span>
                    <div class="flex flex-col min-w-0">
                        <span class="font-label-sm text-label-sm text-outline uppercase truncate">Database Engine</span>
                        <span class="font-code-inline text-code-inline text-on-surface font-medium truncate">MySQL 8.4 InnoDB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form Section -->
    <div class="max-w-7xl mx-auto w-full px-space-lg py-space-lg flex flex-col gap-space-xl">
        <!-- Preset Archetypes -->
        <section class="flex flex-col gap-space-md">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[20px]">grid_view</span>
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Preset Archetypes • สถาปัตยกรรมตั้งต้น</h2>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="openLoadPresetModal()" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-bright text-secondary text-label-sm font-label-sm border border-secondary/30 transition-all cursor-pointer shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">folder_special</span>
                        <span>โหลดแม่แบบ (<span id="top-preset-count" class="font-bold text-primary">0</span>)</span>
                    </button>
                    <span class="hidden md:inline font-label-sm text-label-sm text-outline font-code-inline">ARCHETYPE_SELECTOR</span>
                </div>
            </div>
            <div class="w-full rounded-xl bg-surface-container-high p-space-lg flex flex-col md:flex-row md:items-center justify-between gap-space-md shadow-md relative overflow-hidden transition-all duration-300 border border-surface-container-highest/60" id="archetype-container">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-space-md">
                    <div class="w-12 h-12 rounded-xl bg-surface-container-lowest flex items-center justify-center text-primary shadow-[0_0_12px_rgba(255,85,66,0.2)] border border-surface-container-highest/50" id="archetype-icon-box">
                        <span class="material-symbols-outlined text-[28px]" id="archetype-icon">view_quilt</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-space-sm flex-wrap">
                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold" id="archetype-title">{{ !empty($activePreset['name']) ? $activePreset['name'] : 'Full-Stack Monolith' }}</h3>
                            <span id="archetype-badge" class="px-2.5 py-0.5 rounded-full {{ !empty($activePreset['name']) ? 'bg-tertiary-container text-on-tertiary-container' : 'bg-primary-container text-on-primary-container' }} font-label-sm text-label-sm font-code-inline flex items-center gap-1 border border-tertiary/30">
                                <span class="material-symbols-outlined text-[14px]" id="archetype-badge-icon">verified</span><span id="archetype-badge-text">{{ !empty($activePreset['name']) ? 'Active Preset' : 'Active Foundation' }}</span>
                            </span>
                        </div>
                        <span class="font-label-sm text-label-sm text-outline" id="archetype-subtitle">Blade + Bootstrap 5.3 UI • สถาปัตยกรรมหลักสำหรับแอปพลิเคชันระบบเดี่ยว</span>
                        <p class="font-body-sm text-body-sm text-on-surface-variant max-w-2xl mt-0.5" id="archetype-desc">
                            สถาปัตยกรรมแบบดั้งเดิมที่ผสาน Blade Views เข้ากับ Bootstrap 5.3 และ Sass workflow ควบคุมความซับซ้อนต่ำ ประสิทธิภาพสูง พร้อมคอมไพล์ asset ทันที
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap md:flex-col items-end gap-1.5 pt-space-xs md:pt-0">
                    <div class="flex items-center gap-1">
                        <span class="px-2.5 py-1 rounded bg-surface-container-lowest text-primary font-label-sm text-label-sm font-code-inline border border-surface-container-highest/50 shadow-sm" id="badge-php-version">PHP {{ session('project.php_version', config('generator.default_php', '8.4')) }}</span>
                        <span class="px-2.5 py-1 rounded bg-surface-container-lowest text-secondary font-label-sm text-label-sm font-code-inline border border-surface-container-highest/50 shadow-sm" id="badge-laravel-version">Laravel {{ session('project.laravel_version', config('generator.default_laravel', '13.x')) }}</span>
                        <span class="px-2.5 py-1 rounded bg-surface-container-lowest text-tertiary font-label-sm text-label-sm font-code-inline border border-surface-container-highest/50 shadow-sm">BS 5.3.3</span>
                    </div>
                    <span class="font-label-sm text-label-sm text-outline font-code-inline" id="archetype-status-tag">LOCKED ARCHETYPE</span>
                </div>
            </div>
        </section>

        <form method="POST" action="{{ route('generator.step1.save') }}" id="setup-form">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg">
                <!-- Left 8 Cols -->
                <div class="lg:col-span-8 flex flex-col gap-space-lg">
                    <!-- App Spec -->
                    <div class="bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md border border-surface-container-highest/60">
                        <div class="flex items-center justify-between pb-space-xs">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-primary text-[20px]">tune</span>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Application Specification • ข้อมูลพื้นฐานแอปพลิเคชัน</h3>
                            </div>
                            <span class="font-code-block text-code-block text-outline font-code-inline">config/app.php</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                            <!-- PHP Runtime Engine -->
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <label class="font-label-md text-label-md text-on-surface" for="php-version">PHP Runtime Engine <span class="text-primary">*</span></label>
                                    <span class="font-label-sm text-label-sm text-tertiary font-code-inline">PHP_VERSION</span>
                                </div>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <select class="w-full bg-transparent font-code-inline text-code-inline text-tertiary focus:outline-none cursor-pointer"
                                            id="php-version" name="php_version" onchange="onRuntimeVersionChange()">
                                        @php
                                            $currentPhp = old('php_version', session('project.php_version', config('generator.default_php', '8.4')));
                                            $phpOptions = config('generator.php_versions', []);
                                        @endphp
                                        @foreach($phpOptions as $key => $opt)
                                            <option class="bg-surface-container text-on-surface" value="{{ $key }}" {{ $currentPhp === $key ? 'selected' : '' }}>
                                                {{ $opt['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="font-body-sm text-body-sm text-outline">สภาพแวดล้อมรันไทม์ PHP ภายใน Docker Hub และ Composer constraints</span>
                            </div>

                            <!-- Laravel Framework Generation -->
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <label class="font-label-md text-label-md text-on-surface" for="laravel-version">Laravel Framework Generation <span class="text-primary">*</span></label>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">FRAMEWORK</span>
                                </div>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <select class="w-full bg-transparent font-code-inline text-code-inline text-secondary focus:outline-none cursor-pointer"
                                            id="laravel-version" name="laravel_version" onchange="onRuntimeVersionChange()">
                                        @php
                                            $currentLaravel = old('laravel_version', session('project.laravel_version', config('generator.default_laravel', '13.x')));
                                            $laravelOptions = config('generator.laravel_versions', []);
                                        @endphp
                                        @foreach($laravelOptions as $key => $opt)
                                            <option class="bg-surface-container text-on-surface" value="{{ $key }}" {{ $currentLaravel === $key ? 'selected' : '' }}>
                                                {{ $opt['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="font-body-sm text-body-sm text-outline">เลือกรุ่นสถาปัตยกรรม Laravel สำหรับ Scaffolding และ Service Providers</span>
                            </div>

                            <div class="flex flex-col gap-1">
                                <label class="font-label-md text-label-md text-on-surface" for="project-name">Project Directory Name <span class="text-primary">*</span></label>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                           id="project-name" name="project_name" type="text"
                                           value="{{ old('project_name', session('project.slug', 'artisan-pos-system')) }}" oninput="updateEnvPreview()">
                                    <span class="font-label-sm text-label-sm text-outline ml-2">slug</span>
                                </div>
                                <span class="font-body-sm text-body-sm text-outline">ใช้เป็นชื่อไดเรกทอรีและโฟลเดอร์สำหรับ artisan CLI</span>
                            </div>

                            <div class="flex flex-col gap-1">
                                <label class="font-label-md text-label-md text-on-surface" for="app-title">App Display Title <span class="text-primary">*</span></label>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <input class="w-full bg-transparent font-body-md text-body-md text-on-surface focus:outline-none"
                                           id="app-title" name="app_title" type="text"
                                           value="{{ old('app_title', session('project.name', 'Artisan POS & Inventory Hub')) }}" oninput="updateEnvPreview()">
                                    <span class="font-label-sm text-label-sm text-outline ml-2">APP_NAME</span>
                                </div>
                                <span class="font-body-sm text-body-sm text-outline">ชื่อที่จะปรากฏใน Navigation Bar และแท็บเบราว์เซอร์</span>
                            </div>

                            <div class="flex flex-col gap-1">
                                <label class="font-label-md text-label-md text-on-surface" for="app-env">Application Environment</label>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <select class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none cursor-pointer"
                                            id="app-env" name="app_env" onchange="updateEnvPreview()">
                                        <option class="bg-surface-container text-on-surface" value="local" {{ session('project.env', 'local') === 'local' ? 'selected' : '' }}>local (Development with Debugbar)</option>
                                        <option class="bg-surface-container text-on-surface" value="staging" {{ session('project.env') === 'staging' ? 'selected' : '' }}>staging (Pre-production testing)</option>
                                        <option class="bg-surface-container text-on-surface" value="production" {{ session('project.env') === 'production' ? 'selected' : '' }}>production (Optimized cached state)</option>
                                    </select>
                                </div>
                                <span class="font-body-sm text-body-sm text-outline">APP_ENV ในไฟล์ .env พร้อมการควบคุม APP_DEBUG</span>
                            </div>

                            @php
                                $initHttpsPort = (int) old('docker_https_port', session('project.docker_https_port', 443));
                                $initDefaultUrl = ($initHttpsPort === 443) ? 'https://localhost' : "https://localhost:{$initHttpsPort}";
                                $currentAppUrl = old('app_url', session('project.url'));
                                if (empty($currentAppUrl) || $currentAppUrl === 'http://localhost:8000' || $currentAppUrl === 'http://localhost') {
                                    $currentAppUrl = $initDefaultUrl;
                                }
                            @endphp
                            <div class="flex flex-col gap-1">
                                <label class="font-label-md text-label-md text-on-surface" for="app-url">Application URL</label>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                           id="app-url" name="app_url" type="text"
                                           value="{{ $currentAppUrl }}" oninput="updateEnvPreview()">
                                    <span class="material-symbols-outlined text-[16px] text-outline ml-1">link</span>
                                </div>
                                <span class="font-body-sm text-body-sm text-outline">ใช้สร้าง Absolute URLs และ Asset manifests</span>
                            </div>

                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <label class="font-label-md text-label-md text-on-surface" for="app-tz">App Timezone (เวลาท้องถิ่น)</label>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">APP_TIMEZONE</span>
                                </div>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <select class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none cursor-pointer"
                                            id="app-tz" name="app_timezone" onchange="updateEnvPreview()">
                                        <option class="bg-surface-container text-on-surface" value="Asia/Bangkok" selected>Asia/Bangkok (UTC+07:00 Indochina)</option>
                                        <option class="bg-surface-container text-on-surface" value="UTC">UTC (Coordinated Universal Time)</option>
                                        <option class="bg-surface-container text-on-surface" value="Asia/Singapore">Asia/Singapore (UTC+08:00)</option>
                                        <option class="bg-surface-container text-on-surface" value="Asia/Tokyo">Asia/Tokyo (UTC+09:00)</option>
                                    </select>
                                </div>
                                <span class="font-body-sm text-body-sm text-outline">กำหนดเวลาลงฐานข้อมูลและ Carbon time helper (now(), parse())</span>
                            </div>

                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <label class="font-label-md text-label-md text-on-surface" for="app-log-channel">Log Channel</label>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">LOG_CHANNEL</span>
                                </div>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <select class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none cursor-pointer"
                                            id="app-log-channel" name="log_channel" onchange="updateEnvPreview()">
                                        <option class="bg-surface-container text-on-surface" value="stack">stack (Single + Daily Rotate)</option>
                                        <option class="bg-surface-container text-on-surface" value="daily" selected>daily (Daily log files)</option>
                                        <option class="bg-surface-container text-on-surface" value="single">single (Single laravel.log file)</option>
                                        <option class="bg-surface-container text-on-surface" value="slack">slack (Slack webhook logging)</option>
                                    </select>
                                </div>
                                <span class="font-body-sm text-body-sm text-outline">ช่องทางบันทึก log ระบบ (daily, stack, slack, syslog)</span>
                            </div>

                            <div class="flex flex-col gap-1 md:col-span-2">
                                <div class="flex items-center justify-between">
                                    <label class="font-label-md text-label-md text-on-surface" for="app-key">Application Encryption Key <span class="text-primary">*</span></label>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">APP_KEY</span>
                                </div>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-1.5 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 gap-2 transition-all shadow-sm">
                                    <input class="w-full bg-transparent font-code-inline text-code-inline text-secondary focus:outline-none"
                                           id="app-key" name="app_key" type="text"
                                           value="{{ old('app_key', session('project.key', 'base64:v84X9J2qK7mP3L0wR1tY5uI6oP8aS0dF2gH4jK6lZ8=')) }}"
                                           oninput="updateEnvPreview()">
                                    <button type="button" onclick="generateAppKey()"
                                             class="flex items-center gap-1.5 px-3 py-1 rounded bg-surface-container-high hover:bg-surface-bright text-on-surface text-label-sm font-label-sm font-code-inline transition-all hover:scale-105 active:scale-95 flex-shrink-0 cursor-pointer shadow-sm border border-surface-container-highest/60"
                                            title="สุ่มสร้างคีย์ใหม่แบบปลอดภัย (32-byte AES-256-CBC Base64)">
                                        <span class="material-symbols-outlined text-[16px] text-tertiary">autorenew</span>
                                        <span>Generate New Key</span>
                                    </button>
                                </div>
                                <span class="font-body-sm text-body-sm text-outline flex items-center justify-between">
                                    <span>คีย์สำหรับเข้ารหัส Session, Cookie และข้อมูลความปลอดภัย (AES-256-CBC)</span>
                                    <span class="text-tertiary font-code-inline text-[11px] cursor-pointer hover:underline" onclick="generateAppKey()">กดสุ่มสร้างคีย์ใหม่ได้เรื่อยๆ</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Database Engine -->
                    <div class="bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md border border-surface-container-highest/60">
                        <div class="flex items-center justify-between pb-space-xs">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-tertiary-fixed-dim text-[20px]">database</span>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold" id="db-engine-title">Database Engine (MySQL 8.4 LTS)</h3>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="flex items-center gap-1.5 px-3 py-1 rounded-lg bg-surface-container-highest hover:bg-surface-bright text-on-surface font-label-md text-label-md transition-colors border border-surface-container-highest shadow-sm cursor-pointer"
                                        id="test-connection-btn" onclick="testDbConnection()" type="button">
                                    <span class="w-2 h-2 rounded-full bg-tertiary" id="test-pulse"></span>
                                    <span id="test-text">Test DB Connection</span>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <label class="font-label-md text-label-md text-on-surface" for="db-connection">DB Connection Driver <span class="text-primary">*</span></label>
                                    <span class="font-label-sm text-outline font-code-inline text-[9px]">DB_CONNECTION</span>
                                </div>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <select class="w-full bg-transparent font-code-inline text-code-inline text-secondary font-medium focus:outline-none cursor-pointer"
                                            id="db-connection" name="db_connection" onchange="onDbConnectionChange()">
                                        <option class="bg-surface-container text-on-surface" value="mysql" {{ old('db_connection', session('project.db_connection', 'mysql')) === 'mysql' ? 'selected' : '' }}>mysql (MySQL 8.4 / 8.0)</option>
                                        <option class="bg-surface-container text-on-surface" value="mariadb" {{ old('db_connection', session('project.db_connection')) === 'mariadb' ? 'selected' : '' }}>mariadb (MariaDB 11.x / 10.x)</option>
                                        <option class="bg-surface-container text-on-surface" value="pgsql" {{ old('db_connection', session('project.db_connection')) === 'pgsql' ? 'selected' : '' }}>pgsql (PostgreSQL 15+)</option>
                                        <option class="bg-surface-container text-on-surface" value="sqlite" {{ old('db_connection', session('project.db_connection')) === 'sqlite' ? 'selected' : '' }}>sqlite (SQLite 3 File/Memory)</option>
                                        <option class="bg-surface-container text-on-surface" value="sqlsrv" {{ old('db_connection', session('project.db_connection')) === 'sqlsrv' ? 'selected' : '' }}>sqlsrv (MS SQL Server)</option>
                                        <option class="bg-surface-container text-on-surface" value="oracle" {{ old('db_connection', session('project.db_connection')) === 'oracle' ? 'selected' : '' }}>oracle (Oracle Database)</option>
                                        <option class="bg-surface-container text-primary font-medium" value="custom" {{ (!in_array(old('db_connection', session('project.db_connection', 'mysql')), ['mysql', 'mariadb', 'pgsql', 'sqlite', 'sqlsrv', 'oracle'])) ? 'selected' : '' }}>อื่นๆ (พิมพ์กำหนดเอง...)</option>
                                    </select>
                                </div>
                                <!-- Custom Driver Input (Shown when "custom" is selected) -->
                                <div id="custom-db-driver-wrapper" class="{{ (!in_array(old('db_connection', session('project.db_connection', 'mysql')), ['mysql', 'mariadb', 'pgsql', 'sqlite', 'sqlsrv', 'oracle'])) ? '' : 'hidden' }} flex items-center bg-surface-container-lowest rounded-lg px-3 py-1.5 text-on-surface focus-within:bg-surface-container border border-primary focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 gap-2 mt-1 transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-[16px] text-primary">edit_note</span>
                                    <input class="w-full bg-transparent font-code-inline text-code-inline text-primary font-medium focus:outline-none placeholder:text-outline"
                                            id="db-connection-custom" name="db_connection_custom" type="text"
                                            placeholder="พิมพ์ชื่อไดรเวอร์ เช่น mongodb, clickhouse, duckdb, odbc"
                                            value="{{ !in_array(old('db_connection', session('project.db_connection')), ['mysql', 'mariadb', 'pgsql', 'sqlite', 'sqlsrv', 'oracle', null]) ? old('db_connection', session('project.db_connection')) : old('db_connection_custom', '') }}"
                                            oninput="onCustomDbDriverInput()">
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-label-md text-label-md text-on-surface" for="db-host">DB Host</label>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                           id="db-host" name="db_host" type="text" value="{{ old('db_host', session('project.db_host', '127.0.0.1')) }}" oninput="updateEnvPreview()">
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-label-md text-label-md text-on-surface" for="db-port">DB Port</label>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                           id="db-port" name="db_port" type="text" value="{{ old('db_port', session('project.db_port', '3306')) }}" oninput="updateEnvPreview()">
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-label-md text-label-md text-on-surface" for="db-name">Database Name <span class="text-primary">*</span></label>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <input class="w-full bg-transparent font-code-inline text-code-inline text-primary font-medium focus:outline-none"
                                           id="db-name" name="db_name" type="text" value="{{ old('db_name', session('project.db_name', 'artisan_pos_db')) }}" oninput="updateEnvPreview()">
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-label-md text-label-md text-on-surface" for="db-user">DB Username</label>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                           id="db-user" name="db_user" type="text" value="{{ old('db_user', session('project.db_user', 'root')) }}" oninput="updateEnvPreview()">
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-label-md text-label-md text-on-surface" for="db-pass">DB Password</label>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                           id="db-pass" name="db_pass" type="password" value="{{ old('db_pass', session('project.db_pass', 'secret_local_dev_123')) }}" oninput="updateEnvPreview()">
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-label-md text-label-md text-on-surface" for="db-collation">Charset &amp; Collation</label>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <select class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none cursor-pointer"
                                            id="db-collation" name="db_collation">
                                        <option class="bg-surface-container text-on-surface" selected value="utf8mb4_unicode_ci">utf8mb4_unicode_ci (Standard)</option>
                                        <option class="bg-surface-container text-on-surface" value="utf8mb4_0900_ai_ci">utf8mb4_0900_ai_ci (MySQL 8 Default)</option>
                                        <option class="bg-surface-container text-on-surface" value="utf8mb4_bin">utf8mb4_bin (Binary Exact)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex flex-col justify-center gap-1 md:col-span-2 text-on-surface-variant font-body-sm text-body-sm px-2">
                                <span id="db-driver-hint" class="text-outline">ไดรเวอร์ <span class="text-tertiary font-code-inline" id="hint-driver-name">MySQL</span> พอร์ตเริ่มต้น <span class="text-secondary font-code-inline" id="hint-driver-port">3306</span> สำหรับเชื่อมต่อระบบฐานข้อมูล</span>
                            </div>
                        </div>
                        <div class="p-space-sm rounded-lg bg-surface-container-highest/60 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border border-surface-container-highest transition-colors shadow-sm" id="connection-result">
                            <div class="flex items-center gap-space-sm min-w-0">
                                <span class="w-2.5 h-2.5 rounded-full bg-outline flex-shrink-0" id="result-dot"></span>
                                <span class="font-code-block text-code-block text-on-surface truncate" id="result-msg">กดปุ่ม "Test DB Connection" เพื่อทดสอบการเชื่อมต่อฐานข้อมูลสด</span>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline font-code-inline flex-shrink-0" id="result-latency">STANDBY</span>
                        </div>
                    </div>

                    <!-- Docker Container & Environment Config (BUCC Dev Hub Standard) -->
                    <div id="docker-spec-card" class="bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md border border-primary/30">
                        <div class="flex items-center justify-between pb-space-xs">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-primary text-[20px]">terminal</span>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Docker Container Specification • สภาพแวดล้อม BUCC Dev Hub</h3>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-primary-container text-on-primary-container font-code-inline text-label-sm font-semibold border border-primary/30">BUCC DEVKIT</span>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                            กำหนดค่าคอนเทนเนอร์สำหรับรันระบบด้วยคำสั่ง <code class="text-primary font-code-inline">docker run</code> หรือ <code class="text-secondary font-code-inline">docker compose</code> รองรับการพัฒนา Remote SSH/SFTP ควบคู่เว็บเซิร์ฟเวอร์ Apache PHP 8.4
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                            <!-- 1. Docker Base Image -->
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <label class="font-label-md text-label-md text-on-surface" for="docker-image">1. Docker Base Image <span class="text-primary">*</span></label>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">IMAGE</span>
                                </div>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                           id="docker-image" name="docker_image" type="text"
                                           value="{{ old('docker_image', session('project.docker_image', 'bucchub/php-apache-dev:8.4')) }}"
                                           oninput="updateDockerPreview()">
                                </div>
                                <span class="font-body-sm text-body-sm text-outline">อิมเมจมาตรฐาน BUCC พร้อม Apache2 และ SSH Daemon</span>
                            </div>

                            <!-- 4. Volume Mount Name (Enforced {slug}-code) -->
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <label class="font-label-md text-label-md text-on-surface" for="docker-volume">4. Volume Mount Name <span class="text-primary">*</span></label>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">{slug}-code</span>
                                </div>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <input class="w-full bg-transparent font-code-inline text-code-inline text-primary font-medium focus:outline-none"
                                           id="docker-volume" name="docker_volume" type="text"
                                           value="{{ old('docker_volume', session('project.docker_volume', (session('project.slug', 'artisan-pos-system') . '-code'))) }}"
                                           pattern="^[a-zA-Z0-9_\-]+-code$"
                                           title="ชื่อ Volume ต้องลงท้ายด้วย -code ตามแบบแผน {slug}-code เสมอ"
                                           oninput="updateDockerPreview()">
                                    <span class="material-symbols-outlined text-[18px] text-tertiary ml-1" title="Pattern Enforced">lock</span>
                                </div>
                                <span class="font-body-sm text-body-sm text-outline">แมปเข้า <code class="text-secondary font-code-inline">/var/www/html</code> บังคับลงท้ายด้วย <code class="text-primary font-code-inline">-code</code></span>
                            </div>

                            <!-- 2. HTTPS Port -->
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <label class="font-label-md text-label-md text-on-surface" for="docker-https-port">2. HTTPS Host Port <span class="text-primary">*</span></label>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">-p [HOST]:443</span>
                                </div>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                           id="docker-https-port" name="docker_https_port" type="number" min="1" max="65535"
                                           value="{{ old('docker_https_port', session('project.docker_https_port', 443)) }}"
                                           oninput="onDockerHttpsPortChange(); updateDockerPreview()">
                                </div>
                                <span class="font-body-sm text-body-sm text-outline">Host Port สำหรับเชื่อมต่อ Web SSL (เช่น 443 หรือ 2000)</span>
                            </div>

                            <!-- 3. SSH Port -->
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <label class="font-label-md text-label-md text-on-surface" for="docker-ssh-port">3. SSH / SFTP Host Port <span class="text-primary">*</span></label>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">-p [HOST]:22</span>
                                </div>
                                <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                    <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                           id="docker-ssh-port" name="docker_ssh_port" type="number" min="1" max="65535"
                                           value="{{ old('docker_ssh_port', session('project.docker_ssh_port', 22)) }}"
                                           oninput="updateDockerPreview()">
                                </div>
                                <span class="font-body-sm text-body-sm text-outline">Host Port สำหรับ SSH / SFTP Remote Development (เช่น 22 หรือ 2001)</span>
                            </div>
                        </div>

                        <!-- Live Docker Run Command Preview -->
                        <div class="mt-2 bg-surface-container-lowest rounded-xl p-space-md flex flex-col gap-2 border border-surface-container-highest shadow-sm">
                            <div class="flex items-center justify-between text-outline">
                                <div class="flex items-center gap-1.5 font-label-sm text-label-sm text-primary uppercase font-code-block">
                                    <span class="material-symbols-outlined text-[16px]">play_circle</span>
                                    <span>Generated Docker Run One-Liner Preview</span>
                                </div>
                                <button type="button" onclick="copyDockerRunPreview()" class="text-outline hover:text-on-surface flex items-center gap-1 text-[12px] font-code-inline transition-colors border border-surface-container-highest/60 px-2 py-0.5 rounded cursor-pointer">
                                    <span class="material-symbols-outlined text-[14px]">content_copy</span>
                                    <span id="copy-docker-text">Copy</span>
                                </button>
                            </div>
                            <pre class="m-0 overflow-x-auto text-on-surface font-code-block text-code-block text-[13px] leading-relaxed p-2 rounded bg-surface-container-high/40 border border-surface-container-highest/40"><code id="docker-run-preview-code">docker run --name artisan-pos-system-web --volume=artisan-pos-system-code:/var/www/html -p 443:443 -p 22:22 -t -d bucchub/php-apache-dev:8.4 sh -c "(/usr/sbin/sshd || echo 'SSH not found, continuing...'); apache2-foreground"</code></pre>
                        </div>
                    </div>

                    <!-- UMS BUU Integration & Kong API Gateway Card -->
                    @php
                        $useUmsBuuVal = old('use_ums_buu', session('project.use_ums_buu', false));
                        $umsConfigVal = session('project.ums_config', []);
                    @endphp
                    <div id="ums-spec-card" class="bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md border {{ $useUmsBuuVal ? 'border-tertiary/40' : 'border-surface-container-highest/60' }} transition-all">
                        <div class="flex items-center justify-between pb-space-xs">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-tertiary text-[20px]">hub</span>
                                <div class="flex flex-col">
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">UMS BUU &amp; Kong API Gateway • บูรณาการระบบ ม.บูรพา</h3>
                                    <span class="font-body-sm text-body-sm text-outline">ระบบจัดการผู้ใช้และสิทธิ์กลาง พร้อม Kong Gateway Credentials</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="items-center gap-1.5 px-3 py-1 rounded-lg bg-surface-container-highest hover:bg-surface-bright text-on-surface font-label-md text-label-md transition-colors border border-surface-container-highest shadow-sm cursor-pointer {{ $useUmsBuuVal ? 'flex' : 'hidden' }}"
                                        id="test-ums-connection-btn" onclick="testUmsConnection()" type="button">
                                    <span class="w-2 h-2 rounded-full bg-tertiary" id="test-ums-pulse"></span>
                                    <span id="test-ums-text">Test UMS &amp; Kong Connection</span>
                                </button>
                                <span class="px-2 py-0.5 rounded {{ $useUmsBuuVal ? 'bg-tertiary-container/30 text-tertiary border-tertiary/40' : 'bg-surface-container text-outline border-surface-container-highest' }} font-code-inline text-label-sm font-semibold border" id="badge-ums-step1">
                                    {{ $useUmsBuuVal ? 'ENABLED' : 'OFF' }}
                                </span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="use_ums_buu" id="use-ums-buu" value="1" {{ $useUmsBuuVal ? 'checked' : '' }} onchange="onToggleUmsBuu(this)" class="sr-only peer">
                                    <div class="w-11 h-6 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-tertiary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-tertiary after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                </label>
                            </div>
                        </div>

                        <div class="p-space-sm rounded-lg bg-surface-container-lowest/80 border border-surface-container-highest/60 flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-tertiary text-[18px] shrink-0 mt-0.5">info</span>
                            <p class="font-body-sm text-body-sm text-on-surface-variant m-0">
                                <strong>หมายเหตุความเข้ากันได้ (Mutually Exclusive):</strong> เริ่มต้นเป็น <em>"ไม่เลือก"</em> หากเปิดใช้งานตัวเลือกนี้ ในขั้นตอนที่ 3 ระบบจะ<strong>ล็อกให้เลือกโมดูล UMS BUU</strong> และ<strong>ปิดการเลือกโมดูล BUU LDAP &amp; Active Directory</strong> อัตโนมัติ เพื่อป้องกันการขัดแย้งของฐานผู้ใช้งาน
                            </p>
                        </div>

                        <!-- Form Fields Container (Collapsible) -->
                        <div id="ums-buu-fields" class="{{ $useUmsBuuVal ? 'flex' : 'hidden' }} flex-col gap-space-md pt-space-xs transition-all">
                            <!-- Section: UMS Core Credentials -->
                            <div class="flex items-center justify-between border-b border-surface-container-highest/40 pb-1">
                                <span class="font-label-md text-label-md text-tertiary font-bold flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px]">key</span>
                                    <span>UMS Server Environment (.env &amp; config/constants.php)</span>
                                </span>
                                <span class="font-code-block text-[11px] text-outline">configUms</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                                <!-- UMS_SYSTEM_ID -->
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <label class="font-label-md text-label-md text-on-surface" for="ums-system-id">UMS System ID <span class="text-primary">*</span></label>
                                        <span class="font-label-sm text-label-sm text-outline font-code-inline">SystemID</span>
                                    </div>
                                    <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                        <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                               id="ums-system-id" name="ums_system_id" type="text"
                                               value="{{ old('ums_system_id', $umsConfigVal['system_id'] ?? '149') }}"
                                               placeholder="149" oninput="updateEnvPreview()">
                                    </div>
                                    <span class="font-body-sm text-body-sm text-outline">รหัสระบบที่ลงทะเบียนใน UMS (เช่น 149)</span>
                                </div>

                                <!-- UMS_SERVICE_KEY -->
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <label class="font-label-md text-label-md text-on-surface" for="ums-service-key">UMS Service Key <span class="text-primary">*</span></label>
                                        <span class="font-label-sm text-label-sm text-outline font-code-inline">ServiceKey</span>
                                    </div>
                                    <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                        <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                               id="ums-service-key" name="ums_service_key" type="text"
                                               value="{{ old('ums_service_key', $umsConfigVal['service_key'] ?? '42963d28e7e0996c39d4a1658f8bd763') }}"
                                               placeholder="42963d28e7e0996c39d4a1658f8bd763" oninput="updateEnvPreview()">
                                    </div>
                                    <span class="font-body-sm text-body-sm text-outline">Service Key ประจำระบบที่ออกโดย UMS</span>
                                </div>

                                <!-- UMS_SERVICE_URL -->
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <label class="font-label-md text-label-md text-on-surface" for="ums-service-url">UMS Service URL <span class="text-primary">*</span></label>
                                        <span class="font-label-sm text-label-sm text-outline font-code-inline">ServiceUrl</span>
                                    </div>
                                    <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                        <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                               id="ums-service-url" name="ums_service_url" type="text"
                                               value="{{ old('ums_service_url', $umsConfigVal['service_url'] ?? 'https://ums.buu.ac.th/index.php') }}"
                                               placeholder="https://ums.buu.ac.th/index.php" oninput="updateEnvPreview()">
                                    </div>
                                    <span class="font-body-sm text-body-sm text-outline">URL เซิร์ฟเวอร์ UMS BUU</span>
                                </div>
                            </div>

                            <!-- Section: Kong API Gateway Endpoint & Provision Keys -->
                            <div class="flex items-center justify-between border-b border-surface-container-highest/40 pb-1 mt-1">
                                <span class="font-label-md text-label-md text-secondary font-bold flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px]">dns</span>
                                    <span>Kong Gateway &amp; Provision Keys (config/constants.php kong.api.ums.*)</span>
                                </span>
                                <span class="font-code-block text-[11px] text-outline">kong.api.ums.*</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                                <!-- KONG_DOMAIN_PROD -->
                                <div class="flex flex-col gap-1 md:col-span-2">
                                    <div class="flex items-center justify-between">
                                        <label class="font-label-md text-label-md text-on-surface" for="kong-domain-prod">Kong Domain Production (domain_prod) <span class="text-primary">*</span></label>
                                        <span class="font-label-sm text-label-sm text-secondary font-code-inline">KONG_DOMAIN_PROD</span>
                                    </div>
                                    <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                        <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                               id="kong-domain-prod" name="kong_domain_prod" type="text"
                                               value="{{ old('kong_domain_prod', $umsConfigVal['kong_domain_prod'] ?? 'https://api-gw.buu.ac.th') }}"
                                               placeholder="https://api-gw.buu.ac.th" oninput="updateEnvPreview()">
                                    </div>
                                    <span class="font-body-sm text-body-sm text-outline">โดเมนหลักของ Kong API Gateway สำหรับ Production (ค่าเริ่มต้น: https://api-gw.buu.ac.th)</span>
                                </div>

                                <!-- ums.GLGroupInSystem -->
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <label class="font-label-md text-label-md text-on-surface" for="kong-pk-glgroup">1. ums.GLGroupInSystem</label>
                                        <span class="font-label-sm text-label-sm text-outline font-code-inline">POST (read)</span>
                                    </div>
                                    <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                        <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                               id="kong-pk-glgroup" name="kong_pk_ums_glgroupinsystem" type="text"
                                               value="{{ old('kong_pk_ums_glgroupinsystem', $umsConfigVal['kong_pk_ums_glgroupinsystem'] ?? '') }}"
                                               placeholder="KONG_PK_UMS_GLGROUPINSYSTEM" oninput="updateEnvPreview()">
                                    </div>
                                    <span class="font-body-sm text-body-sm text-outline">Provision Key สำหรับดึงรายชื่อกลุ่มของระบบ (/service-api/ums.GLGroupInSystem)</span>
                                </div>

                                <!-- ums.CUserGroup -->
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <label class="font-label-md text-label-md text-on-surface" for="kong-pk-cusergroup">2. ums.CUserGroup</label>
                                        <span class="font-label-sm text-label-sm text-outline font-code-inline">POST (read)</span>
                                    </div>
                                    <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                        <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                               id="kong-pk-cusergroup" name="kong_pk_ums_cusergroup" type="text"
                                               value="{{ old('kong_pk_ums_cusergroup', $umsConfigVal['kong_pk_ums_cusergroup'] ?? '') }}"
                                               placeholder="KONG_PK_UMS_CUSERGROUP" oninput="updateEnvPreview()">
                                    </div>
                                    <span class="font-body-sm text-body-sm text-outline">Provision Key สำหรับตรวจสอบสิทธิ์เฉพาะระบบ (/service-api/ums.CUserGroup)</span>
                                </div>

                                <!-- ums.GLPersonFromCitizenID -->
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <label class="font-label-md text-label-md text-on-surface" for="kong-pk-glperson">3. ums.GLPersonFromCitizenID</label>
                                        <span class="font-label-sm text-label-sm text-outline font-code-inline">POST (read)</span>
                                    </div>
                                    <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                        <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                               id="kong-pk-glperson" name="kong_pk_ums_glpersonfromcitizenid" type="text"
                                               value="{{ old('kong_pk_ums_glpersonfromcitizenid', $umsConfigVal['kong_pk_ums_glpersonfromcitizenid'] ?? '') }}"
                                               placeholder="KONG_PK_UMS_GLPERSONFROMCITIZENID" oninput="updateEnvPreview()">
                                    </div>
                                    <span class="font-body-sm text-body-sm text-outline">Provision Key สำหรับดึงข้อมูลบุคลากรด้วยเลขบัตรประชาชน (/service-api/ums.GLPersonFromCitizenID)</span>
                                </div>

                                <!-- ums.AUserGroup -->
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center justify-between">
                                        <label class="font-label-md text-label-md text-on-surface" for="kong-pk-ausergroup">4. ums.AUserGroup</label>
                                        <span class="font-label-sm text-label-sm text-outline font-code-inline">POST (write)</span>
                                    </div>
                                    <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                        <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                               id="kong-pk-ausergroup" name="kong_pk_ums_ausergroup" type="text"
                                               value="{{ old('kong_pk_ums_ausergroup', $umsConfigVal['kong_pk_ums_ausergroup'] ?? '') }}"
                                               placeholder="KONG_PK_UMS_AUSERGROUP" oninput="updateEnvPreview()">
                                    </div>
                                    <span class="font-body-sm text-body-sm text-outline">Provision Key สำหรับเพิ่มผู้ใช้งานเข้ากลุ่ม (/service-api/ums.AUserGroup)</span>
                                </div>

                                <!-- ums.DUserGroup -->
                                <div class="flex flex-col gap-1 md:col-span-2">
                                    <div class="flex items-center justify-between">
                                        <label class="font-label-md text-label-md text-on-surface" for="kong-pk-dusergroup">5. ums.DUserGroup</label>
                                        <span class="font-label-sm text-label-sm text-outline font-code-inline">DELETE (read)</span>
                                    </div>
                                    <div class="flex items-center bg-surface-container-lowest rounded-lg px-3 py-2 text-on-surface focus-within:bg-surface-container border border-surface-container-highest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary/20 transition-all shadow-sm">
                                        <input class="w-full bg-transparent font-code-inline text-code-inline text-on-surface focus:outline-none"
                                               id="kong-pk-dusergroup" name="kong_pk_ums_dusergroup" type="text"
                                               value="{{ old('kong_pk_ums_dusergroup', $umsConfigVal['kong_pk_ums_dusergroup'] ?? '') }}"
                                               placeholder="KONG_PK_UMS_DUSERGROUP" oninput="updateEnvPreview()">
                                    </div>
                                    <span class="font-body-sm text-body-sm text-outline">Provision Key สำหรับลบผู้ใช้งานออกจากกลุ่ม (/service-api/ums.DUserGroup)</span>
                                </div>
                            </div>

                            <!-- UMS & Kong Live Connection Test Result -->
                            <div id="ums-connection-result" class="hidden p-space-sm rounded-lg bg-surface-container flex flex-col gap-2 border border-tertiary/30 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2 font-medium" id="ums-result-title">
                                        <span class="w-2.5 h-2.5 rounded-full bg-tertiary" id="ums-result-dot"></span>
                                        <span id="ums-result-msg" class="text-on-surface font-body-sm text-body-sm">สถานะการเชื่อมต่อ UMS &amp; Kong</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-tertiary font-code-inline" id="ums-result-latency"></span>
                                </div>
                                <div class="text-xs text-outline flex flex-col gap-1 pl-4 border-l border-surface-container-highest/60" id="ums-result-details">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right 4 Cols -->
                <div class="lg:col-span-4 flex flex-col gap-space-lg">
                    <!-- Frontend Stack -->
                    <div class="bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md border border-surface-container-highest/60">
                        <div class="flex items-center justify-between pb-space-xs">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-secondary text-[20px]">brush</span>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Frontend Stack &amp; Styling</h3>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline font-code-inline">ASSET PIPELINE</span>
                        </div>
                        <div class="flex flex-col gap-space-sm">
                            <div class="p-space-md rounded-xl bg-surface-container flex flex-col gap-2 border border-surface-container-highest/40 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-headline-sm text-headline-sm text-on-surface font-medium">Bootstrap 5.3.3</span>
                                    <span class="px-2 py-0.5 rounded bg-surface-container-highest text-secondary font-label-sm text-label-sm font-code-inline border border-surface-container-highest">Vite Sass</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">
                                    คอมไพล์ Sass ผ่าน Vite อัตโนมัติ พร้อมสวิตช์ Dark/Light Mode ตามมาตรฐาน Bootstrap Data Attributes
                                </p>
                            </div>
                            <div class="flex flex-col gap-2 pt-space-xs">
                                <label class="font-label-md text-label-md text-on-surface">Icon Library Selection • ชุดไอคอน</label>
                                <label class="flex items-center justify-between p-space-sm rounded-lg bg-surface-container cursor-pointer hover:bg-surface-container-high transition-colors border border-surface-container-highest/50 shadow-sm">
                                    <div class="flex items-center gap-space-sm">
                                        <input {{ old('icon_set', session('project.icon_set', 'bootstrap_icons')) === 'bootstrap_icons' ? 'checked' : '' }} class="accent-primary" name="icon_set" type="radio" value="bootstrap_icons">
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md text-on-surface font-medium">Bootstrap Icons (v1.11)</span>
                                            <span class="font-label-sm text-label-sm text-outline">ติดตั้งเนทีฟ ไม่ต้องเพิ่ม dependency ภายนอก</span>
                                        </div>
                                    </div>
                                    <span class="material-symbols-outlined text-secondary text-[18px]">verified</span>
                                </label>
                                <label class="flex items-center justify-between p-space-sm rounded-lg bg-surface-container cursor-pointer hover:bg-surface-container-high transition-colors border border-surface-container-highest/50 shadow-sm">
                                    <div class="flex items-center gap-space-sm">
                                        <input {{ old('icon_set', session('project.icon_set')) === 'lucide' ? 'checked' : '' }} class="accent-primary" name="icon_set" type="radio" value="lucide">
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md text-on-surface font-medium">Lucide Icons (Blade)</span>
                                            <span class="font-label-sm text-label-sm text-outline">Blade component syntax &lt;x-lucide-... /&gt;</span>
                                        </div>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">MODERN</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Driver Configs -->
                    <div class="bg-surface-container-low rounded-xl p-space-lg shadow-sm flex flex-col gap-space-md border border-surface-container-highest/60">
                        <div class="flex items-center justify-between pb-space-xs">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-primary text-[20px]">settings_suggest</span>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Core Drivers</h3>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline font-code-inline">BOOTSTRAP/APP.PHP</span>
                        </div>
                        <div class="flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between p-space-sm rounded-lg bg-surface-container border border-surface-container-highest/40 shadow-sm">
                                <div class="flex items-center gap-space-sm">
                                    <span class="font-body-md text-body-md text-on-surface">Default Cache Driver</span>
                                    <span class="font-code-block text-[10px] text-outline">CACHE_STORE</span>
                                </div>
                                <select name="cache_driver" id="cache-driver" onchange="updateEnvPreview()" class="bg-surface-container-lowest text-on-surface font-code-inline text-code-inline px-2.5 py-1.5 rounded-lg border border-surface-container-highest focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/20 shadow-sm cursor-pointer">
                                    <option value="database" {{ old('cache_driver', session('project.cache_driver')) === 'database' ? 'selected' : '' }}>database</option>
                                    <option value="redis" {{ old('cache_driver', session('project.cache_driver')) === 'redis' ? 'selected' : '' }}>redis</option>
                                    <option value="file" {{ old('cache_driver', session('project.cache_driver', 'file')) === 'file' ? 'selected' : '' }}>file</option>
                                </select>
                            </div>
                            <div class="flex items-center justify-between p-space-sm rounded-lg bg-surface-container border border-surface-container-highest/40 shadow-sm">
                                <div class="flex items-center gap-space-sm">
                                    <span class="font-body-md text-body-md text-on-surface">Queue Connection</span>
                                    <span class="font-code-block text-[10px] text-outline">QUEUE_CONNECTION</span>
                                </div>
                                <select name="queue_driver" id="queue-driver" onchange="updateEnvPreview()" class="bg-surface-container-lowest text-on-surface font-code-inline text-code-inline px-2.5 py-1.5 rounded-lg border border-surface-container-highest focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/20 shadow-sm cursor-pointer">
                                    <option value="database" {{ old('queue_driver', session('project.queue_driver', 'database')) === 'database' ? 'selected' : '' }}>database</option>
                                    <option value="redis" {{ old('queue_driver', session('project.queue_driver')) === 'redis' ? 'selected' : '' }}>redis</option>
                                    <option value="sync" {{ old('queue_driver', session('project.queue_driver')) === 'sync' ? 'selected' : '' }}>sync</option>
                                </select>
                            </div>
                            <div class="flex items-center justify-between p-space-sm rounded-lg bg-surface-container border border-surface-container-highest/40 shadow-sm">
                                <div class="flex items-center gap-space-sm">
                                    <span class="font-body-md text-body-md text-on-surface">Session Driver</span>
                                    <span class="font-code-block text-[10px] text-outline">SESSION_DRIVER</span>
                                </div>
                                <select name="session_driver" id="session-driver" onchange="updateEnvPreview()" class="bg-surface-container-lowest text-on-surface font-code-inline text-code-inline px-2.5 py-1.5 rounded-lg border border-surface-container-highest focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary/20 shadow-sm cursor-pointer">
                                    <option value="database" {{ old('session_driver', session('project.session_driver')) === 'database' ? 'selected' : '' }}>database</option>
                                    <option value="file" {{ old('session_driver', session('project.session_driver', 'file')) === 'file' ? 'selected' : '' }}>file</option>
                                    <option value="cookie" {{ old('session_driver', session('project.session_driver')) === 'cookie' ? 'selected' : '' }}>cookie</option>
                                    <option value="redis" {{ old('session_driver', session('project.session_driver')) === 'redis' ? 'selected' : '' }}>redis</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Generated .env Preview -->
                    <div id="env-preview-card" class="bg-surface-container-lowest rounded-xl p-space-md flex flex-col gap-2 h-[458px] border border-surface-container-highest/60 shadow-sm">
                        <div class="flex items-center justify-between text-outline flex-shrink-0">
                            <span class="font-label-sm text-label-sm uppercase font-code-block">Generated .env Preview</span>
                            <span class="material-symbols-outlined text-[16px]">terminal</span>
                        </div>
                        <div class="font-code-block text-code-block text-on-surface-variant flex flex-col gap-0.5 overflow-y-auto overflow-x-auto flex-1 pr-1" id="env-preview-box">
                            <div><span class="text-outline">APP_NAME=</span><span class="text-primary" id="env-name">"Artisan POS & Inventory Hub"</span></div>
                            <div><span class="text-outline">APP_ENV=</span><span class="text-tertiary" id="env-env">local</span></div>
                            <div><span class="text-outline">APP_KEY=</span><span class="text-secondary" id="env-key">base64:v84X9J2qK7mP3L0wR1tY5uI6oP8aS0dF2gH4jK6lZ8=</span></div>
                            <div><span class="text-outline">APP_DEBUG=</span><span class="text-primary" id="env-debug">true</span></div>
                            <div><span class="text-outline">APP_TIMEZONE=</span><span class="text-on-surface" id="env-tz">"Asia/Bangkok"</span></div>
                            <div><span class="text-outline">APP_URL=</span><span class="text-on-surface" id="env-url">http://localhost:8000</span></div>
                            <div>&nbsp;</div>
                            <div><span class="text-outline">APP_LOCALE=</span><span class="text-on-surface">en</span></div>
                            <div><span class="text-outline">APP_FALLBACK_LOCALE=</span><span class="text-on-surface">en</span></div>
                            <div><span class="text-outline">APP_FAKER_LOCALE=</span><span class="text-on-surface">en_US</span></div>
                            <div>&nbsp;</div>
                            <div><span class="text-outline">APP_MAINTENANCE_DRIVER=</span><span class="text-tertiary">file</span></div>
                            <div>&nbsp;</div>
                            <div><span class="text-outline">PHP_CLI_SERVER_WORKERS=</span><span class="text-secondary">4</span></div>
                            <div>&nbsp;</div>
                            <div><span class="text-outline">HASH_DRIVER=</span><span class="text-secondary">argon2id</span></div>
                            <div>&nbsp;</div>
                            <div><span class="text-outline">LOG_CHANNEL=</span><span class="text-tertiary" id="env-log-channel">daily</span></div>
                            <div><span class="text-outline">LOG_STACK=</span><span class="text-on-surface">single</span></div>
                            <div><span class="text-outline">LOG_DEPRECATIONS_CHANNEL=</span><span class="text-outline">null</span></div>
                            <div><span class="text-outline">LOG_LEVEL=</span><span class="text-primary" id="env-log-level">debug</span></div>
                            <div>&nbsp;</div>
                            <div><span class="text-outline">DB_CONNECTION=</span><span class="text-secondary font-medium" id="env-db-connection">mysql</span></div>
                            <div><span class="text-outline">DB_HOST=</span><span class="text-on-surface" id="env-db-host">127.0.0.1</span></div>
                            <div><span class="text-outline">DB_PORT=</span><span class="text-on-surface" id="env-db-port">3306</span></div>
                            <div><span class="text-outline">DB_DATABASE=</span><span class="text-primary" id="env-db-name">artisan_pos_db</span></div>
                            <div><span class="text-outline">DB_USERNAME=</span><span class="text-on-surface" id="env-db-user">root</span></div>
                            <div><span class="text-outline">DB_PASSWORD=</span><span class="text-outline">••••••••</span></div>
                            <div>&nbsp;</div>
                            <div><span class="text-outline">SESSION_DRIVER=</span><span class="text-tertiary" id="env-session">file</span></div>
                            <div><span class="text-outline">SESSION_LIFETIME=</span><span class="text-secondary">120</span></div>
                            <div><span class="text-outline">SESSION_ENCRYPT=</span><span class="text-on-surface">false</span></div>
                            <div><span class="text-outline">SESSION_PATH=</span><span class="text-on-surface">/</span></div>
                            <div><span class="text-outline">SESSION_DOMAIN=</span><span class="text-outline">null</span></div>
                            <div>&nbsp;</div>
                            <div><span class="text-outline">BROADCAST_CONNECTION=</span><span class="text-tertiary">log</span></div>
                            <div><span class="text-outline">FILESYSTEM_DISK=</span><span class="text-tertiary">local</span></div>
                            <div><span class="text-outline">QUEUE_CONNECTION=</span><span class="text-secondary font-medium" id="env-queue">database</span></div>
                            <div>&nbsp;</div>
                            <div><span class="text-outline">CACHE_STORE=</span><span class="text-tertiary" id="env-cache">file</span></div>
                            <div><span class="text-outline"># CACHE_PREFIX=</span></div>
                            <div>&nbsp;</div>
                            <div><span class="text-outline">VITE_APP_NAME=</span><span class="text-primary" id="env-vite-name">"${APP_NAME}"</span></div>
                            <div id="env-preview-ums-block" class="{{ $useUmsBuuVal ? 'flex' : 'hidden' }} flex-col gap-0.5">
                                <div>&nbsp;</div>
                                <div class="text-secondary font-bold"># UMS</div>
                                <div><span class="text-outline">UMS_SYSTEM_ID=</span><span class="text-tertiary" id="env-ums-system-id">{{ $umsConfigVal['system_id'] ?? '149' }}</span></div>
                                <div><span class="text-outline">UMS_SERVICE_KEY=</span><span class="text-on-surface" id="env-ums-service-key">{{ $umsConfigVal['service_key'] ?? '42963d28e7e0996c39d4a1658f8bd763' }}</span></div>
                                <div><span class="text-outline">UMS_SERVICE_URL=</span><span class="text-on-surface" id="env-ums-service-url">{{ $umsConfigVal['service_url'] ?? 'https://ums.buu.ac.th/index.php' }}</span></div>
                                <div>&nbsp;</div>
                                <div class="text-secondary font-bold"># KONG API GATEWAY</div>
                                <div><span class="text-outline">KONG_DOMAIN_PROD=</span><span class="text-secondary font-medium" id="env-kong-domain-prod">{{ $umsConfigVal['kong_domain_prod'] ?? 'https://api-gw.buu.ac.th' }}</span></div>
                                <div><span class="text-outline">KONG_PK_UMS_GLGROUPINSYSTEM=</span><span class="text-outline font-code-inline" id="env-kong-pk-glgroup">{{ $umsConfigVal['kong_pk_ums_glgroupinsystem'] ?? '' }}</span></div>
                                <div><span class="text-outline">KONG_PK_UMS_CUSERGROUP=</span><span class="text-outline font-code-inline" id="env-kong-pk-cusergroup">{{ $umsConfigVal['kong_pk_ums_cusergroup'] ?? '' }}</span></div>
                                <div><span class="text-outline">KONG_PK_UMS_GLPERSONFROMCITIZENID=</span><span class="text-outline font-code-inline" id="env-kong-pk-glperson">{{ $umsConfigVal['kong_pk_ums_glpersonfromcitizenid'] ?? '' }}</span></div>
                                <div><span class="text-outline">KONG_PK_UMS_AUSERGROUP=</span><span class="text-outline font-code-inline" id="env-kong-pk-ausergroup">{{ $umsConfigVal['kong_pk_ums_ausergroup'] ?? '' }}</span></div>
                                <div><span class="text-outline">KONG_PK_UMS_DUSERGROUP=</span><span class="text-outline font-code-inline" id="env-kong-pk-dusergroup">{{ $umsConfigVal['kong_pk_ums_dusergroup'] ?? '' }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Navigation -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-space-md pt-space-xl pb-space-lg">
                <div class="flex items-center gap-space-sm flex-wrap sm:flex-nowrap">
                    <button type="button" onclick="resetDefaultsWithConfirm()" class="w-full sm:w-auto flex items-center justify-center gap-space-xs px-space-lg py-2.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-body-md text-body-md transition-colors shadow-sm border border-surface-container-highest/60 cursor-pointer">
                        <span class="material-symbols-outlined text-[18px]">restart_alt</span>
                        <span>Reset Defaults</span>
                    </button>
                    <button id="btn-save-preset" onclick="openSavePresetModal()" class="w-full sm:w-auto flex items-center justify-center gap-space-xs px-space-md py-2.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface font-body-md text-body-md transition-colors shadow-sm border border-surface-container-highest/60 cursor-pointer" type="button">
                        <span class="material-symbols-outlined text-[18px] text-primary">bookmark_add</span>
                        <span>Save as Preset</span>
                    </button>
                    <button id="btn-load-preset" onclick="openLoadPresetModal()" class="w-full sm:w-auto flex items-center justify-center gap-space-xs px-space-md py-2.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface font-body-md text-body-md transition-colors shadow-sm border border-surface-container-highest/60 cursor-pointer" type="button">
                        <span class="material-symbols-outlined text-[18px] text-secondary">folder_special</span>
                        <span>โหลดแม่แบบ (<span id="preset-count" class="font-bold text-primary">0</span>)</span>
                    </button>
                    <div id="bottom-active-preset-chip" class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-lg bg-surface-container border border-tertiary/30 text-xs font-code-inline text-outline shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-tertiary shadow-[0_0_6px_rgba(78,222,163,0.8)]"></span>
                        <span>Preset:</span>
                        <span id="bottom-active-preset-name" class="font-semibold text-tertiary truncate max-w-[160px]">{{ !empty($activePreset['name']) ? $activePreset['name'] : 'None (Custom)' }}</span>
                    </div>
                </div>
                <button type="submit" class="btn-artisan-continue w-full sm:w-auto flex items-center justify-center gap-space-xs px-space-xl py-2.5 rounded-lg bg-primary-container hover:bg-inverse-primary text-on-primary font-headline-sm text-headline-sm font-medium transition-all shadow-[0_0_20px_rgba(255,85,66,0.3)] cursor-pointer">
                    <span>Continue: 2. Packages &amp; Libraries</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function generateAppKey() {
        const bytes = new Uint8Array(32);
        window.crypto.getRandomValues(bytes);
        let binary = '';
        for (let i = 0; i < bytes.byteLength; i++) {
            binary += String.fromCharCode(bytes[i]);
        }
        const newKey = 'base64:' + btoa(binary);
        const keyInput = document.getElementById('app-key');
        if (keyInput) {
            keyInput.value = newKey;
        }
        updateEnvPreview();
        const setupForm = document.getElementById('setup-form');
        if (setupForm) {
            setupForm.dispatchEvent(new Event('input', { bubbles: true }));
        }
    }

    function getEffectiveDbConnection() {
        const connSelect = document.getElementById('db-connection');
        const driver = connSelect ? connSelect.value : 'mysql';
        if (driver === 'custom') {
            const customVal = (document.getElementById('db-connection-custom')?.value || '').trim();
            return customVal || 'custom';
        }
        return driver;
    }

    function onDbConnectionChange(autoPort = true) {
        const connSelect = document.getElementById('db-connection');
        const driver = connSelect ? connSelect.value : 'mysql';
        const customWrapper = document.getElementById('custom-db-driver-wrapper');
        const customInput = document.getElementById('db-connection-custom');
        const portInput = document.getElementById('db-port');
        const engineTitle = document.getElementById('db-engine-title');
        const hintDriverName = document.getElementById('hint-driver-name');
        const hintDriverPort = document.getElementById('hint-driver-port');

        if (driver === 'custom') {
            if (customWrapper) customWrapper.classList.remove('hidden');
            if (customInput && autoPort) {
                setTimeout(() => customInput.focus(), 50);
            }
            const customName = (customInput?.value || '').trim() || 'Custom';
            if (engineTitle) engineTitle.textContent = `Database Engine (${customName})`;
            if (hintDriverName) hintDriverName.textContent = customName;
            if (hintDriverPort) hintDriverPort.textContent = portInput?.value || 'กำหนดเอง';
            updateEnvPreview();
            return;
        } else {
            if (customWrapper) customWrapper.classList.add('hidden');
        }

        const driverMeta = {
            mysql: { title: 'Database Engine (MySQL 8.4 LTS)', port: '3306', name: 'MySQL' },
            mariadb: { title: 'Database Engine (MariaDB 11.x)', port: '3306', name: 'MariaDB' },
            pgsql: { title: 'Database Engine (PostgreSQL 15+)', port: '5432', name: 'PostgreSQL' },
            sqlite: { title: 'Database Engine (SQLite 3 File/Memory)', port: '', name: 'SQLite 3' },
            sqlsrv: { title: 'Database Engine (Microsoft SQL Server)', port: '1433', name: 'MS SQL Server' },
            oracle: { title: 'Database Engine (Oracle Database)', port: '1521', name: 'Oracle Database' },
        };

        const meta = driverMeta[driver] || driverMeta.mysql;
        if (engineTitle) engineTitle.textContent = meta.title;
        if (hintDriverName) hintDriverName.textContent = meta.name;
        if (hintDriverPort) hintDriverPort.textContent = meta.port ? meta.port : 'N/A (Local File)';

        if (autoPort && portInput) {
            portInput.value = meta.port;
        }

        if (driver === 'sqlite') {
            const dbNameInput = document.getElementById('db-name');
            if (dbNameInput && (!dbNameInput.value || dbNameInput.value === 'artisan_pos_db')) {
                dbNameInput.value = 'database/database.sqlite';
            }
        }

        updateEnvPreview();
    }

    function onCustomDbDriverInput() {
        const customInput = document.getElementById('db-connection-custom');
        const customVal = customInput ? customInput.value.trim() : '';
        const engineTitle = document.getElementById('db-engine-title');
        const hintDriverName = document.getElementById('hint-driver-name');
        
        if (engineTitle) engineTitle.textContent = `Database Engine (${customVal || 'Custom Driver'})`;
        if (hintDriverName) hintDriverName.textContent = customVal || 'Custom Driver';
        
        updateEnvPreview();
    }

    function updateEnvPreview() {
        const title = document.getElementById('app-title')?.value || 'Laravel';
        const env = document.getElementById('app-env')?.value || 'local';
        const key = document.getElementById('app-key')?.value || 'base64:v84X9J2qK7mP3L0wR1tY5uI6oP8aS0dF2gH4jK6lZ8=';
        const url = document.getElementById('app-url')?.value || 'http://localhost:8000';
        const tz = document.getElementById('app-tz')?.value || 'Asia/Bangkok';
        const logChannel = document.getElementById('app-log-channel')?.value || 'stack';
        const dbConn = getEffectiveDbConnection();
        const dbHost = document.getElementById('db-host')?.value || '127.0.0.1';
        const dbPort = document.getElementById('db-port')?.value || '3306';
        const dbName = document.getElementById('db-name')?.value || 'laravel';
        const dbUser = document.getElementById('db-user')?.value || 'root';
        const cache = document.getElementById('cache-driver')?.value || 'file';
        const queue = document.getElementById('queue-driver')?.value || 'database';
        const session = document.getElementById('session-driver')?.value || 'file';

        const isDebug = env !== 'production';
        const logLevel = env === 'production' ? 'info' : 'debug';

        if (document.getElementById('env-name')) document.getElementById('env-name').innerText = `"${title}"`;
        if (document.getElementById('env-env')) document.getElementById('env-env').innerText = env;
        if (document.getElementById('env-key')) document.getElementById('env-key').innerText = key;
        if (document.getElementById('env-debug')) document.getElementById('env-debug').innerText = isDebug ? 'true' : 'false';
        if (document.getElementById('env-url')) document.getElementById('env-url').innerText = url;
        if (document.getElementById('env-tz')) document.getElementById('env-tz').innerText = `"${tz}"`;
        if (document.getElementById('env-log-channel')) document.getElementById('env-log-channel').innerText = logChannel;
        if (document.getElementById('env-log-level')) document.getElementById('env-log-level').innerText = logLevel;
        if (document.getElementById('env-db-connection')) document.getElementById('env-db-connection').innerText = dbConn;
        if (document.getElementById('env-db-host')) document.getElementById('env-db-host').innerText = dbHost;
        if (document.getElementById('env-db-port')) document.getElementById('env-db-port').innerText = dbPort;
        if (document.getElementById('env-db-name')) document.getElementById('env-db-name').innerText = dbName;
        if (document.getElementById('env-db-user')) document.getElementById('env-db-user').innerText = dbUser;
        if (document.getElementById('env-cache')) document.getElementById('env-cache').innerText = cache;
        if (document.getElementById('env-queue')) document.getElementById('env-queue').innerText = queue;
        if (document.getElementById('env-session')) document.getElementById('env-session').innerText = session;
        if (document.getElementById('env-vite-name')) document.getElementById('env-vite-name').innerText = '"${APP_NAME}"';

        const useUms = document.getElementById('use-ums-buu')?.checked;
        const umsBlock = document.getElementById('env-preview-ums-block');
        if (umsBlock) {
            if (useUms) {
                umsBlock.classList.remove('hidden');
                umsBlock.classList.add('flex');
                const sysId = document.getElementById('ums-system-id')?.value || '149';
                const sKey = document.getElementById('ums-service-key')?.value || '42963d28e7e0996c39d4a1658f8bd763';
                const sUrl = document.getElementById('ums-service-url')?.value || 'https://ums.buu.ac.th/index.php';
                const kongDomain = document.getElementById('kong-domain-prod')?.value || 'https://api-gw.buu.ac.th';
                const pk1 = document.getElementById('kong-pk-glgroup')?.value || '';
                const pk2 = document.getElementById('kong-pk-cusergroup')?.value || '';
                const pk3 = document.getElementById('kong-pk-glperson')?.value || '';
                const pk4 = document.getElementById('kong-pk-ausergroup')?.value || '';
                const pk5 = document.getElementById('kong-pk-dusergroup')?.value || '';

                if (document.getElementById('env-ums-system-id')) document.getElementById('env-ums-system-id').innerText = sysId;
                if (document.getElementById('env-ums-service-key')) document.getElementById('env-ums-service-key').innerText = sKey;
                if (document.getElementById('env-ums-service-url')) document.getElementById('env-ums-service-url').innerText = sUrl;
                if (document.getElementById('env-kong-domain-prod')) document.getElementById('env-kong-domain-prod').innerText = kongDomain;
                if (document.getElementById('env-kong-pk-glgroup')) document.getElementById('env-kong-pk-glgroup').innerText = pk1;
                if (document.getElementById('env-kong-pk-cusergroup')) document.getElementById('env-kong-pk-cusergroup').innerText = pk2;
                if (document.getElementById('env-kong-pk-glperson')) document.getElementById('env-kong-pk-glperson').innerText = pk3;
                if (document.getElementById('env-kong-pk-ausergroup')) document.getElementById('env-kong-pk-ausergroup').innerText = pk4;
                if (document.getElementById('env-kong-pk-dusergroup')) document.getElementById('env-kong-pk-dusergroup').innerText = pk5;
            } else {
                umsBlock.classList.add('hidden');
                umsBlock.classList.remove('flex');
            }
        }

        syncEnvCardHeight();
    }

    function onToggleUmsBuu(checkbox) {
        const fields = document.getElementById('ums-buu-fields');
        const badge = document.getElementById('badge-ums-step1');
        const card = document.getElementById('ums-spec-card');
        const testBtn = document.getElementById('test-ums-connection-btn');

        if (checkbox.checked) {
            if (fields) { fields.classList.remove('hidden'); fields.classList.add('flex'); }
            if (testBtn) { testBtn.classList.remove('hidden'); testBtn.classList.add('flex'); }
            if (badge) {
                badge.textContent = 'ENABLED';
                badge.className = 'px-2 py-0.5 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-label-sm font-semibold border border-tertiary/40';
            }
            if (card) {
                card.classList.remove('border-surface-container-highest/60');
                card.classList.add('border-tertiary/40');
            }
        } else {
            if (fields) { fields.classList.add('hidden'); fields.classList.remove('flex'); }
            if (testBtn) { testBtn.classList.add('hidden'); testBtn.classList.remove('flex'); }
            if (badge) {
                badge.textContent = 'OFF';
                badge.className = 'px-2 py-0.5 rounded bg-surface-container text-outline font-code-inline text-label-sm font-semibold border border-surface-container-highest';
            }
            if (card) {
                card.classList.add('border-surface-container-highest/60');
                card.classList.remove('border-tertiary/40');
            }
        }
        updateEnvPreview();
        syncEnvCardHeight();
    }

    function syncEnvCardHeight() {
        const lastLeftCard = document.getElementById('ums-spec-card') || document.getElementById('docker-spec-card');
        const envCard = document.getElementById('env-preview-card');
        if (lastLeftCard && envCard && window.innerWidth >= 1024) {
            // Reset height first to get natural positioning
            envCard.style.height = '';
            const lastRect = lastLeftCard.getBoundingClientRect();
            const envRect = envCard.getBoundingClientRect();
            
            // Calculate target height so that bottom of envCard aligns with bottom of lastLeftCard
            const targetHeight = Math.round(lastRect.bottom - envRect.top);
            if (targetHeight > 200) {
                envCard.style.height = `${targetHeight}px`;
            } else {
                envCard.style.height = `${lastLeftCard.offsetHeight}px`;
            }
        } else if (envCard) {
            envCard.style.height = '';
        }
    }

    async function testDbConnection() {
        const pulse = document.getElementById('test-pulse');
        const text = document.getElementById('test-text');
        const resultBox = document.getElementById('connection-result');
        const resultDot = document.getElementById('result-dot');
        const resultMsg = document.getElementById('result-msg');
        const resultLatency = document.getElementById('result-latency');
        const btn = document.getElementById('test-connection-btn');

        const dbConn = getEffectiveDbConnection();
        const dbHost = (document.getElementById('db-host')?.value || '').trim();
        const dbPort = (document.getElementById('db-port')?.value || '').trim();
        const dbName = (document.getElementById('db-name')?.value || '').trim();
        const dbUser = (document.getElementById('db-user')?.value || '').trim();
        const dbPass = document.getElementById('db-pass')?.value || '';

        if (dbConn !== 'sqlite' && (!dbHost || !dbPort || !dbUser)) {
            if (window.ArtisanSwal) {
                ArtisanSwal.fire({
                    icon: 'warning',
                    title: 'กรุณาระบุข้อมูลให้ครบถ้วน',
                    text: 'จำเป็นต้องระบุ DB Host, Port และ DB Username เพื่อทดสอบการเชื่อมต่อ'
                });
            } else {
                alert('กรุณาระบุ DB Host, Port และ DB Username');
            }
            return;
        }

        // Set Loading State
        btn.disabled = true;
        btn.classList.add('opacity-75');
        text.innerText = 'Connecting...';
        pulse.className = 'w-2 h-2 rounded-full bg-primary animate-ping';
        if (resultDot) resultDot.className = 'w-2.5 h-2.5 rounded-full bg-primary animate-pulse flex-shrink-0';
        if (resultMsg) resultMsg.innerText = dbConn === 'sqlite' 
            ? 'กำลังตรวจสอบ SQLite Driver ภายในรันไทม์ ...'
            : `กำลังทดสอบการเชื่อมต่อ ${dbConn.toUpperCase()} Socket ไปที่ ${dbHost}:${dbPort} ...`;
        if (resultLatency) {
            resultLatency.innerText = 'PROBING...';
            resultLatency.className = 'font-label-sm text-label-sm text-primary font-code-inline flex-shrink-0';
        }

        const csrfToken = document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}';

        try {
            const resp = await fetch('{{ route('generator.testDb') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    db_connection: dbConn,
                    db_host: dbHost,
                    db_port: dbPort,
                    db_name: dbName,
                    db_user: dbUser,
                    db_pass: dbPass
                })
            });

            const data = await resp.json();

            btn.disabled = false;
            btn.classList.remove('opacity-75');

            if (data.success) {
                // Success State
                pulse.className = 'w-2 h-2 rounded-full bg-tertiary';
                text.innerText = 'Connection Verified';
                if (resultDot) resultDot.className = 'w-2.5 h-2.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(78,222,163,0.8)] flex-shrink-0';
                if (resultBox) resultBox.className = 'p-space-sm rounded-lg bg-surface-container flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border border-tertiary/30 transition-colors';
                if (resultMsg) resultMsg.innerText = data.message;
                if (resultLatency) {
                    resultLatency.innerText = `LATENCY ${data.latency_ms}ms`;
                    resultLatency.className = 'font-label-sm text-label-sm text-tertiary font-code-inline flex-shrink-0';
                }

                if (window.ArtisanSwal) {
                    ArtisanSwal.fire({
                        icon: 'success',
                        title: 'เชื่อมต่อฐานข้อมูลสำเร็จ!',
                        html: `
                            <div class="text-left font-body-sm leading-relaxed">
                                <div class="mb-2 text-on-surface font-semibold text-tertiary">✔ เชื่อมต่อ MySQL Socket สำเร็จ</div>
                                <div class="text-xs text-outline mb-1"><b>เวอร์ชัน:</b> MySQL v${escapeHtml(data.version)}</div>
                                <div class="text-xs text-outline mb-1"><b>สถานะฐานข้อมูล:</b> ${escapeHtml(data.database_message || 'พร้อมใช้งาน')}</div>
                                <div class="text-xs text-outline"><b>ความเร็ว Latency:</b> ${data.latency_ms} ms (${escapeHtml(data.active_host || dbHost)})</div>
                            </div>
                        `,
                        confirmButtonText: 'ตกลง',
                        timer: 3500
                    });
                }
            } else {
                // Failed State
                pulse.className = 'w-2 h-2 rounded-full bg-error';
                text.innerText = 'Connection Failed';
                if (resultDot) resultDot.className = 'w-2.5 h-2.5 rounded-full bg-error shadow-[0_0_8px_rgba(255,85,66,0.8)] flex-shrink-0';
                if (resultBox) resultBox.className = 'p-space-sm rounded-lg bg-surface-container flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border border-error/40 transition-colors';
                if (resultMsg) resultMsg.innerText = `ล้มเหลว: ${data.message}`;
                if (resultLatency) {
                    resultLatency.innerText = `ERR ${data.latency_ms}ms`;
                    resultLatency.className = 'font-label-sm text-label-sm text-error font-code-inline flex-shrink-0';
                }

                if (window.ArtisanSwal) {
                    ArtisanSwal.fire({
                        icon: 'error',
                        title: 'การเชื่อมต่อฐานข้อมูลล้มเหลว',
                        html: `
                            <div class="text-left font-body-sm leading-relaxed">
                                <div class="text-error font-semibold mb-2">${escapeHtml(data.message)}</div>
                                <div class="p-2 rounded bg-surface-container-lowest font-code-block text-xs text-outline overflow-x-auto">
                                    ${escapeHtml(data.raw_error || 'Connection refused or host unreachable')}
                                </div>
                                <div class="text-xs text-outline mt-2">
                                    กรุณาตรวจสอบว่า Service MySQL เปิดอยู่ และ Host, Port, Username, Password ถูกต้อง
                                </div>
                            </div>
                        `,
                        confirmButtonText: 'รับทราบ'
                    });
                }
            }
        } catch (err) {
            btn.disabled = false;
            btn.classList.remove('opacity-75');
            pulse.className = 'w-2 h-2 rounded-full bg-error';
            text.innerText = 'Connection Failed';
            if (resultDot) resultDot.className = 'w-2.5 h-2.5 rounded-full bg-error flex-shrink-0';
            if (resultMsg) resultMsg.innerText = `เกิดข้อผิดพลาดในการส่งคำขอ: ${err.message}`;
            if (resultLatency) {
                resultLatency.innerText = 'ERR';
                resultLatency.className = 'font-label-sm text-label-sm text-error font-code-inline flex-shrink-0';
            }
        }
    }

    async function testUmsConnection() {
        const pulse = document.getElementById('test-ums-pulse');
        const text = document.getElementById('test-ums-text');
        const resultBox = document.getElementById('ums-connection-result');
        const resultDot = document.getElementById('ums-result-dot');
        const resultMsg = document.getElementById('ums-result-msg');
        const resultLatency = document.getElementById('ums-result-latency');
        const resultDetails = document.getElementById('ums-result-details');
        const btn = document.getElementById('test-ums-connection-btn');

        const systemId = (document.getElementById('ums-system-id')?.value || '').trim();
        const serviceKey = (document.getElementById('ums-service-key')?.value || '').trim();
        const serviceUrl = (document.getElementById('ums-service-url')?.value || '').trim();
        const kongDomain = (document.getElementById('kong-domain-prod')?.value || '').trim();

        if (!systemId || !serviceKey) {
            if (window.ArtisanSwal) {
                ArtisanSwal.fire({
                    icon: 'warning',
                    title: 'กรุณาระบุข้อมูลให้ครบถ้วน',
                    text: 'จำเป็นต้องระบุ UMS System ID และ UMS Service Key เพื่อทดสอบการเชื่อมต่อ'
                });
            } else {
                alert('กรุณาระบุ UMS System ID และ UMS Service Key');
            }
            return;
        }

        // Set Loading State
        btn.disabled = true;
        btn.classList.add('opacity-75');
        text.innerText = 'Connecting UMS & Kong...';
        pulse.className = 'w-2 h-2 rounded-full bg-primary animate-ping';
        if (resultBox) {
            resultBox.classList.remove('hidden');
            resultBox.className = 'p-space-sm rounded-lg bg-surface-container flex flex-col gap-2 border border-primary/30 transition-colors';
        }
        if (resultDot) resultDot.className = 'w-2.5 h-2.5 rounded-full bg-primary animate-pulse flex-shrink-0';
        if (resultMsg) resultMsg.innerText = `กำลังทดสอบการเชื่อมต่อไปยัง UMS Gateway (${serviceUrl}) และ Kong Gateway (${kongDomain}) ...`;
        if (resultLatency) {
            resultLatency.innerText = 'PROBING...';
            resultLatency.className = 'font-label-sm text-label-sm text-primary font-code-inline flex-shrink-0';
        }
        if (resultDetails) resultDetails.innerHTML = '';

        const csrfToken = document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}';

        try {
            const resp = await fetch('{{ route('generator.testUms') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    ums_system_id: systemId,
                    ums_service_key: serviceKey,
                    ums_service_url: serviceUrl,
                    kong_domain_prod: kongDomain
                })
            });

            const data = await resp.json();

            btn.disabled = false;
            btn.classList.remove('opacity-75');

            if (data.success) {
                // Success State
                pulse.className = 'w-2 h-2 rounded-full bg-tertiary';
                text.innerText = 'UMS & Kong Verified';
                if (resultDot) resultDot.className = 'w-2.5 h-2.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(78,222,163,0.8)] flex-shrink-0';
                if (resultBox) resultBox.className = 'p-space-sm rounded-lg bg-surface-container flex flex-col gap-2 border border-tertiary/30 transition-colors';
                if (resultMsg) resultMsg.innerText = data.message;
                if (resultLatency) {
                    resultLatency.innerText = `LATENCY ${data.latency_ms}ms`;
                    resultLatency.className = 'font-label-sm text-label-sm text-tertiary font-code-inline flex-shrink-0';
                }
                if (resultDetails) {
                    let groupList = (data.groups || []).map(g => `<span class="px-1.5 py-0.5 rounded bg-surface-container-highest text-on-surface-variant">${escapeHtml(g)}</span>`).join(' ');
                    resultDetails.innerHTML = `
                        <div>✔ <b>UMS Gateway:</b> ${escapeHtml(data.ums_message)}</div>
                        <div>✔ <b>Kong API Gateway:</b> ${escapeHtml(data.kong_message)}</div>
                        ${groupList ? `<div class="mt-1"><b>ตัวอย่างกลุ่มสิทธิ์:</b> ${groupList}</div>` : ''}
                    `;
                }

                if (window.ArtisanSwal) {
                    ArtisanSwal.fire({
                        icon: 'success',
                        title: 'เชื่อมต่อ UMS & Kong สำเร็จ!',
                        html: `
                            <div class="text-left font-body-sm leading-relaxed">
                                <div class="mb-2 text-on-surface font-semibold text-tertiary">✔ UMS Central Gateway &amp; Kong ตอบกลับปกติ</div>
                                <div class="text-xs text-outline mb-1"><b>ระบบ SystemID:</b> ${escapeHtml(systemId)} (${data.groups_count || 0} กลุ่มสิทธิ์)</div>
                                <div class="text-xs text-outline mb-1"><b>Kong Gateway:</b> ${escapeHtml(data.kong_message || 'พร้อมให้บริการ')}</div>
                                <div class="text-xs text-outline"><b>ความเร็ว Latency:</b> ${data.latency_ms} ms</div>
                            </div>
                        `,
                        confirmButtonText: 'ตกลง',
                        timer: 4000
                    });
                }
            } else {
                // Failed State
                pulse.className = 'w-2 h-2 rounded-full bg-error';
                text.innerText = 'Connection Failed';
                if (resultDot) resultDot.className = 'w-2.5 h-2.5 rounded-full bg-error shadow-[0_0_8px_rgba(255,85,66,0.8)] flex-shrink-0';
                if (resultBox) resultBox.className = 'p-space-sm rounded-lg bg-surface-container flex flex-col gap-2 border border-error/40 transition-colors';
                if (resultMsg) resultMsg.innerText = `ล้มเหลว: ${data.message}`;
                if (resultLatency) {
                    resultLatency.innerText = `ERR ${data.latency_ms || 0}ms`;
                    resultLatency.className = 'font-label-sm text-label-sm text-error font-code-inline flex-shrink-0';
                }
                if (resultDetails) {
                    resultDetails.innerHTML = `
                        <div class="text-error">✖ <b>UMS Gateway:</b> ${escapeHtml(data.ums_message || data.message)}</div>
                        ${data.kong_message ? `<div>${data.kong_status === 'reachable' ? '✔' : '✖'} <b>Kong Gateway:</b> ${escapeHtml(data.kong_message)}</div>` : ''}
                    `;
                }

                if (window.ArtisanSwal) {
                    ArtisanSwal.fire({
                        icon: 'error',
                        title: 'การเชื่อมต่อ UMS BUU ล้มเหลว',
                        html: `
                            <div class="text-left font-body-sm leading-relaxed">
                                <div class="mb-2 text-error font-semibold">${escapeHtml(data.message)}</div>
                                <div class="text-xs text-outline mb-1"><b>เซิร์ฟเวอร์เป้าหมาย:</b> ${escapeHtml(serviceUrl)} (SystemID: ${escapeHtml(systemId)})</div>
                                <div class="text-xs text-outline mb-1"><b>Kong Gateway:</b> ${escapeHtml(data.kong_message || 'ไม่ได้เชื่อมต่อ')}</div>
                                <div class="text-xs text-outline">กรุณาตรวจสอบว่าอยู่ในเครือข่ายภายใน ม.บูรพา (BUU Network / VPN) หรือ Service Key ถูกต้อง</div>
                            </div>
                        `,
                        confirmButtonText: 'ปิด'
                    });
                }
            }
        } catch (err) {
            btn.disabled = false;
            btn.classList.remove('opacity-75');
            pulse.className = 'w-2 h-2 rounded-full bg-error';
            text.innerText = 'Network Error';
            if (resultDot) resultDot.className = 'w-2.5 h-2.5 rounded-full bg-error flex-shrink-0';
            if (resultMsg) resultMsg.innerText = `ข้อผิดพลาดเครือข่าย: ${err.message}`;
            if (resultLatency) resultLatency.innerText = 'OFFLINE';
        }
    }

    function onRuntimeVersionChange() {
        const laravelSelect = document.getElementById('laravel-version');
        const phpSelect = document.getElementById('php-version');
        const laravelVer = (laravelSelect ? laravelSelect.value : '') || '13.x';
        const phpVer = (phpSelect ? phpSelect.value : '') || '8.4';

        const badgeLaravel = document.getElementById('badge-laravel-version');
        const badgePhp = document.getElementById('badge-php-version');
        if (badgeLaravel) badgeLaravel.textContent = `Laravel ${laravelVer}`;
        if (badgePhp) badgePhp.textContent = `PHP ${phpVer}`;

        const dockerImageInput = document.getElementById('docker-image');
        if (dockerImageInput) {
            const currentImg = dockerImageInput.value.trim();
            if (!currentImg || currentImg.startsWith('bucchub/php-apache-dev:')) {
                dockerImageInput.value = `bucchub/php-apache-dev:${phpVer}`;
            }
        }

        updateDockerPreview();
        updateEnvPreview();
    }

    function updateDockerPreview() {
        const slugInput = document.getElementById('project-name');
        const slug = (slugInput ? slugInput.value.trim() : '') || 'artisan-pos-system';
        const phpVer = document.getElementById('php-version')?.value || '8.4';
        const image = (document.getElementById('docker-image').value.trim()) || `bucchub/php-apache-dev:${phpVer}`;
        const httpsPort = (document.getElementById('docker-https-port').value.trim()) || '443';
        const sshPort = (document.getElementById('docker-ssh-port').value.trim()) || '22';
        const volumeInput = document.getElementById('docker-volume');

        let volume = volumeInput ? volumeInput.value.trim() : '';
        if (!volume) {
            volume = slug + '-code';
        }

        const cmd = `docker run --name ${slug}-web --volume=${volume}:/var/www/html -p ${httpsPort}:443 -p ${sshPort}:22 -t -d ${image} sh -c "(/usr/sbin/sshd || echo 'SSH not found, continuing...'); apache2-foreground"`;
        const previewEl = document.getElementById('docker-run-preview-code');
        if (previewEl) {
            previewEl.textContent = cmd;
        }
    }

    // Auto-sync volume when project-name (slug) changes
    const projectNameInput = document.getElementById('project-name');
    if (projectNameInput) {
        projectNameInput.addEventListener('input', function() {
            const volInput = document.getElementById('docker-volume');
            if (volInput && (!volInput.dataset.manuallyEdited || volInput.dataset.manuallyEdited === 'false')) {
                const cleanSlug = projectNameInput.value.toLowerCase().replace(/[^a-z0-9_\-]/g, '-').replace(/-+/g, '-');
                volInput.value = (cleanSlug || 'app') + '-code';
            }
            updateDockerPreview();
        });
    }

    const volField = document.getElementById('docker-volume');
    if (volField) {
        volField.addEventListener('input', function() {
            volField.dataset.manuallyEdited = 'true';
            updateDockerPreview();
        });
    }

    // Auto-sync Application URL when Docker HTTPS Port changes
    function calculateAppUrlFromPort(port) {
        const p = parseInt(port, 10);
        if (!p || p === 443) {
            return 'https://localhost';
        }
        return `https://localhost:${p}`;
    }

    function onDockerHttpsPortChange() {
        const portInput = document.getElementById('docker-https-port');
        const urlInput = document.getElementById('app-url');
        if (!portInput || !urlInput) return;

        const port = portInput.value.trim();
        const currentVal = urlInput.value.trim();

        if (!currentVal || currentVal.includes('localhost') || currentVal === 'http://localhost:8000') {
            urlInput.value = calculateAppUrlFromPort(port);
        } else {
            try {
                const u = new URL(currentVal);
                const p = parseInt(port, 10);
                u.protocol = 'https:';
                u.port = (p === 443 || !p) ? '' : p;
                urlInput.value = u.toString().replace(/\/$/, '');
            } catch (e) {
                urlInput.value = calculateAppUrlFromPort(port);
            }
        }
        updateEnvPreview();
    }

    const dockerHttpsPortInput = document.getElementById('docker-https-port');
    const appUrlField = document.getElementById('app-url');
    if (dockerHttpsPortInput) {
        dockerHttpsPortInput.addEventListener('input', onDockerHttpsPortChange);
        dockerHttpsPortInput.addEventListener('change', onDockerHttpsPortChange);
    }

    function copyDockerRunPreview() {
        const previewEl = document.getElementById('docker-run-preview-code');
        if (!previewEl) return;
        const btn = document.getElementById('copy-docker-btn') || event?.currentTarget;
        copySnippet(btn, previewEl.textContent, 'คัดลอกคำสั่ง Docker สำเร็จ');
    }

    // --- Preset Management System (Local Storage & Built-in Archetypes) ---
    const BUILT_IN_PRESETS = [
        {
            id: 'builtin_bucc_standard',
            name: 'BUCC Dev Hub Standard (Apache + PHP 8.4)',
            desc: 'สภาพแวดล้อมมาตรฐานสำหรับบุคลากร BUCC รองรับ Web SSL (443) และ SSH (22) พร้อม MySQL 8.4',
            config: {
                project_name: 'artisan-pos-system',
                app_title: 'Artisan POS & Inventory Hub',
                laravel_version: '13.x',
                php_version: '8.4',
                app_env: 'local',
                app_url: 'http://localhost:8000',
                app_key: 'base64:v84X9J2qK7mP3L0wR1tY5uI6oP8aS0dF2gH4jK6lZ8=',
                app_timezone: 'Asia/Bangkok',
                log_channel: 'daily',
                db_connection: 'mysql',
                db_host: '127.0.0.1',
                db_port: '3306',
                db_name: 'artisan_pos_db',
                db_user: 'root',
                db_pass: 'secret_local_dev_123',
                db_collation: 'utf8mb4_unicode_ci',
                docker_image: 'bucchub/php-apache-dev:8.4',
                docker_volume: 'artisan-pos-system-code',
                docker_https_port: '443',
                docker_ssh_port: '22',
                icon_set: 'bootstrap_icons',
                cache_driver: 'file',
                queue_driver: 'database',
                session_driver: 'file'
            }
        },
        {
            id: 'builtin_local_minimal',
            name: 'Local Minimalist Dev (Fast Sandbox)',
            desc: 'คอนฟิกแบบเบาสำหรับทดสอบ Localhost พอร์ต 8080 ไม่ต้องพึ่งพา SSH Daemon',
            config: {
                project_name: 'app-dev-sandbox',
                app_title: 'App Dev Sandbox',
                app_env: 'local',
                app_url: 'https://localhost:8080',
                app_key: 'base64:a1b2C3d4E5f6G7h8I9j0K1l2M3n4O5p6Q7r8S9t0U1=',
                app_timezone: 'Asia/Bangkok',
                log_channel: 'daily',
                db_connection: 'mysql',
                db_host: '127.0.0.1',
                db_port: '3306',
                db_name: 'sandbox_db',
                db_user: 'root',
                db_pass: '',
                db_collation: 'utf8mb4_unicode_ci',
                docker_image: 'bucchub/php-apache-dev:8.4',
                docker_volume: 'app-dev-sandbox-code',
                docker_https_port: '8080',
                docker_ssh_port: '2222',
                icon_set: 'lucide',
                cache_driver: 'file',
                queue_driver: 'sync',
                session_driver: 'file'
            }
        },
        {
            id: 'builtin_enterprise_production',
            name: 'Enterprise Production (High-Performance Redis)',
            desc: 'สภาพแวดล้อม Production แยกเครื่อง Cache และ Queue บน Redis เพื่อประสิทธิภาพสูงสุด',
            config: {
                project_name: 'enterprise-core',
                app_title: 'Enterprise Core System',
                app_env: 'production',
                app_url: 'https://core.buu.ac.th',
                app_key: 'base64:e9N8m7K6j5H4g3F2d1S0a9P8o7I6u5Y4t3R2e1W0q9=',
                app_timezone: 'Asia/Bangkok',
                log_channel: 'daily',
                db_connection: 'mysql',
                db_host: '10.0.1.50',
                db_port: '3306',
                db_name: 'prod_core_db',
                db_user: 'db_admin',
                db_pass: '••••••••',
                db_collation: 'utf8mb4_0900_ai_ci',
                docker_image: 'bucchub/php-apache-dev:8.4',
                docker_volume: 'enterprise-core-code',
                docker_https_port: '443',
                docker_ssh_port: '22',
                icon_set: 'bootstrap_icons',
                cache_driver: 'redis',
                queue_driver: 'redis',
                session_driver: 'redis'
            }
        },
        {
            id: 'builtin_sqlite_rapid',
            name: 'Rapid Prototype (Zero-Config SQLite)',
            desc: 'โครงสร้างแบบทดลองเร็วใช้ไฟล์ SQLite ฐานข้อมูลในตัว ไม่ต้องเปิด MySQL เซิร์ฟเวอร์',
            config: {
                project_name: 'rapid-poc-app',
                app_title: 'Rapid PoC Prototype',
                app_env: 'local',
                app_url: 'https://localhost:8000',
                app_key: 'base64:n7k3P9xR2mY5vW8tL1qO4jE6aB0cF2dG3hI5lZ8sX1=',
                app_timezone: 'Asia/Bangkok',
                log_channel: 'single',
                db_connection: 'sqlite',
                db_host: '127.0.0.1',
                db_port: '',
                db_name: 'database/database.sqlite',
                db_user: '',
                db_pass: '',
                db_collation: 'utf8mb4_unicode_ci',
                docker_image: 'bucchub/php-apache-dev:8.4',
                docker_volume: 'rapid-poc-app-code',
                docker_https_port: '8000',
                docker_ssh_port: '2222',
                icon_set: 'lucide',
                cache_driver: 'file',
                queue_driver: 'sync',
                session_driver: 'file'
            }
        }
    ];

    // --- Active Preset State Tracking ---
    let currentActivePresetId = localStorage.getItem('artisan_active_preset_id') || '{{ $activePreset['id'] ?? '' }}' || '';
    let currentActivePresetName = localStorage.getItem('artisan_active_preset_name') || '{{ $activePreset['name'] ?? '' }}' || '';
    let currentActivePresetDesc = localStorage.getItem('artisan_active_preset_desc') || '';
    let isConfigModifiedFromPreset = false;

    function getSavedPresets() {
        try {
            const data = localStorage.getItem('artisan_generator_presets');
            return data ? JSON.parse(data) : [];
        } catch (e) {
            return [];
        }
    }

    function updatePresetCountBadge() {
        const userPresets = getSavedPresets();
        const count = userPresets.length;
        const badgeEl = document.getElementById('preset-count');
        const topBadgeEl = document.getElementById('top-preset-count');
        if (badgeEl) badgeEl.textContent = count;
        if (topBadgeEl) topBadgeEl.textContent = count;
    }

    function collectCurrentConfig() {
        const slugInput = document.getElementById('project-name');
        const slug = (slugInput ? slugInput.value.trim() : '') || 'artisan-pos-system';
        const volumeInput = document.getElementById('docker-volume');
        const iconRadio = document.querySelector('input[name="icon_set"]:checked');

        return {
            project_name: slug,
            app_title: document.getElementById('app-title')?.value || '',
            laravel_version: document.getElementById('laravel-version')?.value || '13.x',
            php_version: document.getElementById('php-version')?.value || '8.4',
            app_env: document.getElementById('app-env')?.value || 'local',
            app_url: document.getElementById('app-url')?.value || 'https://localhost',
            app_key: document.getElementById('app-key')?.value || 'base64:v84X9J2qK7mP3L0wR1tY5uI6oP8aS0dF2gH4jK6lZ8=',
            app_timezone: document.getElementById('app-tz')?.value || 'Asia/Bangkok',
            log_channel: document.getElementById('app-log-channel')?.value || 'daily',
            db_connection: getEffectiveDbConnection(),
            db_connection_custom: document.getElementById('db-connection-custom')?.value || '',
            db_host: document.getElementById('db-host')?.value || '127.0.0.1',
            db_port: document.getElementById('db-port')?.value || '3306',
            db_name: document.getElementById('db-name')?.value || '',
            db_user: document.getElementById('db-user')?.value || 'root',
            db_pass: document.getElementById('db-pass')?.value || '',
            db_collation: document.getElementById('db-collation')?.value || 'utf8mb4_unicode_ci',
            docker_image: document.getElementById('docker-image')?.value || 'bucchub/php-apache-dev:8.4',
            docker_volume: volumeInput?.value || (slug + '-code'),
            docker_https_port: document.getElementById('docker-https-port')?.value || '443',
            docker_ssh_port: document.getElementById('docker-ssh-port')?.value || '22',
            icon_set: iconRadio ? iconRadio.value : 'bootstrap_icons',
            cache_driver: document.getElementById('cache-driver')?.value || 'file',
            queue_driver: document.getElementById('queue-driver')?.value || 'database',
            session_driver: document.getElementById('session-driver')?.value || 'file'
        };
    }

    function updateActivePresetUI(id, name, desc = '') {
        const heroNameEl = document.getElementById('hero-active-preset-name');
        const bottomNameEl = document.getElementById('bottom-active-preset-name');
        const archetypeTitle = document.getElementById('archetype-title');
        const archetypeBadge = document.getElementById('archetype-badge');
        const archetypeBadgeText = document.getElementById('archetype-badge-text');
        const archetypeDesc = document.getElementById('archetype-desc');
        const archetypeStatusTag = document.getElementById('archetype-status-tag');
        const archeContainer = document.getElementById('archetype-container');

        if (id && name) {
            const displayName = isConfigModifiedFromPreset ? `${name} (แก้ไข)` : name;
            if (heroNameEl) heroNameEl.textContent = displayName;
            if (bottomNameEl) bottomNameEl.textContent = displayName;

            if (archetypeTitle) archetypeTitle.textContent = name;
            if (archetypeBadgeText) archetypeBadgeText.textContent = isConfigModifiedFromPreset ? 'Customized Preset' : 'Active Preset';
            if (archetypeBadge) {
                archetypeBadge.className = isConfigModifiedFromPreset
                    ? 'px-2.5 py-0.5 rounded-full bg-secondary-container text-on-secondary-container font-label-sm text-label-sm font-code-inline flex items-center gap-1'
                    : 'px-2.5 py-0.5 rounded-full bg-tertiary-container text-on-tertiary-container font-label-sm text-label-sm font-code-inline flex items-center gap-1';
            }
            if (archetypeDesc && desc) archetypeDesc.textContent = desc;
            if (archetypeStatusTag) archetypeStatusTag.textContent = 'ACTIVE PRESET';
            if (archeContainer) {
                archeContainer.classList.add('border', 'border-tertiary/40');
            }
        } else {
            if (heroNameEl) heroNameEl.textContent = 'None (Custom)';
            if (bottomNameEl) bottomNameEl.textContent = 'Custom Draft';
            if (archetypeTitle) archetypeTitle.textContent = 'Full-Stack Monolith';
            if (archetypeBadgeText) archetypeBadgeText.textContent = 'Active Foundation';
            if (archetypeBadge) {
                archetypeBadge.className = 'px-2.5 py-0.5 rounded-full bg-primary-container text-on-primary-container font-label-sm text-label-sm font-code-inline flex items-center gap-1';
            }
            if (archetypeDesc) archetypeDesc.textContent = 'สถาปัตยกรรมแบบดั้งเดิมที่ผสาน Blade Views เข้ากับ Bootstrap 5.3 และ Sass workflow ควบคุมความซับซ้อนต่ำ ประสิทธิภาพสูง พร้อมคอมไพล์ asset ทันที';
            if (archetypeStatusTag) archetypeStatusTag.textContent = 'LOCKED ARCHETYPE';
            if (archeContainer) {
                archeContainer.classList.remove('border', 'border-tertiary/40');
            }
        }
    }

    function setActivePresetState(id, name, config, desc = '', shouldSync = true) {
        currentActivePresetId = id;
        currentActivePresetName = name;
        currentActivePresetDesc = desc || '';
        isConfigModifiedFromPreset = false;

        localStorage.setItem('artisan_active_preset_id', id);
        localStorage.setItem('artisan_active_preset_name', name);
        localStorage.setItem('artisan_active_preset_desc', currentActivePresetDesc);
        if (config) {
            localStorage.setItem('artisan_step1_draft', JSON.stringify(config));
        }

        updateActivePresetUI(id, name, currentActivePresetDesc);

        if (shouldSync && id && name) {
            const csrfToken = document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}';
            fetch('{{ route('generator.activePreset') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    preset_id: id,
                    preset_name: name,
                    config: config || {}
                })
            }).catch(err => console.warn('Could not sync active preset to server session:', err));
        }
    }

    function applyConfigToForm(config, presetName, presetId = '', presetDesc = '', showToast = true) {
        if (!config) return;

        if (config.project_name && document.getElementById('project-name')) document.getElementById('project-name').value = config.project_name;
        if (config.app_title && document.getElementById('app-title')) document.getElementById('app-title').value = config.app_title;
        if (config.laravel_version && document.getElementById('laravel-version')) document.getElementById('laravel-version').value = config.laravel_version;
        if (config.php_version && document.getElementById('php-version')) document.getElementById('php-version').value = config.php_version;
        onRuntimeVersionChange();
        if (config.app_env && document.getElementById('app-env')) document.getElementById('app-env').value = config.app_env;
        if (config.app_url && document.getElementById('app-url')) document.getElementById('app-url').value = config.app_url;
        if (config.app_key && document.getElementById('app-key')) document.getElementById('app-key').value = config.app_key;
        if (config.app_timezone && document.getElementById('app-tz')) document.getElementById('app-tz').value = config.app_timezone;
        if (config.db_connection) {
            const standardDrivers = ['mysql', 'mariadb', 'pgsql', 'sqlite', 'sqlsrv', 'oracle'];
            const select = document.getElementById('db-connection');
            const customInput = document.getElementById('db-connection-custom');
            if (standardDrivers.includes(config.db_connection)) {
                if (select) select.value = config.db_connection;
                if (customInput) customInput.value = '';
            } else {
                if (select) select.value = 'custom';
                if (customInput) customInput.value = config.db_connection;
            }
            onDbConnectionChange(false);
        } else if (config.db_connection_custom) {
            const select = document.getElementById('db-connection');
            const customInput = document.getElementById('db-connection-custom');
            if (select) select.value = 'custom';
            if (customInput) customInput.value = config.db_connection_custom;
            onDbConnectionChange(false);
        }
        if (config.db_host && document.getElementById('db-host')) document.getElementById('db-host').value = config.db_host;
        if (config.db_port && document.getElementById('db-port')) document.getElementById('db-port').value = config.db_port;
        if (config.db_name && document.getElementById('db-name')) document.getElementById('db-name').value = config.db_name;
        if (config.db_user && document.getElementById('db-user')) document.getElementById('db-user').value = config.db_user;
        if (config.db_pass !== undefined && document.getElementById('db-pass')) document.getElementById('db-pass').value = config.db_pass;
        if (config.db_collation && document.getElementById('db-collation')) document.getElementById('db-collation').value = config.db_collation;
        if (config.docker_image && document.getElementById('docker-image')) document.getElementById('docker-image').value = config.docker_image;
        if (config.docker_volume && document.getElementById('docker-volume')) document.getElementById('docker-volume').value = config.docker_volume;
        if (config.docker_https_port && document.getElementById('docker-https-port')) document.getElementById('docker-https-port').value = config.docker_https_port;
        if (config.docker_ssh_port && document.getElementById('docker-ssh-port')) document.getElementById('docker-ssh-port').value = config.docker_ssh_port;
        if (config.cache_driver && document.getElementById('cache-driver')) document.getElementById('cache-driver').value = config.cache_driver;
        if (config.queue_driver && document.getElementById('queue-driver')) document.getElementById('queue-driver').value = config.queue_driver;
        if (config.session_driver && document.getElementById('session-driver')) document.getElementById('session-driver').value = config.session_driver;

        if (config.icon_set) {
            const radio = document.querySelector(`input[name="icon_set"][value="${config.icon_set}"]`);
            if (radio) radio.checked = true;
        }

        if (config.use_ums_buu !== undefined) {
            const umsCheckbox = document.getElementById('use-ums-buu');
            if (umsCheckbox) {
                umsCheckbox.checked = Boolean(config.use_ums_buu);
                onToggleUmsBuu(umsCheckbox);
            }
        }
        if (config.ums_config) {
            if (config.ums_config.system_id && document.getElementById('ums-system-id')) document.getElementById('ums-system-id').value = config.ums_config.system_id;
            if (config.ums_config.service_key && document.getElementById('ums-service-key')) document.getElementById('ums-service-key').value = config.ums_config.service_key;
            if (config.ums_config.service_url && document.getElementById('ums-service-url')) document.getElementById('ums-service-url').value = config.ums_config.service_url;
            if (config.ums_config.kong_domain_prod && document.getElementById('kong-domain-prod')) document.getElementById('kong-domain-prod').value = config.ums_config.kong_domain_prod;
            if (config.ums_config.kong_pk_ums_glgroupinsystem !== undefined && document.getElementById('kong-pk-glgroup')) document.getElementById('kong-pk-glgroup').value = config.ums_config.kong_pk_ums_glgroupinsystem;
            if (config.ums_config.kong_pk_ums_cusergroup !== undefined && document.getElementById('kong-pk-cusergroup')) document.getElementById('kong-pk-cusergroup').value = config.ums_config.kong_pk_ums_cusergroup;
            if (config.ums_config.kong_pk_ums_glpersonfromcitizenid !== undefined && document.getElementById('kong-pk-glperson')) document.getElementById('kong-pk-glperson').value = config.ums_config.kong_pk_ums_glpersonfromcitizenid;
            if (config.ums_config.kong_pk_ums_ausergroup !== undefined && document.getElementById('kong-pk-ausergroup')) document.getElementById('kong-pk-ausergroup').value = config.ums_config.kong_pk_ums_ausergroup;
            if (config.ums_config.kong_pk_ums_dusergroup !== undefined && document.getElementById('kong-pk-dusergroup')) document.getElementById('kong-pk-dusergroup').value = config.ums_config.kong_pk_ums_dusergroup;
        }

        if (presetId && presetName) {
            setActivePresetState(presetId, presetName, config, presetDesc, true);
        }

        // Recompute previews
        updateEnvPreview();
        updateDockerPreview();

        if (showToast && window.ArtisanSwal) {
            ArtisanSwal.fire({
                icon: 'success',
                title: 'โหลดแม่แบบสำเร็จ!',
                html: `นำการตั้งค่าจากแม่แบบ <span class="text-tertiary font-bold">"${escapeHtml(presetName)}"</span> มาใช้งานและเปิด Session เรียบร้อยแล้ว`,
                timer: 2000,
                showConfirmButton: false
            });
        }
    }

    function openSavePresetModal() {
        const currentName = document.getElementById('app-title')?.value || 'My Preset';
        const currentSlug = document.getElementById('project-name')?.value || 'artisan-pos';

        if (!window.ArtisanSwal) {
            alert('บันทึกแม่แบบเรียบร้อยแล้ว');
            return;
        }

        ArtisanSwal.fire({
            title: 'บันทึกเป็นแม่แบบ (Save as Preset)',
            html: `
                <div class="text-left font-body-sm text-on-surface-variant mb-3 leading-relaxed">
                    บันทึกค่าที่กำหนดไว้ในหน้านี้ (Core Spec, Database, Docker, Drivers) เก็บเป็นแม่แบบ เพื่อนำกลับมาโหลดใช้ซ้ำได้ทันที <span class="text-secondary">(หากตั้งชื่อซ้ำกับแม่แบบเดิม ระบบจะบันทึกทับให้อัตโนมัติ)</span>
                </div>
                <div class="text-left mb-3">
                    <label class="block font-label-sm text-label-sm text-outline uppercase font-semibold mb-1">ชื่อแม่แบบ <span class="text-primary">*</span></label>
                    <input id="swal-preset-name" class="swal2-input !w-full !m-0 !text-sm" placeholder="เช่น BUCC Default, POS Branch System" value="${escapeHtml(currentActivePresetName || currentName)}">
                    <div id="swal-preset-warn" class="text-xs text-secondary mt-1 hidden flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">info</span>
                        <span>พบแม่แบบชื่อนี้อยู่แล้ว ระบบจะบันทึกทับการตั้งค่าเดิม</span>
                    </div>
                </div>
                <div class="text-left">
                    <label class="block font-label-sm text-label-sm text-outline uppercase font-semibold mb-1">คำอธิบายย่อ (Optional)</label>
                    <input id="swal-preset-desc" class="swal2-input !w-full !m-0 !text-sm" placeholder="เช่น สภาพแวดล้อมทดสอบ MySQL 8.4 พร้อมพอร์ต 443" value="${escapeHtml(currentActivePresetDesc || ('โปรเจกต์ ' + currentSlug))}">
                </div>
            `,
            didOpen: () => {
                const nameInput = document.getElementById('swal-preset-name');
                const warnEl = document.getElementById('swal-preset-warn');
                const checkDup = () => {
                    const typed = (nameInput?.value || '').trim().toLowerCase();
                    if (!typed) {
                        if (warnEl) warnEl.classList.add('hidden');
                        return;
                    }
                    const presets = getSavedPresets();
                    const exists = presets.some(p => p.name.trim().toLowerCase() === typed);
                    if (warnEl) {
                        if (exists) {
                            warnEl.classList.remove('hidden');
                        } else {
                            warnEl.classList.add('hidden');
                        }
                    }
                };
                nameInput?.addEventListener('input', checkDup);
                checkDup();
            },
            showCancelButton: true,
            confirmButtonText: '<span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[18px]">save</span> บันทึกแม่แบบ</span>',
            cancelButtonText: 'ยกเลิก',
            focusConfirm: false,
            preConfirm: () => {
                const name = document.getElementById('swal-preset-name')?.value.trim();
                const desc = document.getElementById('swal-preset-desc')?.value.trim();
                if (!name) {
                    Swal.showValidationMessage('กรุณาระบุชื่อแม่แบบ');
                    return false;
                }
                return { name, desc };
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                const config = collectCurrentConfig();
                const presets = getSavedPresets();
                const targetName = result.value.name.trim();

                const existingIndex = presets.findIndex(p => p.name.trim().toLowerCase() === targetName.toLowerCase());
                let isOverwrite = false;
                let finalPresetId = '';
                const descVal = result.value.desc || `สร้างเมื่อ ${new Date().toLocaleDateString('th-TH')} ${new Date().toLocaleTimeString('th-TH')}`;

                if (existingIndex !== -1) {
                    // Overwrite existing preset in-place
                    finalPresetId = presets[existingIndex].id;
                    presets[existingIndex] = {
                        id: finalPresetId,
                        name: targetName,
                        desc: result.value.desc || presets[existingIndex].desc || `อัปเดตเมื่อ ${new Date().toLocaleDateString('th-TH')} ${new Date().toLocaleTimeString('th-TH')}`,
                        createdAt: presets[existingIndex].createdAt || new Date().toISOString(),
                        updatedAt: new Date().toISOString(),
                        config: config
                    };
                    isOverwrite = true;
                } else {
                    // Create new preset entry
                    finalPresetId = 'preset_' + Date.now();
                    const newPreset = {
                        id: finalPresetId,
                        name: targetName,
                        desc: descVal,
                        createdAt: new Date().toISOString(),
                        config: config
                    };
                    presets.unshift(newPreset);
                }

                localStorage.setItem('artisan_generator_presets', JSON.stringify(presets));
                updatePresetCountBadge();

                // Automatically activate this preset session
                setActivePresetState(finalPresetId, targetName, config, descVal, true);

                ArtisanSwal.fire({
                    icon: 'success',
                    title: isOverwrite ? 'บันทึกทับแม่แบบสำเร็จ!' : 'บันทึกแม่แบบสำเร็จ!',
                    html: isOverwrite
                        ? `บันทึกข้อมูลทับแม่แบบ <span class="text-tertiary font-bold">"${escapeHtml(targetName)}"</span> เรียบร้อยแล้ว และตั้งเป็น Active Preset ปัจจุบัน`
                        : `บันทึกแม่แบบ <span class="text-tertiary font-bold">"${escapeHtml(targetName)}"</span> เรียบร้อยแล้ว และตั้งเป็น Active Preset ปัจจุบัน`,
                    confirmButtonText: 'ตกลง',
                    timer: 2500
                });
            }
        });
    }

    function openLoadPresetModal() {
        const userPresets = getSavedPresets();

        let htmlContent = `
            <div class="text-left max-h-96 overflow-y-auto pr-1">
                <div class="font-label-sm text-label-sm uppercase font-semibold text-outline mb-2">
                    แม่แบบที่คุณบันทึกไว้ (${userPresets.length} รายการ)
                </div>
        `;

        if (userPresets.length === 0) {
            htmlContent += `
                <div class="p-3 rounded-lg bg-surface-container text-center font-body-sm text-body-sm text-outline mb-4 border border-dashed border-surface-container-high">
                    ยังไม่มีแม่แบบที่คุณบันทึกไว้ (คลิกปุ่ม <b>"Save as Preset"</b> เพื่อบันทึกการตั้งค่าปัจจุบัน)
                </div>
            `;
        } else {
            userPresets.forEach((p) => {
                const isActive = (p.id === currentActivePresetId);
                const activeCardClass = isActive
                    ? 'border-2 border-tertiary/70 bg-tertiary/5 shadow-sm'
                    : 'border border-surface-container-high bg-surface-container hover:bg-surface-container-high';

                htmlContent += `
                    <div class="flex items-center justify-between p-3 rounded-lg ${activeCardClass} mb-2 transition-all">
                        <div class="flex-1 min-w-0 pr-3">
                            <div class="flex items-center gap-2">
                                <span class="font-headline-sm text-headline-sm text-primary font-semibold truncate">${escapeHtml(p.name)}</span>
                                ${isActive ? '<span class="px-2 py-0.5 rounded-full bg-tertiary/20 text-tertiary text-[11px] font-semibold flex items-center gap-1 flex-shrink-0"><span class="material-symbols-outlined text-[13px]">check_circle</span> กำลังใช้งาน (Active)</span>' : ''}
                            </div>
                            <div class="font-body-sm text-body-sm text-outline truncate">${escapeHtml(p.desc || '')}</div>
                            <div class="font-code-block text-code-block text-[11px] text-outline mt-0.5 font-code-inline truncate">Slug: ${escapeHtml(p.config.project_name || '-')} | DB: ${escapeHtml(p.config.db_name || '-')} | Port: ${escapeHtml(p.config.docker_https_port || '443')}</div>
                        </div>
                        <div class="flex items-center gap-1.5 flex-shrink-0">
                            ${isActive
                                ? `<button type="button" onclick="loadSinglePreset('${p.id}')" class="px-3 py-1.5 rounded-lg bg-tertiary text-surface-container-lowest text-label-sm font-label-sm font-bold flex items-center gap-1 shadow-sm cursor-pointer hover:opacity-90">
                                       <span class="material-symbols-outlined text-[15px]">done</span> ใช้งานอยู่
                                   </button>`
                                : `<button type="button" onclick="loadSinglePreset('${p.id}')" class="px-3 py-1.5 rounded-lg bg-primary text-on-primary text-label-sm font-label-sm font-semibold hover:opacity-90 transition-opacity cursor-pointer">
                                       โหลด
                                   </button>`
                            }
                            <button type="button" onclick="deleteSinglePreset('${p.id}')" class="p-1.5 rounded-lg bg-surface-container-highest hover:bg-error-container text-error transition-colors cursor-pointer" title="ลบแม่แบบ">
                                <span class="material-symbols-outlined text-[16px] block">delete</span>
                            </button>
                        </div>
                    </div>
                `;
            });
        }

        htmlContent += `
                <div class="font-label-sm text-label-sm uppercase font-semibold text-outline mt-4 mb-2">
                    แม่แบบมาตรฐานจากระบบ (Built-in Archetypes)
                </div>
        `;

        BUILT_IN_PRESETS.forEach((p) => {
            const isActive = (p.id === currentActivePresetId);
            const activeCardClass = isActive
                ? 'border-2 border-tertiary/70 bg-tertiary/5 shadow-sm'
                : 'border border-surface-container-high bg-surface-container hover:bg-surface-container-high';

            htmlContent += `
                <div class="flex items-center justify-between p-3 rounded-lg ${activeCardClass} mb-2 transition-all">
                    <div class="flex-1 min-w-0 pr-3">
                        <div class="flex items-center gap-2">
                            <span class="font-headline-sm text-headline-sm text-secondary font-semibold truncate">${escapeHtml(p.name)}</span>
                            ${isActive ? '<span class="px-2 py-0.5 rounded-full bg-tertiary/20 text-tertiary text-[11px] font-semibold flex items-center gap-1 flex-shrink-0"><span class="material-symbols-outlined text-[13px]">check_circle</span> กำลังใช้งาน (Active)</span>' : ''}
                        </div>
                        <div class="font-body-sm text-body-sm text-outline truncate">${escapeHtml(p.desc)}</div>
                    </div>
                    ${isActive
                        ? `<button type="button" onclick="loadSinglePreset('${p.id}')" class="px-3 py-1.5 rounded-lg bg-tertiary text-surface-container-lowest text-label-sm font-label-sm font-bold flex items-center gap-1 shadow-sm cursor-pointer hover:opacity-90 flex-shrink-0">
                               <span class="material-symbols-outlined text-[15px]">done</span> ใช้งานอยู่
                           </button>`
                        : `<button type="button" onclick="loadSinglePreset('${p.id}')" class="px-3 py-1.5 rounded-lg bg-secondary/20 hover:bg-secondary/30 text-secondary border border-secondary/40 text-label-sm font-label-sm font-semibold transition-colors cursor-pointer flex-shrink-0">
                               โหลด
                           </button>`
                    }
                </div>
            `;
        });

        htmlContent += `</div>`;

        ArtisanSwal.fire({
            title: 'เลือกแม่แบบ (Preset Archetypes)',
            html: htmlContent,
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonText: 'ปิดหน้าต่าง',
            width: '640px'
        });
    }

    window.loadSinglePreset = function(id) {
        let preset = BUILT_IN_PRESETS.find(p => p.id === id);
        if (!preset) {
            const userPresets = getSavedPresets();
            preset = userPresets.find(p => p.id === id);
        }
        if (preset) {
            applyConfigToForm(preset.config, preset.name, preset.id, preset.desc, true);
        }
    };

    window.deleteSinglePreset = function(id) {
        const userPresets = getSavedPresets();
        const target = userPresets.find(p => p.id === id);
        if (!target) return;

        ArtisanSwal.fire({
            icon: 'warning',
            title: 'ยืนยันการลบแม่แบบ?',
            html: `คุณต้องการลบแม่แบบ <span class="text-primary font-bold">"${escapeHtml(target.name)}"</span> ใช่หรือไม่?`,
            showCancelButton: true,
            confirmButtonText: 'ลบแม่แบบ',
            cancelButtonText: 'ยกเลิก'
        }).then((res) => {
            if (res.isConfirmed) {
                const filtered = userPresets.filter(p => p.id !== id);
                localStorage.setItem('artisan_generator_presets', JSON.stringify(filtered));
                if (currentActivePresetId === id) {
                    currentActivePresetId = '';
                    currentActivePresetName = '';
                    currentActivePresetDesc = '';
                    localStorage.removeItem('artisan_active_preset_id');
                    localStorage.removeItem('artisan_active_preset_name');
                    localStorage.removeItem('artisan_active_preset_desc');
                    updateActivePresetUI('', '');
                }
                updatePresetCountBadge();
                openLoadPresetModal();
            }
        });
    };

    function resetDefaultsWithConfirm() {
        if (!window.ArtisanSwal) {
            if (confirm('คุณต้องการคืนค่าเริ่มต้นทั้งหมดใช่หรือไม่?')) {
                doResetDefaults();
            }
            return;
        }

        ArtisanSwal.fire({
            icon: 'warning',
            title: 'ยืนยันคืนค่าเริ่มต้น?',
            text: 'ระบบจะล้างค่าที่คุณกำหนดไว้ในหน้านี้ และยกเลิกการเลือกแม่แบบปัจจุบันกลับสู่สถาปัตยกรรมตั้งต้น',
            showCancelButton: true,
            confirmButtonText: 'คืนค่าเริ่มต้น',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#ff5542',
        }).then((res) => {
            if (res.isConfirmed) {
                doResetDefaults();
            }
        });
    }

    function doResetDefaults() {
        localStorage.removeItem('artisan_step1_draft');
        localStorage.removeItem('artisan_active_preset_id');
        localStorage.removeItem('artisan_active_preset_name');
        localStorage.removeItem('artisan_active_preset_desc');

        const csrfToken = document.querySelector('input[name="_token"]')?.value || '{{ csrf_token() }}';
        fetch('{{ route('generator.clearPreset') }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        }).catch(() => {});

        currentActivePresetId = '';
        currentActivePresetName = '';
        currentActivePresetDesc = '';
        isConfigModifiedFromPreset = false;

        const defaultConfig = {
            project_name: 'artisan-pos-system',
            app_title: 'Artisan POS & Inventory Hub',
            app_env: 'local',
            app_url: 'https://localhost',
            app_timezone: 'Asia/Bangkok',
            log_channel: 'daily',
            db_host: '127.0.0.1',
            db_port: '3306',
            db_name: 'artisan_pos_db',
            db_user: 'root',
            db_pass: 'secret_local_dev_123',
            db_collation: 'utf8mb4_unicode_ci',
            docker_image: 'bucchub/php-apache-dev:8.4',
            docker_volume: 'artisan-pos-system-code',
            docker_https_port: '443',
            docker_ssh_port: '22',
            icon_set: 'bootstrap_icons',
            cache_driver: 'file',
            queue_driver: 'database',
            session_driver: 'file'
        };

        applyConfigToForm(defaultConfig, '', '', '', false);
        updateActivePresetUI('', '');
        updateEnvPreview();
        updateDockerPreview();

        if (window.ArtisanSwal) {
            ArtisanSwal.fire({
                icon: 'info',
                title: 'คืนค่าเริ่มต้นเรียบร้อย',
                timer: 1500,
                showConfirmButton: false
            });
        }
    }

    // Auto-save draft on any form input/change event
    const setupForm = document.getElementById('setup-form');
    if (setupForm) {
        const handleFormMutation = () => {
            const currentCfg = collectCurrentConfig();
            localStorage.setItem('artisan_step1_draft', JSON.stringify(currentCfg));
            if (currentActivePresetId && !isConfigModifiedFromPreset) {
                isConfigModifiedFromPreset = true;
                updateActivePresetUI(currentActivePresetId, currentActivePresetName, currentActivePresetDesc);
            }
            updateEnvPreview();
            updateDockerPreview();
        };

        setupForm.addEventListener('input', handleFormMutation);
        setupForm.addEventListener('change', handleFormMutation);
    }

    // Initialize preview, restore draft/preset, and preset badge on DOM loaded
    document.addEventListener('DOMContentLoaded', () => {
        const savedDraft = localStorage.getItem('artisan_step1_draft');
        const savedActiveId = localStorage.getItem('artisan_active_preset_id') || '{{ $activePreset['id'] ?? '' }}';
        const savedActiveName = localStorage.getItem('artisan_active_preset_name') || '{{ $activePreset['name'] ?? '' }}';
        const savedActiveDesc = localStorage.getItem('artisan_active_preset_desc') || '';

        if (savedDraft) {
            try {
                const config = JSON.parse(savedDraft);
                applyConfigToForm(config, savedActiveName, savedActiveId, savedActiveDesc, false);
            } catch (e) {
                console.error('Error parsing saved draft', e);
            }
        } else if (savedActiveId) {
            let preset = BUILT_IN_PRESETS.find(p => p.id === savedActiveId);
            if (!preset) {
                const userPresets = getSavedPresets();
                preset = userPresets.find(p => p.id === savedActiveId);
            }
            if (preset) {
                applyConfigToForm(preset.config, preset.name, preset.id, preset.desc, false);
            }
        }

        if (savedActiveId && savedActiveName) {
            currentActivePresetId = savedActiveId;
            currentActivePresetName = savedActiveName;
            currentActivePresetDesc = savedActiveDesc;
            updateActivePresetUI(savedActiveId, savedActiveName, savedActiveDesc);
        } else {
            updateActivePresetUI('', '');
        }

        onDbConnectionChange(false);
        updateDockerPreview();
        updateEnvPreview();
        syncEnvCardHeight();
        updatePresetCountBadge();

        window.addEventListener('resize', syncEnvCardHeight);
    });
</script>
@endsection
