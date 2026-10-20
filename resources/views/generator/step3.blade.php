@extends('layouts.artisan')

@section('title', 'Step 3: Pre-built Modules & Data Modeling')

@section('content')
@php
    $useUmsBuuFromStep1 = $useUmsBuuFromStep1 ?? session('project.use_ums_buu', false);
    $savedModules = $savedModules ?? session('project.modules', null);
    $isModuleChecked = function($name) use ($savedModules, $useUmsBuuFromStep1) {
        if ($useUmsBuuFromStep1) {
            if ($name === 'ums_buu') return true;
            if ($name === 'buu_ldap') return false;
        }
        if ($savedModules === null) {
            return $name === 'buu_ldap'; // เริ่มต้นให้เป็น เปิด สำหรับ BUU LDAP (Default ON) และ ปิด สำหรับโมดูลอื่น (Default OFF)
        }
        return !empty($savedModules[$name]);
    };
    $activeCount = $savedModules !== null ? count(array_filter($savedModules)) : 1;
    if ($useUmsBuuFromStep1 && $savedModules === null) {
        $activeCount = 1;
    }
@endphp

<div class="flex flex-col w-full">
    <form method="POST" action="{{ route('generator.step3.save') }}" id="step3-form" class="w-full">
        @csrf
        <input type="hidden" name="schemas_json" id="schemas-json-input" value="">

        <div class="w-full px-space-lg py-space-md flex flex-col gap-space-md">
            <!-- Top Step Bar & Contextual Banner -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-sm bg-surface-container-low p-space-md rounded-xl shadow-sm">
                <div class="flex items-start gap-space-sm">
                    <div class="w-11 h-11 rounded-xl bg-surface-container-high border border-surface-container-highest flex items-center justify-center font-code-inline text-headline-sm font-bold text-primary shadow-sm shrink-0">03</div>
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-space-xs flex-wrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-surface-container-highest text-primary font-label-sm text-label-sm font-semibold uppercase tracking-wider">
                                <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                                Pipeline Step 03 / 05
                            </span>
                            <span class="text-outline font-code-inline text-label-sm">|</span>
                            <span class="text-secondary font-code-inline text-label-sm">Enterprise Modules Scaffolding</span>
                        </div>
                        <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold tracking-tight">Pre-built Enterprise Modules</h1>
                        <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">
                            เปิด-ปิดโมดูลระบบมาตรฐานระดับโปรดักชัน พร้อมคอนโทรลเลอร์, ไมเกรชัน, ซี้ดเดอร์ และหน้าจอ Bootstrap 5 ครบชุด
                        </p>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="flex items-center gap-space-sm">
                    <div class="flex items-center gap-space-xs px-space-md py-1.5 rounded-lg bg-surface-container-highest text-on-surface font-body-sm text-body-sm">
                        <span class="material-symbols-outlined text-[18px] text-tertiary">widgets</span>
                        <span class="text-on-surface-variant">Active Modules:</span>
                        <span class="px-2 py-0.5 rounded-full bg-black/35 text-white font-code-inline text-[11px] font-bold border border-white/20 shadow-inner" id="active-modules-count">{{ $activeCount }} Active</span>
                    </div>
                    <div class="hidden lg:flex items-center gap-space-xs px-space-md py-1.5 rounded-lg bg-surface-container text-on-surface-variant font-code-block text-code-block">
                        <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                        <span>Full-Stack Auth</span>
                    </div>
                </div>
            </div>

            <!-- Pre-built Modules Section -->
            <div class="flex flex-col gap-space-md">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="font-headline-sm text-headline-sm text-on-surface">ระบบพื้นฐานและโมดูลสำเร็จรูป</span>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">เปิด-ปิดโมดูลระบบมาตรฐานระดับโปรดักชัน พร้อมคอนโทรลเลอร์, ไมเกรชัน, ซี้ดเดอร์ และหน้าจอ Bootstrap 5 ครบชุด</p>
                    </div>
                    <div class="flex items-center gap-space-xs font-label-sm text-label-sm text-outline">
                        <span class="material-symbols-outlined text-[16px] text-tertiary">check_circle</span>
                        <span>ตรวจสอบ Dependency อัตโนมัติ</span>
                    </div>
                </div>

                <!-- Bento Grid for Module Cards (4 Core Enterprise Modules) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
                    <!-- Module Card 1: BUU LDAP & Active Directory -->
                    <div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all group border-2 {{ $useUmsBuuFromStep1 ? 'border-surface-container-highest/40 opacity-60' : 'border-emerald-500/40 hover:border-emerald-500/70 shadow-[0_0_20px_rgba(16,185,129,0.08)]' }} relative overflow-hidden">
                        <div class="flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between">
                                <div class="relative">
                                    <div class="w-10 h-10 rounded-lg bg-primary-container/25 text-primary flex items-center justify-center border border-primary/30 shadow-sm">
                                        <span class="material-symbols-outlined text-[22px]">badge</span>
                                    </div>
                                    @if(!$useUmsBuuFromStep1)
                                    <span class="absolute -top-1.5 -right-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-emerald-600 text-white text-[10px] font-bold shadow-sm" title="แนะนำสำหรับ ม.บูรพา">
                                        ★
                                    </span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2.5">
                                    @if($useUmsBuuFromStep1)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-highest/70 text-outline border border-surface-container-highest font-code-inline text-[11px] font-semibold tracking-wide shadow-sm">
                                        <span class="material-symbols-outlined text-[14px]">lock_clock</span> DISABLED (UMS ACTIVE)
                                    </span>
                                    <label class="relative inline-flex items-center cursor-not-allowed">
                                        <input disabled class="sr-only peer module-checkbox" name="modules[buu_ldap]" value="1" type="checkbox">
                                        <div class="w-9 h-5 bg-surface-container-highest rounded-full opacity-40 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-surface-variant after:rounded-full after:h-4 after:w-4"></div>
                                    </label>
                                    @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 font-code-inline text-[11px] font-semibold tracking-wide shadow-sm">
                                        <span class="material-symbols-outlined text-[13px]">push_pin</span> PINNED
                                    </span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input {{ $isModuleChecked('buu_ldap') ? 'checked' : '' }} class="sr-only peer module-checkbox" name="modules[buu_ldap]" value="1" onchange="toggleModuleStatus(this, 'badge-ldap')" type="checkbox">
                                        <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-tertiary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-tertiary after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                                    </label>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-space-xs flex-wrap">
                                <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">BUU LDAP &amp; Active Directory</span>
                                @if(!$useUmsBuuFromStep1)
                                <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300 dark:bg-emerald-500/20 dark:text-emerald-300 dark:border-emerald-500/30 font-label-sm text-[11px] font-semibold">
                                    <span class="material-symbols-outlined text-[13px] text-emerald-600 dark:text-emerald-400">verified</span> แนะนำ
                                </span>
                                @endif
                                <span class="px-1.5 py-0.2 rounded {{ $isModuleChecked('buu_ldap') ? 'bg-tertiary-container/30 text-tertiary' : 'bg-surface-container text-outline' }} font-label-sm text-label-sm font-code-inline" id="badge-ldap">{{ $isModuleChecked('buu_ldap') ? 'ENABLED' : 'DISABLED' }}</span>
                            </div>
                            @if($useUmsBuuFromStep1)
                            <div class="p-2 rounded bg-surface-container-highest/50 border border-surface-container-highest text-[12px] text-outline font-body-sm">
                                🔒 โมดูลนี้ถูกปิดการใช้งานเนื่องจากคุณเลือกเปิดใช้ <strong>UMS BUU</strong> ในขั้นตอนที่ 1 แล้ว (Mutually Exclusive)
                            </div>
                            @endif
                            <p class="font-body-sm text-body-sm text-on-surface-variant">ระบบยืนยันตัวตน Active Directory (LDAP) มหาวิทยาลัยบูรพา พร้อมตาราง <span class="font-code-inline text-primary">users</span>, <span class="font-code-inline text-tertiary">users_credentials</span> (Passkey), โมเดล <span class="font-code-inline">UsersModel</span>, <span class="font-code-inline">UsersCredentialsModel</span>, Middleware <span class="font-code-inline text-tertiary">EnsureActiveUser</span>, Rate Limiting และ Local Fallback</p>
                            <div class="flex flex-wrap gap-1 pt-1">
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">UsersModel &amp; users_credentials</span>
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">EnsureActiveUser Middleware</span>
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">sec-login-rate-limit</span>
                                <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 border border-emerald-300 dark:bg-emerald-500/15 dark:text-emerald-300 dark:border-emerald-500/20 font-label-sm text-label-sm font-medium">★ Full-Stack Auth</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-space-md text-outline font-label-sm text-label-sm font-code-block">
                            <span>1 Controller · 1 Middleware · 2 Models · 2 Migrations</span>
                            <span class="text-emerald-600 dark:text-emerald-400 flex items-center gap-0.5 font-semibold"><span class="material-symbols-outlined text-[14px]">push_pin</span>PINNED · Synced</span>
                        </div>
                    </div>

                    <!-- Module Card 2: UMS BUU (Single Sign-On & Identity Gateway) -->
                    <div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all group border {{ $useUmsBuuFromStep1 ? 'border-primary/50 shadow-md ring-1 ring-primary/20' : 'border-surface-container-high/60' }} shadow-sm relative overflow-hidden">
                        <div class="flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between">
                                <div class="w-10 h-10 rounded-lg bg-primary-container/25 text-primary flex items-center justify-center border border-primary/30 shadow-sm">
                                    <span class="material-symbols-outlined text-[22px]">hub</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    @if($useUmsBuuFromStep1)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 font-code-inline text-[11px] font-semibold tracking-wide shadow-sm">
                                        <span class="material-symbols-outlined text-[14px]">lock</span> LOCKED BY STEP 1
                                    </span>
                                    <label class="relative inline-flex items-center cursor-not-allowed">
                                        <input checked disabled class="sr-only peer module-checkbox" type="checkbox">
                                        <input type="hidden" name="modules[ums_buu]" value="1">
                                        <div class="w-9 h-5 bg-tertiary-container peer-focus:outline-none rounded-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-tertiary after:rounded-full after:h-4 after:w-4 after:translate-x-full after:transition-all"></div>
                                    </label>
                                    @else
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input {{ $isModuleChecked('ums_buu') ? 'checked' : '' }} class="sr-only peer module-checkbox" name="modules[ums_buu]" value="1" onchange="toggleModuleStatus(this, 'badge-ums')" type="checkbox">
                                        <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-tertiary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-tertiary after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                                    </label>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-space-xs flex-wrap">
                                <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">UMS BUU</span>
                                <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 border border-blue-300 dark:bg-blue-500/20 dark:text-blue-300 dark:border-blue-500/30 font-label-sm text-[11px] font-semibold">
                                    <span class="material-symbols-outlined text-[13px] text-blue-600 dark:text-blue-400">vpn_key</span> SSO Portal
                                </span>
                                <span class="px-1.5 py-0.2 rounded {{ $isModuleChecked('ums_buu') ? 'bg-tertiary-container/30 text-tertiary' : 'bg-surface-container text-outline' }} font-label-sm text-label-sm font-code-inline" id="badge-ums">{{ $isModuleChecked('ums_buu') ? 'ENABLED' : 'DISABLED' }}</span>
                            </div>
                            @if($useUmsBuuFromStep1)
                            <div class="p-2 rounded bg-tertiary-container/15 border border-tertiary/30 text-[12px] text-tertiary font-body-sm">
                                🔒 โมดูลนี้ถูกเปิดใช้งานและล็อกไว้ตามที่คุณเลือก <strong>UMS BUU Integration</strong> จากขั้นตอนที่ 1
                            </div>
                            @endif
                            <p class="font-body-sm text-body-sm text-on-surface-variant">ระบบยืนยันตัวตนกลาง มหาวิทยาลัยบูรพา (UMS BUU) พร้อมระบบ Mock Login จำลองเข้าใช้งานแบบ SSO สำหรับกลุ่มอาจารย์ เจ้าหน้าที่ และนิสิต พร้อมโครงสร้าง Config และ Controller รองรับการต่อ API จริง</p>
                            <div class="flex flex-wrap gap-1 pt-1">
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">UmsBuuAuthService</span>
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">Mock SSO Gateway</span>
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">UmsBuuController</span>
                                <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 border border-blue-300 dark:bg-blue-500/15 dark:text-blue-300 dark:border-blue-500/20 font-label-sm text-label-sm font-medium">★ Mock Ready</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-space-md text-outline font-label-sm text-label-sm font-code-block">
                            <span>1 Controller · 1 Service · 1 View · Config</span>
                            <span class="text-tertiary flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">done_all</span>Synced</span>
                        </div>
                    </div>

                    <!-- Module Card 3: Audit Trail -->
                    <div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all group">
                        <div class="flex flex-col gap-space-sm">
                            <div class="flex items-start justify-between">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest text-primary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[22px]">history_edu</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input {{ $isModuleChecked('audit_trail') ? 'checked' : '' }} class="sr-only peer module-checkbox" name="modules[audit_trail]" value="1" onchange="toggleModuleStatus(this, 'badge-audit')" type="checkbox">
                                    <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-tertiary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-tertiary after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                                </label>
                            </div>
                            <div class="flex items-center gap-space-xs">
                                <span class="font-headline-sm text-headline-sm text-on-surface">Audit Trail &amp; Activity Log</span>
                                <span class="px-1.5 py-0.2 rounded {{ $isModuleChecked('audit_trail') ? 'bg-tertiary-container/30 text-tertiary' : 'bg-surface-container text-outline' }} font-label-sm text-label-sm font-code-inline" id="badge-audit">{{ $isModuleChecked('audit_trail') ? 'ENABLED' : 'DISABLED' }}</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">บันทึกประวัติการเปลี่ยนแปลงข้อมูลของ Eloquent Model ทุกตัวอัตโนมัติ เก็บ ID ผู้ทำรายการ, IP Address, User-Agent พร้อมเปรียบเทียบข้อมูลก่อนและหลังแก้ไขแบบ JSON diff</p>
                            <div class="flex flex-wrap gap-1 pt-1">
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">LogsActivity Trait</span>
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">JSON Payload</span>
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">Batch Pruning</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-space-md text-outline font-label-sm text-label-sm font-code-block">
                            <span>1 Migration · 1 Viewer UI</span>
                            <span class="text-tertiary flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">done_all</span>Synced</span>
                        </div>
                    </div>

                    <!-- Module Card 4: Notification System -->
                    <div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-low hover:bg-surface-container transition-all group">
                        <div class="flex flex-col gap-space-sm">
                            <div class="flex items-start justify-between">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest text-tertiary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[22px]">notifications_active</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input {{ $isModuleChecked('notifications') ? 'checked' : '' }} class="sr-only peer module-checkbox" name="modules[notifications]" value="1" onchange="toggleModuleStatus(this, 'badge-notif')" type="checkbox">
                                    <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-surface peer-checked:bg-tertiary-container after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-on-tertiary after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                                </label>
                            </div>
                            <div class="flex items-center gap-space-xs">
                                <span class="font-headline-sm text-headline-sm text-on-surface">Notification Engine</span>
                                <span class="px-1.5 py-0.2 rounded {{ $isModuleChecked('notifications') ? 'bg-tertiary-container/30 text-tertiary' : 'bg-surface-container text-outline' }} font-label-sm text-label-sm font-code-inline" id="badge-notif">{{ $isModuleChecked('notifications') ? 'ENABLED' : 'DISABLED' }}</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">ระบบศูนย์แจ้งเตือนกิจกรรม พร้อมตาราง <span class="font-code-inline text-primary">notifications</span>, โมเดล <span class="font-code-inline">NotificationsModel</span>, คอนโทรลเลอร์ <span class="font-code-inline">NotificationController</span>, จัดการอ่านแล้ว/ลบแจ้งเตือน และ 5 Audit Stamps</p>
                            <div class="flex flex-wrap gap-1 pt-1">
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">NotificationsModel</span>
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">Database Channel</span>
                                <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">Mark Read &amp; Delete</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-space-md text-outline font-label-sm text-label-sm font-code-block">
                            <span>1 Migration · Controller &amp; View</span>
                            <span class="text-tertiary flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">done_all</span>Synced</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Database Schema & Entity Architecture Preview (Real-time synced with selected modules) -->
            <div class="flex flex-col gap-space-md p-space-lg rounded-xl bg-surface-container-low border border-surface-container-high/60 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-space-sm border-b border-surface-container pb-space-sm">
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-[20px] text-primary">schema</span>
                        <div>
                            <span class="font-headline-sm text-headline-sm text-on-surface font-semibold">Live Database Schema &amp; Model Architecture</span>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">ผังตารางและโมเดล Eloquent ที่จะถูกสร้างจริงตามโมดูลที่เลือก พร้อมมาตรฐาน 5 Audit Stamps ทุกตาราง</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-tertiary-container/20 text-tertiary font-label-sm text-[11px] font-semibold border border-tertiary/30">
                            <span class="material-symbols-outlined text-[14px]">verified</span>
                            <span>Audit Stamps Standard: COMPLIANT</span>
                        </span>
                    </div>
                </div>

                <!-- Bento Grid of Schema Cards for Each Selected Module -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-md" id="schema-grid">
                    <!-- Base Users Table (Always present) -->
                    <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest/60 flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <span class="font-code-inline text-on-surface font-bold text-sm">users</span>
                            <span class="px-2 py-0.5 rounded bg-primary-container/30 text-primary font-code-inline text-[11px]">UsersModel.php</span>
                        </div>
                        <div class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
                            <div class="text-secondary font-mono">PK: user_id (bigint) | FK: role_id</div>
                            <div>Columns: name, username, email, citizen_id, password, role_id, active</div>
                            <div class="mt-2 pt-1 border-t border-surface-container-highest/60 flex flex-wrap gap-1">
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">created_by</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">created_at</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">updated_by</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">updated_at</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">request_uri</span>
                            </div>
                        </div>
                    </div>

                    <!-- LDAP Credentials Table -->
                    <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest/60 flex flex-col gap-2 {{ $isModuleChecked('buu_ldap') ? '' : 'hidden' }}" id="schema-card-ldap">
                        <div class="flex items-center justify-between">
                            <span class="font-code-inline text-on-surface font-bold text-sm">users_credentials</span>
                            <span class="px-2 py-0.5 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[11px]">UsersCredentialsModel.php</span>
                        </div>
                        <div class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
                            <div class="text-secondary font-mono">PK: cred_id (bigint) | FK: user_id</div>
                            <div>Columns: credential_id, public_key, user_handle, counter</div>
                            <div class="mt-2 pt-1 border-t border-surface-container-highest/60 flex flex-wrap gap-1">
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">created_by</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">created_at</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">updated_by</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">updated_at</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">request_uri</span>
                            </div>
                        </div>
                    </div>

                    <!-- Roles & Users Roles Tables (Core) -->
                    <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest/60 flex flex-col gap-2" id="schema-card-roles">
                        <div class="flex items-center justify-between">
                            <span class="font-code-inline text-on-surface font-bold text-sm">roles &amp; users_roles</span>
                            <span class="px-2 py-0.5 rounded bg-secondary-container/30 text-secondary font-code-inline text-[11px]">RolesModel.php</span>
                        </div>
                        <div class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
                            <div class="text-secondary font-mono">Tables: roles (role_id), users_roles (usrole_id)</div>
                            <div>Superadmin / Admin / User + 5 Audit Stamps</div>
                            <div class="mt-2 pt-1 border-t border-surface-container-highest/60 flex flex-wrap gap-1">
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">created_by</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">created_at</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">updated_by</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">updated_at</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">request_uri</span>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Trail Table -->
                    <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest/60 flex flex-col gap-2 {{ $isModuleChecked('audit_trail') ? '' : 'hidden' }}" id="schema-card-audit">
                        <div class="flex items-center justify-between">
                            <span class="font-code-inline text-on-surface font-bold text-sm">activity_logs</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container-highest text-outline font-code-inline text-[11px]">ActivityLogsModel.php</span>
                        </div>
                        <div class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
                            <div class="text-secondary font-mono">PK: id (bigint) | Trait: LogsActivity</div>
                            <div>Columns: log_name, description, subject, causer, properties</div>
                            <div class="mt-2 pt-1 border-t border-surface-container-highest/60 flex flex-wrap gap-1">
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">created_by</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">created_at</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">updated_by</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">updated_at</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">request_uri</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications Table -->
                    <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest/60 flex flex-col gap-2 {{ $isModuleChecked('notifications') ? '' : 'hidden' }}" id="schema-card-notif">
                        <div class="flex items-center justify-between">
                            <span class="font-code-inline text-on-surface font-bold text-sm">notifications</span>
                            <span class="px-2 py-0.5 rounded bg-warning/20 text-warning font-code-inline text-[11px]">NotificationsModel.php</span>
                        </div>
                        <div class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
                            <div class="text-secondary font-mono">PK: id (uuid) | Morph: notifiable</div>
                            <div>Columns: type, notifiable_type, notifiable_id, data, read_at</div>
                            <div class="mt-2 pt-1 border-t border-surface-container-highest/60 flex flex-wrap gap-1">
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">created_by</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">created_at</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">updated_by</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">updated_at</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-code-inline text-[10px]">request_uri</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Actions Toolbar -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-space-md pt-space-md pb-space-lg">
                <a class="btn-artisan-back w-full sm:w-auto flex items-center justify-center gap-space-xs px-space-lg py-2.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-body-md text-body-md transition-colors shadow-sm" href="{{ route('generator.step2') }}">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span>Previous: 2. Packages &amp; Dependencies</span>
                </a>
                <div class="flex items-center gap-space-sm w-full sm:w-auto justify-end">
                    <span class="hidden sm:inline font-code-block text-code-block text-outline">Stage 03 / 05 Configured</span>
                    <button type="submit" class="btn-artisan-continue w-full sm:w-auto flex items-center justify-center gap-space-xs px-space-xl py-2.5 rounded-lg bg-primary-container hover:bg-inverse-primary text-on-primary font-headline-sm text-headline-sm font-medium transition-all shadow-[0_0_20px_rgba(255,85,66,0.3)] cursor-pointer">
                        <span>Continue: 4. UI Design System &amp; Theme</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleModuleStatus(checkbox, badgeId) {
        const badge = document.getElementById(badgeId);
        if (badge) {
            if (checkbox.checked) {
                badge.textContent = 'ENABLED';
                badge.className = 'px-1.5 py-0.2 rounded bg-tertiary-container/30 text-tertiary font-label-sm text-label-sm font-code-inline';
            } else {
                badge.textContent = 'DISABLED';
                badge.className = 'px-1.5 py-0.2 rounded bg-surface-container text-outline font-label-sm text-label-sm font-code-inline';
            }
        }

        // Mutual Exclusivity between BUU LDAP and UMS BUU
        if (checkbox.checked) {
            if (badgeId === 'badge-ldap') {
                const umsCb = document.querySelector('input.module-checkbox[name="modules[ums_buu]"]');
                if (umsCb && umsCb.checked && !umsCb.disabled) {
                    umsCb.checked = false;
                    toggleModuleStatus(umsCb, 'badge-ums');
                }
            } else if (badgeId === 'badge-ums') {
                const ldapCb = document.querySelector('input.module-checkbox[name="modules[buu_ldap]"]');
                if (ldapCb && ldapCb.checked && !ldapCb.disabled) {
                    ldapCb.checked = false;
                    toggleModuleStatus(ldapCb, 'badge-ldap');
                }
            }
        }

        // Dynamically toggle corresponding Schema Card
        const schemaMap = {
            'badge-ldap': 'schema-card-ldap',
            'badge-usr': 'schema-card-usr',
            'badge-audit': 'schema-card-audit',
            'badge-notif': 'schema-card-notif',
        };
        const cardId = schemaMap[badgeId];
        if (cardId) {
            const card = document.getElementById(cardId);
            if (card) {
                if (checkbox.checked) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            }
        }

        updateActiveModulesCount();
    }

    function updateActiveModulesCount() {
        const checked = document.querySelectorAll('.module-checkbox:checked').length;
        const countBadge = document.getElementById('active-modules-count');
        if (countBadge) {
            countBadge.textContent = checked + ' Active';
        }
    }
</script>

@endsection
