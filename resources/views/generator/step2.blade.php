@extends('layouts.artisan')

@section('title', 'Step 2: Packages & Dependencies Marketplace')

@section('content')
@php
    $savedPackages = session('project.packages');
    if (is_array($savedPackages) && in_array('vinkla/hashids', $savedPackages) && !in_array('hashids/hashids', $savedPackages)) {
        $savedPackages[] = 'hashids/hashids';
    }
    $isPkgChecked = function($pkgName, $defaultChecked = false) use ($savedPackages) {
        if ($savedPackages !== null) {
            return in_array($pkgName, $savedPackages);
        }
        return $defaultChecked;
    };

    $allLaravel = config('generator.laravel_versions', []);
    $allPhp = config('generator.php_versions', []);
    $laravelVerKey = session('project.laravel_version', config('generator.default_laravel', '13.x'));
    $phpVerKey = session('project.php_version', config('generator.default_php', '8.4'));
    $laravelMajor = $allLaravel[$laravelVerKey]['major'] ?? 13;
    $frameworkConstraint = $allLaravel[$laravelVerKey]['constraint'] ?? '^13.0';
    $phpConstraint = $allPhp[$phpVerKey]['constraint'] ?? '^8.4';

    $statsRepoInstance = $statsRepo ?? app(\App\Services\Packages\PackageStatsRepository::class);
    $stats = $packageStats ?? $statsRepoInstance->getAllStats();
    $pkgStat = function(string $name) use ($stats) {
        return $stats[$name] ?? [
            'stars_formatted' => '-',
            'downloads_formatted' => '-',
            'is_abandoned' => false,
            'latest_version' => null,
            'clean_version' => null,
            'active_version' => '^1.0',
        ];
    };
    $pkgVersion = function(string $name) use ($statsRepoInstance, $laravelMajor) {
        return $statsRepoInstance->resolvePackageVersion($name, (string) $laravelMajor);
    };

    $projectSlug = session('project.slug', 'artisan-pos-system');
    $rawBootstrapVer = $pkgVersion('twbs/bootstrap');
    $bootstrapConstraint = str_starts_with($rawBootstrapVer, '^') ? $rawBootstrapVer : '^' . $rawBootstrapVer;

    $pkgRegistry = collect(config('generator.packages', []))->map(function($pkg, $key) use ($pkgVersion) {
        return [
            'source' => $pkg['source'] ?? 'composer',
            'npm_name' => $pkg['npm_name'] ?? $key,
            'is_dev' => $pkg['is_dev'] ?? false,
            'version' => $pkgVersion($key),
        ];
    })->toArray();
@endphp
<div class="flex flex-col w-full">
    <!-- Header Banner -->
    <div class="relative overflow-hidden bg-surface-container-low px-space-lg py-space-xl">
        <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-primary-container/10 blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/3 -bottom-20 w-80 h-80 rounded-full bg-secondary-container/15 blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col gap-space-lg max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md">
                <div class="flex items-start gap-space-sm">
                    <div class="w-11 h-11 rounded-xl bg-surface-container-high border border-surface-container-highest flex items-center justify-center font-code-inline text-headline-sm font-bold text-primary shadow-sm shrink-0">02</div>
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-space-xs flex-wrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-surface-container-highest text-primary font-label-sm text-label-sm font-semibold uppercase tracking-wider">
                                <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                                Pipeline Step 02 / 05
                            </span>
                            <span class="text-outline font-code-inline text-label-sm">|</span>
                            <span class="text-secondary font-code-inline text-label-sm">composer.json &amp; Dependencies Architect</span>
                        </div>
                        <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold tracking-tight">Packages &amp; Engine Dependencies</h1>
                        <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">
                            เลือกและกำหนดแพ็กเกจ PHP 8.4 ที่ผ่านการตรวจสอบความเข้ากันได้ พร้อมปรับแต่งไฟล์ composer.json อัตโนมัติ
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-space-sm bg-surface-container p-space-sm rounded-xl shadow-lg">
                    <div class="flex flex-col px-space-sm py-1">
                        <span class="font-label-sm text-label-sm text-outline uppercase">Active Set</span>
                        <span class="font-headline-sm text-headline-sm text-primary font-code-block" id="selected-counter">15 Packages</span>
                    </div>
                    <div class="w-px h-8 bg-surface-container-highest"></div>
                    <div class="flex flex-col px-space-sm py-1">
                        <span class="font-label-sm text-label-sm text-outline uppercase">Estimated Build</span>
                        <span class="font-headline-sm text-headline-sm text-on-surface font-code-block" id="estimated-build">~48s</span>
                    </div>
                    <div class="w-px h-8 bg-surface-container-highest"></div>
                    <div class="flex items-center gap-1.5 px-space-sm py-1">
                        <span class="w-2.5 h-2.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(78,222,163,0.5)]"></span>
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-tertiary uppercase font-code-inline">PHP {{ $phpVerKey }} Ready</span>
                            <span class="font-label-sm text-label-sm text-on-surface-variant">100% Validated</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Bar -->
            <div class="flex flex-col lg:flex-row gap-space-md items-stretch lg:items-center justify-between">
                <div class="relative flex-1 max-w-xl">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[18px]">search</span>
                    <input class="w-full h-11 pl-10 pr-20 rounded-lg bg-surface-container text-on-surface font-body-md text-body-md placeholder:text-outline focus:outline-none focus:bg-surface-container-high transition-colors shadow-inner"
                           id="pkg-search" placeholder="Search packages: breeze, spatie, datatables, pest, dompdf..." type="text">
                    <div class="absolute right-2.5 top-1/2 -translate-y-1/2 flex items-center gap-1">
                        <button type="button" id="clear-search-btn" class="hidden text-outline hover:text-on-surface mr-1 p-0.5 rounded cursor-pointer" title="ล้างคำค้นหา (Esc)" onclick="resetSearchAndFilter()">
                            <span class="material-symbols-outlined text-[16px]">cancel</span>
                        </button>
                        <kbd class="px-2 py-0.5 rounded bg-surface-container-highest text-outline font-label-sm text-label-sm font-code-inline cursor-pointer hover:bg-surface-container hover:text-on-surface transition-colors" onclick="document.getElementById('pkg-search').focus()" title="กดปุ่ม / เพื่อค้นหา">/</kbd>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 lg:pb-0" id="filter-container">
                    <button class="filter-pill active px-3 py-1.5 rounded-lg bg-primary-container text-on-primary font-label-md text-label-md transition-all shadow-sm" data-filter="all" type="button">
                        All (25)
                    </button>
                    <button class="filter-pill px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface font-label-md text-label-md transition-all" data-filter="auth" type="button">
                        Auth &amp; Security (4)
                    </button>
                    <button class="filter-pill px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface font-label-md text-label-md transition-all" data-filter="ui" type="button">
                        UI &amp; Admin (10)
                    </button>
                    <button class="filter-pill px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface font-label-md text-label-md transition-all" data-filter="data" type="button">
                        Data &amp; Reports (7)
                    </button>
                    <button class="filter-pill px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface font-label-md text-label-md transition-all" data-filter="devtools" type="button">
                        DevTools (4)
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto px-space-lg py-space-lg w-full">
        <form method="POST" action="{{ route('generator.step2.save') }}" id="packages-form" class="w-full flex flex-col">
            @csrf
            <div class="w-full flex flex-col xl:flex-row gap-space-lg items-start">
                <div class="flex-1 w-full flex flex-col gap-space-xl">

            <!-- 1. Auth & Security -->
            <section class="flex flex-col gap-space-md" data-category-group="auth">
                <div class="flex items-center justify-between pb-1">
                    <div class="flex items-center gap-space-sm">
                        <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[18px]">verified_user</span>
                        </div>
                        <div>
                            <h2 class="font-headline-sm text-headline-sm text-on-surface">Authentication &amp; Security Shield</h2>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">Guards, roles, and token orchestration</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                    <!-- Breeze -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="laravel/breeze" data-version="{{ $pkgVersion('laravel/breeze') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[20px]">key</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Laravel Breeze</span>
                                    <span class="font-label-sm text-label-sm text-secondary font-code-inline">Blade + Bootstrap 5.3</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('laravel/breeze', false) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="laravel/breeze" data-target="laravel/breeze" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">ระบบ Authentication พื้นฐานพร้อม UI Bootstrap 5.3 รองรับ Login, Register, Profile และ Reset Password</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require laravel/breeze --dev</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('laravel/breeze')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('laravel/breeze') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('laravel/breeze')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Spatie Permission -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="spatie/laravel-permission" data-version="{{ $pkgVersion('spatie/laravel-permission') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[20px]">admin_panel_settings</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Spatie Permission</span>
                                    <span class="font-label-sm text-label-sm text-tertiary font-code-inline">RBAC Matrix</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('spatie/laravel-permission', false) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="spatie/laravel-permission" data-target="spatie/laravel-permission" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">จัดการสิทธิ์และบทบาทผู้ใช้ (Roles &amp; Permissions) รองรับคำสั่ง Blade (@@can, @@hasrole) และ Middleware</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require spatie/laravel-permission</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('spatie/laravel-permission')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('spatie/laravel-permission') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('spatie/laravel-permission')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sanctum -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md md:col-span-2" data-name="laravel/sanctum" data-version="{{ $pkgVersion('laravel/sanctum') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[20px]">token</span>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Laravel Sanctum</span>
                                        <span class="px-2 py-0.5 rounded bg-surface-container-highest text-secondary font-label-sm text-label-sm uppercase">Mobile &amp; API Ready</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">Token + Cookie Auth</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('laravel/sanctum', false) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="laravel/sanctum" data-target="laravel/sanctum" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">ระบบออก Token และ Cookie Authentication น้ำหนักเบาสำหรับ SPA, Mobile Apps และ REST API</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require laravel/sanctum</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('laravel/sanctum')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('laravel/sanctum') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('laravel/sanctum')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hashids -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md md:col-span-2" data-name="hashids/hashids" data-version="{{ $pkgVersion('hashids/hashids') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[20px]">tag</span>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Hashids for Laravel</span>
                                        <span class="px-2 py-0.5 rounded bg-surface-container-highest text-tertiary font-label-sm text-label-sm uppercase">ID Obfuscation</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">hashids/hashids</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('hashids/hashids', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="hashids/hashids" data-target="hashids/hashids" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">แปลงเลขอินเด็กซ์ฐานข้อมูลเป็นแฮชสั้นสุ่ม เพื่อความปลอดภัยและซ่อน ID จริงใน URL/API</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require hashids/hashids</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('hashids/hashids')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('hashids/hashids') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('hashids/hashids')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 2. UI & Frontend -->
            <section class="flex flex-col gap-space-md" data-category-group="ui">
                <div class="flex items-center justify-between pb-1">
                    <div class="flex items-center gap-space-sm">
                        <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined text-[18px]">web</span>
                        </div>
                        <div>
                            <h2 class="font-headline-sm text-headline-sm text-on-surface">UI &amp; Frontend Systems (Bootstrap 5.3)</h2>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">Vite pipeline, responsive tables, and input formatters</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                    <!-- Bootstrap Locked -->
                    <div class="pkg-card relative p-space-md rounded-xl bg-surface-container-low flex flex-col justify-between gap-space-md shadow-md" data-name="twbs/bootstrap" data-version="{{ $pkgVersion('twbs/bootstrap') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-secondary-container/20 flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-[20px]">layers</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">Bootstrap {{ $pkgStat('twbs/bootstrap')['clean_version'] ?? '5.3.3' }} + Vite</span>
                                    <span class="font-label-sm text-label-sm text-primary font-code-inline">System Core (Locked)</span>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-outline text-[20px]" title="Required Core Module">lock</span>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">แกนหลัก UI พร้อม SCSS, Vite 5 HMR, Popper.js และรองรับ Dark Mode เต็มรูปแบบ</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">npm i bootstrap@^{{ $pkgStat('twbs/bootstrap')['clean_version'] ?? '5.3.3' }} @popperjs/core</span>
                            <div class="flex items-center gap-2">
                                @if(!empty($pkgStat('twbs/bootstrap')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('twbs/bootstrap') }}
                                    </span>
                                @endif
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-tertiary">CORE_BASE</span>
                            </div>
                        </div>
                    </div>

                    <!-- Yajra DataTables -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="yajra/laravel-datatables" data-version="{{ $pkgVersion('yajra/laravel-datatables') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-[20px]">table_chart</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Yajra DataTables</span>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">Server-side Data Grid</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('yajra/laravel-datatables', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="yajra/laravel-datatables" data-target="yajra/laravel-datatables" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">แสดงผลตารางข้อมูลขนาดใหญ่แบบ Server-side รองรับค้นหา จัดเรียง แบ่งหน้า และ Export Excel/PDF</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require yajra/laravel-datatables</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('yajra/laravel-datatables')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('yajra/laravel-datatables') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('yajra/laravel-datatables')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SweetAlert2 -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="sweetalert2/toastr" data-version="{{ $pkgVersion('sweetalert2/toastr') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-[20px]">notifications_active</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">SweetAlert2 &amp; Toastr</span>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">Feedback UI</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('sweetalert2/toastr', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="sweetalert2/toastr" data-target="sweetalert2/toastr" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">กล่องแจ้งเตือนสวยงาม ยืนยันการลบแบบโต้ตอบ และ Flash Notification อัตโนมัติ</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">npm i sweetalert2 toastr</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('sweetalert2/toastr')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('sweetalert2/toastr') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('sweetalert2/toastr')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Blade Icons -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="blade-ui-kit/blade-icons" data-version="{{ $pkgVersion('blade-ui-kit/blade-icons') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-[20px]">category</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Blade UI Kit + Tabler Icons</span>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">SVG Engine</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('blade-ui-kit/blade-icons', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="blade-ui-kit/blade-icons" data-target="blade-ui-kit/blade-icons" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">ชุดคอมโพเนนต์ Blade และไอคอน SVG คมชัดกว่า 1,400+ ไอคอน ใช้งานง่ายผ่านแท็ก x-</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require ryangjchandler/blade-tabler-icons</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('blade-ui-kit/blade-icons')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('blade-ui-kit/blade-icons') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('blade-ui-kit/blade-icons')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AutoNumeric -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="autonumeric" data-version="{{ $pkgVersion('autonumeric') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-[20px]">payments</span>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">AutoNumeric</span>
                                        <span class="px-2 py-0.5 rounded bg-surface-container-highest text-secondary font-label-sm text-label-sm uppercase">Input Mask &amp; Currency</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">AutoNumeric.js</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('autonumeric', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="autonumeric" data-target="autonumeric" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">ปรับแต่งรูปแบบตัวเลข ทศนิยม และสกุลเงินอัตโนมัติ (ใส่คอมม่าเรียลไทม์) ขณะพิมพ์ในฟอร์ม Bootstrap</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">npm i autonumeric</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('autonumeric')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('autonumeric') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('autonumeric')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart.js -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="chart.js" data-version="{{ $pkgVersion('chart.js') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[20px]">bar_chart</span>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Chart.js</span>
                                        <span class="px-2 py-0.5 rounded bg-surface-container-highest text-primary font-label-sm text-label-sm uppercase">Data Visualization</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">chart.js</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('chart.js', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="chart.js" data-target="chart.js" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">แผนภูมิและกราฟสถิติแบบอินเทอร์แอคทีฟ (Line, Bar, Doughnut, Radar) ยอดนิยมสำหรับระบบ Dashboard</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">npm i chart.js</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('chart.js')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('chart.js') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('chart.js')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Select2 -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="select2" data-version="{{ $pkgVersion('select2') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-tertiary">
                                    <span class="material-symbols-outlined text-[20px]">fact_check</span>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Select2</span>
                                        <span class="px-2 py-0.5 rounded bg-surface-container-highest text-tertiary font-label-sm text-label-sm uppercase">Advanced Dropdown</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">select2</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('select2', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="select2" data-target="select2" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">ดรอปดาวน์อัจฉริยะ ค้นหาตัวเลือกได้ (Searchable Dropdown), รองรับเลือกหลายรายการ (Multi-select) และ Remote Data</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">npm i select2</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('select2')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('select2') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('select2')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- jQuery UI Datepicker (พ.ศ.) -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="jquery-ui-datepicker" data-version="{{ $pkgVersion('jquery-ui-datepicker') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">jQuery UI Datepicker (พ.ศ.)</span>
                                        <span class="px-2 py-0.5 rounded bg-surface-container-highest text-primary font-label-sm text-label-sm uppercase">Thai Buddhist</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">jquery-ui</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('jquery-ui-datepicker', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="jquery-ui-datepicker" data-target="jquery-ui-datepicker" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">ปฏิทินเลือกวันที่ภาษาไทย รองรับปี พ.ศ. (+543) อัตโนมัติ พร้อมปุ่มล้างค่า (Clear) ตามมาตรฐาน MA BUCC</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">npm i jquery-ui</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('jquery-ui-datepicker')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('jquery-ui-datepicker') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('jquery-ui-datepicker')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dropzone.js -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="dropzone" data-version="{{ $pkgVersion('dropzone') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-[20px]">upload_file</span>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Dropzone.js</span>
                                        <span class="px-2 py-0.5 rounded bg-surface-container-highest text-secondary font-label-sm text-label-sm uppercase">Drag &amp; Drop</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">dropzone</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('dropzone', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="dropzone" data-target="dropzone" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">ระบบอัปโหลดไฟล์แบบลากและวาง (Drag &amp; Drop File Upload) พร้อม Preview แสดงขนาดไฟล์และแถบความคืบหน้า</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">npm i dropzone</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('dropzone')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('dropzone') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('dropzone')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DataTables Bootstrap 5 -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="datatables-bs5" data-version="{{ $pkgVersion('datatables-bs5') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-tertiary">
                                    <span class="material-symbols-outlined text-[20px]">table_view</span>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">DataTables Bootstrap 5</span>
                                        <span class="px-2 py-0.5 rounded bg-surface-container-highest text-tertiary font-label-sm text-label-sm uppercase">Client/Server Grid</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">datatables.net-bs5</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('datatables-bs5', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="datatables-bs5" data-target="datatables-bs5" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">ไลบรารีจัดการตารางข้อมูล Client-side และ Server-side พร้อมธีม Bootstrap 5.3 ค้นหา เรียงลำดับ และแบ่งหน้า</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">npm i datatables.net-bs5</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('datatables-bs5')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('datatables-bs5') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('datatables-bs5')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 3. Data Processing & Reports -->
            <section class="flex flex-col gap-space-md" data-category-group="data">
                <div class="flex items-center justify-between pb-1">
                    <div class="flex items-center gap-space-sm">
                        <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-tertiary">
                            <span class="material-symbols-outlined text-[18px]">query_stats</span>
                        </div>
                        <div>
                            <h2 class="font-headline-sm text-headline-sm text-on-surface">Data Processing &amp; Media Pipelines</h2>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">Spreadsheet transformations, PDF compiling, and media storage</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                    <!-- Yajra Laravel OCI8 -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="yajra/laravel-oci8" data-version="^{{ $laravelMajor }}.0">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-9 h-9 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[18px]">database</span>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-1.5">
                                        <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Yajra OCI8</span>
                                        <span class="px-1.5 py-0.5 rounded bg-surface-container-highest text-primary font-label-sm text-label-sm uppercase">Oracle DB</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">yajra/laravel-oci8:^{{ $laravelMajor }}</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('yajra/laravel-oci8', false) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="yajra/laravel-oci8" data-target="yajra/laravel-oci8" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Oracle Database Driver สำหรับ Laravel Eloquent &amp; Query Builder รองรับ Sequence และ Triggers</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require yajra/laravel-oci8:^{{ $laravelMajor }}</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('yajra/laravel-oci8')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('yajra/laravel-oci8') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('yajra/laravel-oci8')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Laravel Excel -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="maatwebsite/excel" data-version="{{ $pkgVersion('maatwebsite/excel') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-9 h-9 rounded-lg bg-surface-container-highest flex items-center justify-center text-tertiary">
                                    <span class="material-symbols-outlined text-[18px]">file_save</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Laravel Excel</span>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">XLSX / CSV</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('maatwebsite/excel', false) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="maatwebsite/excel" data-target="maatwebsite/excel" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">นำเข้าและส่งออกไฟล์ Excel/CSV ความเร็วสูง รองรับการแบ่ง Chunk และคิวประมวลผลขนาดใหญ่</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require maatwebsite/excel</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('maatwebsite/excel')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('maatwebsite/excel') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('maatwebsite/excel')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DomPDF -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="barryvdh/laravel-dompdf" data-version="{{ $pkgVersion('barryvdh/laravel-dompdf') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-9 h-9 rounded-lg bg-surface-container-highest flex items-center justify-center text-tertiary">
                                    <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Laravel DomPDF</span>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">Barryvdh Engine</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('barryvdh/laravel-dompdf', false) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="barryvdh/laravel-dompdf" data-target="barryvdh/laravel-dompdf" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">สร้างไฟล์ PDF สวยงาม แปลงตรงจาก Blade View และ HTML/CSS สำหรับใบเสร็จและรายงาน</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require barryvdh/laravel-dompdf</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('barryvdh/laravel-dompdf')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('barryvdh/laravel-dompdf') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('barryvdh/laravel-dompdf')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MediaLibrary -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="spatie/laravel-medialibrary" data-version="{{ $pkgVersion('spatie/laravel-medialibrary') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-9 h-9 rounded-lg bg-surface-container-highest flex items-center justify-center text-outline">
                                    <span class="material-symbols-outlined text-[18px]">photo_library</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Spatie MediaLibrary</span>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">Asset Bucket</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('spatie/laravel-medialibrary', false) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="spatie/laravel-medialibrary" data-target="spatie/laravel-medialibrary" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">จัดการไฟล์ อัปโหลดรูปภาพ ปรับขนาดอัตโนมัติ เชื่อมโยงกับ Model และรองรับ S3/R2</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require spatie/laravel-medialibrary</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('spatie/laravel-medialibrary')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('spatie/laravel-medialibrary') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('spatie/laravel-medialibrary')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- mPDF -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="mpdf/mpdf" data-version="{{ $pkgVersion('mpdf/mpdf') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-9 h-9 rounded-lg bg-surface-container-highest flex items-center justify-center text-tertiary">
                                    <span class="material-symbols-outlined text-[18px]">description</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">mPDF</span>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">UTF-8 Thai PDF</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('mpdf/mpdf', false) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="mpdf/mpdf" data-target="mpdf/mpdf" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">สร้างไฟล์ PDF คุณภาพสูง รองรับภาษาไทย (UTF-8) สมบูรณ์แบบ พร้อมระบบ Barcode และลายน้ำ</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require mpdf/mpdf</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('mpdf/mpdf')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('mpdf/mpdf') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('mpdf/mpdf')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PhpSpreadsheet -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="phpoffice/phpspreadsheet" data-version="{{ $pkgVersion('phpoffice/phpspreadsheet') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-9 h-9 rounded-lg bg-surface-container-highest flex items-center justify-center text-tertiary">
                                    <span class="material-symbols-outlined text-[18px]">table_view</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">PhpSpreadsheet</span>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">XLSX / CSV / ODS</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('phpoffice/phpspreadsheet', false) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="phpoffice/phpspreadsheet" data-target="phpoffice/phpspreadsheet" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">ไลบรารีมาตรฐานสำหรับอ่าน-เขียนไฟล์สเปรดชีต (XLSX, CSV, ODS) พร้อมจัดสไตล์เซลล์ขั้นสูง</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require phpoffice/phpspreadsheet</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('phpoffice/phpspreadsheet')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('phpoffice/phpspreadsheet') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('phpoffice/phpspreadsheet')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PHPWord -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="phpoffice/phpword" data-version="{{ $pkgVersion('phpoffice/phpword') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-9 h-9 rounded-lg bg-surface-container-highest flex items-center justify-center text-tertiary">
                                    <span class="material-symbols-outlined text-[18px]">article</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">PHPWord</span>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">DOCX &amp; Word</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('phpoffice/phpword', false) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="phpoffice/phpword" data-target="phpoffice/phpword" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">ไลบรารีสร้างและอ่านไฟล์เอกสาร Word (DOCX) รองรับ Template และจดหมายเวียน</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require phpoffice/phpword</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('phpoffice/phpword')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('phpoffice/phpword') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('phpoffice/phpword')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 4. DevTools -->
            <section class="flex flex-col gap-space-md" data-category-group="devtools">
                <div class="flex items-center justify-between pb-1">
                    <div class="flex items-center gap-space-sm">
                        <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[18px]">terminal</span>
                        </div>
                        <div>
                            <h2 class="font-headline-sm text-headline-sm text-on-surface">DevTools &amp; Quality Control</h2>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">Profilers, testing frameworks, and static analysis</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                    <!-- Debugbar -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="barryvdh/laravel-debugbar" data-version="{{ $pkgVersion('barryvdh/laravel-debugbar') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[20px]">bug_report</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Laravel Debugbar</span>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">Runtime Profiling</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('barryvdh/laravel-debugbar', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="barryvdh/laravel-debugbar" data-target="barryvdh/laravel-debugbar" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">แถบดีบักสำหรับนักพัฒนา แสดงเวลาทำงาน, SQL Query, Memory และ Cache แบบเรียลไทม์</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require barryvdh/laravel-debugbar --dev</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('barryvdh/laravel-debugbar')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('barryvdh/laravel-debugbar') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('barryvdh/laravel-debugbar')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pest PHP -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="pestphp/pest" data-version="{{ $pkgVersion('pestphp/pest') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[20px]">science</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Pest PHP {{ !empty($pkgStat('pestphp/pest')['clean_version']) ? 'v' . explode('.', $pkgStat('pestphp/pest')['clean_version'])[0] : 'v5' }}</span>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">Modern Testing Framework</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('pestphp/pest', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="pestphp/pest" data-target="pestphp/pest" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Modern Testing Framework with architecture testing, type coverage, and snapshot assertions.</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require pestphp/pest --dev</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('pestphp/pest')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('pestphp/pest') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('pestphp/pest')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Larastan -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md" data-name="larastan/larastan" data-version="{{ $pkgVersion('larastan/larastan') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[20px]">rule</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">PHPStan / Larastan</span>
                                    <span class="font-label-sm text-label-sm text-secondary font-code-inline">Static Level 8</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('larastan/larastan', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="larastan/larastan" data-target="larastan/larastan" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">เครื่องมือ Static Code Analysis ตรวจจับบั๊กและข้อผิดพลาดในโค้ดโดยไม่ต้องรัน</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require larastan/larastan --dev</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('larastan/larastan')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('larastan/larastan') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('larastan/larastan')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pest Browser -->
                    <div class="pkg-card group relative p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all flex flex-col justify-between gap-space-md shadow-md md:col-span-2" data-name="pestphp/pest-plugin-browser" data-version="{{ $pkgVersion('pestphp/pest-plugin-browser') }}">
                        <div class="flex items-start justify-between gap-space-sm">
                            <div class="flex items-center gap-space-sm">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[20px]">devices</span>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">Pest Browser Testing</span>
                                        <span class="px-2 py-0.5 rounded bg-surface-container-highest text-secondary font-label-sm text-label-sm uppercase">E2E Automation</span>
                                    </div>
                                    <span class="font-label-sm text-label-sm text-outline font-code-inline">pestphp/pest-plugin-browser</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input {{ $isPkgChecked('pestphp/pest-plugin-browser', true) ? 'checked' : '' }} class="sr-only peer pkg-checkbox" name="packages[]" value="pestphp/pest-plugin-browser" data-target="pestphp/pest-plugin-browser" type="checkbox">
                                <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-primary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">ระบบทดสอบ E2E อัตโนมัติผ่านเบราว์เซอร์ด้วย Pest CLI ร่วมกับ Playwright / Dusk</p>
                        <div class="flex items-center justify-between pt-space-xs font-code-inline text-label-sm">
                            <span class="text-outline">composer require pestphp/pest-plugin-browser --dev</span>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                @if(!empty($pkgStat('pestphp/pest-plugin-browser')['clean_version']))
                                    <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-secondary text-[11px] font-medium flex items-center gap-1" title="Synced from /admin/setting (Live)">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>{{ $pkgVersion('pestphp/pest-plugin-browser') }}
                                    </span>
                                @endif
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">star</span>
                                    <span>{{ $pkgStat('pestphp/pest-plugin-browser')['stars_formatted'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 5. Custom Dependencies (Composer / NPM) -->
            <section class="flex flex-col gap-space-md" data-category-group="custom">
                <div class="flex items-center justify-between pb-1">
                    <div class="flex items-center gap-space-sm">
                        <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[18px]">add_box</span>
                        </div>
                        <div>
                            <h2 class="font-headline-sm text-headline-sm text-on-surface">Custom Dependencies &amp; CLI Packages</h2>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">กรอกคำสั่ง composer require หรือ npm i ด้วยตนเองตามความต้องการของโปรเจกต์</span>
                        </div>
                    </div>
                </div>

                <div class="p-space-lg rounded-xl bg-surface-container-low border border-surface-container-highest/60 flex flex-col gap-space-md shadow-md">
                    <div class="flex flex-col gap-1">
                        <label for="custom-packages" class="font-headline-sm text-headline-sm text-on-surface flex items-center gap-2">
                            <span>Custom Packages &amp; Commands</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container-highest text-secondary font-code-inline text-label-sm">composer / npm</span>
                        </label>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                            พิมพ์รายการแพ็กเกจที่ต้องการติดตั้ง เช่น <code class="text-tertiary">composer require predis/predis:^2.0</code> หรือ <code class="text-secondary">npm i lodash chart.js</code> (บรรทัดละคำสั่ง หรือระบุเฉพาะชื่อแพ็กเกจ)
                        </p>
                    </div>

                    <div class="relative">
                        <textarea id="custom-packages"
                                  name="custom_packages"
                                  rows="4"
                                  class="w-full p-space-md rounded-lg bg-surface-container-lowest text-on-surface font-code-block text-code-block placeholder:text-outline/70 border border-surface-container-highest focus:border-primary focus:outline-none transition-colors leading-relaxed shadow-inner"
                                  placeholder="composer require predis/predis:^2.0&#10;composer require sentry/sentry-laravel --dev&#10;npm i chart.js dayjs">{{ session('project.custom_packages', '') }}</textarea>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-2 pt-1 font-body-sm text-body-sm text-on-surface-variant">
                        <div class="flex items-center gap-1.5 text-outline">
                            <span class="material-symbols-outlined text-[16px]">info</span>
                            <span>ระบบจะแยกประเภท require และ require-dev ให้ใน composer.json แบบเรียลไทม์</span>
                        </div>
                        <span class="font-code-inline text-label-sm text-secondary" id="custom-pkg-count">0 Custom Packages</span>
                    </div>
                </div>
            </section>

            <!-- Empty State when no packages found -->
            <div id="no-packages-found" class="hidden flex-col items-center justify-center p-space-xl bg-surface-container-low rounded-xl text-center border border-surface-container-highest/60 shadow-md">
                <div class="w-14 h-14 rounded-2xl bg-surface-container flex items-center justify-center text-outline mb-3">
                    <span class="material-symbols-outlined text-[32px]">search_off</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-on-surface font-medium">ไม่พบแพ็กเกจที่ตรงกับคำค้นหา</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant max-w-md mt-1">
                    ไม่พบแพ็กเกจในหมวดหมู่นี้ที่ตรงกับคำค้น ลองปรับเปลี่ยนคำค้นหา หรือกดปุ่มด้านล่างเพื่อแสดงแพ็กเกจทั้งหมด
                </p>
                <button type="button" onclick="resetSearchAndFilter()" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-primary font-label-md text-label-md transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                    <span>ล้างคำค้นหา &amp; แสดงทั้งหมด</span>
                </button>
            </div>
        </div>

        <!-- Right Side: Active Stack & composer.json Inspector -->
        <aside class="w-full xl:w-96 flex flex-col gap-space-md sticky top-20">
            <div class="flex flex-col rounded-xl bg-surface-container-low shadow-xl overflow-hidden">
                <div class="flex items-center justify-between px-space-md py-space-sm bg-surface-container">
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-secondary text-[18px]">checklist</span>
                        <span class="font-headline-sm text-headline-sm text-on-surface font-medium">Active Stack</span>
                    </div>
                    <span class="px-2 py-0.5 rounded bg-surface-container-highest text-tertiary font-code-inline text-label-sm" id="stack-count-badge">15 PKGS</span>
                </div>
                <div class="p-space-md flex flex-col gap-space-xs max-h-72 overflow-y-auto" id="selected-list">
                    <!-- Populated via JavaScript -->
                </div>
                <div class="p-space-md bg-surface-container-high/50 flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <span class="font-label-sm text-label-sm text-outline uppercase font-code-block">Compatibility Check</span>
                        <span class="font-label-sm text-label-sm text-tertiary font-code-inline" id="compat-score">Pass 15/15</span>
                    </div>
                    <div class="w-full h-1.5 rounded-full bg-surface-container-highest overflow-hidden">
                        <div class="w-full h-full bg-tertiary"></div>
                    </div>
                </div>
            </div>

            <!-- Code Inspector (composer.json & package.json Tabs) -->
            <div class="flex flex-col rounded-xl bg-surface-container-lowest shadow-xl overflow-hidden border border-surface-container-high/40">
                <div class="flex items-center justify-between px-space-sm py-space-xs bg-surface-container-high border-b border-surface-container-highest/40">
                    <div class="flex items-center gap-space-xs">
                        <div class="flex items-center gap-1.5 px-1">
                            <span class="w-2.5 h-2.5 rounded-full bg-error"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-surface-tint"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-tertiary"></span>
                        </div>
                        <div class="flex items-center bg-surface-container p-0.5 rounded-lg border border-surface-container-highest/60" id="preview-tab-group">
                            <button type="button" id="tab-composer-btn" class="preview-tab flex items-center gap-1 px-2 py-0.5 rounded-md text-label-sm font-code-inline transition-all bg-surface-container-lowest text-primary shadow-sm font-medium cursor-pointer" onclick="switchPreviewTab('composer')">
                                <span class="material-symbols-outlined text-[14px]">php</span>
                                <span>composer.json</span>
                                <span id="composer-badge" class="px-1 rounded bg-primary/10 text-primary text-[10px] font-bold">10</span>
                            </button>
                            <button type="button" id="tab-package-btn" class="preview-tab flex items-center gap-1 px-2 py-0.5 rounded-md text-label-sm font-code-inline transition-all text-outline hover:text-on-surface cursor-pointer" onclick="switchPreviewTab('package')">
                                <span class="material-symbols-outlined text-[14px]">javascript</span>
                                <span>package.json</span>
                                <span id="package-badge" class="px-1 rounded bg-tertiary/10 text-tertiary text-[10px] font-bold">14</span>
                            </button>
                        </div>
                    </div>
                    <button class="flex items-center gap-1 font-code-inline text-label-sm text-outline hover:text-on-surface transition-colors cursor-pointer px-2 py-1" id="copy-json-btn" type="button" title="คัดลอก JSON ของแท็บที่เปิดอยู่">
                        <span class="material-symbols-outlined text-[14px]">content_copy</span>
                        <span id="copy-btn-label">Copy</span>
                    </button>
                </div>
                <div id="pane-composer" class="flex flex-col">
                    <pre class="p-space-md font-code-block text-code-block text-on-surface overflow-x-auto leading-relaxed max-h-80"><code id="composer-preview">{
  <span class="text-secondary">"require"</span>: {
    <span class="text-primary">"php"</span>: <span class="text-tertiary">"{{ $phpConstraint }}"</span>,
    <span class="text-primary">"laravel/framework"</span>: <span class="text-tertiary">"{{ $frameworkConstraint }}"</span>
  }
}</code></pre>
                </div>
                <div id="pane-package" class="flex flex-col hidden">
                    <pre class="p-space-md font-code-block text-code-block text-on-surface overflow-x-auto leading-relaxed max-h-80"><code id="package-preview"></code></pre>
                </div>
            </div>

            <div class="p-space-md rounded-xl bg-surface-container-low flex items-start gap-space-sm shadow-md">
                <span class="material-symbols-outlined text-secondary text-[20px] shrink-0 mt-0.5">info</span>
                <div class="flex flex-col gap-1">
                    <span class="font-headline-sm text-headline-sm text-on-surface font-medium">Auto-Resolved Providers</span>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">
                        Laravel 13 automatically discovers and binds modern service providers from package manifests without editing configuration files.
                    </p>
                </div>
            </div>
        </aside>
    </div>

    <!-- Bottom Navigation -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-space-md pt-space-xl pb-space-lg">
        <a class="btn-artisan-back w-full sm:w-auto flex items-center justify-center gap-space-xs px-space-lg py-2.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-body-md text-body-md transition-colors shadow-sm"
           href="{{ route('generator.step1') }}">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Previous: 1. Project Setup</span>
        </a>
        <button type="submit" class="btn-artisan-continue w-full sm:w-auto flex items-center justify-center gap-space-xs px-space-xl py-2.5 rounded-lg bg-primary-container hover:bg-inverse-primary text-on-primary font-headline-sm text-headline-sm font-medium transition-all shadow-[0_0_20px_rgba(255,85,66,0.3)] cursor-pointer">
            <span>Continue: 3. Modules &amp; Schema</span>
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </button>
    </div>
</form>
</div>
</div>

<script>
    (function () {
        const checkboxes = document.querySelectorAll('.pkg-checkbox');
        const counterEl = document.getElementById('selected-counter');
        const stackBadge = document.getElementById('stack-count-badge');
        const listEl = document.getElementById('selected-list');
        const searchInput = document.getElementById('pkg-search');
        const filterPills = document.querySelectorAll('.filter-pill');
        const pkgCards = document.querySelectorAll('.pkg-card');
        const copyBtn = document.getElementById('copy-json-btn');
        const previewCode = document.getElementById('composer-preview');
        const packagePreviewCode = document.getElementById('package-preview');
        const customTextarea = document.getElementById('custom-packages');
        const customCountEl = document.getElementById('custom-pkg-count');

        const pkgRegistry = @json($pkgRegistry);
        let currentPreviewTab = 'composer';

        window.switchPreviewTab = function(tab) {
            currentPreviewTab = tab;
            const tabComposerBtn = document.getElementById('tab-composer-btn');
            const tabPackageBtn = document.getElementById('tab-package-btn');
            const paneComposer = document.getElementById('pane-composer');
            const panePackage = document.getElementById('pane-package');

            if (tab === 'composer') {
                tabComposerBtn?.classList.add('bg-surface-container-lowest', 'text-primary', 'shadow-sm', 'font-medium');
                tabComposerBtn?.classList.remove('text-outline');
                tabPackageBtn?.classList.remove('bg-surface-container-lowest', 'text-tertiary', 'shadow-sm', 'font-medium');
                tabPackageBtn?.classList.add('text-outline');
                paneComposer?.classList.remove('hidden');
                panePackage?.classList.add('hidden');
            } else {
                tabPackageBtn?.classList.add('bg-surface-container-lowest', 'text-tertiary', 'shadow-sm', 'font-medium');
                tabPackageBtn?.classList.remove('text-outline');
                tabComposerBtn?.classList.remove('bg-surface-container-lowest', 'text-primary', 'shadow-sm', 'font-medium');
                tabComposerBtn?.classList.add('text-outline');
                panePackage?.classList.remove('hidden');
                paneComposer?.classList.add('hidden');
            }
        };

        function parseCustomPackages() {
            if (!customTextarea) return { composerReq: {}, composerDev: {}, npm: [], count: 0 };
            const text = customTextarea.value.trim();
            if (!text) return { composerReq: {}, composerDev: {}, npm: [], count: 0 };

            const composerReq = {};
            const composerDev = {};
            const npm = [];
            const lines = text.split(/\r?\n/);
            let count = 0;

            lines.forEach(line => {
                line = line.trim();
                if (!line || line.startsWith('#') || line.startsWith('//')) return;

                if (/^composer\s+require\s+/i.test(line)) {
                    const cleanLine = line.replace(/^composer\s+require\s+/i, '').trim();
                    const tokens = cleanLine.split(/\s+/);
                    const isDev = tokens.includes('--dev') || tokens.includes('-D');
                    tokens.forEach(tok => {
                        if (tok === '--dev' || tok === '-D' || tok.startsWith('-')) return;
                        const parts = tok.split(':');
                        const name = parts[0];
                        const ver = parts[1] || '*';
                        if (name) {
                            count++;
                            if (isDev) composerDev[name] = ver;
                            else composerReq[name] = ver;
                        }
                    });
                } else if (/^npm\s+(i|install|add)\s+/i.test(line)) {
                    const cleanLine = line.replace(/^npm\s+(i|install|add)\s+/i, '').trim();
                    const tokens = cleanLine.split(/\s+/);
                    const isDev = tokens.includes('--save-dev') || tokens.includes('-D');
                    tokens.forEach(tok => {
                        if (tok === '--save-dev' || tok === '-D' || tok.startsWith('-')) return;
                        if (tok) {
                            count++;
                            let name = tok;
                            let ver = '^1.0';
                            if (tok.startsWith('@')) {
                                const subparts = tok.substring(1).split('@');
                                name = '@' + subparts[0];
                                ver = subparts[1] || '^1.0';
                            } else if (tok.includes('@')) {
                                const parts = tok.split('@');
                                name = parts[0];
                                ver = parts[1] || '^1.0';
                            }
                            if (!ver.startsWith('^') && !ver.startsWith('~') && !ver.startsWith('>') && !ver.startsWith('=')) {
                                ver = '^' + ver;
                            }
                            npm.push({ name, ver, isDev });
                        }
                    });
                } else if (line.includes('/')) {
                    const parts = line.split(':');
                    const name = parts[0].trim();
                    const ver = parts[1] ? parts[1].trim() : '*';
                    if (name) {
                        count++;
                        composerReq[name] = ver;
                    }
                } else {
                    const parts = line.split(':');
                    const name = parts[0].trim();
                    if (name && !name.startsWith('-')) {
                        count++;
                        composerReq[name] = parts[1] ? parts[1].trim() : '*';
                    }
                }
            });

            return { composerReq, composerDev, npm, count };
        }

        function updateComposerJson(custom, checkedBoxes) {
            let req = { "php": "{{ $phpConstraint }}", "laravel/framework": "{{ $frameworkConstraint }}" };
            let reqDev = {};

            checkedBoxes.forEach(cb => {
                const name = cb.getAttribute('data-target');
                const meta = pkgRegistry[name];
                // Exclude NPM packages from composer.json
                if (meta && meta.source === 'npm') return;

                const card = cb.closest('.pkg-card');
                const version = card ? (card.getAttribute('data-version') || meta?.version || '^1.0') : (meta?.version || '^1.0');

                if (meta?.is_dev || name === 'laravel/breeze' || name.includes('pest') || name.includes('larastan') || name.includes('debugbar')) {
                    reqDev[name] = version;
                } else {
                    req[name] = version;
                }
            });

            if (custom) {
                Object.assign(req, custom.composerReq);
                Object.assign(reqDev, custom.composerDev);
            }

            const jsonStr = JSON.stringify({ "require": req, "require-dev": reqDev }, null, 2);
            if (previewCode) {
                previewCode.textContent = jsonStr;
            }

            const composerBadge = document.getElementById('composer-badge');
            if (composerBadge) {
                composerBadge.textContent = Object.keys(req).length + Object.keys(reqDev).length;
            }
        }

        function updatePackageJson(custom, checkedBoxes) {
            if (!packagePreviewCode) return;

            const baseDev = {
                "@popperjs/core": "^2.11.8",
                "axios": "^1.7.4",
                "bootstrap": "{{ $bootstrapConstraint }}",
                "bootstrap-icons": "^1.11.3",
                "laravel-vite-plugin": "^1.0",
                "sass": "^1.77.8",
                "vite": "^5.0"
            };

            const dynamicDev = {};
            let hasJqueryCandidate = false;

            checkedBoxes.forEach(cb => {
                const name = cb.getAttribute('data-target');
                const meta = pkgRegistry[name];
                const card = cb.closest('.pkg-card');
                const version = card ? (card.getAttribute('data-version') || meta?.version || '^1.0') : (meta?.version || '^1.0');
                const cleanVer = version.startsWith('^') ? version : '^' + version;

                if (meta && meta.source === 'npm') {
                    const npmName = meta.npm_name || name;
                    dynamicDev[npmName] = cleanVer;
                }

                // Auto-add jquery if select2, jquery-ui-datepicker, datatables-bs5, or yajra is selected
                if (name === 'select2' || name === 'jquery-ui-datepicker' || name === 'datatables-bs5' || name === 'yajra/laravel-datatables') {
                    hasJqueryCandidate = true;
                }
            });

            // Check custom text for jQuery indicators
            const customText = customTextarea ? (customTextarea.value || '').toLowerCase() : '';
            if (customText.includes('jquery') || customText.includes('select2') || customText.includes('datatables')) {
                hasJqueryCandidate = true;
            }

            if (hasJqueryCandidate && !dynamicDev['jquery']) {
                const jqueryVer = pkgRegistry['jquery']?.version || '^3.7.1';
                dynamicDev['jquery'] = jqueryVer.startsWith('^') ? jqueryVer : '^' + jqueryVer;
            }

            // Custom NPM packages
            if (custom && custom.npm) {
                custom.npm.forEach(item => {
                    dynamicDev[item.name] = item.ver || '^1.0';
                });
            }

            // Merge and sort devDependencies alphabetically
            const allDev = Object.assign({}, baseDev, dynamicDev);
            const sortedDev = Object.keys(allDev).sort().reduce((acc, k) => {
                acc[k] = allDev[k];
                return acc;
            }, {});

            const packageObj = {
                "private": true,
                "name": "{{ $projectSlug }}",
                "type": "module",
                "scripts": {
                    "postinstall": "node scripts/copy-plugins.mjs",
                    "build:plugins": "node scripts/copy-plugins.mjs",
                    "dev": "vite",
                    "build": "vite build"
                },
                "devDependencies": sortedDev
            };

            packagePreviewCode.textContent = JSON.stringify(packageObj, null, 2);

            const packageBadge = document.getElementById('package-badge');
            if (packageBadge) {
                packageBadge.textContent = Object.keys(sortedDev).length;
            }
        }

        function refreshActiveStack() {
            listEl.innerHTML = '';
            // Core Bootstrap (NPM)
            const coreRow = document.createElement('div');
            coreRow.className = 'flex items-center justify-between py-1 px-2 rounded bg-surface-container-lowest font-code-inline text-code-inline';
            coreRow.innerHTML = '<div class="flex items-center gap-1.5 min-w-0"><span class="px-1 py-0.2 rounded bg-tertiary/10 text-tertiary text-[9px] font-bold uppercase shrink-0">NPM</span><span class="text-on-surface font-medium truncate max-w-[170px]">twbs/bootstrap</span></div><span class="text-secondary text-label-sm shrink-0">{{ $pkgVersion("twbs/bootstrap") }}</span>';
            listEl.appendChild(coreRow);

            const checkedBoxes = Array.from(checkboxes).filter(cb => cb.checked);
            checkedBoxes.forEach(cb => {
                const target = cb.getAttribute('data-target');
                const meta = pkgRegistry[target];
                const isNpm = (meta && meta.source === 'npm');
                const card = cb.closest('.pkg-card');
                const version = card ? (card.getAttribute('data-version') || meta?.version || '^1.0') : (meta?.version || '^1.0');

                const badgeHtml = isNpm
                    ? '<span class="px-1 py-0.2 rounded bg-tertiary/10 text-tertiary text-[9px] font-bold uppercase shrink-0">NPM</span>'
                    : '<span class="px-1 py-0.2 rounded bg-primary/10 text-primary text-[9px] font-bold uppercase shrink-0">PHP</span>';

                const row = document.createElement('div');
                row.className = 'flex items-center justify-between py-1 px-2 rounded bg-surface-container-lowest font-code-inline text-code-inline';
                row.setAttribute('data-pkg-id', target);
                row.innerHTML = `<div class="flex items-center gap-1.5 min-w-0">${badgeHtml}<span class="text-on-surface font-medium truncate max-w-[170px]">${target}</span></div><span class="text-outline text-label-sm shrink-0">${version}</span>`;
                listEl.appendChild(row);
            });

            const custom = parseCustomPackages();
            if (customCountEl) {
                customCountEl.textContent = `${custom.count} Custom Package${custom.count === 1 ? '' : 's'}`;
            }

            // Custom composer packages
            Object.entries(custom.composerReq).forEach(([name, ver]) => {
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between py-1 px-2 rounded bg-surface-container-lowest font-code-inline text-code-inline border-l-2 border-primary';
                row.innerHTML = `<div class="flex items-center gap-1.5 min-w-0"><span class="px-1 py-0.2 rounded bg-primary/10 text-primary text-[9px] font-bold uppercase shrink-0">PHP</span><span class="text-on-surface font-medium truncate max-w-[170px]">${name}</span></div><span class="text-primary text-label-sm shrink-0">${ver}</span>`;
                listEl.appendChild(row);
            });
            Object.entries(custom.composerDev).forEach(([name, ver]) => {
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between py-1 px-2 rounded bg-surface-container-lowest font-code-inline text-code-inline border-l-2 border-secondary';
                row.innerHTML = `<div class="flex items-center gap-1.5 min-w-0"><span class="px-1 py-0.2 rounded bg-secondary/10 text-secondary text-[9px] font-bold uppercase shrink-0">PHP (dev)</span><span class="text-on-surface font-medium truncate max-w-[170px]">${name}</span></div><span class="text-secondary text-label-sm shrink-0">${ver}</span>`;
                listEl.appendChild(row);
            });
            // Custom npm packages
            custom.npm.forEach(item => {
                const row = document.createElement('div');
                row.className = 'flex items-center justify-between py-1 px-2 rounded bg-surface-container-lowest font-code-inline text-code-inline border-l-2 border-tertiary';
                row.innerHTML = `<div class="flex items-center gap-1.5 min-w-0"><span class="px-1 py-0.2 rounded bg-tertiary/10 text-tertiary text-[9px] font-bold uppercase shrink-0">NPM</span><span class="text-on-surface font-medium truncate max-w-[170px]">${item.name}</span></div><span class="text-tertiary text-label-sm shrink-0">${item.ver || 'npm'}</span>`;
                listEl.appendChild(row);
            });

            const total = checkedBoxes.length + 1 + custom.count;
            counterEl.textContent = total + ' Packages';
            stackBadge.textContent = total + ' PKGS';
            document.getElementById('compat-score').textContent = `Pass ${total}/${total}`;
            const estBuildEl = document.getElementById('estimated-build');
            if (estBuildEl) {
                estBuildEl.textContent = `~${Math.max(15, Math.round(total * 3.2))}s`;
            }

            updateComposerJson(custom, checkedBoxes);
            updatePackageJson(custom, checkedBoxes);
        }

        function applySearchAndFilter() {
            const query = (searchInput.value || '').toLowerCase().trim();
            const activePill = document.querySelector('.filter-pill.active') || document.querySelector('.filter-pill[data-filter="all"]');
            const filter = activePill ? activePill.getAttribute('data-filter') : 'all';
            const clearBtn = document.getElementById('clear-search-btn');
            if (clearBtn) {
                clearBtn.classList.toggle('hidden', query.length === 0);
            }

            const groups = document.querySelectorAll('[data-category-group]');
            let totalVisibleCards = 0;

            groups.forEach(group => {
                const groupCategory = group.getAttribute('data-category-group');
                const isGroupMatched = (filter === 'all' || groupCategory === filter);

                if (groupCategory === 'custom') {
                    // Custom dependencies section only depends on category filter
                    group.classList.toggle('hidden', !isGroupMatched);
                    return;
                }

                if (!isGroupMatched) {
                    group.classList.add('hidden');
                    return;
                }

                const cards = group.querySelectorAll('.pkg-card');
                let visibleInGroup = 0;
                cards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    const matchesSearch = query === '' || text.includes(query);
                    card.classList.toggle('hidden', !matchesSearch);
                    if (matchesSearch) {
                        visibleInGroup++;
                    }
                });

                // Hide entire category block if no cards inside it match search
                group.classList.toggle('hidden', visibleInGroup === 0);
                totalVisibleCards += visibleInGroup;
            });

            const noResultEl = document.getElementById('no-packages-found');
            if (noResultEl) {
                const showEmpty = (totalVisibleCards === 0 && filter !== 'custom');
                noResultEl.classList.toggle('hidden', !showEmpty);
                noResultEl.classList.toggle('flex', showEmpty);
            }
        }

        window.resetSearchAndFilter = function() {
            if (searchInput) {
                searchInput.value = '';
            }
            filterPills.forEach(p => {
                p.classList.remove('active', 'bg-primary-container', 'text-on-primary');
                p.classList.add('bg-surface-container', 'text-on-surface-variant');
            });
            const allPill = document.querySelector('.filter-pill[data-filter="all"]');
            if (allPill) {
                allPill.classList.add('active', 'bg-primary-container', 'text-on-primary');
                allPill.classList.remove('bg-surface-container', 'text-on-surface-variant');
            }
            applySearchAndFilter();
            if (searchInput) {
                searchInput.focus();
            }
        };

        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                refreshActiveStack();
            });
        });

        if (customTextarea) {
            customTextarea.addEventListener('input', () => {
                refreshActiveStack();
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', () => {
                applySearchAndFilter();
            });
        }

        filterPills.forEach(pill => {
            pill.addEventListener('click', () => {
                filterPills.forEach(p => {
                    p.classList.remove('active', 'bg-primary-container', 'text-on-primary');
                    p.classList.add('bg-surface-container', 'text-on-surface-variant');
                });
                pill.classList.remove('bg-surface-container', 'text-on-surface-variant');
                pill.classList.add('active', 'bg-primary-container', 'text-on-primary');

                applySearchAndFilter();
            });
        });

        // Keyboard shortcuts: '/' to focus search, 'Escape' to clear
        document.addEventListener('keydown', (e) => {
            const activeTag = document.activeElement ? document.activeElement.tagName : '';
            if (e.key === '/' && activeTag !== 'INPUT' && activeTag !== 'TEXTAREA') {
                e.preventDefault();
                if (searchInput) {
                    searchInput.focus();
                    searchInput.select();
                }
            } else if (e.key === 'Escape' && document.activeElement === searchInput) {
                e.preventDefault();
                if (searchInput.value.trim() !== '') {
                    window.resetSearchAndFilter();
                } else {
                    searchInput.blur();
                }
            }
        });

        if (copyBtn) {
            copyBtn.addEventListener('click', () => {
                const targetText = (currentPreviewTab === 'composer')
                    ? (previewCode ? previewCode.innerText : '')
                    : (packagePreviewCode ? packagePreviewCode.innerText : '');
                const label = (currentPreviewTab === 'composer') ? 'คัดลอก composer.json สำเร็จ' : 'คัดลอก package.json สำเร็จ';
                copySnippet(copyBtn, targetText, label);
            });
        }

        // Initialize on load
        refreshActiveStack();
        applySearchAndFilter();
    })();
</script>
@endsection
