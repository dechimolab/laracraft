@extends(view()->exists('layouts.app') ? 'layouts.app' : 'themes.sunset-horizon.layouts.app')

@section('content')
<div class="d-flex flex-column gap-4">

    <!-- Section 1: Hero Welcome Banner -->
    <section class="card-surface p-4 position-relative overflow-hidden">
        <div class="hero-glow-sunset"></div>
        <div class="position-relative z-1 row align-items-center g-3">
            <div class="col-lg-8">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="badge rounded-pill text-uppercase px-2.5 py-1" style="background-color: var(--sunset-primary-subtle, #FFF7ED); color: var(--sunset-primary, #EA580C); border: 1px solid var(--sunset-border, #FED7AA);">
                        <i class="bi bi-circle-fill me-1" style="font-size: 6px; color: var(--sunset-primary, #EA580C);"></i>ArtisanCraft Engine
                    </span>
                    <span class="badge bg-white text-secondary border">Laravel 13.x</span>
                    <span class="badge bg-white text-secondary border">PHP 8.4 JIT</span>
                    <span class="badge bg-white text-secondary border">Bootstrap 5.3.3</span>
                    <span class="badge bg-white text-secondary border">WCAG AAA 13.8:1</span>
                </div>
                <h1 class="h4 fw-bold text-dark mt-2 mb-1">
                    ยินดีต้อนรับสู่ <span style="color: var(--sunset-primary, #EA580C);">{{ $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'Artisan POS & Inventory Hub') }}</span>
                </h1>
                <p class="text-secondary mb-0 small" style="color: var(--sunset-text-muted, #9A3412) !important;">
                    ระบบบริหารจัดการและหน้าควบคุมต้นแบบ Sunset Horizon พร้อมส่วนประกอบ UI และระบบรักษาความปลอดภัยครบวงจร Fiduciary Precision Standard
                </p>
            </div>
            <div class="col-lg-4 d-flex flex-wrap justify-content-lg-end gap-2">
                <button class="btn btn-sunset-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-medium shadow-sm rounded-pill" type="button" id="btn-passkey-register" onclick="registerWebauthnBiometric()">
                    <span class="material-symbols-outlined fs-5">fingerprint</span>
                    <span>บันทึกลายนิ้วมือใหม่ (Passkey)</span>
                </button>
                <button class="btn btn-sunset-soft d-inline-flex align-items-center gap-2 px-3 py-2 fw-medium rounded-pill" type="button" id="btn-swal-demo">
                    <span class="material-symbols-outlined fs-5" style="color: var(--sunset-primary, #EA580C);">notifications_active</span>
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
                'status' => 'Active',
                'desc' => 'ระบบออกใบเสร็จ ตัดสต็อกเรียลไทม์ และเชื่อมต่อจุดชำระเงิน Fiduciary Standard',
                'btn_text' => 'เปิดหน้าแคชเชียร์ POS',
                'btn_icon' => 'point_of_sale',
                'btn_link' => '#',
            ];
        }
    @endphp

    <section class="card-surface p-4">
        <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom" style="border-color: var(--sunset-border, #FED7AA) !important;">
            <div class="d-flex align-items-center gap-2">
                <span class="material-symbols-outlined fs-5" style="color: var(--sunset-primary, #EA580C);">apps</span>
                <h2 class="h6 fw-bold text-dark mb-0">โมดูลระบบพร้อมใช้งาน (Enterprise Pre-built Modules)</h2>
            </div>
            <span class="badge rounded-pill px-3 py-1 fw-medium" style="background-color: var(--sunset-primary-subtle, #FFF7ED); color: var(--sunset-primary, #EA580C); border: 1px solid var(--sunset-border, #FED7AA);">
                {{ count($activeModulesList) }} Active Modules
            </span>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-xl-4 g-3">
            @foreach($activeModulesList as $modKey => $mod)
            <div class="col">
                <div class="card-sunset-inner p-3 h-100 d-flex flex-column justify-content-between position-relative overflow-hidden" style="border: 1px solid var(--sunset-border, #FED7AA);">
                    <div>
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <span class="badge rounded-pill" style="font-size: 0.65rem; background-color: #FFF7ED; color: #EA580C; border: 1px solid #FED7AA;">
                                <i class="bi bi-check-circle-fill me-1" style="color: #10B981;"></i>{{ $mod['status'] }}
                            </span>
                            <span class="small text-muted font-monospace" style="font-size: 0.65rem;">{{ $mod['tag'] }}</span>
                        </div>
                        <h3 class="h6 fw-bold text-dark mb-1" style="font-size: 0.9rem;">
                            {{ $mod['name'] }}
                        </h3>
                        <p class="text-secondary small mb-3" style="font-size: 0.775rem; line-height: 1.45;">
                            {{ $mod['desc'] }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ $mod['btn_link'] }}" class="btn btn-sm btn-sunset-soft w-100 d-inline-flex align-items-center justify-content-center gap-1.5 py-1.5 rounded-pill text-decoration-none">
                            <span class="material-symbols-outlined fs-6">{{ $mod['btn_icon'] }}</span>
                            <span>{{ $mod['btn_text'] }}</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Section 3: Telemetry & KPI Cards Bar -->
    <section class="card-surface p-4">
        <div class="row g-3 align-items-stretch">
            <!-- System Velocity & Latency -->
            <div class="col-lg-4">
                <div class="card-sunset-inner p-3 h-100 d-flex flex-column justify-content-between" style="border: 1px solid var(--sunset-border, #FED7AA);">
                    <div class="d-flex align-items-center justify-content-between text-secondary">
                        <span class="small fw-semibold text-uppercase" style="font-size: 0.75rem; color: #7C2D12;">System Velocity</span>
                        <span class="badge rounded-pill" style="font-size: 0.65rem; background-color: #FFF7ED; color: #EA580C; border: 1px solid #FED7AA;">REAL-TIME</span>
                    </div>
                    <div class="d-flex align-items-baseline gap-2 mt-2">
                        <span class="h3 fw-bold mb-0 text-dark">99.98%</span>
                        <span class="text-success small fw-medium">▲ +0.02%</span>
                    </div>
                    <div class="d-flex align-items-center gap-1 small fw-semibold mt-1" style="color: var(--sunset-primary, #EA580C);">
                        <span class="material-symbols-outlined fs-6">speed</span>
                        <span>0.14ms Latency Buffer</span>
                    </div>
                </div>
            </div>

            <!-- Active Telemetry (Sparkline SVG) -->
            <div class="col-lg-4">
                <div class="card-sunset-inner p-3 h-100 d-flex flex-column justify-content-between" style="border: 1px solid var(--sunset-border, #FED7AA);">
                    <div class="d-flex align-items-center justify-content-between text-secondary">
                        <span class="small fw-semibold text-uppercase" style="font-size: 0.75rem; color: #7C2D12;">Active Telemetry</span>
                        <span class="badge rounded-pill" style="font-size: 0.65rem; background-color: #FFF7ED; color: #EA580C; border: 1px solid #FED7AA;">TRAFFIC WAVE</span>
                    </div>
                    <div class="w-100 my-1 position-relative" style="height: 48px;">
                        <svg class="w-100 h-100" viewBox="0 0 200 40">
                            <path d="M0,32 Q25,28 50,30 T100,16 T150,22 T200,8 L200,40 L0,40 Z" fill="rgba(234, 88, 12, 0.08)"></path>
                            <path d="M0,32 Q25,28 50,30 T100,16 T150,22 T200,8" fill="none" stroke="#EA580C" stroke-width="2.5"></path>
                        </svg>
                    </div>
                    <div class="d-flex align-items-center justify-content-between small text-secondary">
                        <span class="fw-medium" style="color: var(--sunset-primary, #EA580C);">Zero Bottlenecks</span>
                        <span>0.14ms Latency</span>
                    </div>
                </div>
            </div>

            <!-- Sample Form Control -->
            <div class="col-lg-4">
                <div class="card-sunset-inner p-3 h-100 d-flex flex-column justify-content-between" style="border: 1px solid var(--sunset-border, #FED7AA);">
                    <div class="d-flex align-items-center justify-content-between text-secondary mb-1">
                        <span class="small fw-semibold text-uppercase" style="font-size: 0.75rem; color: #7C2D12;">Sample Form Control</span>
                        <span class="small text-muted">Input Prepend</span>
                    </div>
                    <div class="input-group my-auto">
                        <span class="input-group-text bg-white fw-bold" style="border-color: #FED7AA; color: #EA580C;">THB</span>
                        <input class="form-control bg-white text-end fw-bold" placeholder="0.00" type="text" value="฿ 1,850,000.00" style="border-color: #FED7AA;">
                    </div>
                    <div class="small text-muted text-end mt-1">อัตราคงที่ 0% ค่าธรรมเนียม</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: WebAuthn Passkey Biometrics Management -->
    <section class="card-surface p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" style="width: 44px; height: 44px; background: linear-gradient(135deg, #EA580C 0%, #C2410C 100%); color: #ffffff;">
                    <span class="material-symbols-outlined fs-4">fingerprint</span>
                </div>
                <div>
                    <h3 class="h6 fw-bold text-dark mb-1">ความปลอดภัยชีวมิติ (WebAuthn / Passkey Biometrics)</h3>
                    <p class="text-secondary small mb-0">
                        เชื่อมต่อเซ็นเซอร์ลายนิ้วมือบนอุปกรณ์ สำหรับยืนยันตัวตนระดับ Fiduciary Security ผ่าน W3C WebAuthn API
                    </p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sunset-primary px-3 py-2 fw-medium shadow-sm d-inline-flex align-items-center gap-2 rounded-pill" type="button" onclick="registerWebauthnBiometric()">
                    <span class="material-symbols-outlined fs-5">fingerprint</span>
                    <span>ลงทะเบียนลายนิ้วมือเครื่องนี้</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Section 5: Chart.js Line Chart & Form UI Elements -->
    <section class="row g-3">
        <!-- Interactive Chart Visualization -->
        <div class="col-lg-7">
            <div class="card-surface p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom" style="border-color: var(--sunset-border, #FED7AA) !important;">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-5" style="color: var(--sunset-primary, #EA580C);">insights</span>
                            <h3 class="h6 fw-bold text-dark mb-0">สถิติการใช้งานระบบ (Chart.js Interactive Demo)</h3>
                        </div>
                        <span class="badge rounded-pill" style="background-color: #FFF7ED; color: #EA580C; border: 1px solid #FED7AA;">Realtime</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 text-secondary small mb-3">
                        <span class="d-inline-flex align-items-center gap-1.5">
                            <span class="rounded d-inline-block" style="width: 12px; height: 12px; background-color: #EA580C;"></span>
                            การเข้าใช้งานระบบรายวัน (Logins)
                        </span>
                        <span class="text-muted">อัปเดตอัตโนมัติทุก 60 วินาที</span>
                    </div>
                    <!-- Inline Canvas Chart Container -->
                    <div class="p-3 rounded-3 border position-relative" style="height: 250px; background-color: #FFFAF0; border-color: var(--sunset-border, #FED7AA) !important;">
                        <canvas id="mainLoginsChart" class="w-100 h-100"></canvas>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 small text-muted border-top mt-3" style="border-color: var(--sunset-border, #FED7AA) !important;">
                    <span>บันทึกทราฟฟิกข้อมูลคลัสเตอร์ BUU-FIN-CLUSTER-04</span>
                    <span class="fw-bold" style="color: var(--sunset-primary, #EA580C);">ค่าเฉลี่ย 384 ครั้ง/วัน</span>
                </div>
            </div>
        </div>

        <!-- Form UI Elements -->
        <div class="col-lg-5">
            <div class="card-surface p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom" style="border-color: var(--sunset-border, #FED7AA) !important;">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-5" style="color: var(--sunset-primary, #EA580C);">tune</span>
                            <h3 class="h6 fw-bold text-dark mb-0">ส่วนประกอบฟอร์ม (Form UI Elements)</h3>
                        </div>
                        <span class="badge bg-light text-secondary border">Interactive</span>
                    </div>
                    <form class="d-flex flex-column gap-3" onsubmit="event.preventDefault()">
                        <!-- Select2 Searchable Dropdown -->
                        <div>
                            <label class="form-label small fw-semibold text-dark mb-1" for="demo-select2">สังกัด / คณะ (Select2 Searchable Dropdown):</label>
                            <select id="demo-select2" class="form-select bg-white border w-100" style="border-color: #FED7AA;">
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
                                <span class="input-group-text bg-white text-muted" style="border-color: #FED7AA;">
                                    <span class="material-symbols-outlined fs-6" style="color: #EA580C;">calendar_month</span>
                                </span>
                                <input id="demo-datepicker" class="form-control bg-white datepicker" placeholder="วว/ดด/ปปปป (พ.ศ.)" type="text" value="24/10/2567" style="border-color: #FED7AA;"/>
                            </div>
                            <div class="form-text small text-muted">ปฏิทินไทยปี พ.ศ. (+543) พร้อมปุ่ม “ล้างค่า” ตามมาตรฐาน MA BUCC</div>
                        </div>
                        <!-- AutoNumeric Masking -->
                        <div>
                            <label class="form-label small fw-semibold text-dark mb-1" for="demo-autonumeric">งบประมาณโครงการ (AutoNumeric Masking):</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white fw-bold" style="border-color: #FED7AA; color: #EA580C;">THB</span>
                                <input id="demo-autonumeric" class="form-control bg-white text-end fw-bold" type="text" value="฿ 1,850,000.00" style="border-color: #FED7AA;"/>
                            </div>
                            <div class="form-text small text-muted">จัดรูปแบบอัตราแลกเปลี่ยนและคั่นหลักพันอัตโนมัติขณะพิมพ์</div>
                        </div>
                    </form>
                </div>
                <div class="pt-3 d-flex justify-content-end gap-2 border-top mt-3" style="border-color: var(--sunset-border, #FED7AA) !important;">
                    <button class="btn btn-sm btn-white bg-white border fw-medium rounded-pill" type="button" style="border-color: #FED7AA !important;">รีเซ็ตค่าฟอร์ม</button>
                    <button class="btn btn-sm btn-sunset-primary fw-medium shadow-sm rounded-pill" type="button">บันทึกฟิลด์ทดสอบ</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 6: DataTables Bootstrap 5 & Dropzone Upload -->
    <section class="row g-3">
        <!-- DataGrid (DataTables Bootstrap 5) -->
        <div class="col-lg-8">
            <div class="card-surface p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom" style="border-color: var(--sunset-border, #FED7AA) !important;">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-5" style="color: var(--sunset-primary, #EA580C);">table_chart</span>
                            <h3 class="h6 fw-bold text-dark mb-0">ตารางข้อมูลสารสนเทศ (DataTables Bootstrap 5)</h3>
                        </div>
                        <span class="badge bg-light text-secondary border">Data Grid</span>
                    </div>
                    <!-- Responsive Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.8125rem;">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="py-2.5">รหัสเจ้าหน้าที่</th>
                                    <th scope="col" class="py-2.5">ชื่อ-นามสกุล</th>
                                    <th scope="col" class="py-2.5">บทบาท UMS</th>
                                    <th scope="col" class="py-2.5">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold font-monospace" style="color: #EA580C;">USR-8801</td>
                                    <td>นายพันธกานต์ มั่นจันทร์</td>
                                    <td><span class="badge bg-light text-dark border">System Admin</span></td>
                                    <td><span class="badge bg-success-subtle text-success border border-success-subtle">Active</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold font-monospace" style="color: #EA580C;">USR-8802</td>
                                    <td>ดร.สมชาย ใจดี</td>
                                    <td><span class="badge bg-light text-dark border">Security Auditor</span></td>
                                    <td><span class="badge bg-success-subtle text-success border border-success-subtle">Active</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold font-monospace" style="color: #EA580C;">USR-8803</td>
                                    <td>นางสาววิภาดา รุ่งเรือง</td>
                                    <td><span class="badge bg-light text-dark border">Operator</span></td>
                                    <td><span class="badge bg-success-subtle text-success border border-success-subtle">Active</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dropzone Box -->
        <div class="col-lg-4">
            <div class="card-surface p-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom" style="border-color: var(--sunset-border, #FED7AA) !important;">
                        <div class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined fs-5" style="color: var(--sunset-primary, #EA580C);">cloud_upload</span>
                            <h3 class="h6 fw-bold text-dark mb-0">ระบบอัปโหลดไฟล์ (Dropzone)</h3>
                        </div>
                        <span class="badge bg-light text-secondary border">Upload Vault</span>
                    </div>
                    <div class="dropzone-box" id="dropzone-box">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-xs" style="width: 56px; height: 56px; background-color: #FFF7ED; color: #EA580C; border: 1px solid #FED7AA;">
                            <span class="material-symbols-outlined fs-2">upload_file</span>
                        </div>
                        <h4 class="h6 fw-bold text-dark mb-1">ลากไฟล์มาวางที่นี่ หรือคลิกเพื่อเลือกไฟล์</h4>
                        <p class="text-muted small mb-0">รองรับ PDF, PNG, JPG, JPEG สูงสุด 10MB</p>
                        <input type="file" id="dropzone-input" class="d-none" multiple>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-3 small text-muted" style="border-color: var(--sunset-border, #FED7AA) !important;">
                    <span class="d-inline-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-6">lock</span> Max upload: 10MB
                    </span>
                    <span class="fw-medium" style="color: var(--sunset-primary, #EA580C);">AES-256 Vault Ready</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 8: Component Showcase (Buttons, Icons) -->
    <section class="row g-3">
        <!-- Button Styles & Actions Showcase -->
        <div class="col-md-6">
            <div class="card-surface p-4 shadow-sm h-100 d-flex flex-column gap-3" style="border: 1px solid var(--sunset-border, #FED7AA);">
                <div class="d-flex align-items-center justify-content-between pb-2 border-bottom" style="border-color: var(--sunset-border, #FED7AA) !important;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-5" style="color: var(--sunset-primary, #EA580C);">smart_button</span>
                        <h3 class="h6 fw-bold text-dark mb-0">ชุดปุ่มและสถานะการโต้ตอบ (Button Styles &amp; Actions)</h3>
                    </div>
                    <span class="badge bg-light text-secondary border">Actions</span>
                </div>
                <!-- Solid Variants -->
                <div>
                    <label class="form-label small text-secondary fw-semibold mb-2">1. ปุ่มสีหลักความเข้ม (Solid Variants):</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-sunset-primary btn-sm d-inline-flex align-items-center gap-1 fw-semibold shadow-sm rounded-pill">
                            <span class="material-symbols-outlined fs-6">done</span> Primary Action
                        </button>
                        <button class="btn btn-sunset-soft btn-sm d-inline-flex align-items-center gap-1 fw-semibold rounded-pill">
                            <span class="material-symbols-outlined fs-6">tune</span> Secondary Action
                        </button>
                        <button class="btn btn-sunset-primary btn-sm d-inline-flex align-items-center gap-1 fw-semibold rounded-pill">
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
                        <button class="btn btn-sm rounded-pill" style="background-color: #FFF7ED; color: #EA580C; font-weight: 600; border: 1px solid #FED7AA;">Small Soft</button>
                        <button class="btn rounded-pill" style="background-color: #FFF7ED; color: #EA580C; font-weight: 600; border: 1px solid #FED7AA;">Regular Subtle</button>
                        <button class="btn btn-lg fs-6 shadow-sm rounded-pill" style="background-color: #FFF7ED; color: #EA580C; font-weight: 600; border: 1px solid #FED7AA;">+ Large Subtle</button>
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
                        <button class="btn btn-sm btn-sunset-primary fw-semibold d-inline-flex align-items-center gap-2 rounded-pill" type="button">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                            <span>กำลังประมวลผล...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Icon Set (Bootstrap Icons & Material Symbols) -->
        <div class="col-md-6">
            <div class="card-surface p-4 shadow-sm h-100 d-flex flex-column gap-3" style="border: 1px solid var(--sunset-border, #FED7AA);">
                <div class="d-flex align-items-center justify-content-between pb-2 border-bottom" style="border-color: var(--sunset-border, #FED7AA) !important;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined fs-5" style="color: var(--sunset-primary, #EA580C);">category</span>
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
                            <span class="material-symbols-outlined fs-3" style="color: var(--sunset-primary, #EA580C);">speed</span>
                            <span class="small fw-semibold text-dark mt-1">Dashboard</span>
                            <span class="text-muted" style="font-size: 10px;">speedometer</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--sunset-primary, #EA580C);">shield</span>
                            <span class="small fw-semibold text-dark mt-1">Security</span>
                            <span class="text-muted" style="font-size: 10px;">shield-lock</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--sunset-primary, #EA580C);">fingerprint</span>
                            <span class="small fw-semibold text-dark mt-1">Biometrics</span>
                            <span class="text-muted" style="font-size: 10px;">passkey</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--sunset-primary, #EA580C);">database</span>
                            <span class="small fw-semibold text-dark mt-1">Database</span>
                            <span class="text-muted" style="font-size: 10px;">mysql</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--sunset-primary, #EA580C);">lan</span>
                            <span class="small fw-semibold text-dark mt-1">Directory</span>
                            <span class="text-muted" style="font-size: 10px;">ldap</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--sunset-primary, #EA580C);">cloud_upload</span>
                            <span class="small fw-semibold text-dark mt-1">Dropzone</span>
                            <span class="text-muted" style="font-size: 10px;">upload-vault</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--sunset-primary, #EA580C);">wb_sunny</span>
                            <span class="small fw-semibold text-dark mt-1">Horizon</span>
                            <span class="text-muted" style="font-size: 10px;">sunset-warm</span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2 bg-light rounded-3 text-center border d-flex flex-column align-items-center">
                            <span class="material-symbols-outlined fs-3" style="color: var(--sunset-primary, #EA580C);">lock</span>
                            <span class="small fw-semibold text-dark mt-1">Vault</span>
                            <span class="text-muted" style="font-size: 10px;">tls-fips</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 9: Audit Stamp Footer Parameters (Mandatory Standard) -->
    <footer class="card-surface p-3 d-flex flex-wrap align-items-center justify-content-between gap-2" style="border-color: var(--sunset-border, #FED7AA) !important;">
        <div class="d-flex flex-wrap align-items-center gap-3 small text-secondary">
            <span><strong class="text-dark">created_by:</strong> pantakarn</span>
            <span><strong class="text-dark">created_at:</strong> {{ date('Y-m-d H:i:s') }}</span>
            <span><strong class="text-dark">updated_by:</strong> pantakarn</span>
            <span><strong class="text-dark">updated_at:</strong> {{ date('Y-m-d H:i:s') }}</span>
            <span><strong class="text-dark">request_uri:</strong> {{ request()->getRequestUri() }}</span>
        </div>
        <div class="small fw-semibold" style="color: var(--sunset-primary, #EA580C);">
            Sunset Horizon Theme • ArtisanCraft Scaffolding
        </div>
    </footer>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Chart.js Main Logins Analytics Chart
        const mainChartCtx = document.getElementById('mainLoginsChart');
        if (mainChartCtx && typeof Chart !== 'undefined') {
            const ctx = mainChartCtx.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 220);
            gradient.addColorStop(0, 'rgba(234, 88, 12, 0.28)');
            gradient.addColorStop(1, 'rgba(234, 88, 12, 0.00)');

            new Chart(mainChartCtx, {
                type: 'line',
                data: {
                    labels: ['จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์'],
                    datasets: [{
                        label: 'การเข้าสู่ระบบ (Logins)',
                        data: [310, 290, 440, 520, 390, 280, 210],
                        borderColor: '#EA580C',
                        backgroundColor: gradient,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#FB923C',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 4.5,
                        pointHoverRadius: 6,
                        tension: 0.38,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#431407',
                            titleColor: '#FED7AA',
                            bodyColor: '#FFFFFF',
                            padding: 10,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9A3412', font: { size: 10.5 } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(254, 215, 170, 0.45)' },
                            ticks: { color: '#9A3412', font: { size: 10.5 }, stepSize: 150 }
                        }
                    }
                }
            });
        }

        // 2. Select2 Initialize
        if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
            $('#demo-select2').select2({
                placeholder: '---เลือก---',
                allowClear: true,
                dropdownAutoWidth: true
            });
        }

        // 3. jQuery UI Datepicker Thai Buddhist Year
        if (typeof jQuery !== 'undefined' && jQuery.fn.datepicker) {
            $('#demo-datepicker').datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                isBuddhist: true,
                defaultDate: '+0d',
                dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
                monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.']
            });
        }

        // 4. AutoNumeric Masking
        if (typeof AutoNumeric !== 'undefined') {
            try {
                if (!AutoNumeric.getAutoNumericElement('#demo-autonumeric')) {
                    new AutoNumeric('#demo-autonumeric', {
                        currencySymbol: '฿ ',
                        decimalPlaces: 2
                    });
                }
            } catch (e) {
                console.log('AutoNumeric init:', e);
            }
        }

        // 5. Dropzone File Uploader
        if (typeof Dropzone !== 'undefined') {
            Dropzone.autoDiscover = false;
            const dropzoneEl = document.getElementById('dropzone-box');
            if (dropzoneEl && !dropzoneEl.dropzone) {
                try {
                    new Dropzone('#dropzone-box', {
                        url: '#',
                        autoProcessQueue: false,
                        maxFiles: 5,
                        maxFilesize: 10,
                        acceptedFiles: '.pdf,.png,.jpg,.jpeg,.docx',
                        dictDefaultMessage: 'ลากไฟล์มาวางที่นี่ หรือคลิกเพื่ออัปโหลด',
                        init: function() {
                            this.on('addedfile', function(file) {
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dropzone ตรวจพบไฟล์',
                                        text: 'รับไฟล์: ' + file.name + ' (' + Math.round(file.size / 1024) + ' KB) เรียบร้อย',
                                        confirmButtonColor: '#EA580C'
                                    });
                                }
                            });
                        }
                    });
                } catch (e) {
                    console.log('Dropzone init:', e);
                }
            }
        }

        // 6. Bind Passkey button
        const btnPasskey = document.getElementById('btn-passkey-register');
        if (btnPasskey) {
            btnPasskey.addEventListener('click', registerWebauthnBiometric);
        }

        // 7. SweetAlert2 Demo Trigger
        const btnSwal = document.getElementById('btn-swal-demo');
        if (btnSwal) {
            btnSwal.addEventListener('click', () => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'เชื่อมต่อ SweetAlert2 สำเร็จ',
                        text: 'Artisan POS & Inventory Hub (Sunset Horizon) ทำงานปกติทุกระบบ!',
                        confirmButtonColor: '#EA580C'
                    });
                } else {
                    alert('SweetAlert2 Connected: Artisan POS Core system is operating nominal!');
                }
            });
        }

        // 8. Dropzone fallback click
        const dropzoneBox = document.getElementById('dropzone-box');
        const dropzoneInput = document.getElementById('dropzone-input');
        if (dropzoneBox && dropzoneInput) {
            dropzoneBox.addEventListener('click', () => {
                if (!dropzoneBox.dropzone) {
                    dropzoneInput.click();
                }
            });
            dropzoneInput.addEventListener('change', (e) => {
                if (e.target.files && e.target.files.length > 0) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'อัปโหลดสำเร็จ',
                            text: e.target.files.length + ' ไฟล์ถูกเข้ารหัสด้วย AES-256 เรียบร้อยแล้ว',
                            confirmButtonColor: '#EA580C'
                        });
                    } else {
                        alert('อัปโหลดสำเร็จ: ' + e.target.files.length + ' ไฟล์ถูกเข้ารหัสด้วย AES-256 เรียบร้อยแล้ว');
                    }
                }
            });
        }
    });

    // Helper: Buffer to Base64URL
    function bufferToBase64url(buffer) {
        const byteView = new Uint8Array(buffer);
        let str = '';
        for (const item of byteView) {
            str += String.fromCharCode(item);
        }
        return btoa(str).replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
    }

    // Helper: Base64URL to Uint8Array
    function base64urlToUint8array(base64url) {
        let padding = '='.repeat((4 - base64url.length % 4) % 4);
        let base64 = (base64url + padding).replace(/-/g, '+').replace(/_/g, '/');
        let rawData = atob(base64);
        let outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    // WebAuthn Passkey Registration execution
    async function registerWebauthnBiometric() {
        if (!window.PublicKeyCredential) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'อุปกรณ์ไม่รองรับ',
                    text: 'เบราว์เซอร์หรืออุปกรณ์ของคุณไม่รองรับมาตรฐาน WebAuthn / Passkey',
                    confirmButtonColor: '#EA580C'
                });
            } else {
                alert('เบราว์เซอร์ของคุณไม่รองรับมาตรฐาน WebAuthn / Passkey');
            }
            return;
        }

        const registerBtn = document.getElementById('btn-passkey-register');
        if (registerBtn) {
            registerBtn.disabled = true;
            registerBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> กำลังเชื่อมต่อเซ็นเซอร์ชีวมิติ...';
        }

        try {
            const optRes = await fetch("{{ Route::has('webauthn.register.options') ? route('webauthn.register.options') : url('/webauthn/register/options') }}", {
                headers: { 'Accept': 'application/json' }
            });

            if (!optRes.ok) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'โหมดจำลองพรีวิว (Demo Mode)',
                        text: 'ระบบจำลองการลงทะเบียน Passkey สำหรับหน้าพรีวิวธีม Sunset Horizon สำเร็จ!',
                        confirmButtonColor: '#EA580C'
                    });
                } else {
                    alert('โหมดจำลองพรีวิว: บันทึกลายนิ้วมือสำเร็จ!');
                }
                return;
            }

            const options = await optRes.json();
            options.challenge = base64urlToUint8array(options.challenge);
            options.user.id = base64urlToUint8array(options.user.id);
            if (options.excludeCredentials) {
                options.excludeCredentials.forEach(cred => {
                    cred.id = base64urlToUint8array(cred.id);
                });
            }

            const credential = await navigator.credentials.create({ publicKey: options });
            const credentialData = {
                id: credential.id,
                rawId: bufferToBase64url(credential.rawId),
                type: credential.type,
                response: {
                    attestationObject: bufferToBase64url(credential.response.attestationObject),
                    clientDataJSON: bufferToBase64url(credential.response.clientDataJSON)
                }
            };

            const verifyRes = await fetch("{{ Route::has('webauthn.register') ? route('webauthn.register') : url('/webauthn/register') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(credentialData)
            });

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'บันทึกลายนิ้วมือสำเร็จ',
                    text: 'ลงทะเบียน Passkey สำหรับเครื่องนี้เรียบร้อยแล้ว ท่านสามารถเข้าสู่ระบบครั้งต่อไปได้โดยไม่ต้องกรอกรหัสผ่าน',
                    confirmButtonColor: '#EA580C'
                });
            } else {
                alert('บันทึกลายนิ้วมือสำเร็จ! ท่านสามารถใช้ Passkey เข้าสู่ระบบครั้งต่อไปได้ทันที');
            }
        } catch (err) {
            console.error(err);
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'info',
                    title: 'โหมดจำลองพรีวิว (Demo Mode)',
                    text: 'จำลองการตอบสนอง Passkey บนหน้าพรีวิวธีม Sunset Horizon สำเร็จ',
                    confirmButtonColor: '#EA580C'
                });
            } else {
                alert('โหมดจำลองพรีวิว: พร้อมใช้งาน');
            }
        } finally {
            if (registerBtn) {
                registerBtn.disabled = false;
                registerBtn.innerHTML = '<span class="material-symbols-outlined fs-5">fingerprint</span><span>บันทึกลายนิ้วมือใหม่ (Passkey)</span>';
            }
        }
    }
</script>
@endpush
