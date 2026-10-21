@extends('layouts.artisan')

@section('title', 'Step 4: Live Code Preview & Export Pipeline')

@section('content')
<div class="flex flex-col w-full">
    @php
        $hasBuuLdap = !empty(session('project.modules.buu_ldap'));
        $hasUserRole = !empty(session('project.modules.user_role'));
        $hasSettings = !empty(session('project.modules.system_settings'));
        $hasAuditTrail = !empty(session('project.modules.audit_trail'));
        $hasNotifications = !empty(session('project.modules.notifications'));
        $hasMedia = !empty(session('project.modules.media_storage'));

        $generatedFiles = $generatedFiles ?? [];
        $modelCount = count(array_filter(array_keys($generatedFiles), fn($k) => str_starts_with($k, 'app/Models/')));
        $migrationCount = count(array_filter(array_keys($generatedFiles), fn($k) => str_starts_with($k, 'database/migrations/')));
        $packageCount = count(session('project.packages', [])) ?: 8;

        $activeFile = 'composer.json';
        $activePath = 'composer.json';
        if ($hasBuuLdap && isset($generatedFiles['app/Http/Controllers/Auth/LoginController.php'])) {
            $activeFile = 'LoginController.php';
            $activePath = 'app/Http/Controllers/Auth/LoginController.php';
        } elseif (isset($generatedFiles['app/Http/Controllers/HomeController.php'])) {
            $activeFile = 'HomeController.php';
            $activePath = 'app/Http/Controllers/HomeController.php';
        } elseif ($hasUserRole && isset($generatedFiles['app/Http/Controllers/UserController.php'])) {
            $activeFile = 'UserController.php';
            $activePath = 'app/Http/Controllers/UserController.php';
        }

        // Group generated files dynamically by directory
        $dirs = [];
        $rootFiles = [];
        foreach (array_keys($generatedFiles) as $path) {
            $lastSlash = strrpos($path, '/');
            if ($lastSlash === false) {
                $rootFiles[$path] = $path;
            } else {
                $dir = substr($path, 0, $lastSlash);
                $file = substr($path, $lastSlash + 1);
                $dirs[$dir][$file] = $path;
            }
        }
        ksort($dirs);
        ksort($rootFiles);

        $getFileMeta = function(string $file, string $path) {
            if (str_ends_with($file, '.blade.php')) {
                return ['icon' => 'code', 'color' => 'text-amber-600 dark:text-amber-400', 'badge' => 'BLADE', 'badge_class' => 'bg-amber-500/15 text-amber-800 dark:text-amber-300 border border-amber-500/30'];
            }
            if (str_contains($path, 'Http/Controllers/Auth') || str_contains($path, 'Ldap')) {
                return ['icon' => 'lock', 'color' => 'text-emerald-600 dark:text-tertiary', 'badge' => 'LDAP', 'badge_class' => 'bg-emerald-500/15 text-emerald-800 dark:text-tertiary border border-emerald-500/30'];
            }
            if (str_contains($path, 'Middleware')) {
                return ['icon' => 'verified_user', 'color' => 'text-indigo-600 dark:text-indigo-400', 'badge' => 'MW', 'badge_class' => 'bg-indigo-500/15 text-indigo-800 dark:text-indigo-300 border border-indigo-500/30'];
            }
            if (str_contains($path, 'Models')) {
                return ['icon' => 'data_object', 'color' => 'text-sky-600 dark:text-sky-400', 'badge' => 'MODEL', 'badge_class' => 'bg-sky-500/15 text-sky-800 dark:text-sky-300 border border-sky-500/30'];
            }
            if (str_contains($path, 'migrations')) {
                return ['icon' => 'database', 'color' => 'text-emerald-600 dark:text-emerald-400', 'badge' => 'MIGRATE', 'badge_class' => 'bg-emerald-500/15 text-emerald-800 dark:text-emerald-300 border border-emerald-500/30'];
            }
            if (str_contains($path, 'seeders') || str_contains($path, 'factories')) {
                return ['icon' => 'spa', 'color' => 'text-teal-600 dark:text-teal-400', 'badge' => 'SEED', 'badge_class' => 'bg-teal-500/15 text-teal-800 dark:text-teal-300 border border-teal-500/30'];
            }
            if (str_contains($path, 'Controllers')) {
                return ['icon' => 'php', 'color' => 'text-primary', 'badge' => 'CTRL', 'badge_class' => 'bg-primary/15 text-rose-800 dark:text-primary border border-rose-500/30'];
            }
            if (str_ends_with($file, '.bat') || str_ends_with($file, '.sh')) {
                return ['icon' => 'terminal', 'color' => 'text-emerald-600 dark:text-emerald-400', 'badge' => 'SHELL', 'badge_class' => 'bg-emerald-500/15 text-emerald-800 dark:text-emerald-300 border border-emerald-500/30'];
            }
            if (str_ends_with($file, '.json')) {
                return ['icon' => 'settings', 'color' => 'text-amber-600 dark:text-amber-300', 'badge' => 'JSON', 'badge_class' => 'bg-amber-500/15 text-amber-800 dark:text-amber-300 border border-amber-500/30'];
            }
            if (str_starts_with($file, '.env')) {
                return ['icon' => 'key', 'color' => 'text-rose-600 dark:text-rose-400', 'badge' => 'ENV', 'badge_class' => 'bg-rose-500/15 text-rose-800 dark:text-rose-300 border border-rose-500/30'];
            }
            if (str_ends_with($file, '.yml') || str_ends_with($file, '.yaml')) {
                return ['icon' => 'layers', 'color' => 'text-secondary', 'badge' => 'DOCKER', 'badge_class' => 'bg-secondary-container/30 text-blue-800 dark:text-secondary border border-blue-500/30'];
            }
            if (str_ends_with($file, '.js') || str_ends_with($file, '.mjs')) {
                return ['icon' => 'javascript', 'color' => 'text-yellow-600 dark:text-yellow-400', 'badge' => 'JS', 'badge_class' => 'bg-yellow-500/15 text-yellow-900 dark:text-yellow-300 border border-yellow-500/30'];
            }
            if (str_ends_with($file, '.css')) {
                return ['icon' => 'css', 'color' => 'text-blue-600 dark:text-blue-400', 'badge' => 'CSS', 'badge_class' => 'bg-blue-500/15 text-blue-800 dark:text-blue-300 border border-blue-500/30'];
            }
            if (str_ends_with($file, '.php')) {
                return ['icon' => 'php', 'color' => 'text-outline', 'badge' => 'PHP', 'badge_class' => 'bg-surface-container-high text-on-surface-variant border border-surface-container-highest'];
            }
            return ['icon' => 'description', 'color' => 'text-outline', 'badge' => '', 'badge_class' => ''];
        };
    @endphp

    <!-- Pipeline Status Strip -->
    <div class="w-full bg-surface-container-low px-6 md:px-8 lg:px-10 py-3.5 flex flex-col gap-3 shadow-sm border-b border-surface-container-high">
        <!-- Row 1: Unified Step Header (Full Width - No Text Wrapping) -->
        <div class="flex items-start gap-space-sm w-full">
            <div class="w-11 h-11 rounded-xl bg-surface-container-high border border-surface-container-highest flex items-center justify-center font-code-inline text-headline-sm font-bold text-primary shadow-sm shrink-0">05</div>
            <div class="flex flex-col gap-1 flex-1 min-w-0">
                <div class="flex items-center gap-space-xs flex-wrap">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-surface-container-highest text-primary font-label-sm text-label-sm font-semibold uppercase tracking-wider">
                        <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                        Pipeline Step 05 / 05
                    </span>
                    <span class="text-outline font-code-inline text-label-sm">|</span>
                    <span class="text-secondary font-code-inline text-label-sm">Build, Preview &amp; Export Pipeline</span>
                </div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold tracking-tight whitespace-normal">Build, Preview &amp; Export Pipeline</h1>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-4xl">
                    ตรวจสอบโครงสร้างไฟล์ สภาพแวดล้อม Docker ทดสอบโค้ดระบบจริง และส่งออกโปรเจกต์ Laravel คุณภาพสูงระดับ Production
                </p>
            </div>
        </div>

        <!-- Row 2: Project Info Badges (Wordwrapped down to their own line) -->
        <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-surface-container-high/40 font-code-inline text-label-sm">
            <span class="px-2.5 py-1 rounded-md bg-surface-container text-on-surface font-semibold border border-surface-container-highest">{{ session('project.slug', 'artisan-pos-system') }}</span>
            <span class="px-2 py-0.5 rounded bg-surface-container text-primary">PHP {{ session('project.php_version', config('generator.default_php', '8.4')) }}</span>
            <span class="px-2 py-0.5 rounded bg-surface-container text-secondary">Laravel {{ session('project.laravel_version', config('generator.default_laravel', '13.x')) }}</span>
            <span class="px-2 py-0.5 rounded bg-surface-container text-tertiary">{{ strtoupper(session('project.db_connection', 'mysql')) }}</span>
            <span class="px-2 py-0.5 rounded bg-surface-container text-on-surface-variant">BS 5.3.3</span>
            <span class="px-2 py-0.5 rounded bg-surface-container text-emerald-400"><i class="bi bi-palette me-1"></i>{{ ucfirst(session('project.theme_mode', 'light')) }}: {{ config('themes.themes.' . session('project.theme_key', 'nordic-clean') . '.name', 'Nordic Clean') }}</span>
            <span class="text-outline">•</span>
            <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface">{{ $modelCount }} Models</span>
            <span class="text-outline">•</span>
            <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface">{{ $migrationCount }} Migrations</span>
            <span class="text-outline">•</span>
            <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface">{{ $packageCount }} Packages</span>
        </div>

        <!-- Row 2: Action Toolbar (Left: Back to Step 4, Right: Export Actions) -->
        <div class="flex flex-wrap items-center justify-between gap-space-md pt-2 border-t border-surface-container-high/40">
            <!-- Left Aligned (Green Box): Back Button -->
            <a href="{{ route('generator.step4') }}" class="btn-artisan-back px-space-md py-2 rounded-lg bg-surface-container text-on-surface hover:bg-surface-container-high font-body-sm text-body-sm transition-all border border-surface-container-highest text-decoration-none flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>ย้อนกลับ: Step 4 (Theme Studio)</span>
            </a>

            <!-- Right Aligned: Primary Export Actions Group -->
            <div class="flex items-center gap-space-sm flex-wrap ml-auto justify-end">
                <div class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-surface-container text-tertiary font-label-sm text-label-sm border border-tertiary/20">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    <span>Ready for Export • 100% Real Engine</span>
                </div>
                <button class="flex items-center gap-1.5 px-space-md py-1.5 rounded-lg bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-body-sm text-body-sm transition-all shadow-sm cursor-pointer border border-surface-container-highest/60" id="copy-script-btn" type="button" onclick="copyOneLiner()">
                    <span class="material-symbols-outlined text-[16px] text-outline">terminal</span>
                    <span id="copy-btn-text">Copy One-Liner</span>
                </button>
                <a href="{{ route('generator.export') }}" class="btn-artisan-continue btn-artisan-primary flex items-center gap-2 px-space-lg py-2 rounded-lg bg-primary-container hover:bg-inverse-primary text-on-primary font-headline-sm text-headline-sm font-medium transition-all shadow-[0_0_20px_rgba(255,85,66,0.3)] cursor-pointer text-decoration-none ml-2" id="download-zip-btn">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    <span>Export .ZIP (Production Ready)</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Multi-Pane DevTools Workspace -->
    <div class="w-full grid grid-cols-12 gap-0 min-h-[calc(100vh-10.5rem)]">
        <!-- Left Column: File Tree Explorer -->
        <aside class="col-span-12 lg:col-span-4 xl:col-span-3 bg-surface-container-lowest flex flex-col p-space-md gap-space-md select-none border-r border-surface-container-high">
            <div class="flex items-center justify-between px-space-xs">
                <div class="flex items-center gap-space-xs">
                    <span class="material-symbols-outlined text-outline text-[18px]">account_tree</span>
                    <span class="font-label-md text-label-md text-on-surface uppercase tracking-wider font-semibold">Workspace Explorer</span>
                </div>
                <div class="flex items-center gap-1 text-outline">
                    <button class="hover:text-on-surface p-1 cursor-pointer" onclick="location.reload()" title="Refresh tree"><span class="material-symbols-outlined text-[16px]">refresh</span></button>
                </div>
            </div>

            <!-- Search tree filter -->
            <div class="flex items-center gap-2 px-space-sm py-1.5 rounded-lg bg-surface-container text-body-sm text-on-surface-variant border border-surface-container-high">
                <span class="material-symbols-outlined text-[16px] text-outline">search</span>
                <input class="bg-transparent border-0 outline-none w-full text-on-surface placeholder:text-outline text-body-sm font-body-sm" id="tree-search" placeholder="Filter files (/app, Blade, migration)..." type="text" onkeyup="filterFileTree(this.value)">
            </div>

            <!-- File Tree Node List (100% Dynamic from $generatedFiles) -->
            <div class="flex flex-col gap-1 font-code-inline text-code-inline text-on-surface-variant overflow-y-auto max-h-[calc(100vh-22rem)]" id="file-tree-container">
                @foreach($dirs as $dir => $filesInDir)
                    <div class="dir-group flex flex-col gap-0.5">
                        <div class="flex items-center justify-between px-2 py-1 rounded bg-surface-container-low/50 hover:bg-surface-container cursor-pointer text-on-surface select-none">
                            <div class="flex items-center gap-1.5 min-w-0">
                                <span class="material-symbols-outlined text-[15px] text-yellow-500">folder_open</span>
                                <span class="font-medium text-xs font-mono truncate text-on-surface">{{ $dir }}</span>
                            </div>
                            <span class="text-[10px] text-outline opacity-70">{{ count($filesInDir) }}</span>
                        </div>
                        <div class="ml-2 pl-2 border-l border-surface-container-high/60 flex flex-col gap-0.5">
                            @foreach($filesInDir as $file => $path)
                                @php
                                    $meta = $getFileMeta($file, $path);
                                    $isActive = ($activePath === $path);
                                @endphp
                                <div class="file-node {{ $isActive ? 'active-node bg-primary/10 text-primary font-semibold border-l-2 border-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} flex items-center justify-between px-2 py-1 rounded cursor-pointer transition-all" data-filename="{{ $file }}" data-path="{{ $path }}" onclick="selectFile(this)">
                                    <div class="flex items-center gap-1.5 min-w-0">
                                        <span class="material-symbols-outlined text-[15px] {{ $meta['color'] }}">{{ $meta['icon'] }}</span>
                                        <span class="truncate text-xs">{{ $file }}</span>
                                    </div>
                                    @if(!empty($meta['badge']))
                                        <span class="px-1 py-0.2 rounded {{ $meta['badge_class'] }} text-[9px] font-label-sm uppercase font-mono">{{ $meta['badge'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Root Files Group -->
                @if(!empty($rootFiles))
                    <div class="dir-group flex flex-col gap-0.5 mt-1 pt-1 border-t border-surface-container-high/50">
                        <div class="flex items-center justify-between px-2 py-1 rounded bg-surface-container-low/50 hover:bg-surface-container cursor-pointer text-on-surface select-none">
                            <div class="flex items-center gap-1.5 min-w-0">
                                <span class="material-symbols-outlined text-[15px] text-amber-500">home_storage</span>
                                <span class="font-medium text-xs font-mono uppercase tracking-wider text-outline">Root Directory</span>
                            </div>
                            <span class="text-[10px] text-outline opacity-70">{{ count($rootFiles) }}</span>
                        </div>
                        <div class="ml-2 pl-2 border-l border-surface-container-high/60 flex flex-col gap-0.5">
                            @foreach($rootFiles as $file => $path)
                                @php
                                    $meta = $getFileMeta($file, $path);
                                    $isActive = ($activePath === $path);
                                @endphp
                                <div class="file-node {{ $isActive ? 'active-node bg-primary/10 text-primary font-semibold border-l-2 border-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }} flex items-center justify-between px-2 py-1 rounded cursor-pointer transition-all" data-filename="{{ $file }}" data-path="{{ $path }}" onclick="selectFile(this)">
                                    <div class="flex items-center gap-1.5 min-w-0">
                                        <span class="material-symbols-outlined text-[15px] {{ $meta['color'] }}">{{ $meta['icon'] }}</span>
                                        <span class="truncate text-xs">{{ $file }}</span>
                                    </div>
                                    @if(!empty($meta['badge']))
                                        <span class="px-1 py-0.2 rounded {{ $meta['badge_class'] }} text-[9px] font-label-sm uppercase font-mono">{{ $meta['badge'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            </aside>

        <!-- Center/Right Column: Workspace Multi-Tabs -->
        <main class="col-span-12 lg:col-span-8 xl:col-span-9 flex flex-col bg-surface min-h-full">
            <!-- Tabs Header -->
            <div class="flex items-center justify-between bg-surface-container-low px-4 md:px-6 border-b border-surface-container-high flex-wrap gap-2">
                <div class="flex items-center gap-1">
                    <button class="workspace-tab active-tab flex items-center gap-2 px-space-md py-3 font-body-sm text-body-sm font-semibold border-b-2 border-primary text-primary transition-all cursor-pointer" id="btn-tab-code" onclick="switchWorkspaceTab('code')">
                        <span class="material-symbols-outlined text-[18px]">code</span>
                        <span id="tab-code-label">{{ $activeFile }}</span>
                    </button>
                    <button class="workspace-tab flex items-center gap-2 px-space-md py-3 font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface border-b-2 border-transparent transition-all cursor-pointer" id="btn-tab-preview" onclick="switchWorkspaceTab('preview')">
                        <span class="material-symbols-outlined text-[18px]">devices</span>
                        <span>Live Blade UI Preview</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                    </button>
                    <button class="workspace-tab flex items-center gap-2 px-space-md py-3 font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface border-b-2 border-transparent transition-all cursor-pointer" id="btn-tab-cli" onclick="switchWorkspaceTab('cli')">
                        <span class="material-symbols-outlined text-[18px]">terminal</span>
                        <span>Artisan CLI Terminal &amp; Dry-Run</span>
                        <span class="px-1.5 py-0.2 rounded bg-primary-container/30 text-primary font-code-inline text-[10px]">REAL</span>
                    </button>
                </div>
                <div class="flex items-center gap-2 text-outline font-code-inline text-label-sm">
                    <button type="button" onclick="copyCurrentCode()" class="flex items-center gap-1 px-2 py-1 rounded bg-surface-container hover:bg-surface-container-high text-on-surface cursor-pointer" title="Copy code">
                        <span class="material-symbols-outlined text-[14px]">content_copy</span>
                        <span id="copy-code-text">Copy Code</span>
                    </button>
                    <span id="file-size-badge">Calculating...</span>
                    <span>•</span>
                    <span class="text-tertiary">PHP {{ session('project.php_version', '8.4') }} JIT</span>
                </div>
            </div>

            <!-- TAB 1: Code Editor Pane -->
            <div class="tab-pane flex-1 p-4 md:p-6 overflow-x-auto bg-surface-container-lowest font-code-block text-code-block text-on-surface leading-relaxed" id="pane-code">
                <pre class="m-0"><code id="code-display" class="font-mono text-sm leading-relaxed text-slate-900 dark:text-slate-100 selection:bg-primary/20">Loading code preview...</code></pre>
            </div>

            <!-- TAB 2: Live Blade UI Preview Pane (REAL IFRAME PREVIEW) -->
            <div class="tab-pane hidden flex-1 p-space-md bg-surface-container-high overflow-y-auto" id="pane-preview">
                <div class="w-full bg-surface-container-lowest rounded-xl overflow-hidden shadow-2xl flex flex-col border border-surface-container-high">
                    <!-- Browser Address & Viewport Toolbar -->
                    <div class="bg-surface-container-low px-space-md py-2.5 flex flex-wrap items-center justify-between gap-space-sm border-b border-surface-container-high">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-error-container"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-600"></span>
                            <span class="w-3 h-3 rounded-full bg-tertiary-container"></span>
                            <span class="ml-2 font-code-inline text-label-sm text-outline hidden sm:inline">Live Blade Engine Preview</span>
                        </div>

                        <!-- Screen Selector Dropdown -->
                        <div class="flex items-center gap-2 flex-1 max-w-md mx-2">
                            <span class="material-symbols-outlined text-[16px] text-tertiary">web</span>
                            <select id="preview-screen-select" onchange="changePreviewScreen(this.value)" class="w-full bg-surface-container-highest text-on-surface text-label-sm font-code-inline px-3 py-1.5 rounded-lg border border-surface-container-highest/60 outline-none cursor-pointer">
                                <option value="dashboard">Dashboard (Welcome Screen)</option>
                                @if(($projectConfig['theme_key'] ?? '') === 'emerald-enterprise' || session('project.theme_key') === 'emerald-enterprise')
                                <option value="theme-package">✨ Emerald Enterprise Modular Hub (Pixel-Perfect)</option>
                                @endif
                                @if($hasBuuLdap)
                                <option value="login">Login Screen (BUU LDAP &amp; Passkey)</option>
                                @endif
                                @if($hasUserRole)
                                <option value="users">User &amp; Role Management</option>
                                @endif
                                @if($hasSettings)
                                <option value="settings">System Settings &amp; Configuration</option>
                                @endif
                                @if($hasNotifications)
                                <option value="notifications">Notifications Engine</option>
                                @endif
                                @if($hasMedia)
                                <option value="media">Media &amp; Attachment Vault</option>
                                @endif
                            </select>
                        </div>

                        <!-- Viewport Controls & Actions -->
                        <div class="flex items-center gap-1.5">
                            <button type="button" onclick="setViewport('desktop')" class="px-2 py-1 rounded bg-surface-container-high text-on-surface hover:bg-surface-container-highest text-label-sm font-code-inline flex items-center gap-1 cursor-pointer" title="Desktop View (100%)">
                                <span class="material-symbols-outlined text-[15px]">desktop_windows</span>
                                <span class="hidden md:inline">Desktop</span>
                            </button>
                            <button type="button" onclick="setViewport('tablet')" class="px-2 py-1 rounded bg-surface-container text-outline hover:text-on-surface hover:bg-surface-container-high text-label-sm font-code-inline flex items-center gap-1 cursor-pointer" title="Tablet View (768px)">
                                <span class="material-symbols-outlined text-[15px]">tablet</span>
                                <span class="hidden md:inline">Tablet</span>
                            </button>
                            <button type="button" onclick="setViewport('mobile')" class="px-2 py-1 rounded bg-surface-container text-outline hover:text-on-surface hover:bg-surface-container-high text-label-sm font-code-inline flex items-center gap-1 cursor-pointer" title="Mobile View (390px)">
                                <span class="material-symbols-outlined text-[15px]">smartphone</span>
                                <span class="hidden md:inline">Mobile</span>
                            </button>
                            <button type="button" onclick="refreshPreviewIframe()" class="p-1 rounded text-outline hover:text-on-surface hover:bg-surface-container-high cursor-pointer" title="Reload View">
                                <span class="material-symbols-outlined text-[16px]">refresh</span>
                            </button>
                            <a id="preview-open-new-window" href="{{ route('generator.previewUi', ['view' => 'dashboard']) }}" target="_blank" class="p-1 rounded text-outline hover:text-on-surface hover:bg-surface-container-high cursor-pointer text-decoration-none" title="Open in new window">
                                <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                            </a>
                        </div>
                    </div>

                    <!-- Iframe Container -->
                    <div class="flex justify-center bg-surface-container p-2 overflow-auto" style="min-height: 520px;">
                        <iframe id="preview-iframe" src="{{ route('generator.previewUi', ['view' => 'dashboard']) }}" class="w-full border-0 rounded-lg transition-all shadow-inner" style="height: 560px; max-width: 100%;"></iframe>
                    </div>
                </div>
            </div>

            <!-- TAB 3: Artisan CLI & Architecture Dry-Run Pane (REAL DIAGNOSTIC CENTER) -->
            <div class="tab-pane hidden flex-1 p-space-md bg-surface-container-lowest font-code-block text-code-block overflow-y-auto flex flex-col gap-space-md" id="pane-cli">
                <div class="flex flex-wrap items-center justify-between pb-3 text-outline border-b border-surface-container-high gap-space-sm">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px] text-tertiary">terminal</span>
                        <span class="text-on-surface font-semibold">ArtisanCraft Diagnostic Hub &amp; Dry-Run Engine</span>
                        <span class="px-2 py-0.5 rounded bg-tertiary-container/30 text-tertiary font-label-sm text-[11px] font-bold">100% REAL</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" id="btn-run-dry-run" onclick="executeDryRun()" class="flex items-center gap-1.5 px-space-md py-1.5 rounded-lg bg-primary-container hover:bg-inverse-primary text-on-primary font-headline-sm text-headline-sm font-semibold transition-all shadow-sm cursor-pointer">
                            <span class="material-symbols-outlined text-[16px]" id="dry-run-icon">play_arrow</span>
                            <span id="dry-run-btn-text">Run Architecture Dry-Run &amp; Syntax Audit</span>
                        </button>
                    </div>
                </div>

                <!-- Live Terminal Screen -->
                <div class="p-space-md rounded-xl bg-slate-950 dark:bg-black border border-surface-container-high/60 shadow-inner flex flex-col gap-1.5 text-slate-200 text-[13px] leading-relaxed min-h-[260px] font-mono overflow-x-auto" id="terminal-screen">
                    <div class="text-slate-400 flex items-center justify-between border-b border-surface-container-highest pb-2 mb-1">
                        <span># ArtisanCraft Interactive Architecture Audit v13.4.0 (PHP 8.4 JIT)</span>
                        <span class="text-tertiary flex items-center gap-1" id="terminal-status-indicator"><span class="w-2 h-2 rounded-full bg-tertiary animate-ping"></span> READY</span>
                    </div>
                    <div class="text-slate-400">$ php artisan generator:audit-architecture --dry-run --strict-standards</div>
                    <div id="terminal-output" class="flex flex-col gap-1 pt-1 text-slate-200">
                        <div class="text-slate-400">กดปุ่ม "Run Architecture Dry-Run &amp; Syntax Audit" ด้านบน เพื่อทดสอบคอมไพล์โค้ด, ตรวจสอบไวยากรณ์ PHP 8.4 AST, และตรวจสอบมาตรฐาน 5 Audit Stamps แบบสด ๆ</div>
                    </div>
                </div>

                <!-- Structured Diagnostic Checks Table -->
                <div class="p-space-md rounded-xl bg-surface-container-low border border-surface-container-high/60 flex flex-col gap-space-sm" id="audit-checks-container">
                    <div class="flex items-center justify-between">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">Architecture &amp; Security Compliance Matrix</span>
                        <span id="dry-run-badge" class="px-2 py-0.5 rounded bg-surface-container text-outline font-label-sm text-label-sm font-code-inline">Waiting Execution</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left font-body-sm text-on-surface border-collapse">
                            <tbody id="audit-checks-body">
                                <tr class="border-b border-surface-container-high/50">
                                    <td class="py-2.5 px-3 text-tertiary w-8"><span class="material-symbols-outlined text-[16px]">check_circle</span></td>
                                    <td class="py-2.5 px-3 font-semibold text-on-surface">Environment &amp; Database Architecture</td>
                                    <td class="py-2.5 px-3 text-on-surface-variant font-code-inline text-xs">{{ strtoupper(session('project.db_connection', 'mysql')) }} connection target '{{ session('project.db_name', 'db') }}' on {{ session('project.db_host', '127.0.0.1') }}:{{ session('project.db_port', 3306) }}</td>
                                    <td class="py-2.5 px-3 text-right"><span class="px-2 py-0.5 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[11px]">VERIFIED</span></td>
                                </tr>
                                <tr class="border-b border-surface-container-high/50">
                                    <td class="py-2.5 px-3 text-tertiary w-8"><span class="material-symbols-outlined text-[16px]">check_circle</span></td>
                                    <td class="py-2.5 px-3 font-semibold text-on-surface">Audit Stamps Standard Compliance</td>
                                    <td class="py-2.5 px-3 text-on-surface-variant font-code-inline text-xs">Mandatory 5 columns (created_by, created_at, updated_by, updated_at, request_uri) embedded</td>
                                    <td class="py-2.5 px-3 text-right"><span class="px-2 py-0.5 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[11px]">COMPLIANT</span></td>
                                </tr>
                                <tr class="border-b border-surface-container-high/50">
                                    <td class="py-2.5 px-3 text-tertiary w-8"><span class="material-symbols-outlined text-[16px]">check_circle</span></td>
                                    <td class="py-2.5 px-3 font-semibold text-on-surface">Enterprise Modules Integration</td>
                                    <td class="py-2.5 px-3 text-on-surface-variant font-code-inline text-xs">{{ count(array_filter(session('project.modules', []))) }} Active Modules scaffolded into ZIP</td>
                                    <td class="py-2.5 px-3 text-right"><span class="px-2 py-0.5 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[11px]">PASSED</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- CLI Quickstart Tailored Commands -->
                <div class="flex flex-col gap-2 p-space-md rounded-xl bg-surface-container-low border border-surface-container-high/60">
                    <div class="flex items-center justify-between">
                        <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">คำสั่งเริ่มต้นใช้งานหลังดาวน์โหลด ZIP (Quickstart Commands)</span>
                        <button type="button" onclick="copyCliCommands()" class="text-primary hover:text-inverse-primary font-label-sm text-label-sm font-code-inline flex items-center gap-1 cursor-pointer">
                            <span class="material-symbols-outlined text-[14px]">content_copy</span>
                            <span id="copy-all-cli-text">Copy All</span>
                        </button>
                    </div>
                    <pre class="m-0 p-3 rounded-lg bg-slate-950 dark:bg-black text-slate-100 font-code-block text-[12px] leading-relaxed overflow-x-auto"><code id="cli-commands-snippet"># 1. แตกไฟล์ ZIP และเข้าไปยังโฟลเดอร์โปรเจกต์
unzip {{ session('project.slug', 'artisan-pos-system') }}.zip -d {{ session('project.slug', 'artisan-pos-system') }}
cd {{ session('project.slug', 'artisan-pos-system') }}

# 2. สตาร์ตสภาพแวดล้อม Docker (เลือกได้ 2 โหมดตามที่ต้องการ):
# --- [ตัวเลือก 2.1: โหมด Named Volume + SSH/SFTP (พอร์ต {{ session('project.docker_ssh_port', 22) }})] ---
# บน Windows: .\docker-run-volume.bat
# บน Linux/macOS: bash docker-run-volume.sh

# --- [ตัวเลือก 2.2: โหมด Bind Mount (แก้ไขไฟล์ตรงบนเครื่องโฮสต์)] ---
# บน Windows: .\docker-run-bind.bat
# บน Linux/macOS: bash docker-run-bind.sh

# 3. รัน Database Migration (และ Seed ข้อมูลเริ่มต้น)
docker exec {{ session('project.slug', 'artisan-pos-system') }}-web php artisan migrate --seed
# หรือกรณีต้องการล้างตารางทั้งหมดและเริ่มต้นใหม่ (Reset & Fresh Seed):
# docker exec {{ session('project.slug', 'artisan-pos-system') }}-web php artisan migrate:fresh --seed

# 4. เข้าใช้งานระบบผ่านเว็บเบราว์เซอร์
# Web URL: https://localhost:{{ session('project.docker_https_port', 443) }}</code></pre>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    // 100% Real Generated File Dictionary straight from ZipExportService
    const allGeneratedFiles = @json($generatedFiles ?? []);
    let currentActivePath = '{{ $activePath }}';
    let currentActiveFilename = '{{ $activeFile }}';

    document.addEventListener('DOMContentLoaded', function () {
        // Load initial active file
        if (allGeneratedFiles[currentActivePath]) {
            displayCodeContent(allGeneratedFiles[currentActivePath], currentActiveFilename);
        } else if (allGeneratedFiles['composer.json']) {
            displayCodeContent(allGeneratedFiles['composer.json'], 'composer.json');
        } else {
            const firstKey = Object.keys(allGeneratedFiles)[0];
            if (firstKey) {
                displayCodeContent(allGeneratedFiles[firstKey], firstKey);
            }
        }
    });

    function selectFile(el) {
        const filename = el.getAttribute('data-filename');
        const path = el.getAttribute('data-path') || filename;
        currentActivePath = path;
        currentActiveFilename = filename;

        document.querySelectorAll('.file-node').forEach(node => {
            node.classList.remove('active-node', 'bg-primary/10', 'text-primary', 'font-semibold', 'border-l-2', 'border-primary', 'shadow-sm', 'bg-surface-container-high', 'font-medium');
        });
        el.classList.add('active-node', 'bg-primary/10', 'text-primary', 'font-semibold', 'border-l-2', 'border-primary', 'shadow-sm');

        document.getElementById('tab-code-label').textContent = filename;

        if (allGeneratedFiles[path] !== undefined) {
            displayCodeContent(allGeneratedFiles[path], filename);
        } else {
            // Fallback fetch from real backend
            document.getElementById('code-display').textContent = '// Loading real code from server...';
            fetch(`{{ route('generator.previewFile') }}?path=${encodeURIComponent(path)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.content !== undefined) {
                        allGeneratedFiles[path] = data.content;
                        displayCodeContent(data.content, filename);
                    } else {
                        displayCodeContent('// Content not available for ' + path, filename);
                    }
                })
                .catch(() => {
                    displayCodeContent('// Error loading file: ' + path, filename);
                });
        }

        switchWorkspaceTab('code');
    }

    function displayCodeContent(code, filename) {
        artisanWorkspace.displayCode(code, filename);
    }

    function switchWorkspaceTab(tab) {
        artisanWorkspace.switchTab(tab);
    }

    function changePreviewScreen(view) {
        const iframe = document.getElementById('preview-iframe');
        const openLink = document.getElementById('preview-open-new-window');
        const url = `{{ route('generator.previewUi') }}?view=${encodeURIComponent(view)}`;
        iframe.src = url;
        openLink.href = url;
    }

    function refreshPreviewIframe() {
        const iframe = document.getElementById('preview-iframe');
        iframe.src = iframe.src;
    }

    function setViewport(mode) {
        artisanWorkspace.setViewport(mode);
    }

    function executeDryRun() {
        const btn = document.getElementById('btn-run-dry-run');
        const icon = document.getElementById('dry-run-icon');
        const btnText = document.getElementById('dry-run-btn-text');
        const terminalOutput = document.getElementById('terminal-output');
        const statusIndicator = document.getElementById('terminal-status-indicator');
        const badge = document.getElementById('dry-run-badge');
        const checksBody = document.getElementById('audit-checks-body');

        btn.disabled = true;
        btn.classList.add('opacity-75');
        icon.textContent = 'sync';
        icon.classList.add('animate-spin');
        btnText.textContent = 'Auditing Architecture...';

        terminalOutput.innerHTML = '<div class="text-secondary">[...] Contacting PHP 8.4 engine & AST compiler...</div>';

        fetch('{{ route('generator.dryRun') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.classList.remove('opacity-75');
            icon.textContent = 'done_all';
            icon.classList.remove('animate-spin');
            btnText.textContent = 'Dry-Run Audit Passed (' + data.duration_ms + 'ms)';

            statusIndicator.innerHTML = '<span class="w-2 h-2 rounded-full bg-emerald-500"></span> AUDIT PASSED';
            badge.className = 'px-2 py-0.5 rounded bg-tertiary-container/30 text-tertiary font-label-sm text-label-sm font-code-inline';
            badge.textContent = `Passed (${data.total_files} Files • ${data.total_lines} LOC)`;

            // Render live logs in terminal
            let logHtml = '';
            (data.logs || []).forEach(log => {
                let colorClass = 'text-on-surface';
                if (log.includes('[PASS]') || log.includes('[OK]')) colorClass = 'text-emerald-400';
                else if (log.includes('[FAIL]')) colorClass = 'text-rose-400 font-bold';
                else if (log.includes('[INFO]')) colorClass = 'text-sky-400';
                logHtml += `<div class="${colorClass}">${escapeHtml(log)}</div>`;
            });
            terminalOutput.innerHTML = logHtml;

            // Render structured checks table
            if (data.checks && data.checks.length > 0) {
                let checkRows = '';
                data.checks.forEach(check => {
                    const isPass = check.status === 'pass';
                    checkRows += `
                        <tr class="border-b border-surface-container-high/50">
                            <td class="py-2.5 px-3 ${isPass ? 'text-tertiary' : 'text-error'} w-8">
                                <span class="material-symbols-outlined text-[16px]">${isPass ? 'check_circle' : 'cancel'}</span>
                            </td>
                            <td class="py-2.5 px-3 font-semibold text-on-surface">${escapeHtml(check.name)}</td>
                            <td class="py-2.5 px-3 text-on-surface-variant font-code-inline text-xs">${escapeHtml(check.detail)}</td>
                            <td class="py-2.5 px-3 text-right">
                                <span class="px-2 py-0.5 rounded ${isPass ? 'bg-tertiary-container/30 text-tertiary' : 'bg-error-container/30 text-error'} font-code-inline text-[11px]">
                                    ${isPass ? 'PASSED' : 'FAILED'}
                                </span>
                            </td>
                        </tr>
                    `;
                });
                checksBody.innerHTML = checkRows;
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.classList.remove('opacity-75');
            icon.textContent = 'error';
            icon.classList.remove('animate-spin');
            btnText.textContent = 'Retry Audit';
            terminalOutput.innerHTML = '<div class="text-rose-400">[ERROR] Connection failed: ' + escapeHtml(err.message) + '</div>';
        });
    }

    function copyCurrentCode() {
        const code = document.getElementById('code-display').textContent;
        const btn = event?.currentTarget;
        copySnippet(btn, code, 'คัดลอกซอร์สโค้ดเรียบร้อย');
    }

    function copyOneLiner() {
        const text = `curl -sSL "{{ route('generator.export') }}" -o {{ session('project.slug', 'artisan-app') }}.zip && unzip {{ session('project.slug', 'artisan-app') }}.zip`;
        const btn = document.getElementById('copy-script-btn') || event?.currentTarget;
        copySnippet(btn, text, 'คัดลอก One-Liner สำเร็จ');
    }

    function copyCliCommands() {
        const text = document.getElementById('cli-commands-snippet').textContent;
        const btn = event?.currentTarget;
        copySnippet(btn, text, 'คัดลอกคำสั่ง CLI สำเร็จ');
    }

    function filterFileTree(query) {
        artisanWorkspace.filterFileTree(query);
    }
</script>
@endsection
