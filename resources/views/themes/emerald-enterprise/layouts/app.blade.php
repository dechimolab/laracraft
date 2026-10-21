<!DOCTYPE html>
<html lang="th" data-bs-theme="light" data-theme="emerald-enterprise">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Artisan POS & Inventory Hub') }}</title>

    <!-- Theme Favicon (Emerald Enterprise) -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('image/favicon-emerald.svg') }}">
    <link rel="alternate icon" href="{{ asset('image/favicon-emerald.ico') }}">

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
    <link rel="stylesheet" href="{{ secure_asset('css/style.css') }}">

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--emerald-light-bg, #f7f9fb);
            color: var(--emerald-text-main, #191c1e);
            overscroll-behavior: none;
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
    <header class="app-header d-flex align-items-center px-3 px-lg-4 shadow-sm" style="{{ !empty($isPreviewMode) ? 'top: 38px;' : '' }}">
        <div class="d-flex align-items-center justify-content-between w-100">
            <!-- Brand & Left Navigation Items -->
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge rounded-pill bg-emerald-subtle-mint px-2 py-1 small text-uppercase d-inline-flex align-items-center gap-1">
                        <span class="rounded-circle bg-emerald-primary" style="width: 6px; height: 6px;"></span>
                        EMERALD ENTERPRISE
                    </span>
                    <div class="vr mx-1 d-none d-sm-block text-secondary opacity-50" style="height: 18px;"></div>
                    <a href="{{ Route::has('demo.index') ? route('demo.index') : url('/') }}" class="d-flex align-items-center gap-1 text-decoration-none">
                        <span class="fw-bold text-emerald-primary fs-6">Artisan</span>
                        <span class="fw-semibold text-dark fs-6">{{ preg_replace('/^Artisan\s+/i', '', config('app.name', 'POS & Inventory Hub')) }}</span>
                    </a>
                </div>
                <div class="d-none d-xl-flex align-items-center gap-1 ms-3">
                    <a class="btn btn-sm btn-link text-decoration-none text-secondary d-inline-flex align-items-center gap-1 fw-semibold" href="{{ Route::has('demo.index') ? route('demo.index') : url('/') }}">
                        <span class="material-symbols-outlined fs-6">terminal</span> Demo
                    </a>
                    @if(Route::has('switch.group'))
                    <a class="btn btn-sm btn-link text-decoration-none text-secondary d-inline-flex align-items-center gap-1 fw-semibold" href="{{ route('switch.group') }}">
                        <span class="material-symbols-outlined fs-6">manage_accounts</span> UMS บทบาท (UMS Roles)
                    </a>
                    @endif
                    @if(Route::has('demo.ums'))
                    <a class="btn btn-sm btn-link text-decoration-none text-secondary d-inline-flex align-items-center gap-1 fw-semibold" href="{{ route('demo.ums') }}">
                        <span class="material-symbols-outlined fs-6">sync_alt</span> System Switcher
                    </a>
                    @endif
                </div>
            </div>

            <!-- Right User Identity & Logout Unified Split Capsule with Dropdown (Option 1 Enhanced) -->
            <div class="dropdown">
                @auth
                <div class="user-executive-capsule d-inline-flex align-items-center bg-white rounded-pill shadow-sm border border-emerald-subtle"
                     role="button"
                     data-bs-toggle="dropdown"
                     data-bs-auto-close="true"
                     aria-expanded="false"
                     title="คลิกเพื่อเปิดเมนูผู้ใช้งาน">
                    <div class="d-none d-md-flex align-items-center gap-2 pe-1" data-permit="{{ session('userPermitName') ?? '' }}" data-group="{{ is_array(session('userGroup')) ? implode(',', session('userGroup')) : session('userGroup') }}">
                        <span class="user-display-name small fw-semibold text-dark">
                            {{ session('userFullNameTH') ?? (Auth::user()->name ?? Auth::user()->username) }}
                        </span>
                    </div>
                    <div class="user-avatar-circle rounded-circle bg-emerald-primary d-flex align-items-center justify-content-center text-white fw-bold shadow-xs flex-shrink-0" style="width: 32px; height: 32px; font-size: 0.85rem;">
                        {{ strtoupper(substr(Auth::user()->username ?? (session('userFullNameTH') ?? 'P'), 0, 1)) }}
                    </div>
                    <div class="capsule-divider vr mx-1 text-secondary opacity-25 d-none d-md-block" style="height: 18px;"></div>
                    <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" class="m-0 p-0 d-none d-md-inline-flex pe-1">
                        @csrf
                        <button type="submit" class="btn-capsule-logout btn btn-link p-0 text-danger d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 28px; height: 28px; text-decoration: none;" title="ออกจากระบบ" onclick="event.stopPropagation();">
                            <span class="material-symbols-outlined fs-6 align-middle">logout</span>
                        </button>
                    </form>
                </div>

                <!-- Dropdown Menu for Mobile & Desktop -->
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2 p-1 user-profile-dropdown" style="min-width: 170px;">
                    <li>
                        <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 text-danger fw-semibold rounded-2">
                                <span class="material-symbols-outlined fs-5">logout</span>
                                <span>ออกจากระบบ (Logout)</span>
                            </button>
                        </form>
                    </li>
                </ul>
                @else
                <div class="user-executive-capsule d-inline-flex align-items-center bg-white rounded-pill shadow-sm border border-emerald-subtle"
                     role="button"
                     data-bs-toggle="dropdown"
                     data-bs-auto-close="true"
                     aria-expanded="false"
                     title="คลิกเพื่อเปิดเมนูผู้ใช้งาน">
                    <div class="d-none d-md-flex align-items-center gap-2 pe-1" data-permit="{{ session('userPermitName') ?? '' }}" data-group="{{ is_array(session('userGroup')) ? implode(',', session('userGroup')) : session('userGroup') }}">
                        <span class="user-display-name small fw-semibold text-dark">
                            {{ session('userFullNameTH') ?? 'นายพันธกานต์ มั่นจันทร์ (ผู้ดูแลตำแหน่ง)' }}
                        </span>
                    </div>
                    <div class="user-avatar-circle rounded-circle bg-emerald-primary d-flex align-items-center justify-content-center text-white fw-bold shadow-xs flex-shrink-0" style="width: 32px; height: 32px; font-size: 0.85rem;">
                        P
                    </div>
                    <div class="capsule-divider vr mx-1 text-secondary opacity-25 d-none d-md-block" style="height: 18px;"></div>
                    @if(Route::has('logout'))
                    <form method="POST" action="{{ route('logout') }}" class="m-0 p-0 d-none d-md-inline-flex pe-1">
                        @csrf
                        <button type="submit" class="btn-capsule-logout btn btn-link p-0 text-danger d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 28px; height: 28px; text-decoration: none;" title="ออกจากระบบ" onclick="event.stopPropagation();">
                            <span class="material-symbols-outlined fs-6 align-middle">logout</span>
                        </button>
                    </form>
                    @else
                    <a href="{{ Route::has('login') ? route('login') : '#' }}" class="btn-capsule-logout btn btn-link p-0 text-danger d-none d-md-inline-flex align-items-center justify-content-center rounded-circle pe-1" style="width: 28px; height: 28px; text-decoration: none;" title="ออกจากระบบ" onclick="event.stopPropagation();">
                        <span class="material-symbols-outlined fs-6 align-middle">logout</span>
                    </a>
                    @endif
                </div>

                <!-- Dropdown Menu for Mobile & Desktop -->
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2 p-1 user-profile-dropdown" style="min-width: 170px;">
                    <li>
                        @if(Route::has('logout'))
                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 text-danger fw-semibold rounded-2">
                                <span class="material-symbols-outlined fs-5">logout</span>
                                <span>ออกจากระบบ (Logout)</span>
                            </button>
                        </form>
                        @else
                        <a href="{{ Route::has('login') ? route('login') : '#' }}" class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 text-danger fw-semibold rounded-2">
                            <span class="material-symbols-outlined fs-5">logout</span>
                            <span>ออกจากระบบ (Logout)</span>
                        </a>
                        @endif
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </header>
    @endunless

    @unless(View::hasSection('no_sidebar'))
    <!-- 2. Sidebar Navigation -->
    <aside class="app-sidebar d-flex flex-column justify-content-between p-3" style="{{ !empty($isPreviewMode) ? 'top: calc(64px + 38px);' : '' }}">
        <div>
            <div class="text-uppercase text-secondary fw-bold px-2 mb-2" style="font-size: 0.7rem; letter-spacing: 0.05em;">
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
        <div class="bg-white p-3 rounded-3 shadow-sm border border-light">
            <div class="d-flex align-items-center justify-content-between small">
                <span class="text-secondary fw-semibold">Security Protocol</span>
                <span class="text-emerald-primary fw-bold">TLS 1.3 Active</span>
            </div>
            <div class="text-muted small mt-1 text-truncate" style="font-size: 0.75rem;">
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
