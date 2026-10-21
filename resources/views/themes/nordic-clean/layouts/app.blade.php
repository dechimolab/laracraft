<!DOCTYPE html>
<html lang="th" data-bs-theme="light" data-theme="nordic-clean">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Artisan POS & Inventory Hub') }} - Nordic Clean</title>

    <!-- Theme Favicon (Nordic Clean) -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon-nordic.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon-nordic.ico') }}">

    <!-- Google Fonts: Inter & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme Design System Assets -->
    <link rel="stylesheet" href="{{ secure_asset('css/themes/nordic-clean.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/style.css') }}">

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--nordic-bg, #F8FAFC);
            color: var(--nordic-slate, #0F172A);
            overscroll-behavior: none;
            -webkit-font-smoothing: antialiased;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    @includeIf('themes.components.preview-bar')

    @unless(View::hasSection('no_header'))
    <!-- 1. Header (Navbar) -->
    <header class="app-header d-flex align-items-center px-3 px-lg-4" style="{{ !empty($isPreviewMode) ? 'top: 38px;' : '' }}">
        <div class="d-flex align-items-center justify-content-between w-100">
            <!-- Brand & Left Navigation Items -->
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge rounded-pill badge-nordic px-2.5 py-1 text-uppercase d-inline-flex align-items-center gap-1.5" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                        <span class="rounded-circle" style="width: 6px; height: 6px; background-color: var(--nordic-blue, #3B82F6);"></span>
                        Nordic Clean
                    </span>
                    <div class="vr mx-1 d-none d-sm-block text-secondary opacity-25" style="height: 18px;"></div>
                    <a href="{{ Route::has('demo.index') ? route('demo.index') : url('/') }}" class="d-flex align-items-center gap-1 text-decoration-none">
                        <span class="fw-bold text-nordic-blue fs-6">Artisan</span>
                        <span class="fw-semibold text-dark fs-6">{{ preg_replace('/^Artisan\s+/i', '', config('app.name', 'POS & Inventory Hub')) }}</span>
                    </a>
                </div>
                <div class="d-none d-xl-flex align-items-center gap-1 ms-3">
                    <a class="btn btn-sm btn-link text-decoration-none text-secondary d-inline-flex align-items-center gap-1 fw-medium" href="{{ Route::has('demo.index') ? route('demo.index') : url('/') }}">
                        <span class="material-symbols-outlined fs-6">terminal</span> Demo
                    </a>
                    @if(Route::has('switch.group'))
                    <a class="btn btn-sm btn-link text-decoration-none text-secondary d-inline-flex align-items-center gap-1 fw-medium" href="{{ route('switch.group') }}">
                        <span class="material-symbols-outlined fs-6">manage_accounts</span> UMS บทบาท (UMS Roles)
                    </a>
                    @endif
                    @if(Route::has('demo.ums'))
                    <a class="btn btn-sm btn-link text-decoration-none text-secondary d-inline-flex align-items-center gap-1 fw-medium" href="{{ route('demo.ums') }}">
                        <span class="material-symbols-outlined fs-6">sync_alt</span> System Switcher
                    </a>
                    @endif
                </div>
            </div>

            <!-- Right User Identity Badge -->
            <div class="d-flex align-items-center gap-2 gap-md-3">
                @auth
                <div class="d-none d-md-flex align-items-center gap-2.5 bg-white px-3 py-1.5 rounded-3 border">
                    <div class="text-end lh-sm" data-permit="{{ session('userPermitName') ?? '' }}" data-group="{{ is_array(session('userGroup')) ? implode(',', session('userGroup')) : session('userGroup') }}">
                        <div class="small fw-semibold text-dark">{{ session('userFullNameTH') ?? (Auth::user()->name ?? Auth::user()->username) }}</div>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 32px; height: 32px; background-color: var(--nordic-blue, #3B82F6); font-size: 0.875rem;">
                        {{ strtoupper(substr(Auth::user()->username ?? (session('userFullNameTH') ?? 'P'), 0, 1)) }}
                    </div>
                </div>

                <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" class="m-0 p-0 d-inline-flex">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2 rounded-2 d-inline-flex align-items-center" title="ออกจากระบบ">
                        <span class="material-symbols-outlined fs-6 align-middle">logout</span>
                    </button>
                </form>
                @else
                <div class="d-none d-md-flex align-items-center gap-2.5 bg-white px-3 py-1.5 rounded-3 border">
                    <div class="text-end lh-sm" data-permit="{{ session('userPermitName') ?? '' }}" data-group="{{ is_array(session('userGroup')) ? implode(',', session('userGroup')) : session('userGroup') }}">
                        <div class="small fw-semibold text-dark">{{ session('userFullNameTH') ?? 'นายพันธกานต์ มั่นจันทร์ (ผู้ดูแลตำแหน่ง)' }}</div>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 32px; height: 32px; background-color: var(--nordic-blue, #3B82F6); font-size: 0.875rem;">
                        P
                    </div>
                </div>
                @if(Route::has('login'))
                <a href="{{ route('login') }}" class="btn btn-sm btn-nordic-primary d-inline-flex align-items-center gap-1 shadow-sm">
                    <span class="material-symbols-outlined fs-6">login</span>
                    <span>เข้าสู่ระบบ</span>
                </a>
                @endif
                @endauth
            </div>
        </div>
    </header>
    @endunless

    @unless(View::hasSection('no_sidebar'))
    <!-- 2. Sidebar Navigation -->
    <aside class="app-sidebar d-flex flex-column justify-content-between p-3" style="{{ !empty($isPreviewMode) ? 'top: calc(64px + 38px);' : '' }}">
        <div>
            <div class="text-uppercase fw-semibold px-2 mb-2" style="font-size: 0.7rem; letter-spacing: 0.08em; color: var(--nordic-muted, #64748B);">
                Core Navigation
            </div>
            <nav class="nav flex-column gap-1">
                <a class="sidebar-link active" href="{{ Route::has('demo.index') ? route('demo.index') : url('/') }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Overview Hub</span>
                </a>
                <a class="sidebar-link" href="#point-of-sale">
                    <span class="material-symbols-outlined">point_of_sale</span>
                    <span>Point of Sale</span>
                </a>
                <a class="sidebar-link" href="#inventory-catalog">
                    <span class="material-symbols-outlined">inventory_2</span>
                    <span>Stock &amp; Inventory</span>
                </a>
                <a class="sidebar-link" href="#orders-and-receipts">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span>Orders &amp; Invoices</span>
                </a>
                <a class="sidebar-link" href="#financial-audit-ledger">
                    <span class="material-symbols-outlined">account_balance</span>
                    <span>Audit &amp; Treasury</span>
                </a>
                @if(Route::has('demo.roles'))
                <a class="sidebar-link" href="{{ route('demo.roles') }}">
                    <span class="material-symbols-outlined">admin_panel_settings</span>
                    <span>UMS Permissions</span>
                </a>
                @endif
            </nav>
        </div>

        <!-- Security Node Card -->
        <div class="card-surface p-3 rounded-3 shadow-none">
            <div class="d-flex align-items-center justify-content-between small">
                <span class="fw-medium text-secondary" style="font-size: 0.75rem;">Security Protocol</span>
                <span class="badge badge-nordic-success fw-semibold" style="font-size: 0.7rem;">TLS 1.3 Active</span>
            </div>
            <div class="text-muted small mt-1.5 text-truncate" style="font-size: 0.7rem; font-family: monospace;">
                Node: BUU-FIN-CLUSTER-04
            </div>
        </div>
    </aside>
    @endunless

    <!-- 3. Main Content Area -->
    <div class="app-content @if(View::hasSection('no_sidebar')) no-sidebar @endif @if(View::hasSection('no_header')) no-header @endif" style="{{ !empty($isPreviewMode) && !View::hasSection('no_header') ? 'padding-top: calc(64px + 38px);' : '' }}">
        <main class="container-fluid @if(View::hasSection('no_header')) p-0 @else p-3 p-lg-4 @endif">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5.3 & Runtime Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ secure_asset('js/function.js') }}"></script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>
