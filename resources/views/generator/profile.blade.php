@extends('layouts.artisan')

@section('title', 'Profile & Account Settings')

@section('content')
<div class="flex flex-col w-full">
    <!-- Profile Hero Section with Monospace Metadata Overlays -->
    <section class="relative px-gutter-lg pt-space-lg pb-space-xl bg-surface-container-low overflow-hidden border-b border-surface-container-high">
        <!-- Atmospheric Ambient Glow -->
        <div class="absolute -top-24 -right-16 w-96 h-96 bg-primary-container/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-secondary-container/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto flex flex-col gap-space-lg">
            <!-- Breadcrumb Meta Strip -->
            <div class="flex items-center justify-between">
                <nav aria-label="Breadcrumb Navigation" class="flex items-center gap-space-xs text-outline font-label-sm text-label-sm">
                    <a href="{{ route('generator.step1') }}" class="text-outline hover:text-on-surface cursor-pointer transition-colors text-decoration-none">WORKSPACE</a>
                    <span>/</span>
                    <a href="{{ route('generator.step1') }}" class="text-outline hover:text-on-surface cursor-pointer transition-colors text-decoration-none">ARCHITECT CONSOLE</a>
                    <span>/</span>
                    <span class="text-primary font-code-inline">PROFILE CONFIG</span>
                </nav>
                <div class="flex items-center gap-2 px-space-sm py-1 rounded bg-surface-container font-label-sm text-label-sm text-tertiary">
                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                    <span>โหนดสถานะ: Connected to TH-BKK-01 (18ms)</span>
                </div>
            </div>

            <!-- Identity & Quick Telemetry Header -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-space-lg">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-space-lg">
                    <!-- Large Avatar with Interactive Trigger -->
                    <div class="relative group">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden bg-surface-container-highest shadow-xl flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[64px]">account_circle</span>
                        </div>
                        <button aria-label="เปลี่ยนรูปประจำตัว" class="absolute inset-0 bg-surface-container-lowest/80 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-1 rounded-2xl text-on-surface cursor-pointer" type="button">
                            <span class="material-symbols-outlined text-[20px] text-primary">photo_camera</span>
                            <span class="font-label-sm text-label-sm">เปลี่ยนรูป</span>
                        </button>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-surface-container-low flex items-center justify-center">
                            <span class="w-3.5 h-3.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(78,222,163,0.5)]" title="Active Core Node"></span>
                        </div>
                    </div>

                    <!-- Name, Role & System Badges -->
                    <div class="flex flex-col gap-1.5">
                        <div class="flex flex-wrap items-center gap-space-xs">
                            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">{{ $user->name ?? session('auth_user.name', 'Lead Architect') }}</h1>
                            <span class="font-label-md text-label-md text-outline font-code-inline">({{ $user->username ?? session('auth_user.username', 'lead.architect') }})</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container-high text-primary font-label-sm text-label-sm font-code-inline uppercase ml-1">BUU AD Account</span>
                            <span class="flex items-center gap-1 px-2 py-0.5 rounded bg-surface-container-high text-tertiary font-label-sm text-label-sm">
                                <span class="material-symbols-outlined text-[13px] text-tertiary">verified</span>
                                Verified Member
                            </span>
                        </div>
                        <p class="font-body-md text-body-md text-on-surface-variant flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-[16px] text-outline">domain</span>
                            บัญชีผู้ใช้งานระบบสารสนเทศ • มหาวิทยาลัยบูรพา (Burapha University)
                        </p>
                        <div class="flex items-center gap-space-sm mt-1">
                            <div class="flex items-center gap-1.5 px-space-sm py-1 rounded bg-surface-container text-on-surface font-label-sm text-label-sm font-code-inline">
                                <span class="material-symbols-outlined text-[14px] text-secondary">mail</span>
                                <span>{{ $user->email ?? 'user@buu.ac.th' }}</span>
                            </div>
                            <span class="font-code-block text-code-block text-outline font-code-inline">PSN: {{ $user->psn_id ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Telemetry Stats Cards (Real System Attributes) -->
                <div class="grid grid-cols-3 gap-space-sm sm:gap-space-md p-space-sm rounded-xl bg-surface-container/70 shadow-inner">
                    <div class="flex flex-col px-space-sm py-1">
                        <div class="flex items-center gap-1 text-outline font-label-sm text-label-sm">
                            <span class="material-symbols-outlined text-[14px] text-secondary">layers</span>
                            <span>RUNTIME</span>
                        </div>
                        <span class="font-headline-md text-headline-md text-on-surface font-code-inline font-bold mt-0.5">PHP 8.4</span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Laravel 13.x LTS</span>
                    </div>
                    <div class="flex flex-col px-space-sm py-1">
                        <div class="flex items-center gap-1 text-outline font-label-sm text-label-sm">
                            <span class="material-symbols-outlined text-[14px] text-tertiary">fingerprint</span>
                            <span>PASSKEYS</span>
                        </div>
                        <span class="font-headline-md text-headline-md text-tertiary font-code-inline font-bold mt-0.5">{{ isset($webauthnCredentials) ? $webauthnCredentials->count() : 0 }}</span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">อุปกรณ์ที่ผูกไว้</span>
                    </div>
                    <div class="flex flex-col px-space-sm py-1">
                        <div class="flex items-center gap-1 text-outline font-label-sm text-label-sm">
                            <span class="material-symbols-outlined text-[14px] text-primary">security</span>
                            <span>ACCOUNT</span>
                        </div>
                        <span class="font-headline-md text-headline-md text-tertiary font-code-inline font-bold mt-0.5">{{ ($user->active ?? 'Y') === 'Y' ? 'Active' : 'Suspended' }}</span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">สถานะบัญชีปกติ</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- High-Density Horizontal Settings Navigation Strip -->
    <div class="w-full bg-surface-container-lowest px-gutter-lg overflow-x-auto border-b border-surface-container-high">
        <div class="max-w-7xl mx-auto flex items-center gap-space-xs font-body-sm text-body-sm">
            <button id="nav-tab-profile" onclick="switchProfileTab('profile')" class="tab-btn relative px-space-md py-3 text-primary font-semibold flex items-center gap-space-xs bg-surface-container-low transition-colors cursor-pointer" type="button">
                <span class="active-indicator w-full absolute top-0 left-0 h-0.5 bg-primary-container"></span>
                <span class="material-symbols-outlined text-[18px]">badge</span>
                <span>ข้อมูลส่วนตัวและโปรไฟล์</span>
                <span class="active-badge px-1.5 py-0.2 rounded bg-surface-container-high text-primary font-label-sm text-label-sm font-code-inline">ACTIVE</span>
            </button>
            <button id="nav-tab-security" onclick="switchProfileTab('security')" class="tab-btn relative px-space-md py-3 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low transition-colors flex items-center gap-space-xs cursor-pointer" type="button">
                <span class="active-indicator hidden w-full absolute top-0 left-0 h-0.5 bg-primary-container"></span>
                <span class="material-symbols-outlined text-[18px]">key</span>
                <span>รหัสผ่านและความปลอดภัย</span>
                <span class="active-badge hidden px-1.5 py-0.2 rounded bg-surface-container-high text-primary font-label-sm text-label-sm font-code-inline">ACTIVE</span>
            </button>
        </div>
    </div>

    <!-- Primary Configuration Split Grid -->
    <div class="px-gutter-lg py-space-xl max-w-7xl mx-auto w-full">
        <!-- ========================================== -->
        <!-- TAB 1: ข้อมูลส่วนตัวและโปรไฟล์ (Profile Info) -->
        <!-- ========================================== -->
        <div id="tab-content-profile" class="tab-content">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
                <!-- Left Column: Form & Scaffolding Settings (Col 8) -->
                <div class="lg:col-span-8 flex flex-col gap-space-lg">
                    <!-- Account Information Card -->
                    <div class="p-space-lg rounded-xl bg-surface-container-low flex flex-col gap-space-md shadow-md">
                        <div class="flex items-center justify-between pb-space-xs">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-primary text-[20px]">manage_accounts</span>
                                <h2 class="font-headline-sm text-headline-sm text-on-surface">ข้อมูลบัญชีนักพัฒนา (Account Details)</h2>
                            </div>
                            <span class="font-label-sm text-label-sm text-outline font-code-inline">SYNC: ACTIVE</span>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                            ข้อมูลระบุตัวตนบนแพลตฟอร์ม ArtisanCraft สำหรับการออกใบรับรองสถาปัตยกรรมระบบ และการบันทึกประวัติการสร้างโค้ด
                        </p>
                        <form id="profile-form" class="grid grid-cols-1 md:grid-cols-2 gap-space-md pt-space-xs" onsubmit="handleProfileSubmit(event)">
                            @csrf
                            <!-- Full Name -->
                            <div class="flex flex-col gap-1.5">
                                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider" for="fullName">
                                    ชื่อ-นามสกุล (Full Name)
                                </label>
                                <input class="w-full h-9 px-space-sm bg-surface-container text-on-surface font-body-md text-body-md rounded focus:outline-none focus:bg-surface-container-high transition-colors" 
                                       id="fullName" name="name" type="text" required
                                       value="{{ old('name', $user->name ?? session('auth_user.name', '')) }}">
                            </div>

                            <!-- Developer Username (Readonly from AD) -->
                            <div class="flex flex-col gap-1.5">
                                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider" for="username">
                                    ชื่อผู้ใช้งาน (Developer Handle)
                                </label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-space-sm text-outline font-code-inline text-code-inline">&#64;</span>
                                    <input class="w-full h-9 pl-7 pr-space-sm bg-surface-container/60 text-outline font-code-inline text-code-inline rounded focus:outline-none cursor-not-allowed" 
                                           id="username" name="username" type="text" readonly
                                           value="{{ $user->username ?? session('auth_user.username', '') }}">
                                </div>
                            </div>

                            <!-- Email Address with Verified Badge -->
                            <div class="flex flex-col gap-1.5 md:col-span-2">
                                <div class="flex items-center justify-between">
                                    <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider" for="email">
                                        อีเมลสำหรับงานและรับแจ้งเตือน (Work Email)
                                    </label>
                                    <span class="flex items-center gap-1 font-label-sm text-label-sm text-tertiary">
                                        <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                        ยืนยันตัวตนแล้ว (Verified Primary)
                                    </span>
                                </div>
                                <div class="relative flex items-center">
                                    <input class="w-full h-9 px-space-sm bg-surface-container text-on-surface font-code-inline text-code-inline rounded focus:outline-none focus:bg-surface-container-high transition-colors" 
                                           id="email" name="email" type="email" required
                                           value="{{ old('email', $user->email ?? session('auth_user.email', '')) }}">
                                    <span class="absolute right-space-sm px-1.5 py-0.5 rounded bg-surface-container-highest text-outline font-label-sm text-label-sm">PRIMARY</span>
                                </div>
                            </div>

                            <!-- Timezone Preference -->
                            <div class="flex flex-col gap-1.5">
                                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider" for="timezone">
                                    ไทม์โซนระบบ (Timezone)
                                </label>
                                @php
                                    $currentTimezone = old('timezone', $user->timezone ?? 'Asia/Bangkok');
                                @endphp
                                <select class="w-full h-9 px-space-sm bg-surface-container text-on-surface font-body-sm text-body-sm rounded focus:outline-none cursor-pointer" 
                                        id="timezone" name="timezone">
                                    <option value="">---เลือก---</option>
                                    <option value="Asia/Bangkok" {{ $currentTimezone === 'Asia/Bangkok' ? 'selected' : '' }}>Asia/Bangkok (UTC+07:00 ICT)</option>
                                    <option value="UTC" {{ $currentTimezone === 'UTC' ? 'selected' : '' }}>UTC (Universal Time)</option>
                                    <option value="America/New_York" {{ $currentTimezone === 'America/New_York' ? 'selected' : '' }}>America/New_York (EST)</option>
                                    <option value="Asia/Tokyo" {{ $currentTimezone === 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo (JST)</option>
                                    <option value="Europe/London" {{ $currentTimezone === 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT/BST)</option>
                                </select>
                            </div>

                            <!-- Git Signature -->
                            <div class="flex flex-col gap-1.5">
                                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider" for="gitSignature">
                                    Git Committer Signature
                                </label>
                                @php
                                    $defaultSignature = ($user->name ?? 'User') . ' <' . ($user->email ?? 'user@artisan.io') . '>';
                                @endphp
                                <input class="w-full h-9 px-space-sm bg-surface-container text-on-surface font-code-inline text-code-inline rounded focus:outline-none focus:bg-surface-container-high transition-colors" 
                                       id="gitSignature" name="git_signature" type="text" 
                                       value="{{ old('git_signature', $user->git_signature ?? $defaultSignature) }}">
                            </div>

                            <!-- Feature Flags & Scaffolding Toggles -->
                            @php
                                $userPrefs = $user->preferences ?? [];
                                $pintChecked = old('pint_format', $userPrefs['pint_format'] ?? true);
                                $pestChecked = old('pest_test', $userPrefs['pest_test'] ?? true);
                                $dockerChecked = old('docker_compose', $userPrefs['docker_compose'] ?? false);
                            @endphp
                            <div class="pt-space-sm flex flex-col gap-3 md:col-span-2">
                                <label class="flex items-center justify-between p-space-sm rounded bg-surface-container/60 hover:bg-surface-container cursor-pointer transition-colors">
                                    <div class="flex flex-col">
                                        <span class="font-body-sm text-body-sm font-semibold text-on-surface">เปิดใช้งาน Laravel Pint Auto-Formatting</span>
                                        <span class="font-body-sm text-body-sm text-outline">จัดระเบียบโครงสร้างโค้ดอัตโนมัติตามมาตรฐาน PSR-12 และ Laravel Pint ทุกครั้งที่คอมไพล์เสร็จ</span>
                                    </div>
                                    <input name="pint_format" value="1" {{ $pintChecked ? 'checked' : '' }} class="w-4 h-4 accent-primary-container rounded cursor-pointer" type="checkbox">
                                </label>
                                <label class="flex items-center justify-between p-space-sm rounded bg-surface-container/60 hover:bg-surface-container cursor-pointer transition-colors">
                                    <div class="flex flex-col">
                                        <span class="font-body-sm text-body-sm font-semibold text-on-surface">สร้างชุดทดสอบ PestPHP Test Suite เบื้องต้น</span>
                                        <span class="font-body-sm text-body-sm text-outline">สแคฟโฟลด์ไฟล์ Feature &amp; Unit Tests อัตโนมัติในทุก Entity Model ที่สร้างขึ้น</span>
                                    </div>
                                    <input name="pest_test" value="1" {{ $pestChecked ? 'checked' : '' }} class="w-4 h-4 accent-primary-container rounded cursor-pointer" type="checkbox">
                                </label>
                                <label class="flex items-center justify-between p-space-sm rounded bg-surface-container/60 hover:bg-surface-container cursor-pointer transition-colors">
                                    <div class="flex flex-col">
                                        <span class="font-body-sm text-body-sm font-semibold text-on-surface">ผนวก Docker Compose (Sail Environment) พร้อมทำงาน</span>
                                        <span class="font-body-sm text-body-sm text-outline">รวมคอนฟิก Redis, Mailpit และฐานข้อมูลที่เลือกไว้ในไฟล์ zip ส่งออก</span>
                                    </div>
                                    <input name="docker_compose" value="1" {{ $dockerChecked ? 'checked' : '' }} class="w-4 h-4 accent-primary-container rounded cursor-pointer" type="checkbox">
                                </label>
                            </div>

                            <!-- Action Command Strip -->
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-space-md p-space-md rounded-xl bg-surface-container-high/60 md:col-span-2 mt-2">
                                <div class="flex items-center gap-space-xs text-outline font-label-sm text-label-sm">
                                    <span class="material-symbols-outlined text-[16px] text-tertiary">check</span>
                                    <span>การเปลี่ยนแปลงจะมีผลทันทีต่อการ Scaffold โครงการใหม่ทั้งหมด</span>
                                </div>
                                <div class="flex items-center gap-space-sm w-full sm:w-auto">
                                    <button class="w-1/2 sm:w-auto px-space-md py-2 rounded-lg bg-surface-container text-on-surface-variant hover:text-on-surface hover:bg-surface-bright transition-colors font-body-sm text-body-sm cursor-pointer" type="button" onclick="history.back()">
                                        ยกเลิก
                                    </button>
                                    <button id="btn-save-profile" class="w-1/2 sm:w-auto px-space-lg py-2 rounded-lg bg-primary-container hover:bg-inverse-primary text-on-primary font-body-sm text-body-sm font-medium transition-all shadow-[0_0_16px_rgba(255,85,66,0.3)] flex items-center justify-center gap-1.5 cursor-pointer" type="submit">
                                        <span class="material-symbols-outlined text-[18px]">save</span>
                                        <span>บันทึกข้อมูลโปรไฟล์</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Quick Status & Danger Zone (Col 4) -->
                <div class="lg:col-span-4 flex flex-col gap-space-lg">
                    <!-- Quick Security Summary Card -->
                    <div class="p-space-lg rounded-xl bg-surface-container-low flex flex-col gap-space-md shadow-md border border-surface-container-high/60">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-tertiary text-[20px]">verified_user</span>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface">สถานะความปลอดภัยบัญชี</h3>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-tertiary/15 text-tertiary font-label-sm text-label-sm uppercase font-code-inline">PROTECTED</span>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                            บัญชีของคุณได้รับการปกป้องด้วยระบบ Active Directory ควบคู่ไปกับระบบตรวจสอบความปลอดภัยของมหาวิทยาลัย
                        </p>
                        <div class="flex flex-col gap-2 pt-1">
                            <div class="p-2.5 rounded-lg bg-surface-container flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary text-[18px]">key</span>
                                    <span class="font-body-sm text-body-sm text-on-surface">การยืนยันรหัสผ่าน</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-secondary font-code-inline">Active Directory</span>
                            </div>
                            <div class="p-2.5 rounded-lg bg-surface-container flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-tertiary text-[18px]">fingerprint</span>
                                    <span class="font-body-sm text-body-sm text-on-surface">Passkey ลายนิ้วมือ</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-tertiary font-code-inline">{{ isset($webauthnCredentials) ? $webauthnCredentials->count() : 0 }} อุปกรณ์</span>
                            </div>
                        </div>
                        <button type="button" onclick="switchProfileTab('security')" class="mt-1 w-full py-2 px-3 rounded-lg bg-surface-container-high hover:bg-surface-bright text-on-surface font-body-sm text-body-sm transition-colors flex items-center justify-center gap-1.5 cursor-pointer">
                            <span>จัดการรหัสผ่านและ Passkey</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </button>
                    </div>

                    <!-- Danger Zone Container: ปิดบัญชี / ระงับการใช้งาน -->
                    <div class="p-space-lg rounded-xl bg-error-container/20 flex flex-col gap-space-sm shadow-inner border border-error/30">
                        <div class="flex items-center gap-space-xs text-error">
                            <span class="material-symbols-outlined text-[20px]">warning</span>
                            <h3 class="font-headline-sm text-headline-sm font-semibold">โซนอันตราย (Danger Zone)</h3>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-error-container">
                            การระงับการทำงานหรือปิดบัญชี จะส่งผลให้บัญชีนี้ถูกปิดการใช้งานทันที (Active: N) และจะไม่สามารถเข้าสู่ระบบด้วยรหัสผ่าน, บัญชี AD หรือลายนิ้วมือได้อีกต่อไป
                        </p>
                        <div class="flex items-center justify-between pt-space-xs">
                            <button class="px-space-md py-1.5 rounded bg-error-container hover:bg-on-error text-error hover:text-on-error-container font-body-sm text-body-sm font-medium transition-colors cursor-pointer" type="button" onclick="confirmDeactivateAccount()">
                                ปิดบัญชีหรือระงับการใช้งาน
                            </button>
                            <span class="font-label-sm text-label-sm text-outline-variant font-code-inline">IRREVERSIBLE</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 2: รหัสผ่านและความปลอดภัย (Security Hub) -->
        <!-- ========================================== -->
        <div id="tab-content-security" class="tab-content hidden flex flex-col gap-space-lg">
            <!-- 1. Password Status & Identity Source Card -->
            <div class="p-space-lg rounded-xl bg-surface-container-low flex flex-col gap-space-md shadow-md border border-surface-container-high/60">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-primary text-[22px]">lock_reset</span>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">การจัดการรหัสผ่าน (Password Management)</h2>
                    </div>
                    <span class="px-2 py-0.5 rounded bg-surface-container-highest text-secondary font-code-inline text-label-sm font-semibold">BUU AD CENTRAL AUTH</span>
                </div>

                <!-- Info Alert Banner for BUU AD Accounts -->
                <div class="p-space-md rounded-xl bg-surface-container flex flex-col sm:flex-row items-start sm:items-center justify-between gap-space-md border-l-4 border-primary">
                    <div class="flex items-start gap-space-sm">
                        <span class="material-symbols-outlined text-primary text-[24px] shrink-0 mt-0.5">account_tree</span>
                        <div class="flex flex-col gap-0.5">
                            <span class="font-body-md text-body-md text-on-surface font-semibold">บัญชีผู้ใช้งานเชื่อมต่อกับ Active Directory (มหาวิทยาลัยบูรพา)</span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">
                                เพื่อความปลอดภัยสูงสุดตามนโยบายเทคโนโลยีสารสนเทศ การเปลี่ยนรหัสผ่าน AD จะต้องทำผ่านระบบบริการกลางของมหาวิทยาลัยเท่านั้น รหัสผ่านใหม่จะมีผลบังคับใช้กับทุกระบบทันที
                            </span>
                        </div>
                    </div>
                    <a href="https://myid.buu.ac.th" target="_blank" rel="noopener noreferrer" class="px-space-md py-2 rounded-lg bg-surface-container-highest hover:bg-surface-bright text-on-surface font-body-sm text-body-sm font-medium transition-colors flex items-center gap-1.5 shrink-0 text-decoration-none">
                        <span>เปลี่ยนรหัสผ่านผ่าน BUU Portal</span>
                        <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md pt-space-xs">
                    <div class="p-space-sm rounded-lg bg-surface-container flex flex-col gap-1">
                        <span class="font-label-sm text-label-sm text-outline uppercase font-code-inline">IDENTITY SOURCE</span>
                        <span class="font-body-sm text-body-sm text-on-surface font-semibold flex items-center gap-1 text-primary">
                            <span class="material-symbols-outlined text-[16px]">dns</span>
                            BUU LDAP Directory
                        </span>
                    </div>
                    <div class="p-space-sm rounded-lg bg-surface-container flex flex-col gap-1">
                        <span class="font-label-sm text-label-sm text-outline uppercase font-code-inline">PASSWORD POLICY</span>
                        <span class="font-body-sm text-body-sm text-on-surface font-semibold flex items-center gap-1 text-secondary">
                            <span class="material-symbols-outlined text-[16px]">policy</span>
                            ความซับซ้อน 8+ ตัวอักษร
                        </span>
                    </div>
                    <div class="p-space-sm rounded-lg bg-surface-container flex flex-col gap-1">
                        <span class="font-label-sm text-label-sm text-outline uppercase font-code-inline">DEVELOPER FALLBACK</span>
                        <span class="font-body-sm text-body-sm text-on-surface font-semibold flex items-center gap-1 text-tertiary">
                            <span class="material-symbols-outlined text-[16px]">check_circle</span>
                            รองรับโหมด Dev อัตโนมัติ
                        </span>
                    </div>
                </div>
            </div>

            <!-- 2. WebAuthn & Passkeys Manager (Full-Width Card) -->
            <div id="security-section" class="p-space-lg rounded-xl bg-surface-container-low flex flex-col gap-space-md shadow-md border border-surface-container-high/60">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-tertiary text-[22px]">fingerprint</span>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">สแกนลายนิ้วมือ &amp; Passkey (Passwordless FIDO2)</h2>
                    </div>
                    @if(isset($webauthnCredentials) && $webauthnCredentials->isNotEmpty())
                        <span class="px-2 py-0.5 rounded bg-tertiary/15 text-tertiary font-label-sm text-label-sm uppercase font-code-inline">{{ $webauthnCredentials->count() }} อุปกรณ์พร้อมใช้งาน</span>
                    @else
                        <span class="px-2 py-0.5 rounded bg-surface-container-highest text-outline font-label-sm text-label-sm uppercase font-code-inline">ยังไม่ได้ลงทะเบียน</span>
                    @endif
                </div>

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                    <p class="font-body-sm text-body-sm text-on-surface-variant max-w-3xl">
                        เข้าสู่ระบบได้สะดวกรวดเร็วโดยไม่ต้องพิมพ์รหัสผ่าน รองรับ Windows Hello, Apple Touch ID / Face ID และ YubiKey ตามมาตรฐาน W3C FIDO2 รหัสความปลอดภัยจะถูกเก็บในชิปฮาร์ดแวร์ของอุปกรณ์คุณเท่านั้น
                    </p>
                    <button type="button" onclick="registerPasskey()" class="py-2 px-space-md rounded-lg bg-primary-container hover:bg-inverse-primary text-on-primary font-body-sm text-body-sm font-semibold transition-all shadow-[0_0_12px_rgba(255,85,66,0.3)] flex items-center justify-center gap-2 cursor-pointer shrink-0">
                        <span class="material-symbols-outlined text-[18px]">add_moderator</span>
                        <span>ลงทะเบียนอุปกรณ์ / สแกนนิ้วใหม่</span>
                    </button>
                </div>

                <!-- Registered Credentials Grid -->
                @if(isset($webauthnCredentials) && $webauthnCredentials->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-space-sm mt-2">
                        @foreach($webauthnCredentials as $cred)
                            <div class="p-3 rounded-lg bg-surface-container flex items-center justify-between gap-3 border border-surface-container-high hover:border-tertiary/40 transition-colors">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-tertiary shrink-0">
                                        <span class="material-symbols-outlined text-[22px]">fingerprint</span>
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-body-md text-body-md text-on-surface font-medium truncate" title="{{ $cred->device_name }}">{{ $cred->device_name }}</span>
                                        <span class="font-code-block text-code-block text-outline font-code-inline text-[11px]">
                                            ใช้งานล่าสุด: {{ $cred->last_used_at ? $cred->last_used_at->diffForHumans() : 'ยังไม่เคยใช้งาน' }}
                                        </span>
                                    </div>
                                </div>
                                <button type="button" onclick="deletePasskey({{ $cred->cred_id }}, '{{ addslashes($cred->device_name) }}')" title="ลบอุปกรณ์นี้" class="p-2 rounded text-outline hover:text-error hover:bg-error-container/20 transition-colors cursor-pointer shrink-0">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-space-lg rounded-xl bg-surface-container/60 border border-dashed border-surface-container-highest flex flex-col items-center justify-center text-center gap-2">
                        <span class="material-symbols-outlined text-outline text-[32px]">fingerprint</span>
                        <span class="font-body-md text-body-md text-on-surface font-medium">ยังไม่มีอุปกรณ์สแกนนิ้วที่ลงทะเบียนไว้</span>
                        <span class="font-body-sm text-body-sm text-outline max-w-md">กดปุ่ม "ลงทะเบียนอุปกรณ์ / สแกนนิ้วใหม่" ด้านบนเพื่อเปิดใช้งานการเข้าสู่ระบบแบบไร้รหัสผ่านบนเครื่องนี้</span>
                    </div>
                @endif
            </div>

            <!-- 3. Active Sessions & Security Telemetry -->
            <div class="p-space-lg rounded-xl bg-surface-container-low flex flex-col gap-space-md shadow-md border border-surface-container-high/60">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-secondary text-[22px]">devices</span>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">เซสชันที่ใช้งานอยู่ (Active Sessions)</h2>
                    </div>
                    <span class="px-2 py-0.5 rounded bg-secondary/15 text-secondary font-code-inline text-label-sm font-semibold">HTTPS SECURE SESSION</span>
                </div>

                <div class="p-space-md rounded-xl bg-surface-container flex flex-col sm:flex-row items-start sm:items-center justify-between gap-space-md">
                    <div class="flex items-center gap-space-md">
                        <div class="w-12 h-12 rounded-xl bg-surface-container-highest flex items-center justify-center text-secondary shrink-0">
                            <span class="material-symbols-outlined text-[26px]">laptop_mac</span>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex items-center gap-2">
                                <span class="font-body-md text-body-md text-on-surface font-semibold">เซสชันปัจจุบัน (เครื่องนี้)</span>
                                <span class="px-2 py-0.2 rounded-full bg-tertiary/20 text-tertiary font-label-sm text-label-sm font-code-inline">Active Now</span>
                            </div>
                            <span class="font-body-sm text-body-sm text-outline font-code-inline mt-0.5">
                                IP: {{ request()->ip() }} • {{ request()->userAgent() ? Str::limit(request()->userAgent(), 55) : 'Localhost Developer Node' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-label-sm text-label-sm text-outline font-code-inline">SESSION VER: 1</span>
                    </div>
                </div>
            </div>

            <!-- 4. Recent Login Audit Trail (From log_login Table) -->
            <div class="p-space-lg rounded-xl bg-surface-container-low flex flex-col gap-space-md shadow-md border border-surface-container-high/60">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-space-xs">
                        <span class="material-symbols-outlined text-tertiary text-[22px]">history</span>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">ประวัติการเข้าสู่ระบบล่าสุด (Login Audit Trail)</h2>
                    </div>
                    <span class="font-label-sm text-label-sm text-outline font-code-inline">LOG_LOGIN AUDIT</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                    บันทึกการตรวจสอบความปลอดภัยย้อนหลัง 5 รายการล่าสุดที่ถูกบันทึกลงตาราง <code class="text-tertiary font-code-inline">log_login</code> ของระบบ
                </p>

                <div class="overflow-x-auto">
                    <table class="w-full text-left font-body-sm text-body-sm">
                        <thead>
                            <tr class="border-b border-surface-container-high text-outline font-label-sm text-label-sm uppercase">
                                <th class="pb-2 font-medium">วัน-เวลา</th>
                                <th class="pb-2 font-medium">การกระทำ (Action)</th>
                                <th class="pb-2 font-medium">IP Address</th>
                                <th class="pb-2 font-medium">เบราว์เซอร์ &amp; ระบบ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container-high">
                            @if(isset($loginLogs) && $loginLogs->isNotEmpty())
                                @foreach($loginLogs as $log)
                                    <tr class="hover:bg-surface-container/50 transition-colors">
                                        <td class="py-2.5 font-code-inline text-on-surface">
                                            {{ $log->lg_date ? $log->lg_date->format('Y-m-d H:i:s') : $log->created_at->format('Y-m-d H:i:s') }}
                                        </td>
                                        <td class="py-2.5">
                                            @if(str_contains($log->lg_action ?? '', 'สำเร็จ'))
                                                <span class="px-2 py-0.5 rounded bg-tertiary/15 text-tertiary font-code-inline text-[12px] flex items-center gap-1 w-fit">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                                    {{ $log->lg_action }}
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded bg-error-container/20 text-error font-code-inline text-[12px] flex items-center gap-1 w-fit">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                                    {{ $log->lg_action ?? 'เข้าสู่ระบบ' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-2.5 font-code-inline text-on-surface-variant">
                                            {{ $log->lg_ip ?? '127.0.0.1' }}
                                        </td>
                                        <td class="py-2.5 text-outline truncate max-w-xs" title="{{ $log->lg_browser }} {{ $log->lg_os }}">
                                            {{ $log->lg_browser ?? 'Chrome' }} / {{ $log->lg_os ?? 'Windows' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-outline">
                                        ไม่พบประวัติการเข้าสู่ระบบที่บันทึกไว้ในขณะนี้
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchProfileTab(tabName) {
        const tabProfile = document.getElementById('tab-content-profile');
        const tabSecurity = document.getElementById('tab-content-security');
        const btnProfile = document.getElementById('nav-tab-profile');
        const btnSecurity = document.getElementById('nav-tab-security');

        if (tabName === 'security') {
            tabProfile.classList.add('hidden');
            tabSecurity.classList.remove('hidden');

            // Set Profile Button Inactive
            btnProfile.classList.remove('text-primary', 'font-semibold', 'bg-surface-container-low');
            btnProfile.classList.add('text-on-surface-variant');
            btnProfile.querySelector('.active-indicator').classList.add('hidden');
            btnProfile.querySelector('.active-badge').classList.add('hidden');

            // Set Security Button Active
            btnSecurity.classList.remove('text-on-surface-variant');
            btnSecurity.classList.add('text-primary', 'font-semibold', 'bg-surface-container-low');
            btnSecurity.querySelector('.active-indicator').classList.remove('hidden');
            btnSecurity.querySelector('.active-badge').classList.remove('hidden');

            window.location.hash = 'security';
        } else {
            tabSecurity.classList.add('hidden');
            tabProfile.classList.remove('hidden');

            // Set Security Button Inactive
            btnSecurity.classList.remove('text-primary', 'font-semibold', 'bg-surface-container-low');
            btnSecurity.classList.add('text-on-surface-variant');
            btnSecurity.querySelector('.active-indicator').classList.add('hidden');
            btnSecurity.querySelector('.active-badge').classList.add('hidden');

            // Set Profile Button Active
            btnProfile.classList.remove('text-on-surface-variant');
            btnProfile.classList.add('text-primary', 'font-semibold', 'bg-surface-container-low');
            btnProfile.querySelector('.active-indicator').classList.remove('hidden');
            btnProfile.querySelector('.active-badge').classList.remove('hidden');

            window.location.hash = 'profile';
        }
    }

    // Auto-switch tab based on hash (e.g. #security)
    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash === '#security') {
            switchProfileTab('security');
        }
    });

    function base64urlToUint8Array(base64url) {
        let padding = '='.repeat((4 - base64url.length % 4) % 4);
        let base64 = (base64url + padding).replace(/-/g, '+').replace(/_/g, '/');
        let raw = window.atob(base64);
        let output = new Uint8Array(raw.length);
        for (let i = 0; i < raw.length; ++i) {
            output[i] = raw.charCodeAt(i);
        }
        return output;
    }

    function bufferToBase64url(buffer) {
        let bytes = new Uint8Array(buffer);
        let binary = '';
        for (let i = 0; i < bytes.byteLength; i++) {
            binary += String.fromCharCode(bytes[i]);
        }
        return window.btoa(binary).replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
    }

    async function registerPasskey() {
        if (!window.PublicKeyCredential) {
            alert('ขออภัย เบราว์เซอร์หรืออุปกรณ์ของคุณไม่รองรับมาตรฐาน WebAuthn / Passkey');
            return;
        }

        const defaultDevice = navigator.userAgent.includes('Mac') 
            ? 'Apple Touch ID / Mac' 
            : (navigator.userAgent.includes('Windows') ? 'Windows Hello PC' : 'Mobile / Security Key');

        let deviceName = defaultDevice;
        if (window.ArtisanSwal) {
            const result = await ArtisanSwal.fire({
                title: 'ลงทะเบียนลายนิ้วมือ / Passkey',
                text: 'ระบุชื่ออุปกรณ์หรือชื่อลายนิ้วมือนี้:',
                input: 'text',
                inputValue: defaultDevice,
                showCancelButton: true,
                confirmButtonText: 'ต่อไป (สแกนนิ้ว)',
                cancelButtonText: 'ยกเลิก',
                inputValidator: (value) => {
                    if (!value || !value.trim()) {
                        return 'กรุณาระบุชื่ออุปกรณ์';
                    }
                }
            });

            if (!result.isConfirmed) {
                return;
            }
            deviceName = result.value.trim();
        } else {
            const promptName = prompt('ระบุชื่ออุปกรณ์สำหรับลายนิ้วมือนี้ (เช่น ThinkPad Windows Hello, MacBook Touch ID):', defaultDevice);
            if (promptName === null) return;
            deviceName = promptName.trim() || defaultDevice;
        }

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // 1. ขอ Options & Challenge จาก Server
            const optRes = await fetch('{{ route("webauthn.register.options") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            if (!optRes.ok) {
                const err = await optRes.json();
                throw new Error(err.error || 'ไม่สามารถขอข้อมูล Challenge สำหรับลงทะเบียนได้');
            }

            const options = await optRes.json();

            // แปลง Base64URL สู่ Uint8Array Buffer ตามข้อกำหนด W3C
            options.challenge = base64urlToUint8Array(options.challenge);
            options.user.id = base64urlToUint8Array(options.user.id);
            if (options.excludeCredentials && options.excludeCredentials.length > 0) {
                options.excludeCredentials = options.excludeCredentials.map(cred => {
                    const desc = {
                        id: base64urlToUint8Array(cred.id),
                        type: cred.type || 'public-key'
                    };
                    if (Array.isArray(cred.transports) && cred.transports.length > 0) {
                        desc.transports = cred.transports;
                    }
                    return desc;
                });
            }

            // 2. เรียก Native WebAuthn API ของ OS (Windows Hello / Touch ID / FIDO2)
            const credential = await navigator.credentials.create({
                publicKey: options
            });

            if (!credential) {
                throw new Error('การสแกนลายนิ้วมือถูกยกเลิก');
            }

            // 3. แพ็กข้อมูลตอบกลับเป็น Base64URL
            const credentialPayload = {
                id: credential.id,
                rawId: bufferToBase64url(credential.rawId),
                type: credential.type,
                deviceName: deviceName.trim() || defaultDevice,
                response: {
                    clientDataJSON: bufferToBase64url(credential.response.clientDataJSON),
                    attestationObject: bufferToBase64url(credential.response.attestationObject),
                    transports: credential.response.getTransports ? credential.response.getTransports() : []
                }
            };

            // 4. ส่งไปยืนยันและบันทึกลงตาราง webauthn_credentials
            const verifyRes = await fetch('{{ route("webauthn.register.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(credentialPayload)
            });

            const verifyData = await verifyRes.json();
            if (!verifyRes.ok || !verifyData.success) {
                throw new Error(verifyData.error || 'การยืนยันข้อมูลลายนิ้วมือบนเซิร์ฟเวอร์ไม่สำเร็จ');
            }

            if (window.ArtisanSwal) {
                await ArtisanSwal.fire({
                    icon: 'success',
                    title: 'ลงทะเบียนสำเร็จ!',
                    text: `ลงทะเบียนลายนิ้วมือสำหรับ "${deviceName}" เรียบร้อยแล้ว สามารถใช้ล็อกอินได้ทันที`,
                    confirmButtonText: 'ตกลง'
                });
            } else {
                alert('✅ ลงทะเบียนลายนิ้วมือ / Passkey สำเร็จเรียบร้อยแล้ว!');
            }
            window.location.reload();
        } catch (err) {
            console.error(err);
            const errMsg = err.message || 'ไม่สามารถลงทะเบียนได้';
            if (window.ArtisanSwal) {
                ArtisanSwal.fire({
                    icon: 'error',
                    title: 'การลงทะเบียนไม่สำเร็จ',
                    text: errMsg,
                    confirmButtonText: 'ตกลง'
                });
            } else {
                alert('เกิดข้อผิดพลาด: ' + errMsg);
            }
        }
    }

    async function deletePasskey(credId, deviceName) {
        if (window.ArtisanSwal) {
            const confirmResult = await ArtisanSwal.fire({
                icon: 'warning',
                title: 'ยืนยันการลบอุปกรณ์?',
                text: `คุณต้องการลบอุปกรณ์ "${deviceName}" ออกจากระบบใช่หรือไม่? เมื่อลบแล้วจะไม่สามารถใช้อุปกรณ์นี้สแกนนิ้วเข้าสู่ระบบได้`,
                showCancelButton: true,
                confirmButtonText: 'ลบอุปกรณ์',
                cancelButtonText: 'ยกเลิก'
            });
            if (!confirmResult.isConfirmed) return;
        } else {
            if (!confirm(`คุณต้องการลบอุปกรณ์ "${deviceName}" ออกจากระบบใช่หรือไม่?`)) return;
        }

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch(`/webauthn/credentials/${credId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();
            if (!res.ok || !data.success) {
                throw new Error(data.error || 'ไม่สามารถลบอุปกรณ์ได้');
            }

            if (window.ArtisanSwal) {
                await ArtisanSwal.fire({
                    icon: 'success',
                    title: 'ลบเรียบร้อย',
                    text: 'ลบข้อมูลอุปกรณ์ออกจากระบบเรียบร้อยแล้ว',
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                alert('ลบข้อมูลอุปกรณ์เรียบร้อยแล้ว');
            }
            window.location.reload();
        } catch (err) {
            if (window.ArtisanSwal) {
                ArtisanSwal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถลบอุปกรณ์ได้',
                    text: err.message,
                    confirmButtonText: 'ตกลง'
                });
            } else {
                alert('เกิดข้อผิดพลาด: ' + err.message);
            }
        }
    }

    async function handleProfileSubmit(e) {
        e.preventDefault();
        const form = document.getElementById('profile-form');
        const saveBtn = document.getElementById('btn-save-profile');
        if (!form) return;

        const formData = new FormData(form);
        const payload = {
            name: formData.get('name'),
            email: formData.get('email'),
            timezone: formData.get('timezone'),
            git_signature: formData.get('git_signature'),
            pint_format: form.querySelector('input[name="pint_format"]')?.checked ? 1 : 0,
            pest_test: form.querySelector('input[name="pest_test"]')?.checked ? 1 : 0,
            docker_compose: form.querySelector('input[name="docker_compose"]')?.checked ? 1 : 0,
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (saveBtn) {
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span><span>กำลังบันทึก...</span>';
        }

        try {
            const res = await fetch('{{ route("profile.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json();
            if (!res.ok) {
                let errorMsg = data.message || 'ไม่สามารถบันทึกข้อมูลได้';
                if (data.errors) {
                    errorMsg = Object.values(data.errors).flat().join('<br>');
                }
                throw new Error(errorMsg);
            }

            if (window.ArtisanSwal) {
                ArtisanSwal.fire({
                    icon: 'success',
                    title: 'บันทึกสำเร็จ!',
                    text: data.message || 'บันทึกข้อมูลส่วนตัวและการตั้งค่าโปรไฟล์เรียบร้อยแล้ว',
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                alert('บันทึกข้อมูลส่วนตัวสำเร็จ');
            }
        } catch (err) {
            console.error(err);
            if (window.ArtisanSwal) {
                ArtisanSwal.fire({
                    icon: 'error',
                    title: 'บันทึกไม่สำเร็จ',
                    html: `<p class="text-sm">${err.message}</p>`,
                    confirmButtonText: 'ตกลง'
                });
            } else {
                alert('เกิดข้อผิดพลาด: ' + err.message);
            }
        } finally {
            if (saveBtn) {
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<span class="material-symbols-outlined text-[18px]">save</span><span>บันทึกข้อมูลโปรไฟล์</span>';
            }
        }
    }

    async function confirmDeactivateAccount() {
        let isConfirmed = false;
        if (window.ArtisanSwal) {
            const result = await ArtisanSwal.fire({
                icon: 'warning',
                title: 'ยืนยันการปิดบัญชี?',
                html: `
                    <div class="text-left space-y-2 mt-2">
                        <p class="text-on-surface">คุณแน่ใจหรือไม่ว่าต้องการ <b>ปิดบัญชีหรือระงับการใช้งาน</b> นี้?</p>
                        <div class="p-3 rounded-lg bg-error-container/20 border border-error/30 text-xs text-error">
                            <p class="font-bold mb-1">⚠️ คำเตือนสำคัญ:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>สถานะบัญชีจะถูกเปลี่ยนเป็น ปิดการใช้งาน (Active: N)</li>
                                <li>คุณจะไม่สามารถเข้าสู่ระบบด้วยรหัสผ่าน, บัญชี AD หรือลายนิ้วมือได้อีกต่อไป</li>
                                <li>ระบบจะปฏิเสธการลงทะเบียนหรือสร้างบัญชีใหม่ซ้ำจาก AD</li>
                            </ul>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'ยืนยันปิดบัญชี',
                cancelButtonText: 'ยกเลิก'
            });
            isConfirmed = result.isConfirmed;
        } else {
            isConfirmed = confirm('คุณแน่ใจหรือไม่ว่าต้องการปิดบัญชีนี้? เมื่อปิดแล้วจะไม่สามารถเข้าสู่ระบบได้อีก');
        }

        if (!isConfirmed) return;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch('{{ route("profile.deactivate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();
            if (!res.ok || !data.success) {
                throw new Error(data.error || 'ไม่สามารถปิดบัญชีได้');
            }

            if (window.ArtisanSwal) {
                await ArtisanSwal.fire({
                    icon: 'success',
                    title: 'ปิดบัญชีเรียบร้อยแล้ว',
                    text: data.message || 'บัญชีของคุณถูกระงับการใช้งานแล้ว กำลังนำคุณออกจากระบบ...',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                alert('ปิดบัญชีเรียบร้อยแล้ว');
            }

            window.location.href = data.redirect || '{{ route("login") }}';
        } catch (err) {
            console.error(err);
            if (window.ArtisanSwal) {
                ArtisanSwal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: err.message,
                    confirmButtonText: 'ตกลง'
                });
            } else {
                alert('เกิดข้อผิดพลาด: ' + err.message);
            }
        }
    }
</script>
@endpush
