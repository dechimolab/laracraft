@extends('layouts.artisan')

@section('title', 'เข้าสู่ระบบ ArtisanCraft Engine')

@section('layout_content')
<div class="fixed inset-0 pointer-events-none z-0 bg-[radial-gradient(rgb(var(--surface-container-high))_1px,transparent_1px)] [background-size:24px_24px] opacity-40"></div>
<main class="relative z-10 w-full min-h-screen flex items-center justify-center p-gutter md:p-gutter-md">
    <div class="flex flex-col w-full max-w-6xl mx-auto my-auto py-space-md">
        <!-- Top Tooling Bar -->
        <div class="w-full flex items-center justify-between pb-space-sm mb-space-md">
            <div class="flex items-center space-x-2">
                <div class="w-2.5 h-2.5 rounded-full bg-tertiary animate-pulse"></div>
                <span class="font-label-sm text-label-sm text-tertiary tracking-wider uppercase">ARTISAN DAEMON ACTIVE // NODE_ID: TH-BKK-01</span>
            </div>
            <div class="flex items-center space-x-space-sm bg-surface-container-low px-space-sm py-1 rounded-xl shadow-sm">
                <button class="px-2 py-0.5 rounded text-on-surface bg-surface-container font-label-sm text-label-sm transition-colors" type="button">TH</button>
                <button class="px-2 py-0.5 rounded text-outline font-label-sm text-label-sm hover:text-on-surface transition-colors" type="button">EN</button>
                <div class="w-px h-3 bg-surface-container-highest mx-1"></div>
                <div class="flex items-center text-primary text-label-sm font-label-sm">
                    <span class="material-symbols-outlined text-[14px] mr-1">terminal</span>
                    v1.0.0-dev
                </div>
            </div>
        </div>

        <!-- Main Authenticator Grid -->
        <div class="w-full grid grid-cols-1 lg:grid-cols-12 rounded-xl overflow-hidden shadow-xl bg-surface-container-lowest">
            <!-- Left: Showcase / Forge Engine Terminal Area -->
            <div class="lg:col-span-6 p-space-md lg:p-space-xl flex flex-col justify-between bg-surface-container relative overflow-hidden">
                <!-- Glow Decor -->
                <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full bg-primary/10 blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-80 h-80 rounded-full bg-secondary-container/10 blur-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <!-- Logo & Forge Monogram -->
                    <div class="flex items-center space-x-space-sm mb-space-lg">
                        <div class="w-10 h-10 rounded-xl bg-primary-container flex items-center justify-center text-on-primary-container shadow-md">
                            <span class="material-symbols-outlined text-[24px]">precision_manufacturing</span>
                        </div>
                        <div>
                            <div class="flex items-center space-x-1.5">
                                <span class="font-headline-md text-headline-md tracking-tight text-on-surface font-semibold">ArtisanCraft</span>
                                <span class="bg-primary/20 text-primary font-label-sm text-label-sm px-1.5 py-0.5 rounded">FORGE CORE</span>
                            </div>
                            <p class="font-label-sm text-label-sm text-outline">LARAVEL FULL-STACK ARCHITECTURAL ENGINE</p>
                        </div>
                    </div>

                    <!-- Headings -->
                    <div class="mb-space-lg">
                        <h1 class="font-headline-lg text-headline-lg text-on-surface mb-space-xs font-bold leading-tight">
                            เข้าสู่ระบบ ArtisanCraft Engine
                        </h1>
                        <p class="font-body-md text-body-md text-outline">
                            เครื่องมือสร้างและจำลองโครงสร้างสถาปัตยกรรม Laravel Full-Stack Monolith อัตโนมัติ เร่งสปีดการส่งมอบระบบอย่างมีมาตรฐาน
                        </p>
                    </div>

                    <!-- Tech Stack Pill Row -->
                    <div class="flex flex-wrap gap-1.5 mb-space-lg">
                        <div class="inline-flex items-center space-x-1 px-2.5 py-1 rounded bg-surface-container-high text-on-surface font-label-sm text-label-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                            <span>PHP 8.4.1</span>
                        </div>
                        <div class="inline-flex items-center space-x-1 px-2.5 py-1 rounded bg-surface-container-high text-on-surface font-label-sm text-label-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                            <span>Laravel 13.x</span>
                        </div>
                        <div class="inline-flex items-center space-x-1 px-2.5 py-1 rounded bg-surface-container-high text-on-surface font-label-sm text-label-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                            <span>Bootstrap 5.3</span>
                        </div>
                        <div class="inline-flex items-center space-x-1 px-2.5 py-1 rounded bg-surface-container-high text-on-surface font-label-sm text-label-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                            <span>MySQL 8.4</span>
                        </div>
                    </div>

                    <!-- Feature Capabilities -->
                    <div class="space-y-space-sm mb-space-lg">
                        <div class="p-space-sm rounded-xl bg-surface-container-low flex items-start space-x-space-sm hover:bg-surface-container-high transition-colors">
                            <div class="w-7 h-7 rounded bg-primary/20 flex items-center justify-center text-primary shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[16px]">bolt</span>
                            </div>
                            <div>
                                <h2 class="font-headline-sm text-headline-sm text-on-surface font-medium">AST Code Generation Pipeline</h2>
                                <p class="font-body-sm text-body-sm text-outline">คอมไพล์ Model, Migration, และ Form Request ตามโครงสร้าง AST แบบเรียลไทม์</p>
                            </div>
                        </div>

                        <div class="p-space-sm rounded-xl bg-surface-container-low flex items-start space-x-space-sm hover:bg-surface-container-high transition-colors">
                            <div class="w-7 h-7 rounded bg-tertiary-container/30 flex items-center justify-center text-tertiary shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[16px]">verified_user</span>
                            </div>
                            <div>
                                <h2 class="font-headline-sm text-headline-sm text-on-surface font-medium">Active Directory (AD/LDAP) Integration</h2>
                                <p class="font-body-sm text-body-sm text-outline">รองรับการยืนยันตัวตนด้วยบัญชีองค์กร AD และ LDAPRecord ตามมาตรฐานความปลอดภัยสูงสุด</p>
                            </div>
                        </div>

                        <div class="p-space-sm rounded-xl bg-surface-container-low flex items-start space-x-space-sm hover:bg-surface-container-high transition-colors">
                            <div class="w-7 h-7 rounded bg-secondary-container/30 flex items-center justify-center text-secondary shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[16px]">deployed_code</span>
                            </div>
                            <div>
                                <h2 class="font-headline-sm text-headline-sm text-on-surface font-medium">Pre-configured Enterprise Modules</h2>
                                <p class="font-body-sm text-body-sm text-outline">ผสาน User & Roles, Audit Trail, Media Manager พร้อมใช้งานทันที</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Live Terminal Status Ticker -->
                <div class="relative z-10 bg-surface-container-lowest p-space-sm rounded-xl font-code-block text-code-block text-outline flex items-center justify-between">
                    <div class="flex items-center space-x-2 truncate">
                        <span class="text-tertiary">➜</span>
                        <span class="text-primary">$ artisan tinker</span>
                        <span class="text-on-surface truncate">--status="Online" --memory=18.4MB</span>
                    </div>
                    <span class="bg-surface-container-highest px-2 py-0.5 rounded text-[10px] text-tertiary font-label-sm shrink-0">READY</span>
                </div>
            </div>

            <!-- Right: Authentication Form Console -->
            <div class="lg:col-span-6 p-space-md lg:p-space-xl flex flex-col justify-between bg-surface-container-low">
                <div>
                    <!-- Login Header -->
                    <div class="mb-space-md">
                        <div class="flex items-center justify-between mb-1">
                            <h2 class="font-headline-md text-headline-md text-on-surface font-semibold">ยินดีต้อนรับ</h2>
                            <span class="px-2 py-0.5 rounded-full bg-surface-container-high text-secondary font-label-sm text-label-sm">AD / LDAP CONNECTED</span>
                        </div>
                        <p class="font-body-sm text-body-sm text-outline">กรอกข้อมูลชื่อผู้ใช้งานและรหัสผ่าน Active Directory (AD) เพื่อเข้าสู่ระบบ</p>
                    </div>

                    @if(session('error'))
                        <div class="mb-space-md p-space-sm rounded-xl bg-error-container/30 border border-error/20 text-error flex items-center gap-space-xs font-body-sm">
                            <span class="material-symbols-outlined text-[18px]">error</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif


                    <!-- Form Elements -->
                    <form class="space-y-space-md" method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <!-- AD Username Field -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <label class="font-headline-sm text-headline-sm text-on-surface flex items-center space-x-1.5" for="username">
                                    <span>ชื่อผู้ใช้งาน (AD Username)</span>
                                </label>
                                <span class="font-label-sm text-label-sm text-tertiary">AD ACCOUNT</span>
                            </div>
                            <div class="relative rounded-xl overflow-hidden bg-surface-container focus-within:bg-surface-container-high transition-colors">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">
                                    <span class="material-symbols-outlined text-[18px]">account_circle</span>
                                </div>
                                <input class="w-full bg-transparent pl-10 pr-16 py-2.5 text-on-surface font-code-inline text-code-inline focus:outline-none placeholder-outline"
                                       id="username" name="username" placeholder="ระบุชื่อผู้ใช้งาน AD (เช่น pantakarn)" required type="text"
                                       value="{{ old('username', $rememberedUsername ?? '') }}">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-tertiary material-symbols-outlined text-[18px]">check_circle</span>
                                </div>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <label class="font-headline-sm text-headline-sm text-on-surface" for="password-input">
                                    <span>รหัสผ่าน (AD Password)</span>
                                </label>
                                <a class="font-body-sm text-body-sm text-primary hover:underline" href="#">ลืมรหัสผ่าน?</a>
                            </div>
                            <div class="relative rounded-xl overflow-hidden bg-surface-container focus-within:bg-surface-container-high transition-colors">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-outline">
                                    <span class="material-symbols-outlined text-[18px]">key</span>
                                </div>
                                <input class="w-full bg-transparent pl-10 pr-10 py-2.5 text-on-surface font-code-inline text-code-inline focus:outline-none placeholder-outline"
                                       id="password-input" name="password" placeholder="••••••••••••••••" required type="password" value="">
                                <button class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-on-surface"
                                        onclick="const el = document.getElementById('password-input'); el.type = el.type === 'password' ? 'text' : 'password';" type="button">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </button>
                            </div>
                        </div>

                        <!-- Extra Security & Session Options -->
                        <div class="flex items-center justify-between pt-1">
                            <label class="flex items-center space-x-2 cursor-pointer select-none">
                                <input {{ !empty($rememberChecked) ? 'checked' : '' }} class="w-4 h-4 rounded bg-surface-container text-primary-container focus:ring-0 cursor-pointer accent-primary-container" type="checkbox" name="remember" value="1">
                                <span class="font-body-sm text-body-sm text-on-surface">จดจำเซสชันนี้ในเครื่อง (Remember Me 30 วัน)</span>
                            </label>
                            <div class="flex items-center space-x-1 text-tertiary font-label-sm text-label-sm bg-tertiary-container/20 px-2 py-0.5 rounded">
                                <span class="material-symbols-outlined text-[12px]">lock</span>
                                <span>Argon2id Encrypted</span>
                            </div>
                        </div>

                        <!-- Primary CTA Button -->
                        <div class="pt-2">
                            <button class="w-full relative group overflow-hidden bg-primary-container hover:bg-error-container text-white py-3 px-space-md rounded-xl font-headline-sm text-headline-sm font-semibold flex items-center justify-center space-x-2 transition-all active:scale-[0.99] shadow-lg" type="submit">
                                <span>เข้าสู่ระบบและเริ่มสร้างโปรเจกต์ (Sign In to Engine)</span>
                                <span class="material-symbols-outlined text-[20px] transition-transform group-hover:translate-x-1">arrow_forward</span>
                            </button>
                        </div>
                    </form>

                    <!-- WebAuthn Biometric / Passkey Action Section -->
                    <div class="relative my-space-md flex items-center justify-center">
                        <div class="w-full border-t border-surface-container-high"></div>
                        <span class="absolute bg-surface-container-low px-3 font-code-inline text-[11px] text-outline uppercase tracking-wider">
                            หรือเข้าสู่ระบบด้วย
                        </span>
                    </div>

                    <div class="space-y-2">
                        <button id="btn-biometric-login" type="button" onclick="loginWithBiometrics()"
                                class="w-full relative group overflow-hidden bg-surface-container hover:bg-surface-container-high border border-secondary/40 hover:border-secondary text-secondary py-3 px-space-md rounded-xl font-headline-sm text-headline-sm font-semibold flex items-center justify-center space-x-2 transition-all active:scale-[0.99] shadow-sm cursor-pointer">
                            <span class="material-symbols-outlined text-[22px] text-secondary group-hover:scale-110 transition-transform">fingerprint</span>
                            <span>สแกนลายนิ้วมือ / Passkey (Windows Hello / Touch ID)</span>
                        </button>
                        <div id="biometric-status" class="hidden text-center text-label-sm font-code-inline text-outline py-1"></div>
                    </div>
                </div>

                <!-- Footer Registration Hint -->
                <div class="mt-space-lg pt-space-sm text-center">
                    <p class="font-body-sm text-body-sm text-outline">
                        ยังไม่มีบัญชีนักพัฒนา? 
                        <a class="text-primary font-medium hover:underline inline-flex items-center ml-1" href="#">
                            ลงทะเบียนขอสิทธิ์ทดสอบฟรี (Request Early Access)
                            <span class="material-symbols-outlined text-[14px] ml-0.5">open_in_new</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Bottom System Micro-Readout -->
        <div class="w-full flex flex-col md:flex-row items-center justify-between pt-space-sm text-outline font-label-sm text-label-sm gap-2">
            <div class="flex items-center space-x-4">
                <span>SERVER: TH-WEST-04</span>
                <span>LATENCY: 12ms</span>
                <span>DATABASE: MySQL 8.4 CLUSTER OK</span>
            </div>
            <div class="flex items-center space-x-4">
                <a class="hover:text-on-surface transition-colors" href="#">ข้อกำหนดการใช้งาน</a>
                <span>•</span>
                <a class="hover:text-on-surface transition-colors" href="#">นโยบายความเป็นส่วนตัว</a>
                <span>•</span>
                <a class="hover:text-on-surface transition-colors" href="#">คู่มือสถาปัตยกรรม (Docs)</a>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    const { base64urlToUint8Array, bufferToBase64url } = window.artisanCrypto;

    async function loginWithBiometrics() {
        const statusEl = document.getElementById('biometric-status');
        const btnEl = document.getElementById('btn-biometric-login');

        if (!window.PublicKeyCredential) {
            if (window.ArtisanSwal) {
                ArtisanSwal.fire({
                    icon: 'warning',
                    title: 'อุปกรณ์ไม่รองรับ Passkey',
                    text: 'ขออภัย เบราว์เซอร์หรืออุปกรณ์ของคุณไม่รองรับมาตรฐาน WebAuthn / Passkey'
                });
            } else {
                alert('ขออภัย เบราว์เซอร์หรืออุปกรณ์ของคุณไม่รองรับมาตรฐาน WebAuthn / Passkey');
            }
            return;
        }

        try {
            if (statusEl) {
                statusEl.classList.remove('hidden', 'text-error', 'text-tertiary');
                statusEl.classList.add('text-secondary');
                statusEl.textContent = 'กำลังเตรียมระบบสแกนลายนิ้วมือ...';
            }
            if (btnEl) btnEl.disabled = true;

            const usernameInput = document.getElementById('username')?.value.trim() || null;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // 1. ขอ Login Challenge & Options จาก Server
            const optRes = await fetch('{{ route("webauthn.login.options") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ username: usernameInput })
            });

            if (!optRes.ok) {
                const err = await optRes.json();
                throw new Error(err.error || 'ไม่สามารถขอข้อมูลยืนยันตัวตนได้');
            }

            const options = await optRes.json();

            // ตรวจสอบทันทีว่าระบบมีลายนิ้วมือที่ลงทะเบียนไว้หรือไม่ (กรณีเพิ่งติดตั้งหรือ migrate:fresh)
            if (options.total_credentials === 0 || (options.user_has_credentials === false)) {
                if (statusEl) {
                    statusEl.classList.remove('text-secondary');
                    statusEl.classList.add('text-error');
                    statusEl.textContent = 'ยังไม่มีข้อมูลลายนิ้วมือในระบบ';
                }
                if (window.ArtisanSwal) {
                    ArtisanSwal.fire({
                        icon: 'info',
                        title: 'ยังไม่มีข้อมูลลายนิ้วมือในระบบ',
                        html: `
                            <div class="text-left space-y-3 mt-2">
                                <p class="text-on-surface">ระบบยังไม่พบข้อมูลลายนิ้วมือ (Passkey) ที่ผูกกับบัญชีผู้ใช้ใดๆ ในระบบ</p>
                                <div class="p-3 rounded-lg bg-surface-container border border-surface-container-highest text-sm text-outline">
                                    <p class="font-medium text-tertiary mb-1">📌 ขั้นตอนการใช้งานครั้งแรก:</p>
                                    <ol class="list-decimal list-inside space-y-1.5 text-xs">
                                        <li>กรอก <b>AD Username + รหัสผ่าน</b> เพื่อเข้าสู่ระบบก่อน</li>
                                        <li>ไปที่เมนู <b>โปรไฟล์ (Profile)</b> มุมขวาบน</li>
                                        <li>กดปุ่ม <b>"ลงทะเบียนอุปกรณ์ / สแกนนิ้วใหม่"</b> เพื่อบันทึกลายนิ้วมือ</li>
                                    </ol>
                                </div>
                            </div>
                        `,
                        confirmButtonText: 'เข้าสู่ระบบด้วยรหัสผ่าน'
                    }).then(() => {
                        document.getElementById('username')?.focus();
                    });
                } else {
                    alert('ยังไม่มีข้อมูลลายนิ้วมือในระบบ กรุณาเข้าสู่ระบบด้วยรหัสผ่านแล้วไปลงทะเบียนที่หน้าโปรไฟล์ก่อน');
                }
                return;
            }

            options.challenge = base64urlToUint8Array(options.challenge);
            if (options.allowCredentials && options.allowCredentials.length > 0) {
                options.allowCredentials = options.allowCredentials.map(cred => {
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

            if (statusEl) statusEl.textContent = 'กรุณาแตะลายนิ้วมือบนอุปกรณ์ของคุณ...';

            // 2. เรียก Native WebAuthn API (Windows Hello / Touch ID / FIDO2)
            const assertion = await navigator.credentials.get({
                publicKey: options
            });

            if (!assertion) {
                throw new Error('การสแกนลายนิ้วมือถูกยกเลิก');
            }

            if (statusEl) statusEl.textContent = 'กำลังตรวจสอบความถูกต้องของลายเซ็น...';

            // 3. จัดเตรียม Signature Payload
            const payload = {
                id: assertion.id,
                rawId: bufferToBase64url(assertion.rawId),
                type: assertion.type,
                response: {
                    clientDataJSON: bufferToBase64url(assertion.response.clientDataJSON),
                    authenticatorData: bufferToBase64url(assertion.response.authenticatorData),
                    signature: bufferToBase64url(assertion.response.signature),
                    userHandle: assertion.response.userHandle ? bufferToBase64url(assertion.response.userHandle) : null
                }
            };

            // 4. ส่งไปตรวจสอบลายเซ็นบน Server
            const verifyRes = await fetch('{{ route("webauthn.login.verify") }}', {
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
                const errorObj = new Error(verifyData.error || 'การยืนยันตัวตนไม่สำเร็จ');
                if (verifyData.not_registered) errorObj.notRegistered = true;
                throw errorObj;
            }

            if (statusEl) {
                statusEl.classList.remove('text-secondary');
                statusEl.classList.add('text-tertiary');
                statusEl.textContent = '✓ ยืนยันตัวตนสำเร็จ กำลังเข้าสู่ระบบ...';
            }

            if (window.ArtisanSwal) {
                ArtisanSwal.fire({
                    icon: 'success',
                    title: 'ยืนยันตัวตนสำเร็จ',
                    text: 'ยินดีต้อนรับกลับ กำลังนำคุณเข้าสู่ระบบ...',
                    timer: 1200,
                    showConfirmButton: false
                });
            }

            // นำทางไปยัง Generator Step 1
            setTimeout(() => {
                window.location.href = verifyData.redirect || '{{ route("generator.step1") }}';
            }, 500);
        } catch (err) {
            console.error(err);
            const errMsg = err.message || 'การสแกนลายนิ้วมือไม่สำเร็จ';
            if (statusEl) {
                statusEl.classList.remove('text-secondary');
                statusEl.classList.add('text-error');
                statusEl.textContent = errMsg;
            }

            if (window.ArtisanSwal) {
                const isNoPasskey = err.notRegistered || errMsg.includes('ไม่พบลายนิ้วมือ') || errMsg.includes('ไม่พบข้อมูล') || errMsg.includes('ลงทะเบียน');
                if (isNoPasskey) {
                    ArtisanSwal.fire({
                        icon: 'info',
                        title: 'ยังไม่มีข้อมูลลายนิ้วมือในระบบ',
                        html: `
                            <div class="text-left space-y-3 mt-2">
                                <p class="text-on-surface">ระบบยังไม่พบลายนิ้วมือนี้ผูกกับบัญชีผู้ใช้ใดๆ</p>
                                <div class="p-3 rounded-lg bg-surface-container border border-surface-container-highest text-sm text-outline">
                                    <p class="font-medium text-tertiary mb-1">📌 สำหรับการใช้งานครั้งแรก:</p>
                                    <ol class="list-decimal list-inside space-y-1.5 text-xs">
                                        <li>กรอก <b>AD Username + รหัสผ่าน</b> เพื่อเข้าสู่ระบบก่อน</li>
                                        <li>ไปที่เมนู <b>โปรไฟล์ (Profile)</b> มุมขวาบน</li>
                                        <li>กดปุ่ม <b>"ลงทะเบียนอุปกรณ์ / สแกนนิ้วใหม่"</b> เพื่อบันทึกลายนิ้วมือ</li>
                                    </ol>
                                </div>
                            </div>
                        `,
                        confirmButtonText: 'เข้าสู่ระบบด้วยรหัสผ่าน'
                    }).then(() => {
                        document.getElementById('username')?.focus();
                    });
                } else {
                    ArtisanSwal.fire({
                        icon: 'error',
                        title: 'เข้าสู่ระบบด้วยลายนิ้วมือไม่สำเร็จ',
                        text: errMsg,
                        confirmButtonText: 'รับทราบ'
                    });
                }
            } else {
                alert('เกิดข้อผิดพลาด: ' + errMsg);
            }
        } finally {
            if (btnEl) btnEl.disabled = false;
        }
    }
</script>
@endpush
