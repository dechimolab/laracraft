@extends(view()->exists('layouts.app') ? 'layouts.app' : 'themes.solar-amber.layouts.app')

@section('content')
<div class="d-flex flex-column gap-4">

    <!-- Section 1: Top Subheader Banner -->
    <section class="card bg-white shadow-sm rounded-3" style="border: 1px solid var(--ap-border-warm, #F3E8D0); border-radius: 14px;">
        <div class="card-body p-4" style="background: linear-gradient(135deg, #FFFFFF 0%, var(--ap-surface-low, #F8F4E4) 100%); border-radius: 14px;">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill fw-bold px-2.5 py-1" style="background-color: #451A03; color: #FFFFFF; font-size: 11px; letter-spacing: 0.04em;">
                            <i class="bi bi-cpu-fill text-warning me-1"></i>ARTISANCRAFT ENGINE
                        </span>
                        <span class="badge rounded-pill fw-medium px-2 py-1" style="background-color: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; font-size: 11px;">Laravel 13.x</span>
                        <span class="badge rounded-pill fw-medium px-2 py-1" style="background-color: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; font-size: 11px;">PHP 8.4 JIT</span>
                        <span class="badge rounded-pill fw-medium px-2 py-1" style="background-color: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; font-size: 11px;">Bootstrap 5.3.3</span>
                        <span class="badge rounded-pill fw-medium px-2 py-1" style="background-color: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; font-size: 11px;">WCAG AAA 14.3:1</span>
                    </div>
                    <h1 class="h4 fw-bold mb-1" style="color: var(--ap-coffee, #451A03); letter-spacing: -0.02em;">
                        ยินดีต้อนรับสู่ <span style="color: var(--ap-primary-solar, #D97706);">{{ $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'Artisan POS & Inventory Hub') }}</span>
                    </h1>
                    <p class="mb-0 text-muted" style="color: var(--ap-on-surface-variant, #554336) !important; font-size: 13px;">
                        ระบบบริหารจัดการและหน่วยควบคุมต้นแบบ (Demo Showcase Dashboard) พร้อมส่วนประกอบ UI และระบบรักษาความปลอดภัยครบวงจร Fiduciary Precision Standard
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-solar-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold shadow-sm" id="btn-passkey-register" onclick="registerWebauthnBiometric()" type="button" style="font-size: 13px;">
                        <span class="material-symbols-outlined fs-6">fingerprint</span>
                        <span>บันทึกลายนิ้วมือใหม่ (Passkey)</span>
                    </button>
                    <button class="btn btn-solar-subtle d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold" id="btn-swal-demo" type="button" style="font-size: 13px;">
                        <span class="material-symbols-outlined fs-6">notifications_active</span>
                        <span>ทดสอบ SweetAlert2</span>
                    </button>
                </div>
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
        if (!empty($isPreviewMode) || empty($selectedModules) || count($selectedModules) < 4) {
            $selectedModules = [
                'ums_buu' => '1',
                'buu_ldap' => '1',
                'audit_trail' => '1',
                'user_role' => '1',
            ];
        }

        $moduleDefs = [
            'ums_buu' => [
                'title' => 'UMS BUU (SSO)',
                'badge' => 'Active',
                'desc' => 'ระบบยืนยันตัวตนกลาง ม.บูรพา & จัดการบทบาทสิทธิ์ผู้ใช้งาน (UMS Identity Provider Hub)',
                'icon' => 'login',
                'route' => Route::has('demo.ums') ? route('demo.ums') : (Route::has('switch.group') ? route('switch.group') : '#'),
                'btnText' => 'เข้าสู่ระบบ / สลับสิทธิ์ UMS',
            ],
            'buu_ldap' => [
                'title' => 'BUU LDAP & Passkey',
                'badge' => 'Active',
                'desc' => 'เชื่อมโยงบัญชี Active Directory และกุญแจความปลอดภัยชีวมิติ FIDO2 Passkey',
                'icon' => 'lan',
                'route' => Route::has('demo.ldap') ? route('demo.ldap') : '#',
                'btnText' => 'เปิดหน้าทดสอบ LDAP',
            ],
            'user_role' => [
                'title' => 'Role & Permissions (RBAC)',
                'badge' => 'Active',
                'desc' => 'กำหนดสิทธิ์ระดับกลุ่มและเมนูการใช้งานตามโครงสร้างองค์กรอย่างแม่นยำ',
                'icon' => 'admin_panel_settings',
                'route' => Route::has('demo.roles') ? route('demo.roles') : (Route::has('switch.group') ? route('switch.group') : '#'),
                'btnText' => 'จัดการสิทธิ์ผู้ใช้งาน',
            ],
            'audit_trail' => [
                'title' => 'Audit Trail & Activity Log',
                'badge' => 'Active',
                'desc' => 'บันทึกประวัติการเปลี่ยนแปลงข้อมูลของ Eloquent Model ทุกตัวอัตโนมัติ พร้อมเก็บบันทึก IP และ JSON Diff',
                'icon' => 'policy',
                'route' => Route::has('demo.audit') ? route('demo.audit') : '#',
                'btnText' => 'ตรวจสอบ Audit Trail',
            ],
            'notifications' => [
                'title' => 'Multi-Channel Notifications',
                'badge' => 'Active',
                'desc' => 'ระบบแจ้งเตือนแบบเรียลไทม์ผ่าน Webhook, อีเมล และบันทึกข้อความภายในระบบ',
                'icon' => 'campaign',
                'route' => Route::has('notifications.index') ? route('notifications.index') : '#',
                'btnText' => 'ทดสอบการส่งแจ้งเตือน',
            ],
            'media_storage' => [
                'title' => 'Media Storage & Vault',
                'badge' => 'Active',
                'desc' => 'จัดเก็บและเข้ารหัสไฟล์อย่างปลอดภัย พร้อมการทำสตรีมมิ่งและย่อภาพอัตโนมัติ',
                'icon' => 'cloud_upload',
                'route' => '#media-vault',
                'btnText' => 'เปิดดูคลังไฟล์',
            ],
            'system_settings' => [
                'title' => 'System Settings Matrix',
                'badge' => 'Active',
                'desc' => 'บริหารจัดการพารามิเตอร์การทำงาน ค่าตัวแปรระบบ และ Environment รันไทม์',
                'icon' => 'tune',
                'route' => '#system-settings',
                'btnText' => 'ตั้งค่าระบบ',
            ],
        ];
    @endphp

    <section>
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-2">
                <span class="material-symbols-outlined text-warning fs-5">view_cozy</span>
                <span class="fw-bold text-uppercase" style="font-size: 14px; color: var(--ap-coffee, #451A03); letter-spacing: 0.04em;">
                    โมดูลสำเร็จรูปประจำโปรเจกต์ (Enterprise Pre-built Modules Demo Hub)
                </span>
            </div>
            <span class="badge" style="background: var(--ap-surface-container, #F2EEDE); color: var(--ap-coffee-muted, #78350F); border: 1px solid var(--ap-border-warm, #F3E8D0); font-size: 11px;">
                STEP 3 MODULES
            </span>
        </div>
        <div class="row g-3">
            @foreach($selectedModules as $modKey => $val)
                @if(isset($moduleDefs[$modKey]))
                    @php $mod = $moduleDefs[$modKey]; @endphp
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="subtle-module-card h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge rounded-pill" style="background: #ECFDF5; color: #047857; font-size: 10px; font-weight: 700;">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i>{{ $mod['badge'] }}
                                    </span>
                                    <code class="small text-muted" style="font-size: 11px;">{{ $modKey }}</code>
                                </div>
                                <h6 class="fw-bold mb-1" style="color: var(--ap-coffee, #451A03);">{{ $mod['title'] }}</h6>
                                <p class="small text-muted mb-3" style="font-size: 12px; line-height: 1.5;">{{ $mod['desc'] }}</p>
                            </div>
                            <a class="btn btn-solar-subtle btn-sm w-100 d-flex align-items-center justify-content-center gap-2 text-decoration-none" href="{{ $mod['route'] }}" style="padding: 7px; border-radius: 8px;">
                                <span class="material-symbols-outlined fs-6 text-warning">{{ $mod['icon'] }}</span>
                                <span>{{ $mod['btnText'] }}</span>
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    <!-- Section 3: Telemetry, Speed & Live Control Strip -->
    <section class="card bg-white shadow-sm border-0" style="border: 1px solid var(--ap-border-warm, #F3E8D0) !important; border-radius: 12px;">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between pb-3 mb-3 border-bottom" style="border-color: var(--ap-border-warm, #F3E8D0) !important;">
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold" style="font-size: 14px; color: var(--ap-coffee, #451A03);">{{ config('app.name', 'Artisan POS & Inventory Hub') }}</span>
                    <code class="text-muted" style="font-size: 10px;">SYS-CORE-ONLINE</code>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge rounded-pill" style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 700;">
                        <i class="bi bi-dot"></i>ONLINE &bull; UPTIME 99.98%
                    </span>
                </div>
            </div>
            <div class="row g-4 align-items-center">
                <!-- Metric 1: System Velocity -->
                <div class="col-12 col-lg-3 border-end-lg" style="border-color: var(--ap-border-warm, #F3E8D0) !important;">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="text-uppercase fw-bold text-muted" style="font-size: 10px; letter-spacing: 0.05em;">SYSTEM VELOCITY</span>
                        <i class="bi bi-arrow-up-right text-muted small"></i>
                    </div>
                    <div class="h3 fw-bold mb-1" style="color: var(--ap-primary-solar, #D97706);">$492.30 <span class="small fs-6 text-muted fw-normal">AOV</span></div>
                    <div class="small fw-bold d-flex align-items-center gap-1" style="color: #047857;">
                        <i class="bi bi-graph-up-arrow"></i> +14.8% growth vs last period
                    </div>
                </div>
                <!-- Metric 2: Active Telemetry Sparkline -->
                <div class="col-12 col-lg-4 border-end-lg" style="border-color: var(--ap-border-warm, #F3E8D0) !important;">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="text-uppercase fw-bold text-muted" style="font-size: 10px; letter-spacing: 0.05em;">ACTIVE TELEMETRY</span>
                        <span class="badge rounded-pill px-2 py-0" style="background-color: #FEF3C7; color: #92400E; font-size: 0.65rem;">REAL-TIME</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <svg class="w-100" style="height: 38px;" viewBox="0 0 160 40">
                                <defs>
                                    <linearGradient id="solarSpark" x1="0" x2="0" y1="0" y2="1">
                                        <stop offset="0%" stop-color="#D97706" stop-opacity="0.35"></stop>
                                        <stop offset="100%" stop-color="#D97706" stop-opacity="0"></stop>
                                    </linearGradient>
                                </defs>
                                <path d="M 0 32 Q 30 35, 60 25 T 100 12 T 130 20 T 160 8 L 160 40 L 0 40 Z" fill="url(#solarSpark)"></path>
                                <path d="M 0 32 Q 30 35, 60 25 T 100 12 T 130 20 T 160 8" fill="none" stroke="#D97706" stroke-linecap="round" stroke-width="2.5"></path>
                            </svg>
                        </div>
                        <div class="text-end">
                            <div class="small fw-bold" style="color: var(--ap-coffee, #451A03);">Zero Bottlenecks</div>
                            <div class="text-muted small" style="font-size: 0.72rem;">0.14ms Latency</div>
                        </div>
                    </div>
                </div>
                <!-- Metric 3: Quick Form Action Prepend -->
                <div class="col-12 col-lg-5">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="text-uppercase fw-bold text-muted" style="font-size: 10px; letter-spacing: 0.05em;">SAMPLE FORM CONTROL</span>
                        <span class="text-muted small" style="font-size: 0.7rem;">Input Prepend</span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted" style="border-color: var(--ap-border-warm, #F3E8D0);"><i class="bi bi-person"></i></span>
                        <input class="form-control" readonly style="border-color: var(--ap-border-warm, #F3E8D0);" type="text" value="pantakarn@buu.ac.th"/>
                        <button class="btn btn-solar-primary px-3" type="button" onclick="alert('Primary Action Triggered')">Primary Action</button>
                        <button class="btn btn-outline-secondary" style="border-color: var(--ap-border-warm, #F3E8D0); color: var(--ap-coffee, #451A03);" type="button" onclick="alert('Secondary Action Triggered')">Secondary</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Four Key Stat Metrics -->
    <section class="row g-3">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card bg-white p-3 d-flex flex-row align-items-center gap-3 shadow-sm border-0" style="border: 1px solid var(--ap-border-warm, #F3E8D0) !important; border-radius: 12px;">
                <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 44px; height: 44px; background-color: #FEF3C7; color: #D97706;">
                    <i class="bi bi-people-fill fs-5"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">ผู้ใช้งานในระบบ</div>
                    <div class="h5 fw-bold mb-0" style="color: var(--ap-coffee, #451A03);">1,248 คน</div>
                    <div class="small fw-medium" style="font-size: 0.75rem; color: #047857;"><i class="bi bi-arrow-up-short"></i>+12% สัปดาห์นี้</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card bg-white p-3 d-flex flex-row align-items-center gap-3 shadow-sm border-0" style="border: 1px solid var(--ap-border-warm, #F3E8D0) !important; border-radius: 12px;">
                <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 44px; height: 44px; background-color: #FEF3C7; color: #D97706;">
                    <i class="bi bi-shield-check fs-5"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">ACTIVE DIRECTORY</div>
                    <div class="h5 fw-bold mb-0" style="color: var(--ap-coffee, #451A03);">BUU LDAP</div>
                    <div class="small fw-medium" style="font-size: 0.75rem; color: #047857;"><i class="bi bi-check2"></i> ซิงค์เรียบร้อย</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card bg-white p-3 d-flex flex-row align-items-center gap-3 shadow-sm border-0" style="border: 1px solid var(--ap-border-warm, #F3E8D0) !important; border-radius: 12px;">
                <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 44px; height: 44px; background-color: #FEF3C7; color: #D97706;">
                    <i class="bi bi-database-fill fs-5"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">DATABASE MATRIX</div>
                    <div class="h5 fw-bold mb-0" style="color: var(--ap-coffee, #451A03);">MySQL 8.4</div>
                    <div class="text-muted small fw-medium" style="font-size: 0.75rem;"><i class="bi bi-hdd-stack"></i> InnoDB utf8mb4</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card bg-white p-3 d-flex flex-row align-items-center gap-3 shadow-sm border-0" style="border: 1px solid var(--ap-border-warm, #F3E8D0) !important; border-radius: 12px;">
                <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 44px; height: 44px; background-color: #FEF3C7; color: #D97706;">
                    <i class="bi bi-award-fill fs-5"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">AUDIT TRAIL</div>
                    <div class="h5 fw-bold mb-0" style="color: var(--ap-coffee, #451A03);">5 Stamps</div>
                    <div class="text-muted small fw-medium" style="font-size: 0.75rem;"><i class="bi bi-shield-lock"></i> มาตรฐานความปลอดภัย</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5: WebAuthn / Passkey Biometrics Bar -->
    <section class="card bg-white shadow-sm border-0" style="border: 1px solid var(--ap-border-warm, #F3E8D0) !important; border-radius: 12px;">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-3 border-bottom" style="border-color: var(--ap-border-warm, #F3E8D0) !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-2 rounded-circle" style="background-color: #FEF3C7; color: #D97706;">
                        <span class="material-symbols-outlined fs-3">fingerprint</span>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h5 class="mb-0 fw-bold" style="color: var(--ap-coffee, #451A03);">ระบบยืนยันตัวตนชีวมิติ (WebAuthn / Passkey Biometrics)</h5>
                            <span class="badge" style="background-color: #ECFDF5; color: #047857; border: 1px solid #A7F3D0;"><i class="bi bi-check2-circle me-1"></i>รองรับ Touch ID / Windows Hello</span>
                        </div>
                        <p class="small text-secondary mb-0">เข้าสู่ระบบด้วยลายนิ้วมือ Touch ID / Windows Hello แบบไร้รหัสผ่าน (Passwordless) ตามมาตรฐาน W3C WebAuthn &amp; FIDO2</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-light border btn-sm text-secondary rounded-3" onclick="location.reload()" title="รีเฟรชข้อมูล"><i class="bi bi-arrow-clockwise"></i></button>
                    <button class="btn btn-solar-primary btn-sm px-3 py-2 rounded-3 d-inline-flex align-items-center gap-2" onclick="registerWebauthnBiometric()">
                        <span class="material-symbols-outlined fs-6">vpn_key</span>
                        <span>บันทึกลายนิ้วมือเครื่องนี้</span>
                    </button>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-3">
                <div class="d-flex align-items-center gap-2 small text-secondary">
                    <span class="material-symbols-outlined fs-6">laptop_mac</span>
                    <span><strong>รายการอุปกรณ์และ Passkey ที่บันทึกไว้ในบัญชีของคุณ:</strong> ยังไม่มีการลงทะเบียนอุปกรณ์ลายนิ้วมือ คลิกปุ่ม "บันทึกลายนิ้วมือเครื่องนี้" ด้านบนเพื่อเริ่มใช้งาน</span>
                </div>
                <span class="badge bg-light text-secondary border">0 รายการ</span>
            </div>
        </div>
    </section>

    <!-- Section 6: Middle Dual Column Grid (Chart & Form Elements) -->
    <section class="row g-3">
        <!-- Left: Chart.js Interactive Line Chart -->
        <div class="col-12 col-lg-7">
            <div class="card bg-white p-4 h-100 d-flex flex-column justify-content-between shadow-sm border-0" style="border: 1px solid var(--ap-border-warm, #F3E8D0) !important; border-radius: 12px;">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-warning">analytics</span>
                            <h5 class="fw-bold mb-0" style="color: var(--ap-coffee, #451A03);">สถิติการใช้งานระบบ (Chart.js Interactive Demo)</h5>
                        </div>
                        <span class="badge" style="background-color: #FEF3C7; color: #92400E; border: 1px solid #FDE68A;">Realtime</span>
                    </div>
                    <div class="small text-muted mb-3 d-flex align-items-center gap-2">
                        <span class="spinner-grow spinner-grow-sm text-warning" style="width: 6px; height: 6px;"></span>
                        <span>การเข้าใช้งานระบบรายวัน (Logins) อัปเดตอัตโนมัติทุก 60 วินาที</span>
                    </div>
                    <div class="position-relative" style="height: 240px;">
                        <canvas id="solarAmberChart"></canvas>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top small text-muted mt-3" style="border-color: var(--ap-border-warm, #F3E8D0) !important;">
                    <span>บันทึกทราฟฟิกข้อมูลคลัสเตอร์ BUU-FIN-CLUSTER-04</span>
                    <span class="fw-bold" style="color: var(--ap-coffee, #451A03);">ค่าเฉลี่ย 384 ครั้ง/วัน</span>
                </div>
            </div>
        </div>

        <!-- Right: Form UI Elements Showcase -->
        <div class="col-12 col-lg-5">
            <div class="card bg-white p-4 h-100 d-flex flex-column justify-content-between shadow-sm border-0" style="border: 1px solid var(--ap-border-warm, #F3E8D0) !important; border-radius: 12px;">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-ui-checks text-warning fs-5"></i>
                            <h5 class="fw-bold mb-0" style="color: var(--ap-coffee, #451A03);">ส่วนประกอบฟอร์ม (Form UI Elements)</h5>
                        </div>
                        <span class="badge" style="background: var(--ap-surface-container, #F2EEDE); color: var(--ap-coffee, #451A03);">Interactive</span>
                    </div>
                    <!-- Select2 Searchable Dropdown with standard empty placeholder -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold mb-1" style="color: var(--ap-coffee, #451A03);">สังกัด / คณะ (Select2 Searchable Dropdown):</label>
                        <select class="form-select select2-demo" id="facultySelect" style="width: 100%;">
                            <option value="">---เลือก---</option>
                            <option value="1" selected>คณะวิทยาการสารสนเทศ (Informatics)</option>
                            <option value="2">คณะวิศวกรรมศาสตร์ (Engineering)</option>
                            <option value="3">คณะวิทยาศาสตร์ (Science)</option>
                            <option value="4">วิทยาลัยการจัดการและนวัตกรรม (CIM)</option>
                        </select>
                        <div class="text-muted small mt-1" style="font-size: 0.72rem;">ค้นหาตัวเลือกได้ทันที พร้อม Placeholder มาตรฐาน ---เลือก---</div>
                    </div>
                    <!-- Datepicker Thai Calendar -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold mb-1" style="color: var(--ap-coffee, #451A03);">วันที่เริ่มต้นโครงการ (jQuery UI Datepicker พ.ศ.):</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white" style="border-color: var(--ap-border-warm, #F3E8D0); color: var(--ap-coffee-muted, #78350F);"><i class="bi bi-calendar3"></i></span>
                            <input class="form-control datepicker-th" id="projectStartDate" style="border-color: var(--ap-border-warm, #F3E8D0);" type="text" value="24/10/2569"/>
                        </div>
                        <div class="text-muted small mt-1" style="font-size: 0.72rem;">ปฏิทินไทยปี พ.ศ. (+543) พร้อมปุ่ม "ล้างค่า" ตามมาตรฐาน MA BUCC</div>
                    </div>
                    <!-- AutoNumeric Masking Input -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold mb-1" style="color: var(--ap-coffee, #451A03);">งบประมาณโครงการ (AutoNumeric Masking):</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text" style="background: var(--ap-surface-container, #F2EEDE); border-color: var(--ap-border-warm, #F3E8D0); color: var(--ap-coffee, #451A03); font-weight: 700; font-size: 11px;">THB</span>
                            <input class="form-control text-end fw-bold autonumeric-currency" id="budgetInput" style="border-color: var(--ap-border-warm, #F3E8D0); color: var(--ap-coffee, #451A03);" type="text" value="1850000.00"/>
                        </div>
                        <div class="text-muted small mt-1" style="font-size: 0.72rem;">จัดรูปแบบอัตราแลกเปลี่ยนและคั่นหลักพันอัตโนมัติขณะพิมพ์</div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end gap-2 pt-2 border-top" style="border-color: var(--ap-border-warm, #F3E8D0) !important;">
                    <button class="btn btn-sm btn-outline-secondary" style="border-color: var(--ap-border-warm, #F3E8D0); font-size: 12px; color: var(--ap-coffee, #451A03);" type="button" onclick="document.getElementById('budgetInput').value = '100000.00';">รีเซ็ตค่าฟอร์ม</button>
                    <button class="btn btn-sm btn-solar-primary" style="font-size: 12px;" type="button" onclick="alert('บันทึกข้อมูลเรียบร้อยแล้ว')">บันทึกฟอร์มทดสอบ</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 7: Data Table & Dropzone Upload Grid -->
    <section class="row g-3">
        <!-- DataTables Bootstrap 5 Showcase -->
        <div class="col-12 col-lg-8">
            <div class="card bg-white p-4 h-100 shadow-sm border-0" style="border: 1px solid var(--ap-border-warm, #F3E8D0) !important; border-radius: 12px;">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined text-warning">table_chart</span>
                        <h5 class="fw-bold mb-0" style="color: var(--ap-coffee, #451A03);">ตารางข้อมูลสารสนเทศ (DataTables Bootstrap 5)</h5>
                    </div>
                    <span class="badge" style="background-color: #FEF3C7; color: #92400E; border: 1px solid #FDE68A;">Data Grid</span>
                </div>
                <!-- Table Controls (Show Entries & Search) -->
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
                    <div class="d-flex align-items-center gap-2 small text-secondary">
                        <span>แสดง</span>
                        <select class="form-select form-select-sm" style="width: 70px; border-color: var(--ap-border-warm, #F3E8D0);">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                        </select>
                        <span>รายการ</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 small">
                        <span class="text-secondary">ค้นหา:</span>
                        <input class="form-control form-control-sm" placeholder="พิมพ์เพื่อค้นหา..." style="width: 170px; border-color: var(--ap-border-warm, #F3E8D0);" type="search"/>
                    </div>
                </div>
                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-2">
                        <thead style="background-color: var(--ap-surface-low, #F8F4E4);">
                            <tr class="small text-uppercase text-secondary">
                                <th scope="col" style="color: var(--ap-coffee, #451A03);">#รหัส <i class="bi bi-arrow-down-up small ms-1"></i></th>
                                <th scope="col" style="color: var(--ap-coffee, #451A03);">ชื่อโมดูล / ระบบงาน</th>
                                <th scope="col" style="color: var(--ap-coffee, #451A03);">ผู้รับผิดชอบ</th>
                                <th scope="col" style="color: var(--ap-coffee, #451A03);">วันที่ (พ.ศ.)</th>
                                <th class="text-end" scope="col" style="color: var(--ap-coffee, #451A03);">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            <tr>
                                <td class="fw-bold" style="color: var(--ap-primary-solar, #D97706);">#MD-01</td>
                                <td>Active Directory &amp; LDAP Service</td>
                                <td><i class="bi bi-person me-1 text-muted"></i>System Admin</td>
                                <td>15/10/2569</td>
                                <td class="text-end"><span class="badge rounded-pill" style="background-color: #ECFDF5; color: #047857; border: 1px solid #A7F3D0;">พร้อมใช้งาน</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="color: var(--ap-primary-solar, #D97706);">#MD-02</td>
                                <td>Role &amp; Permission Access Control</td>
                                <td><i class="bi bi-shield-lock me-1 text-muted"></i>Security Auditor</td>
                                <td>14/10/2569</td>
                                <td class="text-end"><span class="badge rounded-pill" style="background-color: #ECFDF5; color: #047857; border: 1px solid #A7F3D0;">พร้อมใช้งาน</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="color: var(--ap-primary-solar, #D97706);">#MD-03</td>
                                <td>5 Audit Stamps Pipeline Monitor</td>
                                <td><i class="bi bi-database me-1 text-muted"></i>DBA Architect</td>
                                <td>12/10/2569</td>
                                <td class="text-end"><span class="badge rounded-pill" style="background-color: #ECFDF5; color: #047857; border: 1px solid #A7F3D0;">พร้อมใช้งาน</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="color: var(--ap-primary-solar, #D97706);">#MD-04</td>
                                <td>Realtime Webhook Notifications</td>
                                <td><i class="bi bi-bell me-1 text-muted"></i>API Engineer</td>
                                <td>10/10/2569</td>
                                <td class="text-end"><span class="badge rounded-pill" style="background-color: #ECFDF5; color: #047857; border: 1px solid #A7F3D0;">พร้อมใช้งาน</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="d-flex flex-wrap align-items-center justify-content-between pt-2 small text-secondary">
                    <span>แสดง 1 ถึง 4 จาก 4 รายการ</span>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><span class="page-link">&laquo; ก่อนหน้า</span></li>
                        <li class="page-item active"><span class="page-link" style="background-color: var(--ap-primary-solar, #D97706); border-color: var(--ap-primary-solar, #D97706);">1</span></li>
                        <li class="page-item disabled"><span class="page-link">ถัดไป &raquo;</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Dropzone File Upload -->
        <div class="col-12 col-lg-4">
            <div class="card bg-white p-4 h-100 shadow-sm border-0 d-flex flex-column justify-content-between" style="border: 1px solid var(--ap-border-warm, #F3E8D0) !important; border-radius: 12px;">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-warning">upload_file</span>
                            <h5 class="fw-bold mb-0" style="color: var(--ap-coffee, #451A03);">อัปโหลดไฟล์ (Dropzone.js)</h5>
                        </div>
                        <span class="badge" style="background: var(--ap-surface-container, #F2EEDE); color: var(--ap-coffee, #451A03);">Secure</span>
                    </div>
                    <form action="#" class="dropzone dropzone-solar p-4 text-center d-flex flex-column align-items-center justify-content-center" id="demoDropzone" style="min-height: 180px; cursor: pointer;">
                        <div class="dz-message needsclick d-flex flex-column align-items-center gap-2 m-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; background-color: #FEF3C7; color: #D97706;">
                                <span class="material-symbols-outlined fs-2">cloud_upload</span>
                            </div>
                            <span class="fw-bold" style="color: var(--ap-coffee, #451A03); font-size: 13px;">ลากไฟล์มาวางที่นี่ หรือคลิกเพื่อเลือกไฟล์</span>
                            <span class="text-muted small" style="font-size: 0.72rem;">รองรับ PDF, PNG, JPG ขนาดไม่เกิน 10MB</span>
                        </div>
                    </form>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-3 small text-muted" style="border-color: var(--ap-border-warm, #F3E8D0) !important;">
                    <span class="d-flex align-items-center gap-1"><i class="bi bi-shield-check text-success"></i> Safe Upload Engine</span>
                    <span>Antivirus Scan: Active</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 8: Component Showcase (Buttons, Icons) -->
    <section class="row g-3">
        <!-- Button Styles & Actions Showcase -->
        <div class="col-md-6">
            <div class="card-surface p-4 shadow-sm h-100 d-flex flex-column gap-3" style="border: 1px solid var(--ap-border-warm, #F3E8D0);">
                <div class="d-flex align-items-center justify-content-between pb-2 border-bottom" style="border-color: var(--ap-border-warm, #F3E8D0) !important;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-5" style="color: var(--ap-primary-solar, #D97706);">smart_button</span>
                        <h3 class="h6 fw-bold text-dark mb-0">ชุดปุ่มและสถานะการโต้ตอบ (Button Styles &amp; Actions)</h3>
                    </div>
                    <span class="badge bg-light text-secondary border">Actions</span>
                </div>
                <!-- Solid Variants -->
                <div>
                    <label class="form-label small text-secondary fw-semibold mb-2">1. ปุ่มสีหลักความเข้ม (Solid Variants):</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-solar-primary btn-sm d-inline-flex align-items-center gap-1 fw-semibold shadow-sm rounded-pill">
                            <span class="material-symbols-outlined fs-6">done</span> Primary Action
                        </button>
                        <button class="btn btn-solar-subtle btn-sm d-inline-flex align-items-center gap-1 fw-semibold rounded-pill">
                            <span class="material-symbols-outlined fs-6">tune</span> Secondary Action
                        </button>
                        <button class="btn btn-solar-primary btn-sm d-inline-flex align-items-center gap-1 fw-semibold rounded-pill">
                            <span class="material-symbols-outlined fs-6">verified</span> Success
                        </button>
                        <button class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1 fw-semibold rounded-pill">
                            <span class="material-symbols-outlined fs-6">error</span> Danger
                        </button>
                        <button class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1 fw-semibold rounded-pill">
                            <span class="material-symbols-outlined fs-6">delete</span> Outline Danger
                        </button>
                        <button class="btn btn-warning btn-sm d-inline-flex align-items-center gap-1 fw-semibold text-dark rounded-pill">
                            <span class="material-symbols-outlined fs-6">warning</span> Warning
                        </button>
                        <button class="btn btn-secondary btn-sm fw-semibold rounded-pill">Muted Neutral</button>
                    </div>
                </div>
                <!-- Soft Subtle & Sizes -->
                <div>
                    <label class="form-label small text-secondary fw-semibold mb-2">2. ปุ่มแบบนวลและขนาด (Soft Subtle &amp; Sizes):</label>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button class="btn btn-sm rounded-pill" style="background-color: #FEF3C7; color: #92400E; font-weight: 600; border: 1px solid #FDE68A;">Small Soft</button>
                        <button class="btn rounded-pill" style="background-color: #FEF3C7; color: #92400E; font-weight: 600; border: 1px solid #FDE68A;">Regular Subtle</button>
                        <button class="btn btn-lg fs-6 shadow-sm rounded-pill" style="background-color: #FEF3C7; color: #92400E; font-weight: 600; border: 1px solid #FDE68A;">+ Large Subtle</button>
                        <button class="btn btn-sm fw-semibold text-danger rounded-pill" style="background-color: #FEE2E2;">Danger Soft</button>
                    </div>
                </div>
                <!-- Group, Badge & Spinner -->
                <div>
                    <label class="form-label small text-secondary fw-semibold mb-2">3. ปุ่มกลุ่ม, ป้ายเตือน และสถานะโหลด (Group, Badge &amp; Spinner):</label>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <div class="btn-group btn-group-sm shadow-sm" role="group">
                            <button class="btn btn-light border fw-semibold d-inline-flex align-items-center gap-1 active" type="button">
                                <span class="material-symbols-outlined fs-6">grid_view</span> Grid
                            </button>
                            <button class="btn btn-light border text-secondary fw-semibold d-inline-flex align-items-center gap-1" type="button">
                                <span class="material-symbols-outlined fs-6">format_list_bulleted</span> List
                            </button>
                            <button class="btn btn-light border text-secondary fw-semibold d-inline-flex align-items-center gap-1" type="button">
                                <span class="material-symbols-outlined fs-6">table_rows</span> Table
                            </button>
                        </div>
                        <button class="btn btn-sm btn-light border text-dark position-relative fw-semibold d-inline-flex align-items-center gap-1 rounded-pill" type="button">
                            <span class="material-symbols-outlined fs-6">notifications</span> Alerts
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                                5+
                            </span>
                        </button>
                        <button class="btn btn-sm btn-solar-primary fw-semibold d-inline-flex align-items-center gap-2 rounded-pill" type="button">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                            <span>กำลังประมวลผล...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Icon Set (Bootstrap Icons & Material Symbols) -->
        <div class="col-md-6">
            <div class="card-surface p-4 shadow-sm h-100 d-flex flex-column gap-3" style="border: 1px solid var(--ap-border-warm, #F3E8D0);">
                <div class="d-flex align-items-center justify-content-between pb-2 border-bottom" style="border-color: var(--ap-border-warm, #F3E8D0) !important;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-5" style="color: var(--ap-primary-solar, #D97706);">category</span>
                        <h3 class="h6 fw-bold text-dark mb-0">คลังไอคอนระบบ (Bootstrap Icons &amp; Vector Icons)</h3>
                    </div>
                    <span class="badge bg-light text-secondary border">Icons Set</span>
                </div>
                <p class="text-secondary small mb-1">
                    ไอคอนเวกเตอร์ความคมชัดสูง รองรับทั้งการเรียกผ่านคลาส HTML และ Blade Components:
                </p>
                <div class="row row-cols-2 row-cols-sm-4 g-2">
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--ap-primary-solar, #D97706);">speed</span>
                            <span class="small fw-semibold text-dark mt-1">Dashboard</span>
                            <span class="text-muted" style="font-size: 10px;">speedometer</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--ap-primary-solar, #D97706);">shield</span>
                            <span class="small fw-semibold text-dark mt-1">Security</span>
                            <span class="text-muted" style="font-size: 10px;">shield-lock</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--ap-primary-solar, #D97706);">fingerprint</span>
                            <span class="small fw-semibold text-dark mt-1">Biometrics</span>
                            <span class="text-muted" style="font-size: 10px;">passkey</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--ap-primary-solar, #D97706);">database</span>
                            <span class="small fw-semibold text-dark mt-1">Database</span>
                            <span class="text-muted" style="font-size: 10px;">mysql</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--ap-primary-solar, #D97706);">lan</span>
                            <span class="small fw-semibold text-dark mt-1">Directory</span>
                            <span class="text-muted" style="font-size: 10px;">ldap</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--ap-primary-solar, #D97706);">cloud_upload</span>
                            <span class="small fw-semibold text-dark mt-1">Dropzone</span>
                            <span class="text-muted" style="font-size: 10px;">upload-vault</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--ap-primary-solar, #D97706);">local_cafe</span>
                            <span class="small fw-semibold text-dark mt-1">Artisanal</span>
                            <span class="text-muted" style="font-size: 10px;">solar-amber</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--ap-primary-solar, #D97706);">lock</span>
                            <span class="small fw-semibold text-dark mt-1">Vault</span>
                            <span class="text-muted" style="font-size: 10px;">tls-fips</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 9: Audit Stamps Footer Parameters (Mandatory Standard) -->
    <footer class="card-surface p-3 d-flex flex-wrap align-items-center justify-content-between gap-2" style="border-color: var(--ap-border-warm, #F3E8D0) !important;">
        <div class="d-flex flex-wrap align-items-center gap-3 small text-secondary">
            <span><strong class="text-dark">created_by:</strong> pantakarn</span>
            <span><strong class="text-dark">created_at:</strong> {{ date('Y-m-d H:i:s') }}</span>
            <span><strong class="text-dark">updated_by:</strong> pantakarn</span>
            <span><strong class="text-dark">updated_at:</strong> {{ date('Y-m-d H:i:s') }}</span>
            <span><strong class="text-dark">request_uri:</strong> {{ request()->getRequestUri() }}</span>
        </div>
        <div class="small fw-semibold" style="color: var(--ap-primary-solar, #D97706);">
            Solar Amber &amp; Coffee Theme • ArtisanCraft Scaffolding
        </div>
    </footer>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Chart.js Initialization
        const ctx = document.getElementById('solarAmberChart');
        if (ctx && typeof Chart !== 'undefined') {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์'],
                    datasets: [{
                        label: 'การเข้าใช้งานระบบ (Logins)',
                        data: [140, 210, 320, 490, 530, 260, 190],
                        borderColor: '#D97706',
                        backgroundColor: 'rgba(217, 119, 6, 0.15)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#FFFFFF',
                        pointBorderColor: '#D97706',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#451A03',
                            titleColor: '#FFFFFF',
                            bodyColor: '#FFFFFF',
                            padding: 10,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#78350F', font: { family: 'Plus Jakarta Sans, Sarabun' } }
                        },
                        y: {
                            grid: { color: 'rgba(243, 232, 208, 0.6)' },
                            ticks: { color: '#78350F', font: { family: 'Plus Jakarta Sans, Sarabun' } },
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // 2. Select2 Initialization with standard ---เลือก--- placeholder
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('.select2-demo').select2({
                placeholder: '---เลือก---',
                allowClear: true,
                width: '100%'
            });
        }

        // 3. jQuery UI Datepicker Thai Calendar
        if (typeof $ !== 'undefined' && $.fn.datepicker) {
            $('.datepicker-th').datepicker({
                dateFormat: 'dd/mm/yy',
                isBuddhist: true,
                changeMonth: true,
                changeYear: true,
                dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
                monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.']
            });
        }

        // 4. AutoNumeric Initialization
        if (typeof AutoNumeric !== 'undefined') {
            const budgetEl = document.querySelector('.autonumeric-currency');
            if (budgetEl && !AutoNumeric.getAutoNumericElement(budgetEl)) {
                new AutoNumeric(budgetEl, {
                    currencySymbol: '฿ ',
                    decimalPlaces: 2,
                    digitGroupSeparator: ',',
                    decimalCharacter: '.'
                });
            }
        }

        // 5. SweetAlert2 Demo
        const swalBtn = document.getElementById('btn-swal-demo');
        if (swalBtn) {
            swalBtn.addEventListener('click', function () {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Solar Amber & Coffee Alert',
                        text: 'ระบบโมดัลมาตรฐาน Forge Artisan Engine พร้อมใช้งาน 100%',
                        icon: 'success',
                        confirmButtonText: 'รับทราบ',
                        confirmButtonColor: '#D97706'
                    });
                } else {
                    alert('SweetAlert2: ระบบโมดัลทำงานปกติ');
                }
            });
        }
    });

    // WebAuthn Passkey Registration Handler
    function registerWebauthnBiometric() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'ลงทะเบียนกุญแจชีวมิติ (Passkey)',
                text: 'คุณต้องการบันทึกกุญแจความปลอดภัยลายนิ้วมือ Touch ID / Windows Hello สำหรับเครื่องนี้หรือไม่?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#D97706',
                cancelButtonColor: '#78350F',
                confirmButtonText: 'ลงทะเบียนทันที',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'สำเร็จ!',
                        text: 'ลงทะเบียนกุญแจ Passkey สำหรับโหมดพรีวิว Solar Amber & Coffee เรียบร้อยแล้ว',
                        icon: 'success',
                        confirmButtonColor: '#D97706'
                    });
                }
            });
        } else {
            alert('ลงทะเบียนกุญแจ Passkey เรียบร้อยแล้ว');
        }
    }
</script>
@endpush