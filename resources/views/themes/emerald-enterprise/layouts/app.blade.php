<!DOCTYPE html>
<html lang="th" data-bs-theme="light" data-theme="emerald-enterprise">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Artisan POS & Inventory Hub') }}</title>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme Design System Assets -->
    <link rel="stylesheet" href="{{ secure_asset('css/themes/emerald-enterprise.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/theme-core.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/style.css') }}">

    <!-- Tailwind 3.4 Runtime with Emerald Sovereign Extended Tokens -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            "darkMode": "class",
            "theme": {
                "extend": {
                    "colors": {
                        "primary": "#047857",
                        "primary-container": "#005d42",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#9ffdd3",
                        "primary-fixed": "#97f5cc",
                        "primary-fixed-dim": "#7bd8b1",
                        "inverse-primary": "#7bd8b1",
                        "secondary": "#006c49",
                        "secondary-container": "#ecfdf5",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#047857",
                        "secondary-fixed": "#89f5e7",
                        "secondary-fixed-dim": "#6bd8cb",
                        "tertiary": "#495167",
                        "tertiary-container": "#616980",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-container": "#e4e9ff",
                        "tertiary-fixed": "#dae2fd",
                        "tertiary-fixed-dim": "#bec6e0",
                        "on-tertiary-fixed": "#131b2e",
                        "surface": "#f7f9fb",
                        "surface-dim": "#d8dadc",
                        "surface-bright": "#f7f9fb",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f2f4f6",
                        "surface-container": "#eceef0",
                        "surface-container-high": "#e6e8ea",
                        "surface-container-highest": "#e0e3e5",
                        "on-surface": "#191c1e",
                        "on-surface-variant": "#3e4943",
                        "inverse-surface": "#2d3133",
                        "inverse-on-surface": "#eff1f3",
                        "outline": "#6e7a73",
                        "outline-variant": "#bdc9c1",
                        "surface-tint": "#006c4e",
                        "background": "#f7f9fb",
                        "on-background": "#191c1e",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error": "#ffffff",
                        "on-error-container": "#93000a"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "sm": "0.125rem",
                        "md": "0.375rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "space-xs": "0.25rem",
                        "space-sm": "0.5rem",
                        "space-md": "0.75rem",
                        "space-lg": "1.25rem",
                        "space-xl": "2rem",
                        "gutter": "1.5rem",
                        "gutter-mobile": "1rem",
                        "gutter-desktop": "1.5rem",
                        "margin": "2rem",
                        "margin-mobile": "1rem",
                        "margin-desktop": "2.5rem"
                    },
                    "fontFamily": {
                        "sans": ["Inter", "sans-serif"],
                        "body-md": ["Inter", "sans-serif"],
                        "label-sm": ["Inter", "sans-serif"],
                        "label-md": ["Inter", "sans-serif"],
                        "label-lg": ["Inter", "sans-serif"],
                        "headline-sm": ["Inter", "sans-serif"],
                        "headline-md": ["Inter", "sans-serif"],
                        "headline-lg": ["Inter", "sans-serif"],
                        "headline-xl": ["Inter", "sans-serif"],
                        "metric-sm": ["Inter", "sans-serif"],
                        "metric-lg": ["Inter", "sans-serif"]
                    }
                }
            }
        };
    </script>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f7f9fb;
            color: #191c1e;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>
</head>
<body class="bg-background font-body-md text-on-surface antialiased">

    <!-- Top Navigation Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] border-b border-surface-container-high/60">
        <div class="h-16 w-full px-4 lg:px-6 flex items-center justify-between">
            <div class="flex items-center gap-space-lg">
                <div class="flex items-center gap-space-sm">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm uppercase tracking-wider font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                        Emerald Enterprise
                    </span>
                    <div class="h-4 w-px bg-outline-variant hidden sm:block"></div>
                    <a href="{{ Route::has('demo.index') ? route('demo.index') : url('/') }}" class="flex items-center gap-1.5 text-decoration-none">
                        <span class="font-headline-sm font-bold text-primary">Artisan</span>
                        <span class="font-headline-sm font-semibold text-on-surface">{{ config('app.name', 'POS & Inventory Hub') }}</span>
                    </a>
                </div>

                <div class="hidden xl:flex items-center gap-space-xs ml-space-md">
                    <a class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-label-md transition-colors text-decoration-none" href="{{ Route::has('demo.index') ? route('demo.index') : url('/') }}">
                        <span class="material-symbols-outlined text-[16px]">terminal</span> Demo Hub
                    </a>
                    @if(Route::has('switch.group'))
                    <a class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-label-md transition-colors text-decoration-none" href="{{ route('switch.group') }}">
                        <span class="material-symbols-outlined text-[16px]">manage_accounts</span> UMS บทบาท
                    </a>
                    @endif
                    @if(Route::has('demo.ums'))
                    <a class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-label-md transition-colors text-decoration-none" href="{{ route('demo.ums') }}">
                        <span class="material-symbols-outlined text-[16px]">sync_alt</span> UMS Connector
                    </a>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-space-md">
                @auth
                <div class="flex items-center gap-space-sm px-3 py-1.5 rounded-lg bg-surface-container-lowest shadow-[0_1px_4px_rgba(0,0,0,0.03)] border border-surface-container-high/60">
                    <div class="flex flex-col text-right">
                        <span class="font-label-sm font-semibold text-on-surface leading-tight">{{ session('userFullNameTH') ?? (Auth::user()->name ?? Auth::user()->username) }}</span>
                        <div class="flex items-center justify-end gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                            <span class="font-label-sm text-primary leading-none">{{ session('userPermitName') ?? (Auth::user()->currentRole->role_name_th ?? (Auth::user()->role->name ?? 'ผู้ใช้งาน UMS BUU')) }}</span>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->username ?? 'U', 0, 1)) }}
                    </div>
                </div>

                @if(session()->has('userGroup') && count(session('userGroup', [])) > 1)
                <a href="{{ Route::has('switch.group') ? route('switch.group') : '#' }}" class="p-2 rounded-lg bg-surface-container hover:bg-emerald-50 text-primary transition-colors cursor-pointer border border-surface-container-high/60" title="สลับกลุ่มงาน (Switch Role)">
                    <span class="material-symbols-outlined text-[18px]">cached</span>
                </a>
                @endif

                <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" class="m-0 p-0 inline-flex">
                    @csrf
                    <button type="submit" class="p-2 rounded-lg bg-surface-container hover:bg-red-50 text-on-surface-variant hover:text-red-600 transition-colors cursor-pointer border border-surface-container-high/60" title="ออกจากระบบ">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                    </button>
                </form>
                @else
                <div class="hidden md:flex items-center gap-space-sm px-3 py-1.5 rounded-lg bg-surface-container-lowest shadow-[0_1px_4px_rgba(0,0,0,0.03)] border border-surface-container-high/60">
                    <div class="flex flex-col text-right">
                        <span class="font-label-sm font-semibold text-on-surface leading-tight">{{ session('userFullNameTH') ?? 'นายพันธกานต์ มั่นจันทร์ (ผู้ดูแลตำแหน่ง)' }}</span>
                        <div class="flex items-center justify-end gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                            <span class="font-label-sm text-primary leading-none">{{ session('userPermitName') ?? 'เข้าสู่ระบบ (UMS BUU)' }}</span>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">person</span>
                    </div>
                </div>
                @if(Route::has('login'))
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary hover:bg-primary-container text-on-primary font-label-md transition-colors text-decoration-none shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">login</span>
                    <span>เข้าสู่ระบบ</span>
                </a>
                @endif
                @endauth
            </div>
        </div>
    </header>

    @unless(View::hasSection('no_sidebar'))
    <!-- Sidebar Navigation Rail -->
    <aside class="fixed left-0 top-16 bottom-0 w-64 bg-surface-container-low shadow-[0_1px_8px_rgba(0,0,0,0.03)] z-40 flex flex-col justify-between py-space-md border-r border-surface-container-high/60">
        <div class="flex-1 px-3">
            <div class="px-3 py-2 mb-2 font-label-sm text-outline uppercase tracking-wider font-semibold">Core Navigation</div>
            <nav class="flex flex-col gap-1">
                <a class="flex items-center gap-3 px-3 py-2.5 rounded transition-colors bg-primary text-on-primary font-label-lg shadow-sm text-decoration-none" href="{{ Route::has('demo.index') ? route('demo.index') : url('/') }}">
                    <span class="material-symbols-outlined text-[20px]">dashboard</span>
                    <span>Overview Hub</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-label-lg transition-colors text-decoration-none" href="#point-of-sale">
                    <span class="material-symbols-outlined text-[20px]">point_of_sale</span>
                    <span>Point of Sale</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-label-lg transition-colors text-decoration-none" href="#inventory-catalog">
                    <span class="material-symbols-outlined text-[20px]">inventory_2</span>
                    <span>Stock &amp; Inventory</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-label-lg transition-colors text-decoration-none" href="#orders-and-receipts">
                    <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                    <span>Orders &amp; Invoices</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-label-lg transition-colors text-decoration-none" href="#financial-audit-ledger">
                    <span class="material-symbols-outlined text-[20px]">account_balance</span>
                    <span>Audit &amp; Treasury</span>
                </a>
                @if(Route::has('demo.roles'))
                <a class="flex items-center gap-3 px-3 py-2.5 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface font-label-lg transition-colors text-decoration-none" href="{{ route('demo.roles') }}">
                    <span class="material-symbols-outlined text-[20px]">admin_panel_settings</span>
                    <span>UMS Permissions</span>
                </a>
                @endif
            </nav>
        </div>

        <div class="px-4 py-3 bg-surface-container-lowest mx-3 rounded-lg shadow-[0_1px_4px_rgba(0,0,0,0.02)] border border-surface-container-high/60">
            <div class="flex items-center justify-between text-on-surface-variant font-label-sm">
                <span>Security Protocol</span>
                <span class="font-label-sm text-primary font-semibold">TLS 1.3 Active</span>
            </div>
            <div class="mt-1 font-body-sm text-outline truncate">Node: BUU-FIN-CLUSTER-04</div>
        </div>
    </aside>
    @endunless

    <!-- Main Content Area -->
    <div class="@if(View::hasSection('no_sidebar')) w-full @else pl-64 @endif">
        <main class="relative pt-16 min-h-screen bg-background px-4 lg:px-8 py-space-lg">
            @yield('content')
        </main>
    </div>
        <main class="relative pt-16 min-h-screen bg-background px-4 lg:px-8 py-space-lg">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5.3 & Runtime Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ secure_asset('js/theme.js') }}"></script>
    <script src="{{ secure_asset('js/function.js') }}"></script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>
