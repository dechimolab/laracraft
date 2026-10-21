@extends(view()->exists('layouts.app') ? 'layouts.app' : 'themes.nordic-clean.layouts.app')

@section('content')
<div class="d-flex flex-column gap-4">

    <!-- Section 1: Hero Welcome Banner -->
    <section class="card-surface p-4 position-relative overflow-hidden">
        <div class="hero-glow-nordic"></div>
        <div class="position-relative z-1 row align-items-center g-3">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="badge rounded-pill badge-nordic text-uppercase px-2.5 py-1">
                        <i class="bi bi-circle-fill me-1" style="font-size: 6px; color: var(--nordic-blue, #3B82F6);"></i>ArtisanCraft Engine
                    </span>
                    <span class="badge bg-white text-secondary border">Laravel 13.x</span>
                    <span class="badge bg-white text-secondary border">PHP 8.4 JIT</span>
                    <span class="badge bg-white text-secondary border">Bootstrap 5.3.3</span>
                </div>
                <h1 class="h4 fw-bold text-dark mt-2 mb-1">
                    ยินดีต้อนรับสู่ <span class="text-nordic-blue">{{ config('app.name', 'Artisan POS & Inventory Hub') }}</span>
                </h1>
                <p class="text-secondary mb-0 small">
                    ระบบบริหารจัดการและหน้าควบคุมต้นแบบ (Demo Showcase Dashboard) พร้อมส่วนประกอบ UI และระบบรักษาความปลอดภัยครบวงจร Fiduciary Precision Standard
                </p>
            </div>
            <div class="col-lg-4 d-flex flex-wrap justify-content-lg-end gap-2">
                <button class="btn btn-nordic-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-medium shadow-sm" id="btn-passkey-register">
                    <span class="material-symbols-outlined fs-5">fingerprint</span>
                    <span>บันทึกลายนิ้วมือใหม่ (Passkey)</span>
                </button>
                <button class="btn btn-white bg-white border d-inline-flex align-items-center gap-2 px-3 py-2 text-dark fw-medium" id="btn-swal-demo">
                    <span class="material-symbols-outlined fs-5 text-secondary">notifications_active</span>
                    <span>ทดสอบ SweetAlert2</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Section 2: Enterprise Pre-built Modules Demo Hub -->
    @php
        $rawModules = $selectedModules ?? session('project.modules', []);
        $selectedModules = [];
        if (is_array($rawModules)) {
            foreach ($rawModules as $k => $v) {
                if (is_numeric($k)) {
                    $selectedModules[$v] = '1';
                } elseif (!empty($v)) {
                    $selectedModules[$k] = '1';
                }
            }
        }
        if (empty($selectedModules)) {
            $selectedModules = ['ums_buu' => '1'];
        }
        $activeModulesList = [];
        if (!empty($selectedModules['ums_buu'])) {
            $activeModulesList['ums_buu'] = [
                'name' => 'UMS BUU (SSO)',
                'tag' => 'ums_buu',
                'status' => 'Active',
                'desc' => 'ระบบยืนยันตัวตนกลาง ม.บูรพา & จัดการบทบาทสิทธิ์ผู้ใช้งาน (UMS Identity Provider Hub)',
                'btn_text' => 'เข้าสู่ระบบ / สลับสิทธิ์ UMS',
                'btn_icon' => 'login',
                'btn_link' => Route::has('demo.ums') ? route('demo.ums') : '#',
            ];
        }
        if (!empty($selectedModules['buu_ldap'])) {
            $activeModulesList['buu_ldap'] = [
                'name' => 'BUU LDAP & Active Directory',
                'tag' => 'buu_ldap',
                'status' => 'Active',
                'desc' => 'ระบบยืนยันตัวตนผ่าน Active Directory ม.บูรพา (Zero Service Account)',
                'btn_text' => 'ตรวจสอบการเชื่อมต่อ LDAP',
                'btn_icon' => 'hub',
                'btn_link' => '#',
            ];
        }
        if (!empty($selectedModules['audit_trail'])) {
            $activeModulesList['audit_trail'] = [
                'name' => 'Audit Trail & Activity Log',
                'tag' => 'audit_trail',
                'status' => 'Active',
                'desc' => 'บันทึกประวัติการเปลี่ยนแปลงข้อมูลของ Eloquent Model ทุกตัวอัตโนมัติ พร้อมเก็บบันทึก IP, User-Agent และ JSON Diff',
                'btn_text' => 'ตรวจสอบ Audit Trail',
                'btn_icon' => 'history_edu',
                'btn_link' => Route::has('demo.audit') ? route('demo.audit') : '#',
            ];
        }
        if (!empty($selectedModules['user_role']) || !empty($selectedModules['roles_management'])) {
            $activeModulesList['user_role'] = [
                'name' => 'Role & Permission (RBAC)',
                'tag' => 'user_role',
                'status' => 'Active',
                'desc' => 'ระบบจัดการบทบาท สิทธิ์การเข้าถึง และการแบ่งแยกหน้าที่ตามมาตรฐานความปลอดภัย (Role-Based Access Control)',
                'btn_text' => 'จัดการสิทธิ์บทบาท',
                'btn_icon' => 'admin_panel_settings',
                'btn_link' => Route::has('switch.group') ? route('switch.group') : '#',
            ];
        }
        if (!empty($selectedModules['notifications'])) {
            $activeModulesList['notifications'] = [
                'name' => 'Multi-Channel Notifications',
                'tag' => 'notifications',
                'status' => 'Active',
                'desc' => 'ระบบแจ้งเตือนแบบเรียลไทม์ผ่าน Webhook, อีเมล และบันทึกข้อความภายในระบบ',
                'btn_text' => 'ทดสอบการส่งแจ้งเตือน',
                'btn_icon' => 'notifications_active',
                'btn_link' => '#',
            ];
        }
        if (!empty($selectedModules['pos_gateway'])) {
            $activeModulesList['pos_gateway'] = [
                'name' => 'POS Real-Time Ledger',
                'tag' => 'pos_gateway',
                'status' => 'Standby',
                'desc' => 'สตรีมคำนวณบิลขายหน้าร้าน พร้อมออกใบเสร็จรับเงินภาษีเต็มรูปและเกตเวย์ QR พร้อมเพย์',
                'btn_text' => 'ตรวจสอบแคชเชียร์สแตนด์บาย',
                'btn_icon' => 'point_of_sale',
                'btn_link' => '#',
            ];
        }
        if (!empty($selectedModules['wh_replenish'])) {
            $activeModulesList['wh_replenish'] = [
                'name' => 'Inventory Matrix Auto-Stock',
                'tag' => 'wh_replenish',
                'status' => 'Syncing',
                'desc' => 'เชื่อมโยงคลังสินค้าคงคลัง ตรวจสอบจุดสั่งซื้อต่ำสุดพร้อมจัดกลุ่มล็อตสินค้าอัจฉริยะ',
                'btn_text' => 'ซิงค์ความคืบหน้าสต็อก',
                'btn_icon' => 'sync',
                'btn_link' => '#',
            ];
        }
        if (empty($activeModulesList)) {
            $activeModulesList['ums_buu'] = [
                'name' => 'UMS BUU (SSO)',
                'tag' => 'ums_buu',
                'status' => 'Active',
                'desc' => 'ระบบยืนยันตัวตนกลาง ม.บูรพา & จัดการบทบาทสิทธิ์ผู้ใช้งาน (UMS Identity Provider Hub)',
                'btn_text' => 'เข้าสู่ระบบ / สลับสิทธิ์ UMS',
                'btn_icon' => 'login',
                'btn_link' => Route::has('demo.ums') ? route('demo.ums') : '#',
            ];
        }
    @endphp
    <section class="card-surface p-4">
        <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <span class="material-symbols-outlined text-nordic-blue fs-5">view_module</span>
                <h2 class="h6 fw-bold mb-0 text-dark">โมดูลสำเร็จรูปประจำโปรเจกต์ (Enterprise Pre-built Modules Demo Hub)</h2>
            </div>
            <span class="badge badge-nordic text-uppercase px-2.5 py-1">Step 3 Modules</span>
        </div>
        <div class="row g-3">
            @foreach($activeModulesList as $mKey => $mod)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="subtle-module-card p-3.5 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge badge-nordic-success rounded-pill d-inline-flex align-items-center gap-1.5">
                                <span class="rounded-circle" style="width: 6px; height: 6px; background-color: #10B981;"></span> {{ $mod['status'] }}
                            </span>
                            <span class="small text-muted font-monospace">{{ $mod['tag'] }}</span>
                        </div>
                        <h3 class="h6 fw-bold text-dark mb-1">{{ $mod['name'] }}</h3>
                        <p class="text-secondary small mb-3">
                            {{ $mod['desc'] }}
                        </p>
                    </div>
                    <a href="{{ $mod['btn_link'] }}" class="btn btn-sm btn-white bg-white text-nordic-blue border shadow-sm w-100 d-inline-flex align-items-center justify-content-center gap-1 fw-medium text-decoration-none">
                        <span class="material-symbols-outlined fs-6">{{ $mod['btn_icon'] }}</span>
                        <span>{{ $mod['btn_text'] }}</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Section 3: Telemetry & KPI Cards Bar -->
    <section class="card-surface p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between pb-2 mb-3 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <h2 class="h6 fw-bold text-dark mb-0">{{ config('app.name', 'Artisan POS & Inventory Hub') }}</h2>
                <span class="badge bg-light text-muted border font-monospace">SYS-CORE-ONLINE</span>
            </div>
            <span class="badge rounded-pill badge-nordic d-inline-flex align-items-center gap-1 text-uppercase">
                <span class="spinner-grow spinner-grow-sm text-primary" role="status" style="width: 8px; height: 8px;"></span>
                Online • Uptime 99.98%
            </span>
        </div>
        <div class="row g-3">
            <!-- System Velocity -->
            <div class="col-lg-4">
                <div class="subtle-module-card p-3 h-100 d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center justify-content-between text-secondary">
                        <span class="small fw-semibold text-uppercase" style="font-size: 0.75rem;">System Velocity</span>
                        <span class="material-symbols-outlined text-nordic-blue fs-5">speed</span>
                    </div>
                    <div class="mt-2">
                        <div class="fs-3 fw-bold text-dark">$492.30 <span class="fs-6 fw-normal text-muted">AOV</span></div>
                        <div class="d-flex align-items-center gap-1 text-nordic-blue small fw-semibold mt-1">
                            <span class="material-symbols-outlined fs-6">trending_up</span>
                            <span>+14.8% growth vs last period</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Active Telemetry (Sparkline SVG) -->
            <div class="col-lg-4">
                <div class="subtle-module-card p-3 h-100 d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center justify-content-between text-secondary">
                        <span class="small fw-semibold text-uppercase" style="font-size: 0.75rem;">Active Telemetry</span>
                        <span class="badge badge-nordic" style="font-size: 0.65rem;">REAL-TIME</span>
                    </div>
                    <div class="w-100 my-1 position-relative" style="height: 48px;">
                        <svg class="w-100 h-100" viewBox="0 0 200 40">
                            <path d="M0,32 Q25,28 50,30 T100,16 T150,22 T200,8 L200,40 L0,40 Z" fill="rgba(59, 130, 246, 0.12)"></path>
                            <path d="M0,32 Q25,28 50,30 T100,16 T150,22 T200,8" fill="none" stroke="#3B82F6" stroke-width="2.5"></path>
                        </svg>
                    </div>
                    <div class="d-flex align-items-center justify-content-between small text-secondary">
                        <span class="text-nordic-blue fw-medium">Zero Bottlenecks</span>
                        <span>0.14ms Latency</span>
                    </div>
                </div>
            </div>
            <!-- Sample Form Control -->
            <div class="col-lg-4">
                <div class="subtle-module-card p-3 h-100 d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center justify-content-between text-secondary mb-1">
                        <span class="small fw-semibold text-uppercase" style="font-size: 0.75rem;">Sample Form Control</span>
                        <span class="small text-muted">Input Prepend</span>
                    </div>
                    <div class="input-group shadow-sm my-1">
                        <span class="input-group-text bg-white border-end-0">
                            <span class="material-symbols-outlined fs-6 text-secondary">person</span>
                        </span>
                        <input class="form-control bg-white border-start-0" readonly="" type="text" value="pantakarn@buu.ac.th"/>
                    </div>
                    <div class="d-flex gap-2 mt-2">
                        <button class="btn btn-sm btn-nordic-primary flex-fill fw-medium">Primary Action</button>
                        <button class="btn btn-sm btn-white bg-white border fw-medium">Secondary</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: 4 Metric Stat Cards -->
    <section class="row g-3">
        <div class="col-sm-6 col-lg-3">
            <div class="card-surface p-3 d-flex align-items-center gap-3 h-100">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: var(--nordic-blue-soft, #EFF6FF);">
                    <span class="material-symbols-outlined fs-3 text-nordic-blue">groups</span>
                </div>
                <div class="d-flex flex-column text-truncate justify-content-center flex-grow-1">
                    <span class="small text-muted text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.03em;">ผู้ใช้งานในระบบ</span>
                    <span class="fs-5 fw-bold text-dark my-0.5">1,248 คน</span>
                    <span class="small text-nordic-blue fw-medium d-inline-flex align-items-center gap-1" style="font-size: 0.75rem;">
                        <span class="material-symbols-outlined fs-6">trending_up</span> +12% สัปดาห์นี้
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card-surface p-3 d-flex align-items-center gap-3 h-100">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: var(--nordic-blue-soft, #EFF6FF);">
                    <span class="material-symbols-outlined fs-3 text-nordic-blue">verified_user</span>
                </div>
                <div class="d-flex flex-column text-truncate justify-content-center flex-grow-1">
                    <span class="small text-muted text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.03em;">Active Directory</span>
                    <span class="fs-5 fw-bold text-dark my-0.5">BUU LDAP</span>
                    <span class="small text-success fw-medium d-inline-flex align-items-center gap-1" style="font-size: 0.75rem;">
                        <span class="material-symbols-outlined fs-6">check_circle</span> ซิงค์เรียบร้อย
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card-surface p-3 d-flex align-items-center gap-3 h-100">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: var(--nordic-blue-soft, #EFF6FF);">
                    <span class="material-symbols-outlined fs-3 text-nordic-blue">database</span>
                </div>
                <div class="d-flex flex-column text-truncate justify-content-center flex-grow-1">
                    <span class="small text-muted text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.03em;">Database Matrix</span>
                    <span class="fs-5 fw-bold text-dark my-0.5">MySQL 8.4</span>
                    <span class="small text-muted d-inline-flex align-items-center gap-1" style="font-size: 0.75rem;">
                        <span class="material-symbols-outlined fs-6">dns</span> InnoDB utf8mb4
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card-surface p-3 d-flex align-items-center gap-3 h-100">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: var(--nordic-blue-soft, #EFF6FF);">
                    <span class="material-symbols-outlined fs-3 text-nordic-blue">history_edu</span>
                </div>
                <div class="d-flex flex-column text-truncate justify-content-center flex-grow-1">
                    <span class="small text-muted text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.03em;">Audit Trail</span>
                    <span class="fs-5 fw-bold text-dark my-0.5">5 Stamps</span>
                    <span class="small text-nordic-blue fw-medium d-inline-flex align-items-center gap-1" style="font-size: 0.75rem;">
                        <span class="material-symbols-outlined fs-6">shield</span> มาตรฐานความปลอดภัย
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5: WebAuthn / Passkey Biometrics Bar -->
    <section class="card-surface p-4">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-start gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 44px; height: 44px; background-color: var(--nordic-blue-soft, #EFF6FF);">
                    <span class="material-symbols-outlined fs-4 text-nordic-blue">fingerprint</span>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <h3 class="h6 fw-bold text-dark mb-0">ระบบยืนยันตัวตนชีวมิติ (WebAuthn / Passkey Biometrics)</h3>
                        <span class="badge badge-nordic d-none d-sm-inline-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-6">check</span> รองรับ Touch ID / Windows Hello
                        </span>
                    </div>
                    <p class="text-secondary small mt-1 mb-0">
                        เข้าสู่ระบบด้วยลายนิ้วมือ Touch ID / Windows Hello แบบไร้รหัสผ่าน (Passwordless) ตามมาตรฐาน W3C WebAuthn &amp; FIDO2
                    </p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 w-100 w-md-auto justify-content-end">
                <button class="btn btn-white bg-white border" id="btn-refresh-passkeys" title="รีเฟรช" type="button">
                    <span class="material-symbols-outlined fs-5 text-secondary">refresh</span>
                </button>
                <button class="btn btn-nordic-primary d-inline-flex align-items-center gap-2 fw-medium shadow-sm" id="btn-register-passkey-device" type="button">
                    <span class="material-symbols-outlined fs-5">fingerprint</span>
                    <span>บันทึกลายนิ้วมือเครื่องนี้</span>
                </button>
            </div>
        </div>
        <!-- Passkeys list status box -->
        <div class="mt-3 p-3 rounded-2 bg-light d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2 border">
            <div class="d-flex align-items-center gap-2 text-secondary small">
                <span class="material-symbols-outlined fs-5 text-muted">devices</span>
                <span class="fw-semibold text-dark">รายการอุปกรณ์และ Passkey ที่บันทึกไว้ในบัญชีของคุณ:</span>
                <span class="text-muted">ยังไม่มีการลงทะเบียนอุปกรณ์ลายนิ้วมือ คลิกปุ่ม “บันทึกลายนิ้วมือเครื่องนี้” ด้านบนเพื่อเริ่มใช้งาน</span>
            </div>
            <span class="badge bg-white text-secondary border">0 รายการ</span>
        </div>
    </section>

    <!-- Section 6: Chart.js Line Chart & Form UI Elements -->
    <section class="row g-3">
        <!-- Interactive Chart Visualization -->
        <div class="col-lg-7">
            <div class="card-surface p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-nordic-blue fs-5">insights</span>
                            <h3 class="h6 fw-bold text-dark mb-0">สถิติการใช้งานระบบ (Chart.js Interactive Demo)</h3>
                        </div>
                        <span class="badge badge-nordic">Realtime</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 text-secondary small mb-3">
                        <span class="d-inline-flex align-items-center gap-1.5">
                            <span class="rounded bg-primary d-inline-block" style="width: 12px; height: 12px; background-color: var(--nordic-blue, #3B82F6) !important;"></span>
                            การเข้าใช้งานระบบรายวัน (Logins)
                        </span>
                        <span class="text-muted">อัปเดตอัตโนมัติทุก 60 วินาที</span>
                    </div>
                    <!-- Inline SVG Chart Demo Container -->
                    <div class="p-3 bg-light rounded-3 border position-relative" style="height: 250px;">
                        <svg class="w-100 overflow-visible" style="height: 180px;" viewBox="0 0 500 160">
                            <line stroke="#E2E8F0" stroke-dasharray="3 3" x1="0" x2="500" y1="0" y2="0"></line>
                            <line stroke="#E2E8F0" stroke-dasharray="3 3" x1="0" x2="500" y1="40" y2="40"></line>
                            <line stroke="#E2E8F0" stroke-dasharray="3 3" x1="0" x2="500" y1="80" y2="80"></line>
                            <line stroke="#E2E8F0" stroke-dasharray="3 3" x1="0" x2="500" y1="120" y2="120"></line>
                            <defs>
                                <linearGradient id="chartNordicGrad" x1="0%" x2="0%" y1="0%" y2="100%">
                                    <stop offset="0%" stop-color="#3B82F6" stop-opacity="0.35"></stop>
                                    <stop offset="70%" stop-color="#3B82F6" stop-opacity="0.08"></stop>
                                    <stop offset="100%" stop-color="#3B82F6" stop-opacity="0.0"></stop>
                                </linearGradient>
                            </defs>
                            <path d="M 10 135 C 70 120, 110 90, 170 80 C 230 70, 270 20, 340 18 C 400 16, 440 95, 490 125 L 490 160 L 10 160 Z" fill="url(#chartNordicGrad)"></path>
                            <path d="M 10 135 C 70 120, 110 90, 170 80 C 230 70, 270 20, 340 18 C 400 16, 440 95, 490 125" fill="none" stroke="#3B82F6" stroke-linecap="round" stroke-width="2.5"></path>
                            <circle cx="10" cy="135" fill="#3B82F6" r="4" stroke="#ffffff" stroke-width="2"></circle>
                            <circle cx="90" cy="115" fill="#3B82F6" r="4" stroke="#ffffff" stroke-width="2"></circle>
                            <circle cx="170" cy="80" fill="#3B82F6" r="4" stroke="#ffffff" stroke-width="2"></circle>
                            <circle cx="255" cy="40" fill="#3B82F6" r="4" stroke="#ffffff" stroke-width="2"></circle>
                            <circle cx="340" cy="18" fill="#3B82F6" r="5" stroke="#ffffff" stroke-width="2"></circle>
                            <circle cx="420" cy="98" fill="#3B82F6" r="4" stroke="#ffffff" stroke-width="2"></circle>
                            <circle cx="490" cy="125" fill="#3B82F6" r="4" stroke="#ffffff" stroke-width="2"></circle>
                        </svg>
                        <div class="d-flex justify-content-between text-secondary small pt-1" style="font-size: 0.75rem;">
                            <span>จันทร์</span>
                            <span>อังคาร</span>
                            <span>พุธ</span>
                            <span>พฤหัสบดี</span>
                            <span>ศุกร์</span>
                            <span>เสาร์</span>
                            <span>อาทิตย์</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 small text-muted border-top mt-3">
                    <span>บันทึกทราฟฟิกข้อมูลคลัสเตอร์ BUU-FIN-CLUSTER-04</span>
                    <span class="text-nordic-blue fw-bold">ค่าเฉลี่ย 384 ครั้ง/วัน</span>
                </div>
            </div>
        </div>
        <!-- Form UI Elements -->
        <div class="col-lg-5">
            <div class="card-surface p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-nordic-blue fs-5">tune</span>
                            <h3 class="h6 fw-bold text-dark mb-0">ส่วนประกอบฟอร์ม (Form UI Elements)</h3>
                        </div>
                        <span class="badge bg-light text-secondary border">Interactive</span>
                    </div>
                    <form class="d-flex flex-column gap-3" onsubmit="event.preventDefault()">
                        <!-- Select2 Searchable Dropdown -->
                        <div>
                            <label class="form-label small fw-semibold text-dark mb-1" for="demo-select2">สังกัด / คณะ (Select2 Searchable Dropdown):</label>
                            <select id="demo-select2" class="form-select bg-white border w-100">
                                <option value="">---เลือก---</option>
                                <option selected="" value="buu_inf">คณะวิทยาการสารสนเทศ (Informatics)</option>
                                <option value="buu_eng">คณะวิศวกรรมศาสตร์</option>
                                <option value="buu_med">คณะแพทยศาสตร์</option>
                                <option value="buu_mgt">คณะการจัดการและการท่องเที่ยว</option>
                            </select>
                            <div class="form-text small text-muted">ค้นหาตัวเลือกได้ทันที พร้อม Placeholder มาตรฐาน ---เลือก---</div>
                        </div>
                        <!-- jQuery UI Datepicker พ.ศ. -->
                        <div>
                            <label class="form-label small fw-semibold text-dark mb-1" for="demo-datepicker">วันที่เริ่มต้นโครงการ (jQuery UI Datepicker พ.ศ.):</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted">
                                    <span class="material-symbols-outlined fs-6">calendar_month</span>
                                </span>
                                <input id="demo-datepicker" class="form-control bg-white" placeholder="วว/ดด/ปปปป (พ.ศ.)" type="text" value="24/10/2567"/>
                            </div>
                            <div class="form-text small text-muted">ปฏิทินไทยปี พ.ศ. (+543) พร้อมปุ่ม “ล้างค่า” ตามมาตรฐาน MA BUCC</div>
                        </div>
                        <!-- AutoNumeric Masking -->
                        <div>
                            <label class="form-label small fw-semibold text-dark mb-1" for="demo-autonumeric">งบประมาณโครงการ (AutoNumeric Masking):</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white fw-bold text-secondary">THB</span>
                                <input id="demo-autonumeric" class="form-control bg-white text-end fw-bold" type="text" value="฿ 1,850,000.00"/>
                            </div>
                            <div class="form-text small text-muted">จัดรูปแบบอัตราแลกเปลี่ยนและคั่นหลักพันอัตโนมัติขณะพิมพ์</div>
                        </div>
                    </form>
                </div>
                <div class="pt-3 d-flex justify-content-end gap-2 border-top mt-3">
                    <button class="btn btn-sm btn-white bg-white border fw-medium" type="button">รีเซ็ตค่าฟอร์ม</button>
                    <button class="btn btn-sm btn-nordic-primary fw-medium shadow-sm" type="button">บันทึกฟิลด์ทดสอบ</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 7: DataTables Bootstrap 5 & Dropzone Upload -->
    <section class="row g-3">
        <!-- DataGrid (DataTables Bootstrap 5) -->
        <div class="col-lg-8">
            <div class="card-surface p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-nordic-blue fs-5">table_chart</span>
                            <h3 class="h6 fw-bold text-dark mb-0">ตารางข้อมูลสารสนเทศ (DataTables Bootstrap 5)</h3>
                        </div>
                        <span class="badge bg-light text-secondary border">Data Grid</span>
                    </div>
                    <!-- Table Controls -->
                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2 mb-3">
                        <div class="d-flex align-items-center gap-2 small">
                            <span>แสดง</span>
                            <select class="form-select form-select-sm" style="width: auto;">
                                <option>5</option>
                                <option>10</option>
                                <option>25</option>
                            </select>
                            <span>รายการ</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 small">
                            <span>ค้นหา:</span>
                            <input class="form-control form-control-sm" placeholder="พิมพ์เพื่อค้นหา..." style="width: 180px;" type="search"/>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-secondary">
                                    <th scope="col">
                                        <span class="d-inline-flex align-items-center gap-1 cursor-pointer">
                                            #รหัส <i class="bi bi-caret-up-fill" style="font-size: 10px;"></i>
                                        </span>
                                    </th>
                                    <th scope="col">ชื่อโมดูล / ระบบงาน</th>
                                    <th scope="col">ผู้รับผิดชอบ</th>
                                    <th class="text-center" scope="col">วันที่ (พ.ศ.)</th>
                                    <th class="text-center" scope="col">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <tr>
                                    <td class="fw-bold">#MD-01</td>
                                    <td>Active Directory &amp; LDAP Service</td>
                                    <td>
                                        <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                            <span class="material-symbols-outlined fs-6 text-nordic-blue">person</span> System Admin
                                        </span>
                                    </td>
                                    <td class="text-center text-muted">15/10/2569</td>
                                    <td class="text-center">
                                        <span class="badge badge-nordic-success rounded-pill px-2.5 py-1">พร้อมใช้งาน</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">#MD-02</td>
                                    <td>Role &amp; Permission Access Control</td>
                                    <td>
                                        <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                            <span class="material-symbols-outlined fs-6 text-nordic-blue">security</span> Security Auditor
                                        </span>
                                    </td>
                                    <td class="text-center text-muted">14/10/2569</td>
                                    <td class="text-center">
                                        <span class="badge badge-nordic-success rounded-pill px-2.5 py-1">พร้อมใช้งาน</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">#MD-03</td>
                                    <td>5 Audit Stamps Pipeline Monitor</td>
                                    <td>
                                        <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                            <span class="material-symbols-outlined fs-6 text-secondary">storage</span> DBA Architect
                                        </span>
                                    </td>
                                    <td class="text-center text-muted">12/10/2569</td>
                                    <td class="text-center">
                                        <span class="badge badge-nordic-syncing rounded-pill px-2.5 py-1">กำลังประมวลผล</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">#MD-04</td>
                                    <td>Media Vault &amp; Dropzone Uploader</td>
                                    <td>
                                        <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                            <span class="material-symbols-outlined fs-6 text-secondary">cloud_sync</span> DevOps Lead
                                        </span>
                                    </td>
                                    <td class="text-center text-muted">10/10/2569</td>
                                    <td class="text-center">
                                        <span class="badge badge-nordic-standby rounded-pill px-2.5 py-1">รอตรวจสอบ</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">#MD-05</td>
                                    <td>Export Engine &amp; ZIP Stream Archiver</td>
                                    <td>
                                        <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                            <span class="material-symbols-outlined fs-6 text-nordic-blue">code</span> Backend Engineer
                                        </span>
                                    </td>
                                    <td class="text-center text-muted">08/10/2569</td>
                                    <td class="text-center">
                                        <span class="badge badge-nordic-success rounded-pill px-2.5 py-1">พร้อมใช้งาน</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Table Pagination -->
                <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between pt-3 border-top mt-3 small text-muted">
                    <span>แสดง 1 ถึง 5 จากทั้งหมด 6 รายการ</span>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">ก่อนหน้า</a></li>
                            <li class="page-item active"><a class="page-link btn-nordic-primary border-primary text-white" href="#">1</a></li>
                            <li class="page-item"><a class="page-link text-secondary" href="#">2</a></li>
                            <li class="page-item"><a class="page-link text-secondary" href="#">ถัดไป</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Dropzone Upload Container -->
        <div class="col-lg-4">
            <div class="card-surface p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-nordic-blue fs-5">cloud_upload</span>
                            <h3 class="h6 fw-bold text-dark mb-0">ระบบอัปโหลดไฟล์ (Dropzone)</h3>
                        </div>
                        <span class="badge bg-light text-secondary border">Upload Vault</span>
                    </div>
                    <!-- Dropzone Canvas -->
                    <div class="p-4 bg-light rounded-3 text-center border border-2 border-dashed border-secondary-subtle" id="dropzone-box" style="cursor: pointer;">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px; background-color: var(--nordic-blue-soft, #EFF6FF);">
                            <span class="material-symbols-outlined fs-2 text-nordic-blue">upload_file</span>
                        </div>
                        <h4 class="h6 fw-bold text-dark mb-1">ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเลือกไฟล์</h4>
                        <p class="text-muted small mb-3">
                            รองรับไฟล์เอกสาร PDF, PNG, JPG, DOCX (จำลองการทดสอบ Client-side Encrypted)
                        </p>
                        <span class="badge bg-white text-nordic-blue border shadow-sm px-3 py-1.5 fw-medium d-inline-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-6">verified</span>
                            <span>Client AES-256 Validated</span>
                        </span>
                        <input class="d-none" id="dropzone-input" multiple="" type="file"/>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-3 small text-muted">
                    <span class="d-inline-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-6">lock</span> Max upload: 10MB
                    </span>
                    <span class="text-nordic-blue fw-medium">AutoPreview Enabled</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 8: Component Showcase (Buttons, Icons, Inputs, Switches) -->
    <section class="row g-3">
        <!-- Button Styles & Actions Showcase -->
        <div class="col-md-6">
            <div class="card-surface p-4 h-100 d-flex flex-column gap-3">
                <div class="d-flex align-items-center justify-content-between pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-nordic-blue fs-5">smart_button</span>
                        <h3 class="h6 fw-bold text-dark mb-0">ชุดปุ่มและสถานะการโต้ตอบ (Button Styles &amp; Actions)</h3>
                    </div>
                    <span class="badge bg-light text-secondary border">Actions</span>
                </div>
                <!-- Solid Variants -->
                <div>
                    <label class="form-label small text-secondary fw-semibold mb-2">1. ปุ่มสีหลักความเข้ม (Solid Variants):</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-nordic-primary btn-sm d-inline-flex align-items-center gap-1 shadow-sm">
                            <span class="material-symbols-outlined fs-6">done</span> Primary Action
                        </button>
                        <button class="btn btn-nordic-slate btn-sm d-inline-flex align-items-center gap-1">
                            <span class="material-symbols-outlined fs-6">tune</span> Secondary Slate
                        </button>
                        <button class="btn btn-success btn-sm d-inline-flex align-items-center gap-1 fw-medium">
                            <span class="material-symbols-outlined fs-6">verified</span> Success
                        </button>
                        <button class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1 fw-medium">
                            <span class="material-symbols-outlined fs-6">error</span> Danger
                        </button>
                        <button class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1 fw-medium">
                            <span class="material-symbols-outlined fs-6">delete</span> Outline Danger
                        </button>
                        <button class="btn btn-warning btn-sm d-inline-flex align-items-center gap-1 fw-medium text-dark">
                            <span class="material-symbols-outlined fs-6">warning</span> Warning
                        </button>
                        <button class="btn btn-secondary btn-sm fw-medium">Muted Neutral</button>
                    </div>
                </div>
                <!-- Soft Subtle & Sizes -->
                <div>
                    <label class="form-label small text-secondary fw-semibold mb-2">2. ปุ่มแบบนวลและขนาด (Soft Subtle &amp; Sizes):</label>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button class="btn btn-nordic-soft btn-sm">Small Soft</button>
                        <button class="btn btn-nordic-soft">Regular Subtle</button>
                        <button class="btn btn-nordic-soft btn-lg fs-6 shadow-sm">+ Large Subtle</button>
                        <button class="btn btn-danger-subtle text-danger btn-sm fw-medium border border-danger-subtle">Danger Soft</button>
                    </div>
                </div>
                <!-- Group, Badge & Spinner -->
                <div>
                    <label class="form-label small text-secondary fw-semibold mb-2">3. ปุ่มกลุ่ม, ป้ายเตือน และสถานะโหลด (Group, Badge &amp; Spinner):</label>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <!-- Button Group -->
                        <div class="btn-group btn-group-sm shadow-sm" role="group">
                            <button class="btn btn-white bg-white border fw-medium d-inline-flex align-items-center gap-1 active text-nordic-blue" type="button">
                                <span class="material-symbols-outlined fs-6">grid_view</span> Grid
                            </button>
                            <button class="btn btn-white bg-white border text-secondary fw-medium d-inline-flex align-items-center gap-1" type="button">
                                <span class="material-symbols-outlined fs-6">format_list_bulleted</span> List
                            </button>
                            <button class="btn btn-white bg-white border text-secondary fw-medium d-inline-flex align-items-center gap-1" type="button">
                                <span class="material-symbols-outlined fs-6">table_rows</span> Table
                            </button>
                        </div>
                        <!-- Alert Badge Button -->
                        <button class="btn btn-sm btn-white bg-white border text-dark position-relative fw-medium d-inline-flex align-items-center gap-1" type="button">
                            <span class="material-symbols-outlined fs-6">notifications</span> Alerts
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                                5+
                            </span>
                        </button>
                        <!-- Loading Spinner Button -->
                        <button class="btn btn-sm btn-nordic-primary fw-medium d-inline-flex align-items-center gap-2" type="button">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                            <span>กำลังประมวลผล...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Icon Set (Bootstrap Icons & Blade Icons) -->
        <div class="col-md-6">
            <div class="card-surface p-4 h-100 d-flex flex-column gap-3">
                <div class="d-flex align-items-center justify-content-between pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-nordic-blue fs-5">category</span>
                        <h3 class="h6 fw-bold text-dark mb-0">คลังไอคอนระบบ (Bootstrap Icons &amp; Blade Icons)</h3>
                    </div>
                    <span class="badge bg-light text-secondary border">Icons Set</span>
                </div>
                <p class="text-secondary small mb-1">
                    ไอคอนเวกเตอร์ความคมชัดสูง รองรับทั้งการเรียกผ่านคลาส HTML และ Blade Components:
                </p>
                <div class="row row-cols-2 row-cols-sm-4 g-2">
                    <div class="col">
                        <div class="p-2.5 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined text-nordic-blue fs-3">speed</span>
                            <span class="small fw-semibold text-dark mt-1">Dashboard</span>
                            <span class="text-muted" style="font-size: 10px;">speedometer2</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2.5 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined text-nordic-blue fs-3">shield</span>
                            <span class="small fw-semibold text-dark mt-1">Security</span>
                            <span class="text-muted" style="font-size: 10px;">shield-lock</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2.5 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined text-nordic-blue fs-3">fingerprint</span>
                            <span class="small fw-semibold text-dark mt-1">Biometrics</span>
                            <span class="text-muted" style="font-size: 10px;">fingerprint</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2.5 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined text-nordic-blue fs-3">database</span>
                            <span class="small fw-semibold text-dark mt-1">Database</span>
                            <span class="text-muted" style="font-size: 10px;">database-gear</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2.5 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined text-nordic-blue fs-3">cloud</span>
                            <span class="small fw-semibold text-dark mt-1">Cloud Upload</span>
                            <span class="text-muted" style="font-size: 10px;">cloud-upload</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2.5 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined text-nordic-blue fs-3">memory</span>
                            <span class="small fw-semibold text-dark mt-1">Engine Core</span>
                            <span class="text-muted" style="font-size: 10px;">cpu-fill</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2.5 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined text-nordic-blue fs-3">picture_as_pdf</span>
                            <span class="small fw-semibold text-dark mt-1">PDF Export</span>
                            <span class="text-muted" style="font-size: 10px;">file-pdf</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2.5 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined text-nordic-blue fs-3">qr_code_scanner</span>
                            <span class="small fw-semibold text-dark mt-1">Scanner</span>
                            <span class="text-muted" style="font-size: 10px;">qr-code</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Form Inputs & Textarea -->
        <div class="col-md-6">
            <div class="card-surface p-4 h-100 d-flex flex-column gap-3">
                <div class="d-flex align-items-center justify-content-between pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-nordic-blue fs-5">edit_note</span>
                        <h3 class="h6 fw-bold text-dark mb-0">กล่องกรอกข้อมูลและข้อความ (Inputs &amp; Textarea)</h3>
                    </div>
                    <span class="badge bg-light text-secondary border">Form Fields</span>
                </div>
                <!-- Standard Input with icon -->
                <div>
                    <label class="form-label small fw-semibold text-dark mb-1">ชื่อ-นามสกุล (Standard Input with Icon):</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-muted">
                            <span class="material-symbols-outlined fs-6">badge</span>
                        </span>
                        <input class="form-control bg-white" type="text" value="ดร.สมชาย มุ่งมั่น"/>
                    </div>
                </div>
                <!-- Password with Visibility Toggle -->
                <div>
                    <label class="form-label small fw-semibold text-dark mb-1">รหัสผ่านลับ (Password with Visibility Toggle):</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-muted">
                            <span class="material-symbols-outlined fs-6">key</span>
                        </span>
                        <input class="form-control bg-white" id="input-password-demo" type="password" value="SuperSecretPassword123"/>
                        <button class="btn btn-white bg-white border text-muted" id="btn-toggle-password" type="button">
                            <span class="material-symbols-outlined fs-6">visibility</span>
                        </button>
                    </div>
                </div>
                <!-- Valid & Invalid States Dual Input -->
                <div class="row g-2">
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold text-success mb-1">สถานะผ่าน (Valid):</label>
                        <div class="input-group has-validation">
                            <input class="form-control is-valid" type="text" value="admin.pantakarn"/>
                        </div>
                        <div class="valid-feedback d-block small">ชื่อผู้ใช้พร้อมใช้งาน</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold text-danger mb-1">สถานะผิด (Invalid):</label>
                        <div class="input-group has-validation">
                            <input class="form-control is-invalid" type="text" value="inv@lid#id"/>
                        </div>
                        <div class="invalid-feedback d-block small">รูปแบบรหัสไม่ถูกต้อง</div>
                    </div>
                </div>
                <!-- Textarea with Character Counter -->
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <label class="form-label small fw-semibold text-dark mb-0">รายละเอียดข้อคิดเห็น (Textarea):</label>
                        <span class="small text-muted">0 / 250</span>
                    </div>
                    <textarea class="form-control bg-white" placeholder="พิมพ์ข้อความรายละเอียด หรือบันทึกเพิ่มเติมที่นี่..." rows="3"></textarea>
                </div>
            </div>
        </div>
        <!-- Checkboxes, Radios & Switches -->
        <div class="col-md-6">
            <div class="card-surface p-4 h-100 d-flex flex-column justify-content-between gap-3">
                <div>
                    <div class="d-flex align-items-center justify-content-between pb-2 border-bottom mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-nordic-blue fs-5">toggle_on</span>
                            <h3 class="h6 fw-bold text-dark mb-0">ตัวเลือกและสวิตช์ (Checkboxes, Radios &amp; Switches)</h3>
                        </div>
                        <span class="badge bg-light text-secondary border">Selections</span>
                    </div>
                    <!-- 1. Checkboxes -->
                    <div class="mb-3">
                        <span class="form-label small text-secondary fw-semibold d-block mb-2">1. ตัวเลือกหลายรายการ (Checkboxes):</span>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <div class="form-check">
                                <input checked="" class="form-check-input" id="check1" type="checkbox"/>
                                <label class="form-check-label small" for="check1">ตัวเลือกที่ 1 (เปิด)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="check2" type="checkbox"/>
                                <label class="form-check-label small" for="check2">ตัวเลือกที่ 2 (ปิด)</label>
                            </div>
                            <div class="form-check">
                                <input checked="" class="form-check-input" disabled="" id="check3" type="checkbox"/>
                                <label class="form-check-label small text-muted" for="check3">ล็อคถาวร (Disabled)</label>
                            </div>
                        </div>
                    </div>
                    <!-- 2. Switches -->
                    <div class="mb-3">
                        <span class="form-label small text-secondary fw-semibold d-block mb-2">2. สวิตช์เปิด/ปิดฟังก์ชัน (Switch Toggles):</span>
                        <div class="d-flex flex-column gap-2">
                            <div class="p-2.5 rounded-2 bg-light border d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="small fw-semibold text-dark">การยืนยันตัวตน 2 ขั้นตอน (2FA / WebAuthn)</div>
                                    <div class="text-muted" style="font-size: 11px;">บังคับใช้สแกนลายนิ้วมือหรือรหัสผ่านรอบสอง</div>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input checked="" class="form-check-input" role="switch" type="checkbox"/>
                                </div>
                            </div>
                            <div class="p-2.5 rounded-2 bg-light border d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="small fw-semibold text-dark">ส่งการแจ้งเตือนทางอีเมลอัตโนมัติ (Email Dispatcher)</div>
                                    <div class="text-muted" style="font-size: 11px;">แจ้งสรุปเหตุการณ์สำคัญประจำวัน</div>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" role="switch" type="checkbox"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 3. Radios -->
                    <div class="mb-3">
                        <span class="form-label small text-secondary fw-semibold d-block mb-2">3. ตัวเลือกรายการเดียว (Radio Buttons):</span>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <div class="form-check">
                                <input checked="" class="form-check-input" id="radioAdmin" name="userRoleRadio" type="radio"/>
                                <label class="form-check-label small" for="radioAdmin">ผู้ดูแลระบบ (Admin)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="radioStaff" name="userRoleRadio" type="radio"/>
                                <label class="form-check-label small" for="radioStaff">เจ้าหน้าที่ (Staff)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="radioUser" name="userRoleRadio" type="radio"/>
                                <label class="form-check-label small" for="radioUser">ผู้ใช้งานทั่วไป (User)</label>
                            </div>
                        </div>
                    </div>
                    <!-- 4. Segmented Button Group -->
                    <div>
                        <span class="form-label small text-secondary fw-semibold d-block mb-2">4. ตัวเลือกสไตล์ปุ่มสลับช่วงเวลา (Segmented Button Group):</span>
                        <div class="btn-group segmented-theme-group w-100 p-1 border rounded-2" role="group">
                            <input autocomplete="off" checked="" class="btn-check" id="btnradio1" name="btnperiod" type="radio"/>
                            <label class="btn btn-sm" for="btnradio1">รายวัน</label>
                            <input autocomplete="off" class="btn-check" id="btnradio2" name="btnperiod" type="radio"/>
                            <label class="btn btn-sm" for="btnradio2">รายสัปดาห์</label>
                            <input autocomplete="off" class="btn-check" id="btnradio3" name="btnperiod" type="radio"/>
                            <label class="btn btn-sm" for="btnradio3">รายเดือน</label>
                            <input autocomplete="off" class="btn-check" id="btnradio4" name="btnperiod" type="radio"/>
                            <label class="btn btn-sm" for="btnradio4">รายปี</label>
                        </div>
                    </div>
                </div>
                <div class="pt-3 d-flex align-items-center justify-content-between small text-secondary border-top">
                    <span>สถานะการเลือก: อัปเดตไปยัง Reactivity State ทันที</span>
                    <span class="text-nordic-blue fw-bold">Ready</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 9: Institutional Footer Audit Stamp -->
    <footer class="card-surface p-3 d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background-color: var(--nordic-blue-soft, #EFF6FF);">
                <span class="material-symbols-outlined fs-5 text-nordic-blue">verified</span>
            </div>
            <div>
                <div class="small fw-semibold text-dark">มาตรฐานฐานข้อมูล 5 Audit Stamps (model-migration-audit-stamps)</div>
                <div class="text-muted font-monospace" style="font-size: 11px;">
                    created_by • created_at • updated_by • updated_at • request_uri
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge badge-nordic text-uppercase px-2.5 py-1.5 fw-semibold">
                AUDIT COMPLIANT
            </span>
            <span class="small text-muted font-monospace">v4.8-NORDIC</span>
        </div>
    </footer>
</div>

<script>
    // SweetAlert2 Mock / Live Toast simulation
    const btnSwal = document.getElementById('btn-swal-demo');
    if (btnSwal) {
        btnSwal.addEventListener('click', () => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'เชื่อมต่อ SweetAlert2 สำเร็จ',
                    text: 'Artisan POS & Inventory Hub ทำงานปกติทุกระบบ!',
                    confirmButtonColor: '#3B82F6'
                });
            } else {
                const toast = document.createElement('div');
                toast.className = 'position-fixed bottom-0 end-0 m-4 p-3 bg-dark text-white rounded-3 shadow-lg d-flex align-items-center gap-2';
                toast.style.zIndex = '9999';
                toast.innerHTML = '<span class="material-symbols-outlined text-primary">check_circle</span><div><div class="fw-bold small">SweetAlert2 Connected</div><div class="small text-secondary">Artisan POS Core system is operating nominal!</div></div>';
                document.body.appendChild(toast);
                setTimeout(() => {
                    toast.remove();
                }, 3500);
            }
        });
    }

    // Dropzone click trigger
    const dropzoneBox = document.getElementById('dropzone-box');
    const dropzoneInput = document.getElementById('dropzone-input');
    if (dropzoneBox && dropzoneInput) {
        dropzoneBox.addEventListener('click', () => dropzoneInput.click());
        dropzoneInput.addEventListener('change', (e) => {
            if (e.target.files && e.target.files.length > 0) {
                alert('อัปโหลดสำเร็จ: ' + e.target.files.length + ' ไฟล์ถูกเข้ารหัสด้วย AES-256 เรียบร้อยแล้ว');
            }
        });
    }

    // Password Visibility Toggle
    const btnTogglePass = document.getElementById('btn-toggle-password');
    const inputPass = document.getElementById('input-password-demo');
    if (btnTogglePass && inputPass) {
        btnTogglePass.addEventListener('click', () => {
            const isPass = inputPass.getAttribute('type') === 'password';
            inputPass.setAttribute('type', isPass ? 'text' : 'password');
            const icon = btnTogglePass.querySelector('.material-symbols-outlined');
            if (icon) {
                icon.textContent = isPass ? 'visibility_off' : 'visibility';
            }
        });
    }

    // WebAuthn Passkey Helper Functions
    function bufferToBase64url(buffer) {
        const bytes = new Uint8Array(buffer);
        let binary = '';
        for (let i = 0; i < bytes.byteLength; i++) {
            binary += String.fromCharCode(bytes[i]);
        }
        return btoa(binary).replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
    }

    function base64urlToUint8Array(base64url) {
        let padding = '='.repeat((4 - (base64url.length % 4)) % 4);
        let base64 = (base64url + padding).replace(/-/g, '+').replace(/_/g, '/');
        let rawData = atob(base64);
        let outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    async function registerWebauthnBiometric() {
        if (!window.PublicKeyCredential) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'เบราว์เซอร์ไม่รองรับ WebAuthn',
                    text: 'อุปกรณ์หรือเบราว์เซอร์นี้ไม่รองรับการยืนยันตัวตนด้วยลายนิ้วมือ / Passkey'
                });
            } else {
                alert('อุปกรณ์หรือเบราว์เซอร์นี้ไม่รองรับการยืนยันตัวตนด้วยลายนิ้วมือ / Passkey');
            }
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const registerBtn = document.getElementById('btn-register-passkey-device') || document.getElementById('btn-passkey-register');
        const origBtnHtml = registerBtn ? registerBtn.innerHTML : '';
        if (registerBtn) {
            registerBtn.disabled = true;
            registerBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> <span>กำลังเชื่อมต่ออุปกรณ์...</span>';
        }

        try {
            const optRes = await fetch('{{ Route::has("webauthn.register.options") ? route("webauthn.register.options") : url("/webauthn/register/options") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            if (!optRes.ok) {
                const err = await optRes.json().catch(() => ({}));
                throw new Error(err.error || 'ไม่สามารถรับข้อมูลการลงทะเบียนจากเซิร์ฟเวอร์');
            }

            const options = await optRes.json();
            options.challenge = base64urlToUint8Array(options.challenge);
            if (options.user && options.user.id) {
                options.user.id = base64urlToUint8Array(options.user.id);
            }
            if (options.excludeCredentials && options.excludeCredentials.length > 0) {
                options.excludeCredentials = options.excludeCredentials.map(c => ({
                    ...c,
                    id: base64urlToUint8Array(c.id)
                }));
            }

            const credential = await navigator.credentials.create({
                publicKey: options
            });

            if (!credential) {
                throw new Error('การลงทะเบียนลายนิ้วมือถูกยกเลิก');
            }

            const payload = {
                id: credential.id,
                rawId: bufferToBase64url(credential.rawId),
                type: credential.type,
                response: {
                    clientDataJSON: bufferToBase64url(credential.response.clientDataJSON),
                    attestationObject: bufferToBase64url(credential.response.attestationObject)
                }
            };

            const verifyRes = await fetch('{{ Route::has("webauthn.register.verify") ? route("webauthn.register.verify") : url("/webauthn/register/verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const verifyData = await verifyRes.json();
            if (!verifyRes.ok || !verifyData.success) {
                throw new Error(verifyData.error || 'การตรวจสอบความถูกต้องล้มเหลว');
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'บันทึกลายนิ้วมือสำเร็จ',
                    text: 'ลงทะเบียน Passkey สำหรับเครื่องนี้เรียบร้อยแล้ว ท่านสามารถเข้าสู่ระบบครั้งต่อไปได้โดยไม่ต้องกรอกรหัสผ่าน',
                    confirmButtonColor: '#3B82F6'
                });
            } else {
                alert('บันทึกลายนิ้วมือสำเร็จ! ท่านสามารถใช้ Passkey เข้าสู่ระบบครั้งต่อไปได้ทันที');
            }
        } catch (err) {
            console.error(err);
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'ลงทะเบียนไม่สำเร็จ',
                    text: err.message || 'เกิดข้อผิดพลาดในการเชื่อมต่อเซ็นเซอร์ลายนิ้วมือ',
                    confirmButtonColor: '#3B82F6'
                });
            } else {
                alert('ลงทะเบียนไม่สำเร็จ: ' + (err.message || 'เกิดข้อผิดพลาด'));
            }
        } finally {
            if (registerBtn) {
                registerBtn.disabled = false;
                registerBtn.innerHTML = origBtnHtml;
            }
        }
    }
</script>
@endsection
