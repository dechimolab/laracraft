@extends(view()->exists('layouts.app') ? 'layouts.app' : 'themes.forest-moss.layouts.app')

@section('content')
<div class="d-flex flex-column gap-4">

    <!-- Section 1: Enterprise Welcome Hero Banner -->
    <section class="card-surface p-4 shadow-sm position-relative overflow-hidden border-0" style="background: linear-gradient(135deg, #F0FDF4 0%, #FFFFFF 60%, #DCFCE7 100%); border-radius: 16px; border: 1px solid #BBF7D0 !important;">
        <div class="position-relative z-1 row align-items-center g-3">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="badge rounded-pill text-uppercase px-2.5 py-1 fw-semibold" style="background-color: #DCFCE7; color: #14532D; font-size: 11px;">
                        <i class="bi bi-circle-fill me-1" style="font-size: 6px; color: #15803D;"></i>ArtisanCraft Engine
                    </span>
                    <span class="badge bg-white text-secondary border shadow-xs">Laravel 13.x</span>
                    <span class="badge bg-white text-secondary border shadow-xs">PHP 8.4 JIT</span>
                    <span class="badge bg-white text-secondary border shadow-xs">Bootstrap 5.3.3</span>
                    <span class="badge bg-white text-secondary border shadow-xs">WCAG AAA 14.9:1</span>
                </div>
                <h1 class="h3 fw-bold text-dark mt-2 mb-1">
                    ยินดีต้อนรับสู่ <span style="color: #15803D;">{{ config('app.name', 'Artisan POS & Inventory Hub') }}</span>
                </h1>
                <p class="text-secondary mb-0 small">
                    ระบบบริหารจัดการและหน้าควบคุมต้นแบบ (Forest Moss &amp; Sage) พร้อมส่วนประกอบ UI และระบบรักษาความปลอดภัยครบวงจร Fiduciary Precision Standard
                </p>
            </div>
            <div class="col-lg-4 d-flex flex-wrap justify-content-lg-end gap-2">
                <button class="btn btn-forest-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold shadow-sm rounded-3" type="button" id="btn-passkey-register" onclick="registerWebauthnBiometric()">
                    <span class="material-symbols-outlined fs-5">fingerprint</span>
                    <span>บันทึกลายนิ้วมือใหม่ (Passkey)</span>
                </button>
                <button class="btn btn-white bg-white border d-inline-flex align-items-center gap-2 px-3 py-2 text-dark fw-medium shadow-xs rounded-3" type="button" id="btn-swal-demo">
                    <span class="material-symbols-outlined fs-5 text-secondary">notifications_active</span>
                    <span>ทดสอบ SweetAlert2</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Section 2: Enterprise Pre-built Modules Demo Hub (4-Grid Left-Aligned) -->
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
        // Force complete 4-grid in preview mode or when fewer than 4 modules
        if (!empty($isPreviewMode) || empty($selectedModules) || count($selectedModules) < 4) {
            $selectedModules['ums_buu'] = '1';
            $selectedModules['buu_ldap'] = '1';
            $selectedModules['audit_trail'] = '1';
            $selectedModules['user_role'] = '1';
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
                'btn_link' => Route::has('demo.ums') ? route('demo.ums') : (Route::has('switch.group') ? route('switch.group') : '#'),
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
                'btn_link' => Route::has('demo.ldap') ? route('demo.ldap') : '#',
            ];
        }
        if (!empty($selectedModules['audit_trail'])) {
            $activeModulesList['audit_trail'] = [
                'name' => 'Audit Trail & Activity Log',
                'tag' => 'audit_trail',
                'status' => 'Active',
                'desc' => 'บันทึกประวัติการเปลี่ยนแปลงข้อมูลของ Eloquent Model ทุกตัวอัตโนมัติ พร้อมเก็บบันทึก IP และ JSON Diff',
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
    @endphp

    <section class="card-surface p-4 shadow-sm" style="border: 1px solid #BBF7D0;">
        <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom border-success-subtle">
            <div class="d-flex align-items-center gap-2">
                <span class="material-symbols-outlined fs-5" style="color: #15803D;">view_module</span>
                <h2 class="h6 fw-bold mb-0 text-dark">โมดูลสำเร็จรูปประจำโปรเจกต์ (Enterprise Pre-built Modules Demo Hub)</h2>
            </div>
            <span class="badge text-uppercase px-2.5 py-1" style="background-color: #DCFCE7; color: #14532D; border: 1px solid #BBF7D0;">Step 3 Modules</span>
        </div>
        <div class="row g-3">
            @foreach($activeModulesList as $mKey => $mod)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="subtle-module-card p-3.5 h-100 d-flex flex-column justify-content-between" style="border: 1px solid #BBF7D0; border-radius: 12px; background: #FFFFFF; padding: 1rem;">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge rounded-pill d-inline-flex align-items-center gap-1" style="background-color: #DCFCE7; color: #14532D; font-size: 11px;">
                                <span class="rounded-circle" style="width: 6px; height: 6px; background-color: #84CC16;"></span> {{ $mod['status'] }}
                            </span>
                            <span class="small text-muted font-monospace" style="font-size: 11px;">{{ $mod['tag'] }}</span>
                        </div>
                        <h3 class="h6 fw-bold text-dark mb-1">{{ $mod['name'] }}</h3>
                        <p class="text-secondary small mb-3" style="font-size: 12px; line-height: 1.5;">
                            {{ $mod['desc'] }}
                        </p>
                    </div>
                    <a href="{{ $mod['btn_link'] }}" class="btn btn-sm btn-white bg-white border shadow-sm w-100 d-inline-flex align-items-center justify-content-center gap-1 fw-semibold text-decoration-none" style="color: #15803D; border-color: #BBF7D0 !important;">
                        <span class="material-symbols-outlined fs-6">{{ $mod['btn_icon'] }}</span>
                        <span>{{ $mod['btn_text'] }}</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Section 3: Telemetry & KPI Cards Bar -->
    <section class="card-surface p-4 shadow-sm" style="border: 1px solid #BBF7D0;">
        <div class="d-flex flex-wrap align-items-center justify-content-between pb-2 mb-3 border-bottom border-success-subtle">
            <div class="d-flex align-items-center gap-2">
                <h2 class="h6 fw-bold mb-0" style="color: #15803D;">{{ config('app.name', 'Artisan POS & Inventory Hub') }}</h2>
                <span class="badge bg-light text-muted border font-monospace">SYS-CORE-ONLINE</span>
            </div>
            <span class="badge rounded-pill d-inline-flex align-items-center gap-1 text-uppercase" style="background-color: #DCFCE7; color: #14532D; border: 1px solid #84CC16;">
                <span class="spinner-grow spinner-grow-sm text-success" role="status" style="width: 8px; height: 8px;"></span>
                Online &bull; Uptime 99.98%
            </span>
        </div>
        <div class="row g-3">
            <!-- System Velocity -->
            <div class="col-lg-4">
                <div class="subtle-module-card p-3 h-100 d-flex flex-column justify-content-between" style="border: 1px solid #BBF7D0; border-radius: 10px;">
                    <div class="d-flex align-items-center justify-content-between text-secondary">
                        <span class="small fw-bold text-uppercase">System Velocity</span>
                        <span class="material-symbols-outlined fs-5" style="color: #15803D;">speed</span>
                    </div>
                    <div class="mt-2">
                        <div class="fs-3 fw-bold text-dark">$492.30 <span class="fs-6 fw-normal text-muted">AOV</span></div>
                        <div class="d-flex align-items-center gap-1 small fw-semibold mt-1" style="color: #15803D;">
                            <span class="material-symbols-outlined fs-6">trending_up</span>
                            <span>+14.8% growth vs last period</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Active Telemetry (Sparkline SVG) -->
            <div class="col-lg-4">
                <div class="subtle-module-card p-3 h-100 d-flex flex-column justify-content-between" style="border: 1px solid #BBF7D0; border-radius: 10px;">
                    <div class="d-flex align-items-center justify-content-between text-secondary">
                        <span class="small fw-bold text-uppercase">Active Telemetry</span>
                        <span class="badge rounded-pill" style="background-color: #DCFCE7; color: #14532D; font-size: 10px;">REAL-TIME</span>
                    </div>
                    <div class="w-100 my-1" style="height: 48px;">
                        <svg class="w-100 h-100" viewBox="0 0 200 40">
                            <path d="M0,32 Q25,28 50,30 T100,16 T150,22 T200,8 L200,40 L0,40 Z" fill="rgba(187, 247, 208, 0.4)"></path>
                            <path d="M0,32 Q25,28 50,30 T100,16 T150,22 T200,8" fill="none" stroke="#15803D" stroke-width="2.5"></path>
                        </svg>
                    </div>
                    <div class="d-flex align-items-center justify-content-between small text-secondary">
                        <span class="fw-semibold" style="color: #15803D;">Zero Bottlenecks</span>
                        <span>0.14ms Latency</span>
                    </div>
                </div>
            </div>
            <!-- Sample Form Control -->
            <div class="col-lg-4">
                <div class="subtle-module-card p-3 h-100 d-flex flex-column justify-content-between" style="border: 1px solid #BBF7D0; border-radius: 10px;">
                    <div class="d-flex align-items-center justify-content-between text-secondary mb-1">
                        <span class="small fw-bold text-uppercase">Sample Form Control</span>
                        <span class="small text-muted">Input Prepend</span>
                    </div>
                    <div class="input-group shadow-sm my-1">
                        <span class="input-group-text bg-light border-end-0">
                            <span class="material-symbols-outlined fs-6 text-secondary">person</span>
                        </span>
                        <input class="form-control bg-white border-start-0" readonly type="text" value="pantakarn@buu.ac.th"/>
                    </div>
                    <div class="d-flex gap-2 mt-2">
                        <button class="btn btn-sm btn-forest-primary flex-fill fw-semibold">Primary Action</button>
                        <button class="btn btn-sm btn-light border fw-semibold">Secondary</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Metric Counter Grid (4 Equalized Cards) -->
    <section class="row g-3">
        <div class="col-sm-6 col-lg-3">
            <div class="card-surface p-3 shadow-sm d-flex align-items-center gap-3 h-100" style="border: 1px solid #BBF7D0;">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #DCFCE7; color: #15803D;">
                    <span class="material-symbols-outlined fs-3">groups</span>
                </div>
                <div class="d-flex flex-column justify-content-center flex-grow-1 min-w-0">
                    <span class="text-secondary text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.04em;">ผู้ใช้งานในระบบ</span>
                    <div class="fs-5 fw-bold text-dark my-0.5 text-truncate">1,248</div>
                    <div class="small fw-semibold d-inline-flex align-items-center gap-1 text-truncate" style="font-size: 0.8rem; color: #15803D;">
                        <span class="material-symbols-outlined fs-6">trending_up</span> +12% สัปดาห์นี้
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card-surface p-3 shadow-sm d-flex align-items-center gap-3 h-100" style="border: 1px solid #BBF7D0;">
                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center flex-shrink-0 border" style="width: 48px; height: 48px; color: #15803D;">
                    <span class="material-symbols-outlined fs-3">verified_user</span>
                </div>
                <div class="d-flex flex-column justify-content-center flex-grow-1 min-w-0">
                    <span class="text-secondary text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.04em;">Active Directory</span>
                    <div class="fs-5 fw-bold text-dark my-0.5 text-truncate">BUU LDAP</div>
                    <div class="small fw-semibold d-inline-flex align-items-center gap-1 text-truncate" style="font-size: 0.8rem; color: #15803D;">
                        <span class="material-symbols-outlined fs-6">check_circle</span> ซิงค์เรียบร้อย
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card-surface p-3 shadow-sm d-flex align-items-center gap-3 h-100" style="border: 1px solid #BBF7D0;">
                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center flex-shrink-0 border" style="width: 48px; height: 48px; color: #15803D;">
                    <span class="material-symbols-outlined fs-3">database</span>
                </div>
                <div class="d-flex flex-column justify-content-center flex-grow-1 min-w-0">
                    <span class="text-secondary text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.04em;">Database Matrix</span>
                    <div class="fs-5 fw-bold text-dark my-0.5 text-truncate">MySQL 8.4</div>
                    <div class="small text-muted text-truncate" style="font-size: 0.8rem;">
                        InnoDB utf8mb4
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card-surface p-3 shadow-sm d-flex align-items-center gap-3 h-100" style="border: 1px solid #BBF7D0;">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #DCFCE7; color: #15803D;">
                    <span class="material-symbols-outlined fs-3">history_edu</span>
                </div>
                <div class="d-flex flex-column justify-content-center flex-grow-1 min-w-0">
                    <span class="text-secondary text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.04em;">Audit Trail</span>
                    <div class="fs-5 fw-bold text-dark my-0.5 text-truncate">5 Stamps</div>
                    <div class="small fw-semibold d-inline-flex align-items-center gap-1 text-truncate" style="font-size: 0.8rem; color: #15803D;">
                        <span class="material-symbols-outlined fs-6">shield</span> มาตรฐานความปลอดภัย
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5: WebAuthn / Passkey Biometrics Bar -->
    <section class="card-surface p-4 shadow-sm" style="border: 1px solid #BBF7D0;">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-start gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 44px; height: 44px; background-color: #DCFCE7; color: #15803D;">
                    <span class="material-symbols-outlined fs-4">fingerprint</span>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <h3 class="h6 fw-bold text-dark mb-0">ระบบยืนยันตัวตนชีวมิติ (WebAuthn / Passkey Biometrics)</h3>
                        <span class="badge text-dark d-none d-sm-inline-flex align-items-center gap-1" style="background-color: #DCFCE7; border: 1px solid #84CC16;">
                            <span class="material-symbols-outlined fs-6">check</span> รองรับ Touch ID / Windows Hello
                        </span>
                    </div>
                    <p class="text-secondary small mt-1 mb-0">
                        เข้าสู่ระบบด้วยลายนิ้วมือ Touch ID / Windows Hello แบบไร้รหัสผ่าน (Passwordless) ตามมาตรฐาน W3C WebAuthn &amp; FIDO2
                    </p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 w-100 w-md-auto justify-content-end">
                <button class="btn btn-light border" id="btn-refresh-passkeys" onclick="location.reload()" title="รีเฟรช" type="button">
                    <span class="material-symbols-outlined fs-5">refresh</span>
                </button>
                <button class="btn btn-forest-primary d-inline-flex align-items-center gap-2 fw-semibold shadow-sm" id="btn-register-passkey-device" onclick="registerWebauthnBiometric()" type="button">
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

    <!-- Section 6: Dual Grid: Chart.js Line Chart & Form UI Elements -->
    <section class="row g-3">
        <!-- Interactive Chart Visualization -->
        <div class="col-lg-7">
            <div class="card-surface p-4 shadow-sm h-100 d-flex flex-column justify-content-between" style="border: 1px solid #BBF7D0;">
                <div>
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom border-success-subtle">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-5" style="color: #15803D;">insights</span>
                            <h3 class="h6 fw-bold text-dark mb-0">สถิติการใช้งานระบบ (Chart.js Interactive Demo)</h3>
                        </div>
                        <span class="badge" style="background-color: #DCFCE7; color: #14532D; border: 1px solid #84CC16;">Realtime</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 text-secondary small mb-3">
                        <span class="d-inline-flex align-items-center gap-1">
                            <span class="rounded d-inline-block" style="width: 12px; height: 12px; background-color: #15803D;"></span>
                            การเข้าใช้งานระบบรายวัน (Logins)
                        </span>
                        <span class="text-muted">อัปเดตอัตโนมัติทุก 60 วินาที</span>
                    </div>
                    <div class="position-relative" style="height: 240px;">
                        <canvas id="forestMossChart"></canvas>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 small text-muted border-top border-success-subtle mt-3">
                    <span>บันทึกทราฟฟิกข้อมูลคลัสเตอร์ BUU-BOTANICAL-CLUSTER-02</span>
                    <span class="fw-bold" style="color: #15803D;">ค่าเฉลี่ย 384 ครั้ง/วัน</span>
                </div>
            </div>
        </div>
        <!-- Form UI Elements -->
        <div class="col-lg-5">
            <div class="card-surface p-4 shadow-sm h-100 d-flex flex-column justify-content-between" style="border: 1px solid #BBF7D0;">
                <div>
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom border-success-subtle">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-5" style="color: #15803D;">tune</span>
                            <h3 class="h6 fw-bold text-dark mb-0">ส่วนประกอบฟอร์ม (Form UI Elements)</h3>
                        </div>
                        <span class="badge bg-light text-secondary border">Interactive</span>
                    </div>
                    <form class="d-flex flex-column gap-3" onsubmit="event.preventDefault()">
                        <!-- Select2 Searchable Dropdown -->
                        <div>
                            <label class="form-label small fw-bold text-dark mb-1" for="facultySelect">สังกัด / คณะ (Select2 Searchable Dropdown):</label>
                            <select id="facultySelect" class="form-select select2-demo bg-light border w-100">
                                <option value="">---เลือก---</option>
                                <option selected="" value="1">คณะวิทยาการสารสนเทศ (Informatics)</option>
                                <option value="2">คณะวิศวกรรมศาสตร์</option>
                                <option value="3">คณะวิทยาศาสตร์และนวัตกรรม</option>
                                <option value="4">วิทยาลัยการบริหารรัฐกิจ</option>
                            </select>
                            <div class="form-text small text-muted">ค้นหาตัวเลือกได้ทันที พร้อม Placeholder มาตรฐาน ---เลือก---</div>
                        </div>
                        <!-- jQuery UI Datepicker พ.ศ. -->
                        <div>
                            <label class="form-label small fw-bold text-dark mb-1" for="projectStartDate">วันที่เริ่มต้นโครงการ (jQuery UI Datepicker พ.ศ.):</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted">
                                    <span class="material-symbols-outlined fs-6" style="color: #15803D;">calendar_month</span>
                                </span>
                                <input id="projectStartDate" class="form-control bg-light datepicker-th" placeholder="วว/ดด/ปปปป (พ.ศ.)" type="text" value="24/10/2569"/>
                            </div>
                            <div class="form-text small text-muted">ปฏิทินไทยปี พ.ศ. (+543) พร้อมปุ่ม “ล้างค่า” ตามมาตรฐาน MA BUCC</div>
                        </div>
                        <!-- AutoNumeric Masking -->
                        <div>
                            <label class="form-label small fw-bold text-dark mb-1" for="budgetInput">งบประมาณโครงการ (AutoNumeric Masking):</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold text-secondary">THB</span>
                                <input id="budgetInput" class="form-control bg-light text-end fw-bold autonumeric-currency" type="text" value="1850000.00"/>
                            </div>
                            <div class="form-text small text-muted">จัดรูปแบบอัตราแลกเปลี่ยนและคั่นหลักพันอัตโนมัติขณะพิมพ์</div>
                        </div>
                    </form>
                </div>
                <div class="pt-3 d-flex justify-content-end gap-2 border-top border-success-subtle mt-3">
                    <button class="btn btn-sm btn-light border fw-semibold" type="button" onclick="document.getElementById('budgetInput').value = '100000.00';">รีเซ็ตค่าฟอร์ม</button>
                    <button class="btn btn-sm btn-forest-primary fw-semibold shadow-sm" type="button" onclick="alert('บันทึกข้อมูลเรียบร้อยแล้ว')">บันทึกฟอร์มทดสอบ</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 7: DataTables Bootstrap 5 & Dropzone Upload -->
    <section class="row g-3">
        <!-- DataGrid (DataTables Bootstrap 5) -->
        <div class="col-lg-8">
            <div class="card-surface p-4 shadow-sm h-100 d-flex flex-column justify-content-between" style="border: 1px solid #BBF7D0;">
                <div>
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom border-success-subtle">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-5" style="color: #15803D;">table_chart</span>
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
                    <!-- Bootstrap Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color: #F0FDF4;">
                                <tr class="small text-secondary">
                                    <th scope="col">
                                        <span class="d-inline-flex align-items-center gap-1 cursor-pointer" style="color: #14532D;">
                                            #รหัส <i class="bi bi-caret-up-fill" style="font-size: 10px;"></i>
                                        </span>
                                    </th>
                                    <th scope="col" style="color: #14532D;">ชื่อโมดูล / ระบบงาน</th>
                                    <th scope="col" style="color: #14532D;">ผู้รับผิดชอบ</th>
                                    <th class="text-center" scope="col" style="color: #14532D;">วันที่ (พ.ศ.)</th>
                                    <th class="text-center" scope="col" style="color: #14532D;">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <tr>
                                    <td class="fw-bold" style="color: #15803D;">#MD-01</td>
                                    <td>Active Directory &amp; LDAP Service</td>
                                    <td>
                                        <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                            <span class="material-symbols-outlined fs-6" style="color: #15803D;">person</span> System Admin
                                        </span>
                                    </td>
                                    <td class="text-center text-muted">15/10/2569</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill px-2.5 py-1" style="background-color: #DCFCE7; color: #14532D; border: 1px solid #BBF7D0;">พร้อมใช้งาน</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="color: #15803D;">#MD-02</td>
                                    <td>Role &amp; Permission Access Control</td>
                                    <td>
                                        <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                            <span class="material-symbols-outlined fs-6" style="color: #15803D;">security</span> Security Auditor
                                        </span>
                                    </td>
                                    <td class="text-center text-muted">14/10/2569</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill px-2.5 py-1" style="background-color: #DCFCE7; color: #14532D; border: 1px solid #BBF7D0;">พร้อมใช้งาน</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="color: #15803D;">#MD-03</td>
                                    <td>5 Audit Stamps Pipeline Monitor</td>
                                    <td>
                                        <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                            <span class="material-symbols-outlined fs-6 text-secondary">storage</span> DBA Architect
                                        </span>
                                    </td>
                                    <td class="text-center text-muted">12/10/2569</td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1">กำลังประมวลผล</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="color: #15803D;">#MD-04</td>
                                    <td>Media Vault &amp; Dropzone Uploader</td>
                                    <td>
                                        <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                            <span class="material-symbols-outlined fs-6 text-secondary">cloud_sync</span> DevOps Lead
                                        </span>
                                    </td>
                                    <td class="text-center text-muted">10/10/2569</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-secondary border rounded-pill px-2.5 py-1">รอตรวจสอบ</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold" style="color: #15803D;">#MD-05</td>
                                    <td>Export Engine &amp; ZIP Stream Archiver</td>
                                    <td>
                                        <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                            <span class="material-symbols-outlined fs-6" style="color: #15803D;">code</span> Backend Engineer
                                        </span>
                                    </td>
                                    <td class="text-center text-muted">08/10/2569</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill px-2.5 py-1" style="background-color: #DCFCE7; color: #14532D; border: 1px solid #BBF7D0;">พร้อมใช้งาน</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Table Pagination -->
                <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between pt-3 border-top border-success-subtle mt-3 small text-muted">
                    <span>แสดง 1 ถึง 5 จากทั้งหมด 5 รายการ</span>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">ก่อนหน้า</a></li>
                            <li class="page-item active"><a class="page-link text-white" style="background-color: #15803D; border-color: #15803D;" href="#">1</a></li>
                            <li class="page-item disabled"><a class="page-link text-secondary" href="#">ถัดไป</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Dropzone Upload Container -->
        <div class="col-lg-4">
            <div class="card-surface p-4 shadow-sm h-100 d-flex flex-column justify-content-between" style="border: 1px solid #BBF7D0;">
                <div>
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom border-success-subtle">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-5" style="color: #15803D;">cloud_upload</span>
                            <h3 class="h6 fw-bold text-dark mb-0">ระบบอัปโหลดไฟล์ (Dropzone)</h3>
                        </div>
                        <span class="badge bg-light text-secondary border">Upload Vault</span>
                    </div>
                    <!-- Dropzone Canvas -->
                    <div class="p-4 rounded-3 text-center border border-2 border-dashed border-success-subtle cursor-pointer" id="dropzone-box" style="cursor: pointer; background-color: #F0FDF4;">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px; background-color: #DCFCE7; color: #15803D;">
                            <span class="material-symbols-outlined fs-2">upload_file</span>
                        </div>
                        <h4 class="h6 fw-bold text-dark mb-1">ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเลือกไฟล์</h4>
                        <p class="text-muted small mb-3">
                            รองรับไฟล์เอกสาร PDF, PNG, JPG, DOCX (จำลองการทดสอบ Client-side Encrypted)
                        </p>
                        <span class="badge bg-white border shadow-sm px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1" style="color: #15803D; border-color: #BBF7D0 !important;">
                            <span class="material-symbols-outlined fs-6">verified</span>
                            <span>Client AES-256 Validated</span>
                        </span>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 border-top border-success-subtle mt-3 small text-muted">
                    <span class="d-inline-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-6">lock</span> Max upload: 10MB
                    </span>
                    <span class="fw-semibold" style="color: #15803D;">AutoPreview Enabled</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 8: Component Showcase (Buttons, Icons) -->
    <section class="row g-3">
        <!-- Button Styles & Actions Showcase -->
        <div class="col-md-6">
            <div class="card-surface p-4 shadow-sm h-100 d-flex flex-column gap-3" style="border: 1px solid #BBF7D0;">
                <div class="d-flex align-items-center justify-content-between pb-2 border-bottom border-success-subtle">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-5" style="color: #15803D;">smart_button</span>
                        <h3 class="h6 fw-bold text-dark mb-0">ชุดปุ่มและสถานะการโต้ตอบ (Button Styles &amp; Actions)</h3>
                    </div>
                    <span class="badge bg-light text-secondary border">Actions</span>
                </div>
                <!-- Solid Variants -->
                <div>
                    <label class="form-label small text-secondary fw-semibold mb-2">1. ปุ่มสีหลักความเข้ม (Solid Variants):</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-forest-primary btn-sm d-inline-flex align-items-center gap-1 fw-semibold shadow-sm">
                            <span class="material-symbols-outlined fs-6">done</span> Primary Action
                        </button>
                        <button class="btn btn-forest-subtle btn-sm d-inline-flex align-items-center gap-1 fw-semibold">
                            <span class="material-symbols-outlined fs-6">tune</span> Secondary Action
                        </button>
                        <button class="btn btn-forest-primary btn-sm d-inline-flex align-items-center gap-1 fw-semibold">
                            <span class="material-symbols-outlined fs-6">verified</span> Success
                        </button>
                        <button class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1 fw-semibold">
                            <span class="material-symbols-outlined fs-6">error</span> Danger
                        </button>
                        <button class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1 fw-semibold">
                            <span class="material-symbols-outlined fs-6">delete</span> Outline Danger
                        </button>
                        <button class="btn btn-warning btn-sm d-inline-flex align-items-center gap-1 fw-semibold text-dark">
                            <span class="material-symbols-outlined fs-6">warning</span> Warning
                        </button>
                        <button class="btn btn-secondary btn-sm fw-semibold">Muted Neutral</button>
                    </div>
                </div>
                <!-- Soft Subtle & Sizes -->
                <div>
                    <label class="form-label small text-secondary fw-semibold mb-2">2. ปุ่มแบบนวลและขนาด (Soft Subtle &amp; Sizes):</label>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button class="btn btn-sm" style="background-color: #DCFCE7; color: #14532D; font-weight: 600;">Small Soft</button>
                        <button class="btn" style="background-color: #DCFCE7; color: #14532D; font-weight: 600;">Regular Subtle</button>
                        <button class="btn btn-lg fs-6 shadow-sm" style="background-color: #DCFCE7; color: #14532D; font-weight: 600;">+ Large Subtle</button>
                        <button class="btn btn-sm fw-semibold text-danger" style="background-color: #FEE2E2;">Danger Soft</button>
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
                        <button class="btn btn-sm btn-light border text-dark position-relative fw-semibold d-inline-flex align-items-center gap-1" type="button">
                            <span class="material-symbols-outlined fs-6">notifications</span> Alerts
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                                5+
                            </span>
                        </button>
                        <button class="btn btn-sm btn-forest-primary fw-semibold d-inline-flex align-items-center gap-2" type="button">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                            <span>กำลังประมวลผล...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Icon Set (Bootstrap Icons & Material Symbols) -->
        <div class="col-md-6">
            <div class="card-surface p-4 shadow-sm h-100 d-flex flex-column gap-3" style="border: 1px solid #BBF7D0;">
                <div class="d-flex align-items-center justify-content-between pb-2 border-bottom border-success-subtle">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-5" style="color: #15803D;">category</span>
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
                            <span class="material-symbols-outlined fs-3" style="color: #15803D;">speed</span>
                            <span class="small fw-semibold text-dark mt-1">Dashboard</span>
                            <span class="text-muted" style="font-size: 10px;">speedometer</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: #15803D;">shield</span>
                            <span class="small fw-semibold text-dark mt-1">Security</span>
                            <span class="text-muted" style="font-size: 10px;">shield-lock</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: #15803D;">fingerprint</span>
                            <span class="small fw-semibold text-dark mt-1">Biometrics</span>
                            <span class="text-muted" style="font-size: 10px;">passkey</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: #15803D;">database</span>
                            <span class="small fw-semibold text-dark mt-1">Database</span>
                            <span class="text-muted" style="font-size: 10px;">mysql</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: #15803D;">lan</span>
                            <span class="small fw-semibold text-dark mt-1">Directory</span>
                            <span class="text-muted" style="font-size: 10px;">ldap</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: #15803D;">cloud_upload</span>
                            <span class="small fw-semibold text-dark mt-1">Dropzone</span>
                            <span class="text-muted" style="font-size: 10px;">upload-vault</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: #15803D;">eco</span>
                            <span class="small fw-semibold text-dark mt-1">Botanical</span>
                            <span class="text-muted" style="font-size: 10px;">forest-moss</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: #15803D;">lock</span>
                            <span class="small fw-semibold text-dark mt-1">Vault</span>
                            <span class="text-muted" style="font-size: 10px;">tls-fips</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 9: Audit Stamps Footer -->
    <div class="d-flex flex-wrap align-items-center justify-content-between pt-2 border-top border-success-subtle text-muted" style="font-size: 11px;">
        <div class="d-flex flex-wrap align-items-center gap-3">
            <span><strong>created_by:</strong> pantakarn</span>
            <span><strong>created_at:</strong> {{ date('Y-m-d H:i:s') }}</span>
            <span><strong>updated_by:</strong> pantakarn</span>
            <span><strong>updated_at:</strong> {{ date('Y-m-d H:i:s') }}</span>
            <span><strong>request_uri:</strong> {{ request()->getRequestUri() }}</span>
        </div>
        <div class="fw-semibold" style="color: #15803D;">
            Forest Moss &amp; Sage Theme &bull; ArtisanCraft Scaffolding
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Chart.js Initialization
        const ctx = document.getElementById('forestMossChart');
        if (ctx && typeof Chart !== 'undefined') {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์'],
                    datasets: [{
                        label: 'การเข้าใช้งานระบบ (Logins)',
                        data: [140, 210, 320, 490, 530, 260, 190],
                        borderColor: '#15803D',
                        backgroundColor: 'rgba(21, 128, 61, 0.12)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#FFFFFF',
                        pointBorderColor: '#15803D',
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
                            backgroundColor: '#052E16',
                            titleColor: '#FFFFFF',
                            bodyColor: '#FFFFFF',
                            padding: 10,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#14532D', font: { family: 'Plus Jakarta Sans, Sarabun' } }
                        },
                        y: {
                            grid: { color: 'rgba(187, 247, 208, 0.4)' },
                            ticks: { color: '#14532D', font: { family: 'Plus Jakarta Sans, Sarabun' } },
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
                        title: 'Forest Moss & Sage Alert',
                        text: 'ระบบโมดัลมาตรฐาน Forge Artisan Engine พร้อมใช้งาน 100%',
                        icon: 'success',
                        confirmButtonText: 'รับทราบ',
                        confirmButtonColor: '#15803D'
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
                confirmButtonColor: '#15803D',
                cancelButtonColor: '#14532D',
                confirmButtonText: 'ลงทะเบียนทันที',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'สำเร็จ!',
                        text: 'ลงทะเบียนกุญแจ Passkey สำหรับโหมดพรีวิว Forest Moss & Sage เรียบร้อยแล้ว',
                        icon: 'success',
                        confirmButtonColor: '#15803D'
                    });
                }
            });
        } else {
            alert('ลงทะเบียนกุญแจ Passkey เรียบร้อยแล้ว');
        }
    }
</script>
@endpush