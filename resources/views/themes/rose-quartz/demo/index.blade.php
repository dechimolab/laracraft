@extends(view()->exists('layouts.app') ? 'layouts.app' : 'themes.rose-quartz.layouts.app')

@section('content')
<div class="rq-theme-wrapper d-flex flex-column gap-4">

    <!-- Section 1: Welcome Header & Engine Status Bar -->
    <section class="rq-card p-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="badge rq-badge-rose px-2 py-1">
                        <i class="bi bi-gem me-1"></i>ATELIER SCENE
                    </span>
                    <span class="badge bg-light text-secondary border px-2 py-1">Laravel 13.x</span>
                    <span class="badge bg-light text-secondary border px-2 py-1">PHP 8.4 JIT</span>
                    <span class="badge bg-light text-secondary border px-2 py-1">Bootstrap 5.3.3</span>
                    <span class="badge bg-light text-secondary border px-2 py-1">WCAG AA 11.9:1</span>
                </div>
                <h1 class="h4 mb-1 fw-bold" style="color: #400014;">
                    ยินดีต้อนรับสู่ <span style="color: var(--rq-ruby, #BE123C);">{{ $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'Artisan POS & Inventory Hub') }}</span>
                </h1>
                <p class="text-secondary small mb-0">
                    ระบบบริหารจัดการและหน่วยควบคุมต้นแบบ Rose Quartz &amp; Velvet พร้อมส่วนประกอบ UI และระบบรักษาความปลอดภัยครบวงจร Fiduciary Precision Standard
                </p>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <button class="btn rq-btn-ruby btn-sm px-3 py-2 rounded-3 shadow-sm d-inline-flex align-items-center gap-2" id="btn-passkey-register" onclick="registerWebauthnBiometric()" type="button">
                    <i class="bi bi-fingerprint fs-6"></i>
                    <span>บันทึกลายนิ้วมือใหม่ (Passkey)</span>
                </button>
                <button class="btn rq-btn-outline-ruby btn-sm px-3 py-2 rounded-3 d-inline-flex align-items-center gap-2" id="btn-swal-demo" type="button">
                    <i class="bi bi-bell-fill"></i>
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
                'desc' => 'ระบบยืนยันตัวตนกลาง ม.บูรพา & จัดการบทบาทผู้ใช้งาน (UMS Identity Provider Hub)',
                'icon' => 'bi-shield-check',
                'route' => Route::has('demo.ums') ? route('demo.ums') : (Route::has('switch.group') ? route('switch.group') : '#'),
                'btnText' => 'เข้าสู่ระบบ / สลับสิทธิ์ UMS',
            ],
            'buu_ldap' => [
                'title' => 'BUU LDAP & Passkey',
                'badge' => 'Active',
                'desc' => 'เชื่อมโยงบัญชี Active Directory และกุญแจความปลอดภัยชีวมิติ FIDO2 Passkey',
                'icon' => 'bi-diagram-3-fill',
                'route' => Route::has('demo.ldap') ? route('demo.ldap') : '#',
                'btnText' => 'เปิดหน้าทดสอบ LDAP',
            ],
            'user_role' => [
                'title' => 'Role & Permissions (RBAC)',
                'badge' => 'Active',
                'desc' => 'กำหนดสิทธิ์ระดับกลุ่มและเมนูการใช้งานตามโครงสร้างองค์กรอย่างแม่นยำ',
                'icon' => 'bi-person-gear',
                'route' => Route::has('demo.roles') ? route('demo.roles') : (Route::has('switch.group') ? route('switch.group') : '#'),
                'btnText' => 'จัดการสิทธิ์ผู้ใช้งาน',
            ],
            'audit_trail' => [
                'title' => 'Audit Trail & Activity Log',
                'badge' => 'Active',
                'desc' => 'บันทึกประวัติการเปลี่ยนแปลงข้อมูลของ Eloquent Model ทุกตัวอัตโนมัติ พร้อม IP และ JSON Diff',
                'icon' => 'bi-clock-history',
                'route' => Route::has('demo.audit') ? route('demo.audit') : '#',
                'btnText' => 'ตรวจสอบ Audit Trail',
            ],
            'notifications' => [
                'title' => 'Multi-Channel Notifications',
                'badge' => 'Active',
                'desc' => 'ระบบแจ้งเตือนแบบเรียลไทม์ผ่าน Webhook, อีเมล และบันทึกข้อความภายในระบบ',
                'icon' => 'bi-bell-fill',
                'route' => Route::has('notifications.index') ? route('notifications.index') : '#',
                'btnText' => 'ทดสอบการส่งแจ้งเตือน',
            ],
            'media_storage' => [
                'title' => 'Media Storage & Vault',
                'badge' => 'Active',
                'desc' => 'จัดเก็บและเข้ารหัสไฟล์อย่างปลอดภัย พร้อมการทำสตรีมมิ่งและย่อภาพอัตโนมัติ',
                'icon' => 'bi-cloud-arrow-up-fill',
                'route' => '#media-vault',
                'btnText' => 'เปิดดูคลังไฟล์',
            ],
            'system_settings' => [
                'title' => 'System Settings Matrix',
                'badge' => 'Active',
                'desc' => 'บริหารจัดการพารามิเตอร์การทำงาน ค่าตัวแปรระบบ และ Environment รันไทม์',
                'icon' => 'bi-sliders',
                'route' => '#system-settings',
                'btnText' => 'ตั้งค่าระบบ',
            ],
        ];
    @endphp

    <section>
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-box-fill text-danger"></i>
                <span class="fw-bold small text-uppercase" style="letter-spacing: 0.05em; color: #881337;">
                    โมดูลสำเร็จประจําโปรเจกต์ (Enterprise Pre-built Modules Demo Hub)
                </span>
            </div>
            <span class="badge bg-white text-secondary border rounded-pill px-2.5 py-1 small">STEP 3 MODULES</span>
        </div>
        <div class="row g-3">
            @foreach($selectedModules as $modKey => $val)
                @if(isset($moduleDefs[$modKey]))
                    @php $mod = $moduleDefs[$modKey]; @endphp
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="subtle-module-card h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1 small d-flex align-items-center gap-1">
                                        <span class="spinner-grow spinner-grow-sm" role="status" style="width: 6px; height: 6px;"></span> {{ $mod['badge'] }}
                                    </span>
                                    <code class="small text-muted" style="font-size: 0.75rem;">{{ $modKey }}</code>
                                </div>
                                <h5 class="fw-bold mb-1" style="color: #881337;">{{ $mod['title'] }}</h5>
                                <p class="small text-secondary mb-3">{{ $mod['desc'] }}</p>
                            </div>
                            <a class="btn rq-btn-rose-subtle btn-sm w-100 rounded-3 py-2 d-flex align-items-center justify-content-center gap-2 text-decoration-none" href="{{ $mod['route'] }}">
                                <i class="bi {{ $mod['icon'] }}"></i>
                                <span>{{ $mod['btnText'] }}</span>
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    <!-- Section 3: Telemetry, Speed & Live Control Strip -->
    <section class="rq-card p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between pb-3 mb-3 border-bottom border-danger-subtle">
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold text-dark">{{ config('app.name', 'Artisan POS & Inventory Hub') }}</span>
                <span class="badge bg-light text-secondary border font-monospace small">SYS-CORE-ONLINE</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="spinner-grow spinner-grow-sm text-danger" role="status" style="width: 8px; height: 8px;"></span>
                <span class="badge rq-badge-rose"><i class="bi bi-check-circle me-1"></i>ONLINE • UPTIME 99.98%</span>
            </div>
        </div>
        <div class="row g-4 align-items-center">
            <!-- Metric 1: System Velocity -->
            <div class="col-12 col-lg-3 border-end-lg border-danger-subtle">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-secondary small fw-bold text-uppercase">SYSTEM VELOCITY</span>
                    <i class="bi bi-arrow-up-right text-muted small"></i>
                </div>
                <div class="h3 fw-bold mb-1" style="color: #BE123C;">$492.30 <span class="small fs-6 text-muted fw-normal">AOV</span></div>
                <div class="small text-success fw-bold d-flex align-items-center gap-1">
                    <i class="bi bi-graph-up-arrow"></i> +14.8% growth vs last period
                </div>
            </div>
            <!-- Metric 2: Active Telemetry Sparkline -->
            <div class="col-12 col-lg-4 border-end-lg border-danger-subtle">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-secondary small fw-bold text-uppercase">ACTIVE TELEMETRY</span>
                    <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-0" style="font-size: 0.65rem;">REAL-TIME</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="flex-grow-1">
                        <svg class="w-100" style="height: 38px;" viewBox="0 0 160 40">
                            <defs>
                                <linearGradient id="roseSpark" x1="0" x2="0" y1="0" y2="1">
                                    <stop offset="0%" stop-color="#BE123C" stop-opacity="0.35"></stop>
                                    <stop offset="100%" stop-color="#BE123C" stop-opacity="0"></stop>
                                </linearGradient>
                            </defs>
                            <path d="M 0 32 Q 30 35, 60 25 T 100 12 T 130 20 T 160 8 L 160 40 L 0 40 Z" fill="url(#roseSpark)"></path>
                            <path d="M 0 32 Q 30 35, 60 25 T 100 12 T 130 20 T 160 8" fill="none" stroke="#BE123C" stroke-linecap="round" stroke-width="2.5"></path>
                        </svg>
                    </div>
                    <div class="text-end">
                        <div class="small fw-bold text-dark">Zero Bottlenecks</div>
                        <div class="text-muted small" style="font-size: 0.72rem;">0.14ms Latency</div>
                    </div>
                </div>
            </div>
            <!-- Metric 3: Quick Form Action Prepend -->
            <div class="col-12 col-lg-5">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="text-secondary small fw-bold text-uppercase">SAMPLE FORM CONTROL</span>
                    <span class="text-muted small" style="font-size: 0.7rem;">Input Prepend</span>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border"><i class="bi bi-person"></i></span>
                    <input class="form-control" readonly type="text" value="pantakarn@buu.ac.th"/>
                    <button class="btn rq-btn-ruby px-3" type="button" onclick="alert('Primary Action Triggered')">Primary Action</button>
                    <button class="btn btn-outline-secondary" type="button" onclick="alert('Secondary Action Triggered')">Secondary</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Four Key Stat Metrics -->
    <section class="row g-3">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="rq-card p-3 d-flex align-items-center gap-3">
                <div class="rq-icon-circle"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="text-muted small fw-semibold">ผู้ใช้งานในระบบ</div>
                    <div class="h5 fw-bold mb-0 text-dark">1,248 คน</div>
                    <div class="text-success small fw-medium" style="font-size: 0.75rem;"><i class="bi bi-arrow-up-short"></i>+12% สัปดาห์นี้</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="rq-card p-3 d-flex align-items-center gap-3">
                <div class="rq-icon-circle"><i class="bi bi-shield-check"></i></div>
                <div>
                    <div class="text-muted small fw-semibold">ACTIVE DIRECTORY</div>
                    <div class="h5 fw-bold mb-0 text-dark">BUU LDAP</div>
                    <div class="text-success small fw-medium" style="font-size: 0.75rem;"><i class="bi bi-check2"></i> ซิงค์เรียบร้อย</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="rq-card p-3 d-flex align-items-center gap-3">
                <div class="rq-icon-circle"><i class="bi bi-database-fill"></i></div>
                <div>
                    <div class="text-muted small fw-semibold">DATABASE MATRIX</div>
                    <div class="h5 fw-bold mb-0 text-dark">MySQL 8.4</div>
                    <div class="text-muted small fw-medium" style="font-size: 0.75rem;"><i class="bi bi-hdd-stack"></i> InnoDB utf8mb4</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="rq-card p-3 d-flex align-items-center gap-3">
                <div class="rq-icon-circle"><i class="bi bi-award-fill"></i></div>
                <div>
                    <div class="text-muted small fw-semibold">AUDIT TRAIL</div>
                    <div class="h5 fw-bold mb-0 text-dark">5 Stamps</div>
                    <div class="text-muted small fw-medium" style="font-size: 0.75rem;"><i class="bi bi-shield-lock"></i> มาตรฐานความปลอดภัย</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5: WebAuthn / Passkey Biometrics Bar -->
    <section class="rq-card p-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-3 border-bottom border-danger-subtle">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2 rounded-circle" style="background-color: #FFF1F2; color: #BE123C;">
                    <i class="bi bi-fingerprint fs-3"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h5 class="mb-0 fw-bold text-dark">ระบบยืนยันตัวตนชีวมิติ (WebAuthn / Passkey Biometrics)</h5>
                        <span class="badge rq-badge-rose"><i class="bi bi-check2-circle me-1"></i>รองรับ Touch ID / Windows Hello</span>
                    </div>
                    <p class="small text-secondary mb-0">เข้าสู่ระบบด้วยลายนิ้วมือ Touch ID / Windows Hello แบบไร้รหัสผ่าน (Passwordless) ตามมาตรฐาน W3C WebAuthn &amp; FIDO2</p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-light border btn-sm text-secondary rounded-3" onclick="location.reload()" title="รีเฟรชข้อมูล"><i class="bi bi-arrow-clockwise"></i></button>
                <button class="btn rq-btn-ruby btn-sm px-3 py-2 rounded-3 d-inline-flex align-items-center gap-2" onclick="registerWebauthnBiometric()">
                    <i class="bi bi-key-fill"></i>
                    <span>บันทึกลายนิ้วมือเครื่องนี้</span>
                </button>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between pt-3">
            <div class="d-flex align-items-center gap-2 small text-secondary">
                <i class="bi bi-laptop"></i>
                <span><strong>รายการอุปกรณ์และ Passkey ที่บันทึกไว้ในบัญชีของคุณ:</strong> ยังไม่มีการลงทะเบียนอุปกรณ์ลายนิ้วมือ คลิกปุ่ม "บันทึกลายนิ้วมือเครื่องนี้" ด้านบนเพื่อเริ่มใช้งาน</span>
            </div>
            <span class="badge bg-light text-secondary border">0 รายการ</span>
        </div>
    </section>

    <!-- Section 6: Middle Dual Column Grid (Chart & Form Elements) -->
    <section class="row g-3">
        <!-- Left: Chart.js Interactive Line Chart -->
        <div class="col-12 col-lg-7">
            <div class="rq-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-activity text-danger"></i>
                            <h5 class="fw-bold mb-0 text-dark">สถิติการใช้งานระบบ (Chart.js Interactive Demo)</h5>
                        </div>
                        <span class="badge rq-badge-rose">Realtime</span>
                    </div>
                    <div class="small text-muted mb-3 d-flex align-items-center gap-2">
                        <span class="spinner-grow spinner-grow-sm text-danger" style="width: 6px; height: 6px;"></span>
                        <span>การเข้าใช้งานระบบรายวัน (Logins) อัปเดตอัตโนมัติทุก 60 วินาที</span>
                    </div>
                    <div class="position-relative" style="height: 240px;">
                        <canvas id="roseQuartzChart"></canvas>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top border-danger-subtle small text-muted mt-3">
                    <span>บันทึกกราฟิกข้อมูลคลัสเตอร์ BUU-FIN-CLUSTER-04</span>
                    <span class="fw-bold" style="color: #BE123C;">ค่าเฉลี่ย 384 ครั้ง/วัน</span>
                </div>
            </div>
        </div>

        <!-- Right: Form UI Elements Showcase -->
        <div class="col-12 col-lg-5">
            <div class="rq-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-ui-checks-grid text-danger"></i>
                            <h5 class="fw-bold mb-0 text-dark">ส่วนประกอบฟอร์ม (Form UI Elements)</h5>
                        </div>
                        <span class="badge rq-badge-rose">Interactive</span>
                    </div>
                    <!-- Select2 Searchable Dropdown with standard empty placeholder -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary mb-1">สังกัด / คณะ (Select2 Searchable Dropdown):</label>
                        <select class="form-select select2-demo" id="facultySelect" style="width: 100%;">
                            <option value="">---เลือก---</option>
                            <option value="1" selected>คณะวิทยาการสารสนเทศ (Informatics)</option>
                            <option value="2">คณะมนุษยศาสตร์และสังคมศาสตร์</option>
                            <option value="3">คณะวิทยาศาสตร์และนวัตกรรม</option>
                            <option value="4">วิทยาลัยการบริหารรัฐกิจ</option>
                        </select>
                        <div class="text-muted small mt-1" style="font-size: 0.72rem;">ค้นหาตัวเลือกได้ทันที พร้อม Placeholder มาตรฐาน ---เลือก---</div>
                    </div>
                    <!-- Datepicker Thai Calendar -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary mb-1">วันที่เริ่มต้นโครงการ (jQuery UI Datepicker พ.ศ.):</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-danger"><i class="bi bi-calendar3"></i></span>
                            <input class="form-control datepicker-th" id="projectStartDate" type="text" value="24/10/2569"/>
                        </div>
                        <div class="text-muted small mt-1" style="font-size: 0.72rem;">ปฏิทินไทยปี พ.ศ. (+543) พร้อมปุ่ม "ล้างค่า" ตามมาตรฐาน MA BUCC</div>
                    </div>
                    <!-- AutoNumeric Masking Input -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary mb-1">งบประมาณโครงการ (AutoNumeric Masking):</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold text-secondary">THB</span>
                            <input class="form-control text-end fw-bold autonumeric-currency" id="budgetInput" style="color: #881337;" type="text" value="1850000.00"/>
                        </div>
                        <div class="text-muted small mt-1" style="font-size: 0.72rem;">จัดรูปแบบอัตราแลกเปลี่ยนและคั่นหลักพันอัตโนมัติขณะพิมพ์</div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end gap-2 pt-2 border-top border-danger-subtle">
                    <button class="btn btn-sm btn-light border text-secondary px-3" onclick="document.getElementById('budgetInput').value = '100000.00';">รีเซ็ตค่าฟอร์ม</button>
                    <button class="btn btn-sm rq-btn-ruby px-3" onclick="alert('บันทึกข้อมูลเรียบร้อยแล้ว')">บันทึกฟอร์มทดสอบ</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 7: Data Table & Dropzone Upload Grid -->
    <section class="row g-3">
        <!-- DataTables Bootstrap 5 Showcase -->
        <div class="col-12 col-lg-8">
            <div class="rq-card p-4 h-100">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-table text-danger"></i>
                        <h5 class="fw-bold mb-0 text-dark">ตารางข้อมูลสารสนเทศ (DataTables Bootstrap 5)</h5>
                    </div>
                    <span class="badge rq-badge-rose">Data Grid</span>
                </div>
                <!-- Table Controls (Show Entries & Search) -->
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
                    <div class="d-flex align-items-center gap-2 small text-secondary">
                        <span>แสดง</span>
                        <select class="form-select form-select-sm" style="width: 70px;">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                        </select>
                        <span>รายการ</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 small">
                        <span class="text-secondary">ค้นหา:</span>
                        <input class="form-control form-control-sm" placeholder="พิมพ์เพื่อค้นหา..." style="width: 170px;" type="search"/>
                    </div>
                </div>
                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-2">
                        <thead style="background-color: #FFF1F2;">
                            <tr class="small text-uppercase text-secondary">
                                <th scope="col" style="color: #881337;">#รหัส <i class="bi bi-arrow-down-up small ms-1"></i></th>
                                <th scope="col" style="color: #881337;">ชื่อโมดูล / ระบบงาน</th>
                                <th scope="col" style="color: #881337;">ผู้รับผิดชอบ</th>
                                <th scope="col" style="color: #881337;">วันที่ (พ.ศ.)</th>
                                <th class="text-end" scope="col" style="color: #881337;">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            <tr>
                                <td class="fw-bold text-danger">#MD-01</td>
                                <td>Active Directory &amp; LDAP Service</td>
                                <td><i class="bi bi-person me-1 text-muted"></i>System Admin</td>
                                <td>15/10/2569</td>
                                <td class="text-end"><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">พร้อมใช้งาน</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-danger">#MD-02</td>
                                <td>Role &amp; Permission Access Control</td>
                                <td><i class="bi bi-shield-lock me-1 text-muted"></i>Security Auditor</td>
                                <td>14/10/2569</td>
                                <td class="text-end"><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">พร้อมใช้งาน</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-danger">#MD-03</td>
                                <td>5 Audit Stamps Pipeline Monitor</td>
                                <td><i class="bi bi-database me-1 text-muted"></i>DBA Architect</td>
                                <td>12/10/2569</td>
                                <td class="text-end"><span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill">กำลังประมวลผล</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-danger">#MD-04</td>
                                <td>Media Vault &amp; Dropzone Uploader</td>
                                <td><i class="bi bi-cloud-arrow-up me-1 text-muted"></i>DevOps Lead</td>
                                <td>10/10/2569</td>
                                <td class="text-end"><span class="badge bg-info-subtle text-info-emphasis border border-info-subtle rounded-pill">รอการตรวจสอบ</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-danger">#MD-05</td>
                                <td>Export Engine &amp; ZIP Stream Archiver</td>
                                <td><i class="bi bi-code-slash me-1 text-muted"></i>Backend Engineer</td>
                                <td>08/10/2569</td>
                                <td class="text-end"><span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">พร้อมใช้งาน</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination Footer -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 pt-2 small text-secondary">
                    <div>แสดง 1 ถึง 5 จากทั้งหมด 6 รายการ</div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">ก่อนหน้า</a></li>
                            <li class="page-item active"><a class="page-link" href="#" style="background-color: #BE123C; border-color: #BE123C;">1</a></li>
                            <li class="page-item"><a class="page-link text-secondary" href="#">2</a></li>
                            <li class="page-item"><a class="page-link text-secondary" href="#">ถัดไป</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Dropzone File Upload Vault -->
        <div class="col-12 col-lg-4">
            <div class="rq-card p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-cloud-arrow-up-fill text-danger"></i>
                            <h5 class="fw-bold mb-0 text-dark">ระบบอัปโหลดไฟล์ (Dropzone)</h5>
                        </div>
                        <span class="badge rq-badge-rose">Upload Vault</span>
                    </div>
                    <form action="#" class="dropzone rq-dropzone p-4 text-center d-flex flex-column align-items-center justify-content-center my-2 cursor-pointer" id="roseDropzone">
                        @csrf
                        <div class="dz-message needsclick m-0">
                            <div class="mb-3">
                                <div class="p-3 rounded-circle d-inline-flex" style="background-color: #FFE4E6; color: #BE123C;">
                                    <i class="bi bi-file-earmark-arrow-up fs-2"></i>
                                </div>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเลือกไฟล์</h6>
                            <p class="small text-secondary mb-3" style="font-size: 0.75rem;">รองรับไฟล์เอกสาร PDF, PNG, JPG, DOCX (จำลองการทดสอบ Client-side Encrypted)</p>
                            <span class="badge rq-badge-rose"><i class="bi bi-shield-check me-1"></i>Client AES-256 Validated</span>
                        </div>
                    </form>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-2 border-top border-danger-subtle small text-muted">
                    <span><i class="bi bi-lock-fill me-1"></i>Max upload: 10MB</span>
                    <span class="fw-semibold text-danger">AutoPreview Enabled</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 8: Button Styles, Icon Set, Inputs & Controls -->
    <section class="row g-3">
        <!-- Button Styles & Actions -->
        <div class="col-12 col-lg-6">
            <div class="rq-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-hand-index-thumb text-danger"></i>
                        <h5 class="fw-bold mb-0 text-dark">ชุดปุ่มและสถานะการโต้ตอบ (Button Styles &amp; Actions)</h5>
                    </div>
                    <span class="badge rq-badge-rose">Actions</span>
                </div>
                <!-- Solid Variants -->
                <div class="mb-3">
                    <div class="small fw-semibold text-muted mb-2">1. ปุ่มสลักความเข้ม (Solid Variants):</div>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn rq-btn-ruby btn-sm"><i class="bi bi-check2 me-1"></i>Primary Action</button>
                        <button class="btn btn-secondary btn-sm"><i class="bi bi-sliders me-1"></i>Secondary Slate</button>
                        <button class="btn btn-success btn-sm"><i class="bi bi-check-circle me-1"></i>Success</button>
                        <button class="btn btn-danger btn-sm"><i class="bi bi-exclamation-triangle me-1"></i>Danger</button>
                        <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3 me-1"></i>Outline Danger</button>
                        <button class="btn btn-warning btn-sm text-dark"><i class="bi bi-flag me-1"></i>Warning</button>
                        <button class="btn btn-light border btn-sm text-secondary">Muted Neutral</button>
                    </div>
                </div>
                <!-- Soft & Subtle Sizes -->
                <div class="mb-3">
                    <div class="small fw-semibold text-muted mb-2">2. ปุ่มแบบความนวลและขนาด (Soft Subtle &amp; Sizes):</div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button class="btn rq-btn-rose-subtle btn-sm py-1 px-2" style="font-size: 0.75rem;">Small Soft</button>
                        <button class="btn rq-btn-rose-subtle btn-sm">Regular Subtle</button>
                        <button class="btn rq-btn-rose-subtle px-3 py-2 fw-bold">+ Large Subtle</button>
                        <button class="btn btn-danger-subtle text-danger btn-sm">Danger Soft</button>
                    </div>
                </div>
                <!-- Button Groups, Badges & Spinners -->
                <div>
                    <div class="small fw-semibold text-muted mb-2">3. ปุ่มกลุ่ม, ป้ายเตือน และสถานะโหลด (Group, Badge &amp; Spinner):</div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-outline-secondary active" type="button"><i class="bi bi-grid-fill"></i> Grid</button>
                            <button class="btn btn-outline-secondary" type="button"><i class="bi bi-list"></i> List</button>
                            <button class="btn btn-outline-secondary" type="button"><i class="bi bi-table"></i> Table</button>
                        </div>
                        <button class="btn btn-sm rq-btn-rose-subtle position-relative" type="button">
                            <i class="bi bi-bell"></i> Alerts
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                                5+
                            </span>
                        </button>
                        <button class="btn rq-btn-ruby btn-sm d-flex align-items-center gap-2" disabled type="button">
                            <span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span>
                            <span>กำลังประมวลผล...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Icon Repository Matrix -->
        <div class="col-12 col-lg-6">
            <div class="rq-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-collection text-danger"></i>
                        <h5 class="fw-bold mb-0 text-dark">คลังไอคอนระบบ (Bootstrap Icons Repository)</h5>
                    </div>
                    <span class="badge rq-badge-rose">Vector Symbols</span>
                </div>
                <div class="row g-2 text-center small text-secondary">
                    <div class="col-3 col-sm-2 p-2 rounded-3 border bg-light-subtle">
                        <i class="bi bi-shield-check fs-4 text-danger d-block mb-1"></i>
                        <span class="text-truncate d-block" style="font-size: 0.65rem;">Shield</span>
                    </div>
                    <div class="col-3 col-sm-2 p-2 rounded-3 border bg-light-subtle">
                        <i class="bi bi-fingerprint fs-4 text-danger d-block mb-1"></i>
                        <span class="text-truncate d-block" style="font-size: 0.65rem;">Passkey</span>
                    </div>
                    <div class="col-3 col-sm-2 p-2 rounded-3 border bg-light-subtle">
                        <i class="bi bi-database-check fs-4 text-danger d-block mb-1"></i>
                        <span class="text-truncate d-block" style="font-size: 0.65rem;">MySQL</span>
                    </div>
                    <div class="col-3 col-sm-2 p-2 rounded-3 border bg-light-subtle">
                        <i class="bi bi-diagram-3 fs-4 text-danger d-block mb-1"></i>
                        <span class="text-truncate d-block" style="font-size: 0.65rem;">LDAP</span>
                    </div>
                    <div class="col-3 col-sm-2 p-2 rounded-3 border bg-light-subtle">
                        <i class="bi bi-cloud-arrow-up fs-4 text-danger d-block mb-1"></i>
                        <span class="text-truncate d-block" style="font-size: 0.65rem;">Dropzone</span>
                    </div>
                    <div class="col-3 col-sm-2 p-2 rounded-3 border bg-light-subtle">
                        <i class="bi bi-flower1 fs-4 text-danger d-block mb-1"></i>
                        <span class="text-truncate d-block" style="font-size: 0.65rem;">Rose</span>
                    </div>
                    <div class="col-3 col-sm-2 p-2 rounded-3 border bg-light-subtle">
                        <i class="bi bi-gem fs-4 text-danger d-block mb-1"></i>
                        <span class="text-truncate d-block" style="font-size: 0.65rem;">Atelier</span>
                    </div>
                    <div class="col-3 col-sm-2 p-2 rounded-3 border bg-light-subtle">
                        <i class="bi bi-box-seam fs-4 text-danger d-block mb-1"></i>
                        <span class="text-truncate d-block" style="font-size: 0.65rem;">Inventory</span>
                    </div>
                    <div class="col-3 col-sm-2 p-2 rounded-3 border bg-light-subtle">
                        <i class="bi bi-receipt-cutoff fs-4 text-danger d-block mb-1"></i>
                        <span class="text-truncate d-block" style="font-size: 0.65rem;">Receipt</span>
                    </div>
                    <div class="col-3 col-sm-2 p-2 rounded-3 border bg-light-subtle">
                        <i class="bi bi-safe2 fs-4 text-danger d-block mb-1"></i>
                        <span class="text-truncate d-block" style="font-size: 0.65rem;">Treasury</span>
                    </div>
                    <div class="col-3 col-sm-2 p-2 rounded-3 border bg-light-subtle">
                        <i class="bi bi-stars fs-4 text-danger d-block mb-1"></i>
                        <span class="text-truncate d-block" style="font-size: 0.65rem;">Luxury</span>
                    </div>
                    <div class="col-3 col-sm-2 p-2 rounded-3 border bg-light-subtle">
                        <i class="bi bi-key fs-4 text-danger d-block mb-1"></i>
                        <span class="text-truncate d-block" style="font-size: 0.65rem;">Vault</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 9: Audit Stamps Footer Parameters (Mandatory Standard) -->
    <footer class="card-surface p-3 d-flex flex-wrap align-items-center justify-content-between gap-2" style="border-color: #FECDD3 !important;">
        <div class="d-flex flex-wrap align-items-center gap-3 small text-secondary">
            <span><strong class="text-dark">created_by:</strong> pantakarn</span>
            <span><strong class="text-dark">created_at:</strong> {{ date('Y-m-d H:i:s') }}</span>
            <span><strong class="text-dark">updated_by:</strong> pantakarn</span>
            <span><strong class="text-dark">updated_at:</strong> {{ date('Y-m-d H:i:s') }}</span>
            <span><strong class="text-dark">request_uri:</strong> {{ request()->getRequestUri() }}</span>
        </div>
        <div class="small fw-semibold" style="color: #BE123C;">
            Rose Quartz &amp; Velvet Theme • ArtisanCraft Scaffolding
        </div>
    </footer>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Chart.js Initialization
        const ctx = document.getElementById('roseQuartzChart');
        if (ctx && typeof Chart !== 'undefined') {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์'],
                    datasets: [{
                        label: 'การเข้าใช้งานระบบ (Logins)',
                        data: [120, 190, 310, 480, 520, 240, 180],
                        borderColor: '#BE123C',
                        backgroundColor: 'rgba(190, 18, 60, 0.12)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#FFFFFF',
                        pointBorderColor: '#BE123C',
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
                            backgroundColor: '#881337',
                            titleColor: '#FFFFFF',
                            bodyColor: '#FFFFFF',
                            padding: 10,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#7A4B55', font: { family: 'Plus Jakarta Sans, Sarabun' } }
                        },
                        y: {
                            grid: { color: 'rgba(254, 205, 211, 0.4)' },
                            ticks: { color: '#A93349', font: { family: 'Plus Jakarta Sans, Sarabun' } },
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
                        title: 'Rose Quartz & Velvet Alert',
                        text: 'ระบบโมดัลมาตรฐาน Forge Artisan Engine พร้อมใช้งาน 100%',
                        icon: 'success',
                        confirmButtonText: 'รับทราบ',
                        confirmButtonColor: '#BE123C'
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
                confirmButtonColor: '#BE123C',
                cancelButtonColor: '#7A4B55',
                confirmButtonText: 'ลงทะเบียนทันที',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'สำเร็จ!',
                        text: 'ลงทะเบียนกุญแจ Passkey สำหรับโหมดพรีวิว Rose Quartz & Velvet เรียบร้อยแล้ว',
                        icon: 'success',
                        confirmButtonColor: '#BE123C'
                    });
                }
            });
        } else {
            alert('ลงทะเบียนกุญแจ Passkey เรียบร้อยแล้ว');
        }
    }
</script>
@endpush
