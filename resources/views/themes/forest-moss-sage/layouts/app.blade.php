<!DOCTYPE html>
<html lang="th" data-bs-theme="light" data-theme="forest-moss">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Artisan POS & Inventory Hub') }} - Forest Moss &amp; Sage</title>

    <!-- Theme Favicon (Forest Moss & Sage) -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('image/favicon-forest-moss.svg') }}">
    <link rel="alternate icon" href="{{ asset('image/favicon-forest-moss.ico') }}">

    <!-- Google Fonts: Plus Jakarta Sans, Sarabun, Inter & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Frontend Plugins CSS (Select2, jQuery UI, Dropzone) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.css" rel="stylesheet">

    <!-- Theme Design System Assets -->
    <link rel="stylesheet" href="{{ secure_asset('css/themes/forest-moss.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('css/style.css') }}">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', 'Sarabun', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--forest-bg, #F0FDF4);
            color: var(--forest-text-dark, #052E16);
            overscroll-behavior: none;
            -webkit-font-smoothing: antialiased;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        /* Select2 Bootstrap 5 Integration */
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--single {
            height: 42px !important;
            padding: 0.375rem 0.75rem !important;
            border: 1px solid var(--theme-border-subtle, #BBF7D0) !important;
            border-radius: 0.5rem !important;
            background-color: #FFFFFF !important;
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--forest-text-dark, #052E16) !important;
            line-height: 1.5 !important;
            padding-left: 0 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
            right: 8px !important;
        }
        .select2-dropdown {
            border: 1px solid var(--theme-border-subtle, #BBF7D0) !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 4px 12px rgba(21, 128, 61, 0.08) !important;
            z-index: 1060 !important;
        }

        /* jQuery UI Datepicker Thai Buddhist Year Polish */
        .ui-datepicker {
            border-radius: 0.75rem !important;
            border: 1px solid var(--theme-border-subtle, #BBF7D0) !important;
            box-shadow: 0 10px 20px -3px rgba(21, 128, 61, 0.1) !important;
            padding: 0.75rem !important;
            font-family: inherit !important;
            z-index: 1060 !important;
            background-color: #FFFFFF !important;
        }
        .ui-datepicker-header {
            background: #DCFCE7 !important;
            border: 0 !important;
            border-radius: 0.5rem !important;
            color: #14532D !important;
        }
        .ui-datepicker-title select {
            border: 1px solid #BBF7D0 !important;
            border-radius: 0.375rem !important;
            padding: 2px 4px !important;
        }

        /* Dropzone Styling Polish */
        .dropzone {
            border: 2px dashed #86EFAC !important;
            border-radius: 0.75rem !important;
            background-color: #F0FDF4 !important;
            transition: all 0.2s ease-in-out;
        }
        .dropzone:hover {
            border-color: var(--forest-primary, #15803D) !important;
            background-color: #DCFCE7 !important;
        }
    </style>
</head>
<body>
    @includeIf('themes.components.preview-bar')

    @unless(View::hasSection('no_header'))
    <!-- 1. Header (Navbar - Emerald Enterprise Standard) -->
    <header class="app-header d-flex align-items-center px-3 px-lg-4 shadow-sm" style="{{ !empty($isPreviewMode) ? 'top: 38px;' : '' }}">
        <div class="d-flex align-items-center justify-content-between w-100">
            <!-- Brand & Left Navigation Items -->
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge rounded-pill px-2.5 py-1 text-uppercase d-inline-flex align-items-center gap-1.5" style="font-size: 0.7rem; letter-spacing: 0.05em; background-color: #15803D; color: #ffffff; border: none; box-shadow: 0 2px 6px rgba(21, 128, 61, 0.3);">
                        <span class="rounded-circle" style="width: 6px; height: 6px; background-color: #84CC16;"></span>
                        Forest Moss &amp; Sage
                    </span>
                    <div class="vr mx-1 d-none d-sm-block text-secondary opacity-25" style="height: 18px;"></div>
                    <a href="{{ Route::has('demo.index') ? route('demo.index') : url('/') }}" class="d-flex align-items-center gap-1 text-decoration-none">
                        <span class="fw-bold fs-6" style="color: #15803D !important;">Artisan</span>
                        <span class="fw-semibold text-dark fs-6">{{ preg_replace('/^Artisan\s+/i', '', $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'POS & Inventory Hub')) }}</span>
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

            <!-- Right User Identity & Logout Unified Split Capsule with Dropdown (Option 1 Enhanced) -->
            <div class="dropdown">
                @auth
                <div class="user-executive-capsule d-inline-flex align-items-center bg-white rounded-pill pe-1" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                    <div class="d-none d-md-flex align-items-center gap-2 px-2" data-permit="{{ session('userPermitName') ?? '' }}" data-group="{{ is_array(session('userGroup')) ? implode(',', array_map(fn($g) => is_object($g) ? ($g->GPNAMET ?? $g->GPID ?? $g->name ?? '') : (is_array($g) ? ($g['GPNAMET'] ?? $g['GPID'] ?? $g['name'] ?? '') : (string)$g), session('userGroup'))) : (is_scalar(session('userGroup')) ? session('userGroup') : '') }}">
                        <span class="user-display-name small fw-semibold">
                            {{ session('userFullNameTH') ?? (Auth::user()->name ?? Auth::user()->username) }}
                        </span>
                    </div>
                    <div class="user-avatar-circle rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0" style="width: 32px; height: 32px; background-color: #15803D !important; font-size: 0.85rem;">
                        {{ strtoupper(substr(Auth::user()->username ?? (session('userFullNameTH') ?? 'P'), 0, 1)) }}
                    </div>
                    <div class="capsule-divider vr mx-1 d-none d-md-block" style="height: 18px;"></div>
                    <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" class="m-0 p-0 d-none d-md-inline-flex">
                        @csrf
                        <button type="submit" class="btn-capsule-logout btn btn-link p-0 text-danger d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 28px; height: 28px; text-decoration: none;" title="ออกจากระบบ (Logout)">
                            <span class="material-symbols-outlined fs-6 align-middle">logout</span>
                        </button>
                    </form>
                </div>

                <!-- Dropdown Menu for Mobile -->
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2 p-1 user-profile-dropdown d-md-none" style="min-width: 170px;">
                    <li>
                        <div class="px-3 py-2 border-bottom">
                            <div class="small fw-bold text-dark">{{ session('userFullNameTH') ?? (Auth::user()->name ?? Auth::user()->username) }}</div>
                            <div class="text-muted" style="font-size: 0.7rem;">{{ session('userPermitName') ?? 'ผู้ใช้งานระบบ' }}</div>
                        </div>
                    </li>
                    <li>
                        <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2">
                                <span class="material-symbols-outlined fs-6">logout</span>
                                <span>ออกจากระบบ</span>
                            </button>
                        </form>
                    </li>
                </ul>
                @else
                <!-- Mockup Preview State -->
                <div class="user-executive-capsule d-inline-flex align-items-center bg-white rounded-pill pe-1" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                    <div class="d-none d-md-flex align-items-center gap-2 px-2">
                        <span class="user-display-name small fw-semibold">
                            {{ session('userFullNameTH') ?? 'นายพันธกานต์ มั่นจันทร์ (ผู้ดูแลตำแหน่ง)' }}
                        </span>
                    </div>
                    <div class="user-avatar-circle rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0" style="width: 32px; height: 32px; background-color: #15803D !important; font-size: 0.85rem;">
                        P
                    </div>
                    <div class="capsule-divider vr mx-1 d-none d-md-block" style="height: 18px;"></div>
                    <a href="{{ Route::has('logout') ? route('logout') : url('/') }}" class="btn-capsule-logout btn btn-link p-0 text-danger d-none d-md-inline-flex align-items-center justify-content-center rounded-circle" style="width: 28px; height: 28px; text-decoration: none;" title="ออกจากระบบ (Logout)">
                        <span class="material-symbols-outlined fs-6 align-middle">logout</span>
                    </a>
                </div>

                <!-- Dropdown Menu for Mobile -->
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2 p-1 user-profile-dropdown d-md-none" style="min-width: 170px;">
                    <li>
                        <div class="px-3 py-2 border-bottom">
                            <div class="small fw-bold text-dark">{{ session('userFullNameTH') ?? 'นายพันธกานต์ มั่นจันทร์' }}</div>
                            <div class="text-muted" style="font-size: 0.7rem;">ผู้ดูแลตำแหน่ง (Admin)</div>
                        </div>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger d-flex align-items-center gap-2 py-2" href="{{ Route::has('logout') ? route('logout') : url('/') }}">
                            <span class="material-symbols-outlined fs-6">logout</span>
                            <span>ออกจากระบบ</span>
                        </a>
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </header>
    @endunless

    @unless(View::hasSection('no_sidebar'))
    <!-- 2. Sidebar Navigation (Emerald Enterprise Standard Architecture) -->
    <aside class="app-sidebar d-flex flex-column justify-content-between p-3" style="{{ !empty($isPreviewMode) ? 'top: calc(64px + 38px);' : '' }}">
        <div>
            <div class="text-uppercase fw-semibold px-2 mb-2" style="font-size: 0.7rem; letter-spacing: 0.08em; color: #15803D;">
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
                <a class="sidebar-link" href="#stock-and-inventory">
                    <span class="material-symbols-outlined">inventory_2</span>
                    <span>Stock &amp; Inventory</span>
                </a>
                <a class="sidebar-link" href="#orders-and-invoices">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span>Orders &amp; Invoices</span>
                </a>
                <a class="sidebar-link" href="#audit-and-treasury">
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

        <!-- Security Node Card in Sidebar Footer -->
        <div class="p-2.5 rounded bg-white border border-success-subtle shadow-sm" style="font-size: 0.72rem;">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-semibold text-secondary">Security Protocol</span>
                <span class="badge text-white py-0.5 px-1.5" style="background-color: #15803D; font-size: 0.65rem;">TLS 1.3 Active</span>
            </div>
            <div class="text-dark">Protocol: <strong style="color: #15803D;">v4.8-Fiduciary</strong></div>
            <div class="text-truncate text-muted font-monospace" style="font-size: 0.68rem;">Node: BUU-FIN-CLUSTER-04</div>
        </div>
    </aside>
    @endunless

    <!-- 3. Main Content Area (Zero Overlap Guaranteed) -->
    <div class="app-content @if(View::hasSection('no_sidebar')) no-sidebar @endif @if(View::hasSection('no_header')) no-header @endif" style="{{ !empty($isPreviewMode) && !View::hasSection('no_header') ? 'padding-top: calc(64px + 38px);' : '' }}">
        <main class="container-fluid @if(View::hasSection('no_header')) p-0 @else p-3 p-lg-4 @endif">
            @yield('content')
        </main>
    </div>

    <!-- Runtime Scripts & Frontend Plugins -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.10.5/dist/autoNumeric.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="{{ secure_asset('js/function.js') }}"></script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>