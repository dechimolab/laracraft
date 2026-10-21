@extends(view()->exists('layouts.app') ? 'layouts.app' : 'themes.emerald-enterprise.layouts.app')

@section('content')
<div class="flex flex-col w-full gap-space-lg">

    <!-- 1. Enterprise Welcome Hero Banner -->
    <section class="relative overflow-hidden rounded-xl bg-surface-container-lowest p-space-lg shadow-sm border border-surface-container-high/60">
        <div class="absolute -right-16 -top-20 w-80 h-80 rounded-full bg-primary-fixed/25 blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-space-md">
            <div class="flex flex-col gap-space-xs max-w-4xl">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-sm tracking-wider uppercase font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>ArtisanCraft Engine
                    </span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm">
                        Laravel 13.x
                    </span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm">
                        PHP 8.4 JIT
                    </span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm">
                        Bootstrap 5.3 + Tailwind 3.4
                    </span>
                </div>
                <h1 class="font-headline-xl text-headline-xl font-bold text-on-surface tracking-tight mt-1">
                    ยินดีต้อนรับสู่ <span class="text-primary">{{ config('app.name', 'Artisan POS & Inventory Hub') }}</span>
                </h1>
                <p class="font-body-md text-body-md text-on-surface-variant">
                    ระบบบริหารจัดการและหน้าควบคุมต้นแบบ (Demo Showcase Dashboard) พร้อมส่วนประกอบ UI และระบบรักษาความปลอดภัยครบวงจร Fiduciary Precision Standard
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-space-sm shrink-0">
                <button class="inline-flex items-center gap-2 px-4 py-2 rounded bg-primary text-on-primary hover:bg-primary-container font-label-lg font-semibold transition-all shadow-sm cursor-pointer" id="btn-passkey-register">
                    <span class="material-symbols-outlined text-[18px]">fingerprint</span>
                    <span>บันทึกลายนิ้วมือใหม่ (Passkey)</span>
                </button>
                <button class="inline-flex items-center gap-2 px-4 py-2 rounded bg-surface-container-high hover:bg-surface-container text-on-surface font-label-lg font-medium transition-all cursor-pointer border border-surface-container-highest" id="btn-swal-demo">
                    <span class="material-symbols-outlined text-[18px]">notifications_active</span>
                    <span>ทดสอบ SweetAlert2</span>
                </button>
            </div>
        </div>
    </section>

    <!-- 2. Pre-built Modules Demo Hub -->
    <section class="rounded-xl bg-surface-container-lowest p-space-md shadow-sm border border-surface-container-high/60">
        <div class="flex items-center justify-between pb-space-sm mb-space-sm border-b border-surface-container-high/40">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]">view_module</span>
                <span class="font-headline-sm font-semibold text-on-surface">โมดูลสำเร็จรูปประจำโปรเจกต์ (Enterprise Pre-built Modules Demo Hub)</span>
            </div>
            <span class="px-2.5 py-0.5 rounded bg-primary text-on-primary font-label-sm uppercase font-semibold">Step 3 Modules</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
            <div class="p-space-md rounded-lg bg-surface-container-low hover:bg-surface-container transition-all border border-surface-container-high/40">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-sm font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>Active
                    </span>
                    <span class="font-label-sm text-outline font-mono">ums_buu</span>
                </div>
                <h3 class="font-headline-sm font-semibold text-on-surface mt-2">UMS BUU (SSO)</h3>
                <p class="font-body-sm text-on-surface-variant mt-1 line-clamp-2">
                    ระบบยืนยันตัวตนกลาง ม.บูรพา &amp; จัดการบทบาทสิทธิ์ผู้ใช้งาน (UMS Identity Provider Hub)
                </p>
                <a href="{{ Route::has('demo.ums') ? route('demo.ums') : '#' }}" class="mt-3 w-full inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded bg-surface-container-lowest text-primary hover:bg-primary hover:text-on-primary font-label-md font-semibold transition-colors shadow-sm text-decoration-none border border-primary/20">
                    <span class="material-symbols-outlined text-[16px]">login</span>
                    <span>เข้าสู่ระบบ / สลับสิทธิ์ UMS</span>
                </a>
            </div>

            <div class="p-space-md rounded-lg bg-surface-container-low hover:bg-surface-container transition-all border border-surface-container-high/40">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>Standby
                    </span>
                    <span class="font-label-sm text-outline font-mono">pos_gateway</span>
                </div>
                <h3 class="font-headline-sm font-semibold text-on-surface mt-2">POS Real-Time Ledger</h3>
                <p class="font-body-sm text-on-surface-variant mt-1 line-clamp-2">
                    สตรีมคำนวณบิลขายหน้าร้าน พร้อมออกใบเสร็จรับเงินภาษีเต็มรูปและเกตเวย์ QR พร้อมเพย์
                </p>
                <button type="button" class="mt-3 w-full inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded bg-surface-container-lowest text-on-surface-variant hover:text-on-surface font-label-md font-medium transition-colors shadow-sm border border-surface-container-highest">
                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    <span>ตรวจสอบแคชเชียร์สแตนด์บาย</span>
                </button>
            </div>

            <div class="p-space-md rounded-lg bg-surface-container-low hover:bg-surface-container transition-all border border-surface-container-high/40">
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>Syncing
                    </span>
                    <span class="font-label-sm text-outline font-mono">wh_replenish</span>
                </div>
                <h3 class="font-headline-sm font-semibold text-on-surface mt-2">Inventory Matrix Auto-Stock</h3>
                <p class="font-body-sm text-on-surface-variant mt-1 line-clamp-2">
                    เชื่อมโยงคลังสินค้าคงคลัง ตรวจสอบจุดสั่งซื้อต่ำสุดพร้อมจัดกลุ่มล็อตสินค้าอัจฉริยะ
                </p>
                <button type="button" class="mt-3 w-full inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded bg-surface-container-lowest text-on-surface-variant hover:text-on-surface font-label-md font-medium transition-colors shadow-sm border border-surface-container-highest">
                    <span class="material-symbols-outlined text-[16px]">sync</span>
                    <span>ซิงค์ความคืบหน้าสต็อก</span>
                </button>
            </div>
        </div>
    </section>

    <!-- 3. Telemetry & KPI Cards Bar -->
    <section class="rounded-xl bg-surface-container-lowest p-space-md shadow-sm border border-surface-container-high/60">
        <div class="flex items-center justify-between pb-space-sm mb-space-sm border-b border-surface-container-high/40">
            <div class="flex items-center gap-2">
                <span class="font-headline-md font-semibold text-primary">Artisan POS &amp; Inventory Hub</span>
                <span class="px-2 py-0.5 rounded bg-surface-container-high text-outline font-label-sm font-mono">SYS-CORE-ONLINE</span>
            </div>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-secondary-container text-on-secondary-container font-label-sm font-semibold">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Online • Uptime 99.98%
            </span>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md">
            <!-- System Velocity -->
            <div class="lg:col-span-4 p-space-md rounded-lg bg-surface-container-low flex flex-col justify-between border border-surface-container-high/40">
                <div class="flex items-center justify-between text-on-surface-variant">
                    <span class="font-label-md uppercase tracking-wider font-semibold">System Velocity</span>
                    <span class="material-symbols-outlined text-[20px] text-primary">speed</span>
                </div>
                <div class="mt-2">
                    <div class="font-metric-lg text-2xl font-bold text-on-surface tracking-tight">$492.30 <span class="text-label-lg font-label-lg text-outline font-normal">AOV</span></div>
                    <div class="flex items-center gap-1 font-label-sm text-primary font-medium mt-1">
                        <span class="material-symbols-outlined text-[16px]">trending_up</span>
                        <span>+14.8% growth vs last period</span>
                    </div>
                </div>
            </div>

            <!-- Active Telemetry (Sparkline SVG) -->
            <div class="lg:col-span-4 p-space-md rounded-lg bg-surface-container-low flex flex-col justify-between border border-surface-container-high/40">
                <div class="flex items-center justify-between text-on-surface-variant">
                    <span class="font-label-md uppercase tracking-wider font-semibold">Active Telemetry</span>
                    <span class="px-2 py-0.5 rounded bg-primary text-on-primary font-label-sm font-bold">REAL-TIME</span>
                </div>
                <div class="w-full h-12 my-1">
                    <svg class="w-full h-full stroke-primary fill-primary/15" viewBox="0 0 200 40">
                        <path d="M0,32 Q25,28 50,30 T100,16 T150,22 T200,8 L200,40 L0,40 Z"></path>
                        <path d="M0,32 Q25,28 50,30 T100,16 T150,22 T200,8" fill="none" stroke-width="2.5"></path>
                    </svg>
                </div>
                <div class="flex items-center justify-between font-label-sm text-on-surface-variant">
                    <span class="text-primary font-label-md font-semibold">Zero Bottlenecks</span>
                    <span class="font-mono">0.14ms Latency</span>
                </div>
            </div>

            <!-- Sample Form Control -->
            <div class="lg:col-span-4 p-space-md rounded-lg bg-surface-container-low flex flex-col justify-between border border-surface-container-high/40">
                <div class="flex items-center justify-between text-on-surface-variant mb-1">
                    <span class="font-label-md uppercase tracking-wider font-semibold">Sample Form Control</span>
                    <span class="font-label-sm text-outline font-mono">Input Prepend</span>
                </div>
                <div class="flex rounded shadow-sm bg-surface-container-lowest border border-surface-container-high/60 overflow-hidden">
                    <span class="inline-flex items-center px-3 bg-surface-container-high text-on-surface-variant">
                        <span class="material-symbols-outlined text-[18px]">person</span>
                    </span>
                    <input class="w-full bg-transparent px-3 py-1.5 font-body-md text-on-surface focus:outline-none truncate" readonly type="text" value="{{ Auth::user()->email ?? 'pantakarn@buu.ac.th' }}">
                </div>
                <div class="flex gap-2 mt-2">
                    <button type="button" class="flex-1 py-1.5 rounded bg-primary hover:bg-primary-container text-on-primary font-label-md font-semibold transition-colors text-center cursor-pointer shadow-sm">
                        Primary Action
                    </button>
                    <button type="button" class="px-3 py-1.5 rounded bg-surface-container-high hover:bg-surface-container text-on-surface font-label-md font-medium transition-colors cursor-pointer border border-surface-container-highest">
                        Secondary
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Metric Counter Grid (4 Institutional Cards) -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
        <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm flex items-center gap-space-md border border-surface-container-high/60">
            <div class="w-12 h-12 rounded-lg bg-secondary-container text-on-secondary-container flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[26px]">groups</span>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="font-label-md text-outline truncate font-medium">ผู้ใช้งานในระบบ</span>
                <span class="font-metric-lg text-2xl font-bold text-on-surface font-mono">1,248</span>
                <span class="font-label-sm text-primary flex items-center gap-0.5 font-medium">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>+12% สัปดาห์นี้
                </span>
            </div>
        </div>

        <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm flex items-center gap-space-md border border-surface-container-high/60">
            <div class="w-12 h-12 rounded-lg bg-surface-container-high text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[26px]">verified_user</span>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="font-label-md text-outline uppercase truncate font-medium">Active Directory</span>
                <span class="font-headline-md font-bold text-on-surface truncate">BUU LDAP</span>
                <span class="font-label-sm text-primary flex items-center gap-1 font-medium">
                    <span class="material-symbols-outlined text-[14px]">check_circle</span>ซิงค์เรียบร้อย
                </span>
            </div>
        </div>

        <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm flex items-center gap-space-md border border-surface-container-high/60">
            <div class="w-12 h-12 rounded-lg bg-surface-container-high text-primary flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[26px]">database</span>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="font-label-md text-outline uppercase truncate font-medium">Database Matrix</span>
                <span class="font-headline-md font-bold text-on-surface truncate font-mono">MySQL 8.4</span>
                <span class="font-label-sm text-outline truncate font-mono">InnoDB utf8mb4</span>
            </div>
        </div>

        <div class="p-space-md rounded-xl bg-surface-container-lowest shadow-sm flex items-center gap-space-md border border-surface-container-high/60">
            <div class="w-12 h-12 rounded-lg bg-secondary-container text-on-secondary-container flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[26px]">history_edu</span>
            </div>
            <div class="flex flex-col min-w-0">
                <span class="font-label-md text-outline uppercase truncate font-medium">Audit Trail</span>
                <span class="font-metric-lg text-2xl font-bold text-on-surface truncate font-mono">5 Stamps</span>
                <span class="font-label-sm text-primary flex items-center gap-1 font-medium">
                    <span class="material-symbols-outlined text-[14px]">shield</span>มาตรฐานความปลอดภัย
                </span>
            </div>
        </div>
    </section>

    <!-- 5. WebAuthn / Passkey Biometrics Bar -->
    <section class="rounded-xl bg-surface-container-lowest p-space-md shadow-sm border border-surface-container-high/60">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-space-md">
            <div class="flex items-start gap-space-md">
                <div class="w-10 h-10 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center shrink-0 mt-0.5">
                    <span class="material-symbols-outlined text-[22px]">fingerprint</span>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="font-headline-sm font-bold text-on-surface">ระบบยืนยันตัวตนชีวมิติ (WebAuthn / Passkey Biometrics)</span>
                        <span class="hidden sm:inline-flex items-center gap-1 px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-sm font-semibold">
                            <span class="material-symbols-outlined text-[14px]">check</span> รองรับ Touch ID / Windows Hello
                        </span>
                    </div>
                    <p class="font-body-md text-on-surface-variant mt-0.5">
                        เข้าสู่ระบบด้วยลายนิ้วมือ Touch ID / Windows Hello แบบไร้รหัสผ่าน (Passwordless) ตามมาตรฐาน W3C WebAuthn &amp; FIDO2
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-space-sm w-full md:w-auto justify-end">
                <button class="p-2 rounded bg-surface-container-low hover:bg-surface-container text-on-surface-variant hover:text-on-surface transition-colors cursor-pointer border border-surface-container-high/60" id="btn-refresh-passkeys" title="รีเฟรช">
                    <span class="material-symbols-outlined text-[20px]">refresh</span>
                </button>
                <button class="inline-flex items-center gap-2 px-4 py-2 rounded bg-primary text-on-primary hover:bg-primary-container font-label-lg font-semibold transition-all shadow-sm cursor-pointer" id="btn-register-biometric" onclick="registerWebauthnBiometric()">
                    <span class="material-symbols-outlined text-[18px]">fingerprint</span>
                    <span>บันทึกลายนิ้วมือเครื่องนี้</span>
                </button>
            </div>
        </div>

        <div class="mt-space-md p-space-md rounded-lg bg-surface-container-low flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border border-surface-container-high/40">
            <div class="flex items-center gap-2 text-on-surface-variant font-body-sm">
                <span class="material-symbols-outlined text-[18px] text-outline">devices</span>
                <span>รายการอุปกรณ์และ Passkey ที่บันทึกไว้ในบัญชีของคุณ:</span>
                <span class="text-outline">ยังไม่มีการลงทะเบียนอุปกรณ์ลายนิ้วมือ คลิกปุ่ม “บันทึกลายนิ้วมือเครื่องนี้” ด้านบนเพื่อเริ่มใช้งาน</span>
            </div>
            <span class="px-2.5 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm font-mono">0 รายการ</span>
        </div>
    </section>

    <!-- 6. Dual Grid: Chart & Form UI Elements -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-space-md">
        <!-- Chart.js SVG Demo -->
        <div class="lg:col-span-7 rounded-xl bg-surface-container-lowest p-space-md shadow-sm flex flex-col justify-between border border-surface-container-high/60">
            <div>
                <div class="flex items-center justify-between pb-space-sm mb-space-sm border-b border-surface-container-high/40">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">insights</span>
                        <span class="font-headline-sm font-semibold text-on-surface">สถิติการใช้งานระบบ (Chart.js Interactive Demo)</span>
                    </div>
                    <span class="px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-sm font-semibold">Realtime</span>
                </div>
                <div class="flex items-center gap-4 text-on-surface-variant font-label-sm mb-2">
                    <span class="inline-flex items-center gap-1.5 font-medium">
                        <span class="w-3 h-3 rounded bg-primary"></span> การเข้าใช้งานระบบรายวัน (Logins)
                    </span>
                    <span class="text-outline">อัปเดตอัตโนมัติทุก 60 วินาที</span>
                </div>
                <div class="w-full h-64 relative bg-surface-container-low rounded-lg p-space-md flex flex-col justify-between border border-surface-container-high/40">
                    <div class="flex justify-between text-outline font-label-sm font-mono">
                        <span>550</span><span>ยอดเข้าชมสูงสุด (520)</span>
                    </div>
                    <svg class="w-full h-40 overflow-visible" viewBox="0 0 500 160">
                        <defs>
                            <linearGradient id="chartEmeraldGrad" x1="0%" x2="0%" y1="0%" y2="100%">
                                <stop offset="0%" stop-color="#10B981" stop-opacity="0.45"></stop>
                                <stop offset="70%" stop-color="#047857" stop-opacity="0.15"></stop>
                                <stop offset="100%" stop-color="#047857" stop-opacity="0.0"></stop>
                            </linearGradient>
                        </defs>
                        <path d="M 10 135 C 70 120, 110 90, 170 80 C 230 70, 270 20, 340 18 C 400 16, 440 95, 490 125 L 490 160 L 10 160 Z" fill="url(#chartEmeraldGrad)"></path>
                        <path d="M 10 135 C 70 120, 110 90, 170 80 C 230 70, 270 20, 340 18 C 400 16, 440 95, 490 125" fill="none" stroke="#047857" stroke-linecap="round" stroke-width="3"></path>
                        <circle cx="10" cy="135" r="4" fill="#047857" stroke="#ffffff" stroke-width="2"></circle>
                        <circle cx="90" cy="115" r="4" fill="#047857" stroke="#ffffff" stroke-width="2"></circle>
                        <circle cx="170" cy="80" r="4" fill="#047857" stroke="#ffffff" stroke-width="2"></circle>
                        <circle cx="255" cy="40" r="4" fill="#047857" stroke="#ffffff" stroke-width="2"></circle>
                        <circle cx="340" cy="18" r="5" fill="#047857" stroke="#ffffff" stroke-width="2"></circle>
                        <circle cx="420" cy="98" r="4" fill="#047857" stroke="#ffffff" stroke-width="2"></circle>
                        <circle cx="490" cy="125" r="4" fill="#047857" stroke="#ffffff" stroke-width="2"></circle>
                    </svg>
                    <div class="flex justify-between text-on-surface-variant font-label-sm pt-1">
                        <span>จันทร์</span><span>อังคาร</span><span>พุธ</span><span>พฤหัสบดี</span><span>ศุกร์</span><span>เสาร์</span><span>อาทิตย์</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between pt-space-sm text-outline font-label-sm">
                <span>บันทึกทราฟฟิกข้อมูลคลัสเตอร์ BUU-FIN-CLUSTER-04</span>
                <span class="text-primary font-label-md font-semibold">ค่าเฉลี่ย 384 ครั้ง/วัน</span>
            </div>
        </div>

        <!-- Form UI Elements -->
        <div class="lg:col-span-5 rounded-xl bg-surface-container-lowest p-space-md shadow-sm flex flex-col justify-between border border-surface-container-high/60">
            <div>
                <div class="flex items-center justify-between pb-space-sm mb-space-sm border-b border-surface-container-high/40">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">tune</span>
                        <span class="font-headline-sm font-semibold text-on-surface">ส่วนประกอบฟอร์ม (Form UI Elements)</span>
                    </div>
                    <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-label-sm">Interactive</span>
                </div>
                <form class="space-y-space-md" onsubmit="event.preventDefault()">
                    <div>
                        <label class="block font-label-md font-semibold text-on-surface mb-1">สังกัด / คณะ (Select2 Searchable Dropdown):</label>
                        <div class="relative">
                            <select class="w-full h-10 px-3 rounded bg-surface-container-low text-on-surface font-body-md focus:bg-surface-container-lowest focus:outline-none focus:ring-1 focus:ring-primary appearance-none cursor-pointer border border-surface-container-high/60">
                                <option value="">---เลือก---</option>
                                <option value="buu_inf">คณะวิทยาการสารสนเทศ (Informatics)</option>
                                <option value="buu_eng">คณะวิศวกรรมศาสตร์</option>
                                <option value="buu_med">คณะแพทยศาสตร์</option>
                                <option value="buu_mgt">คณะการจัดการและการท่องเที่ยว</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-2.5 text-outline pointer-events-none text-[20px]">expand_more</span>
                        </div>
                        <p class="mt-1 font-body-sm text-outline">ค้นหาตัวเลือกได้ทันที พร้อม Placeholder มาตรฐาน <code class="text-primary">---เลือก---</code></p>
                    </div>

                    <div>
                        <label class="block font-label-md font-semibold text-on-surface mb-1">วันที่เริ่มต้นโครงการ (jQuery UI Datepicker พ.ศ.):</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-outline text-[20px]">calendar_month</span>
                            <input class="w-full h-10 pl-10 pr-3 rounded bg-surface-container-low text-on-surface font-body-md focus:bg-surface-container-lowest focus:outline-none focus:ring-1 focus:ring-primary border border-surface-container-high/60" placeholder="วว/ดด/ปปปป (พ.ศ.)" type="text" value="24/10/2567">
                        </div>
                        <p class="mt-1 font-body-sm text-outline">ปฏิทินไทยปี พ.ศ. (+543) พร้อมปุ่ม “ล้างค่า” ตามมาตรฐาน MA BUCC</p>
                    </div>

                    <div>
                        <label class="block font-label-md font-semibold text-on-surface mb-1">งบประมาณโครงการ (AutoNumeric Masking):</label>
                        <div class="flex rounded bg-surface-container-low border border-surface-container-high/60 overflow-hidden">
                            <span class="inline-flex items-center px-3.5 bg-surface-container-high text-on-surface-variant font-label-md font-semibold">THB</span>
                            <input class="w-full h-10 px-3 bg-transparent text-on-surface font-body-md text-right font-mono font-semibold focus:outline-none focus:bg-surface-container-lowest" type="text" value="฿ 1,850,000.00">
                        </div>
                        <p class="mt-1 font-body-sm text-outline">จัดรูปแบบอัตราแลกเปลี่ยนและคั่นหลักพันอัตโนมัติขณะพิมพ์</p>
                    </div>
                </form>
            </div>
            <div class="pt-space-sm flex justify-end gap-2 border-t border-surface-container-high/40">
                <button type="button" class="px-3 py-1.5 rounded bg-surface-container-high hover:bg-surface-container text-on-surface-variant font-label-md font-medium transition-colors cursor-pointer border border-surface-container-highest">
                    รีเซ็ตค่าฟอร์ม
                </button>
                <button type="button" class="px-4 py-1.5 rounded bg-primary hover:bg-primary-container text-on-primary font-label-md font-semibold transition-colors shadow-sm cursor-pointer">
                    บันทึกฟิลด์ทดสอบ
                </button>
            </div>
        </div>
    </section>

    <!-- 7. DataTables & Dropzone -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-space-md">
        <!-- DataGrid DataTables -->
        <div class="lg:col-span-8 rounded-xl bg-surface-container-lowest p-space-md shadow-sm flex flex-col justify-between border border-surface-container-high/60">
            <div>
                <div class="flex items-center justify-between pb-space-sm mb-space-sm border-b border-surface-container-high/40">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">table_chart</span>
                        <span class="font-headline-sm font-semibold text-on-surface">ตารางข้อมูลสารสนเทศ (DataTables Bootstrap 5)</span>
                    </div>
                    <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-label-sm font-semibold">Data Grid</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left font-body-md border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low text-on-surface-variant font-label-md">
                                <th class="py-2.5 px-3 rounded-l">#รหัส</th>
                                <th class="py-2.5 px-3">ชื่อโมดูล / ระบบงาน</th>
                                <th class="py-2.5 px-3">ผู้รับผิดชอบ</th>
                                <th class="py-2.5 px-3 text-center">วันที่ (พ.ศ.)</th>
                                <th class="py-2.5 px-3 rounded-r text-center">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container-high/60 font-body-sm">
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="py-2.5 px-3 font-mono font-semibold text-primary">#MD-01</td>
                                <td class="py-2.5 px-3 font-medium text-on-surface">Active Directory &amp; LDAP Service</td>
                                <td class="py-2.5 px-3 text-on-surface-variant flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-primary">person</span> System Admin
                                </td>
                                <td class="py-2.5 px-3 text-center font-mono">15/10/2569</td>
                                <td class="py-2.5 px-3 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-secondary-container text-on-secondary-container font-label-sm font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>พร้อมใช้งาน
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="py-2.5 px-3 font-mono font-semibold text-primary">#MD-02</td>
                                <td class="py-2.5 px-3 font-medium text-on-surface">Role &amp; Permission Access Control</td>
                                <td class="py-2.5 px-3 text-on-surface-variant flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-primary">security</span> Security Auditor
                                </td>
                                <td class="py-2.5 px-3 text-center font-mono">14/10/2569</td>
                                <td class="py-2.5 px-3 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-secondary-container text-on-secondary-container font-label-sm font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>พร้อมใช้งาน
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container-low/50 transition-colors">
                                <td class="py-2.5 px-3 font-mono font-semibold text-primary">#MD-03</td>
                                <td class="py-2.5 px-3 font-medium text-on-surface">5 Audit Stamps Pipeline Monitor</td>
                                <td class="py-2.5 px-3 text-on-surface-variant flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-outline">storage</span> DBA Architect
                                </td>
                                <td class="py-2.5 px-3 text-center font-mono">12/10/2569</td>
                                <td class="py-2.5 px-3 text-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-surface-container-high text-on-surface-variant font-label-sm font-semibold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>กำลังประมวลผล
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex items-center justify-between pt-space-sm text-outline font-label-sm border-t border-surface-container-high/40 mt-3">
                <span>แสดง 1 ถึง 3 จากทั้งหมด 3 รายการ</span>
                <span class="text-primary font-semibold">DataTables BS 5.3 Active</span>
            </div>
        </div>

        <!-- Dropzone Box -->
        <div class="lg:col-span-4 rounded-xl bg-surface-container-lowest p-space-md shadow-sm flex flex-col justify-between border border-surface-container-high/60">
            <div>
                <div class="flex items-center justify-between pb-space-sm mb-space-sm border-b border-surface-container-high/40">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">cloud_upload</span>
                        <span class="font-headline-sm font-semibold text-on-surface">ระบบอัปโหลดไฟล์ (Dropzone)</span>
                    </div>
                    <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-label-sm">Upload Vault</span>
                </div>
                <div class="group relative rounded-xl bg-surface-container-low hover:bg-surface-container p-space-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all border border-dashed border-primary/40" id="dropzone-box">
                    <div class="w-14 h-14 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center mb-3 group-hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined text-[32px]">upload_file</span>
                    </div>
                    <h4 class="font-headline-sm font-semibold text-on-surface">ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเลือกไฟล์</h4>
                    <p class="font-body-sm text-on-surface-variant mt-1 max-w-xs">
                        รองรับไฟล์เอกสาร PDF, PNG, JPG, DOCX (จำลองการทดสอบ Client-side Encrypted)
                    </p>
                    <div class="mt-4 inline-flex items-center gap-1.5 px-3 py-1 rounded bg-surface-container-lowest text-primary font-label-sm shadow-sm font-semibold border border-primary/20">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        <span>Client AES-256 Validated</span>
                    </div>
                    <input class="hidden" id="dropzone-input" multiple type="file">
                </div>
            </div>
            <div class="flex items-center justify-between pt-space-sm font-label-sm text-outline border-t border-surface-container-high/40 mt-3">
                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">lock</span> Max upload: 10MB</span>
                <span class="text-primary font-medium">AutoPreview Enabled</span>
            </div>
        </div>
    </section>

    <!-- 8. Component Showcase (Buttons with Danger variants) -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
        <!-- Button Styles & Actions -->
        <div class="rounded-xl bg-surface-container-lowest p-space-md shadow-sm flex flex-col gap-space-md border border-surface-container-high/60">
            <div class="flex items-center justify-between pb-space-xs border-b border-surface-container-high/40">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[20px]">smart_button</span>
                    <span class="font-headline-sm font-semibold text-on-surface">ชุดปุ่มและสถานะการโต้ตอบ (Button Styles &amp; Actions)</span>
                </div>
                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-label-sm font-semibold">Actions</span>
            </div>
            <div class="flex flex-col gap-2">
                <span class="font-label-md text-on-surface-variant font-medium">1. ปุ่มสีหลักความเข้ม (Solid Variants):</span>
                <div class="flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary inline-flex items-center gap-1.5 px-3.5 py-2 rounded bg-primary text-on-primary hover:bg-primary-container font-label-md font-semibold transition-colors shadow-sm cursor-pointer border-0">
                        <span class="material-symbols-outlined text-[18px]">done</span> Primary Action
                    </button>
                    <button type="button" class="btn btn-secondary inline-flex items-center gap-1.5 px-3.5 py-2 rounded bg-secondary text-on-secondary hover:bg-primary-container font-label-md font-semibold transition-colors cursor-pointer border-0">
                        <span class="material-symbols-outlined text-[18px]">tune</span> Secondary Action
                    </button>
                    <button type="button" class="btn btn-success inline-flex items-center gap-1.5 px-3.5 py-2 rounded bg-emerald-600 text-white font-label-md font-semibold cursor-pointer border-0">
                        <span class="material-symbols-outlined text-[18px]">verified</span> Success (Emerald)
                    </button>
                    <!-- Danger Buttons required by test suite -->
                    <button type="button" class="btn btn-danger inline-flex items-center gap-1.5 px-3.5 py-2 rounded bg-red-600 text-white hover:bg-red-700 font-label-md font-semibold cursor-pointer border-0">
                        <span class="material-symbols-outlined text-[18px]">error</span> Danger Action
                    </button>
                    <button type="button" class="btn btn-outline-danger inline-flex items-center gap-1.5 px-3.5 py-2 rounded border border-red-600 text-red-600 hover:bg-red-50 font-label-md font-semibold cursor-pointer bg-transparent">
                        <span class="material-symbols-outlined text-[18px]">warning</span> Outline Danger
                    </button>
                </div>
            </div>
        </div>

        <!-- Icons Set -->
        <div class="rounded-xl bg-surface-container-lowest p-space-md shadow-sm flex flex-col gap-space-md border border-surface-container-high/60">
            <div class="flex items-center justify-between pb-space-xs border-b border-surface-container-high/40">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[20px]">category</span>
                    <span class="font-headline-sm font-semibold text-on-surface">คลังไอคอนระบบ (Bootstrap &amp; Material Icons)</span>
                </div>
                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-label-sm font-semibold">Icons Set</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                <div class="p-3 rounded-lg bg-surface-container-low flex flex-col items-center text-center gap-1 hover:bg-surface-container transition-colors border border-surface-container-high/40">
                    <span class="material-symbols-outlined text-primary text-[28px]">speed</span>
                    <span class="font-label-sm font-semibold text-on-surface">Dashboard</span>
                    <span class="font-body-sm text-outline text-[11px] font-mono">speedometer2</span>
                </div>
                <div class="p-3 rounded-lg bg-surface-container-low flex flex-col items-center text-center gap-1 hover:bg-surface-container transition-colors border border-surface-container-high/40">
                    <span class="material-symbols-outlined text-primary text-[28px]">shield</span>
                    <span class="font-label-sm font-semibold text-on-surface">Security</span>
                    <span class="font-body-sm text-outline text-[11px] font-mono">shield-lock</span>
                </div>
                <div class="p-3 rounded-lg bg-surface-container-low flex flex-col items-center text-center gap-1 hover:bg-surface-container transition-colors border border-surface-container-high/40">
                    <span class="material-symbols-outlined text-primary text-[28px]">fingerprint</span>
                    <span class="font-label-sm font-semibold text-on-surface">Biometrics</span>
                    <span class="font-body-sm text-outline text-[11px] font-mono">fingerprint</span>
                </div>
                <div class="p-3 rounded-lg bg-surface-container-low flex flex-col items-center text-center gap-1 hover:bg-surface-container transition-colors border border-surface-container-high/40">
                    <span class="material-symbols-outlined text-primary text-[28px]">database</span>
                    <span class="font-label-sm font-semibold text-on-surface">Database</span>
                    <span class="font-body-sm text-outline text-[11px] font-mono">database-gear</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. Institutional Footer Audit Stamp -->
    <footer class="rounded-xl bg-surface-container-lowest p-space-md shadow-sm flex flex-col sm:flex-row items-center justify-between gap-space-sm border border-surface-container-high/60">
        <div class="flex items-center gap-space-sm">
            <div class="w-8 h-8 rounded bg-secondary-container text-on-secondary-container flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[18px]">verified</span>
            </div>
            <div class="flex flex-col">
                <span class="font-headline-sm font-semibold text-on-surface">มาตรฐานฐานข้อมูล 5 Audit Stamps (model-migration-audit-stamps)</span>
                <span class="font-body-sm text-outline font-mono">created_by • created_at • updated_by • updated_at • request_uri</span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm tracking-wide uppercase font-semibold">
                Audit Compliant
            </span>
            <span class="font-label-sm text-outline font-mono">v4.8-EMERALD</span>
        </div>
    </footer>
</div>
@endsection

@section('scripts')
<script>
    // SweetAlert2 Demo
    const btnSwal = document.getElementById('btn-swal-demo');
    if (btnSwal) {
        btnSwal.addEventListener('click', () => {
            if (typeof window.artisanNotify !== 'undefined') {
                window.artisanNotify.success('SweetAlert2 Connected', 'ArtisanCraft Engine & Emerald Enterprise Design System กำลังทำงาน 100%!');
            } else {
                alert('SweetAlert2 Connected: Emerald Enterprise Theme Active!');
            }
        });
    }

    // WebAuthn / Passkey Biometric Registration
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
        const registerBtn = document.getElementById('btn-register-biometric');
        const origBtnHtml = registerBtn ? registerBtn.innerHTML : '';
        if (registerBtn) {
            registerBtn.disabled = true;
            registerBtn.innerHTML = '<span class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span> <span>กำลังเชื่อมต่ออุปกรณ์...</span>';
        }

        try {
            const optRes = await fetch('{{ route("webauthn.register.options") }}', {
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

            const verifyRes = await fetch('{{ route("webauthn.register.verify") }}', {
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
                    confirmButtonColor: '#047857'
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
                    confirmButtonColor: '#047857'
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

    // Dropzone Box Click
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
</script>
@endsection
