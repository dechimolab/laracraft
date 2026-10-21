@extends(view()->exists('layouts.app') ? 'layouts.app' : 'themes.emerald-enterprise.layouts.app')

@section('no_sidebar', 'true')

@section('content')
<div class="flex flex-col w-full items-center justify-center py-6 px-4">
    <!-- Subtle decorative ambient glows -->
    <div class="relative w-full max-w-[540px]">
        <div class="absolute -top-20 -left-20 w-64 h-64 bg-emerald-200/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -right-20 w-72 h-72 bg-teal-200/35 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Main Authentication Card -->
        <div class="relative w-full bg-surface-container-lowest rounded-xl shadow-xl p-6 sm:p-8 flex flex-col gap-space-lg" style="background: #ffffff; border: 1px solid #d1fae5; box-shadow: rgba(4, 120, 87, 0.08) 0px 20px 25px -5px, rgba(4, 120, 87, 0.04) 0px 8px 10px -6px;">
            <!-- Top Accent Bar -->
            <div class="absolute top-0 left-6 right-6 h-1.5 rounded-full" style="background: linear-gradient(90deg, #047857 0%, #10b981 100%);"></div>

            <!-- Header & Crest Section -->
            <div class="flex flex-col items-center text-center pt-2">
                <!-- Shield Badge with Pulse -->
                <div class="relative mb-3 flex items-center justify-center">
                    <div class="absolute -inset-1.5 rounded-2xl bg-emerald-100 opacity-80 blur-sm"></div>
                    <div class="relative w-14 h-14 rounded-2xl flex items-center justify-center shadow-md" style="background: #047857; color: #ffffff; border: 2px solid #a7f3d0;">
                        <span class="material-symbols-outlined text-[30px]" style="font-variation-settings: 'FILL' 1;">shield_person</span>
                    </div>
                </div>

                <h1 class="font-headline-lg text-headline-lg font-bold text-on-surface tracking-tight mb-2" style="color: #0f172a;">
                    {{ config('app.name', 'Artisan POS & Inventory Hub') }}
                </h1>

                <!-- Enterprise Protocol Badges -->
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background: #f0fdf4; border: 1px solid #a7f3d0; color: #047857;">
                        <span class="w-2 h-2 rounded-full" style="background: #10b981;"></span>UMS BUU Protocol
                    </span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold" style="background: #f0fdf4; border: 1px solid #d1fae5; color: #047857;">
                        <span class="material-symbols-outlined text-[14px]" style="color: #10b981;">account_tree</span>Active Directory
                    </span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #475569;">
                        <span class="material-symbols-outlined text-[13px]">lock</span>256-Bit TLS
                    </span>
                </div>
            </div>

            <!-- Status Banner -->
            @if(session('error'))
            <div class="w-full rounded-lg p-3.5 flex items-start gap-2 bg-red-50 border border-red-200 text-red-800" role="alert">
                <span class="material-symbols-outlined text-[20px] shrink-0 mt-0.5 text-red-600">error</span>
                <div class="flex-1 min-w-0 font-body-sm">{{ session('error') }}</div>
            </div>
            @endif

            @if(session('success'))
            <div class="w-full rounded-lg p-3.5 flex items-start gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800" role="alert">
                <span class="material-symbols-outlined text-[20px] shrink-0 mt-0.5 text-emerald-600">check_circle</span>
                <div class="flex-1 min-w-0 font-body-sm">{{ session('success') }}</div>
            </div>
            @endif

            <!-- Authentication Form -->
            <form method="POST" action="{{ route('login.post') }}" class="flex flex-col gap-4" id="loginForm">
                @csrf
                <!-- Username Field -->
                <div class="flex flex-col gap-1.5">
                    <label class="flex items-center justify-between font-label-md text-label-md text-on-surface" for="username">
                        <span>ชื่อผู้ใช้งาน <span class="text-outline font-normal">(BUU ACCOUNT / USERNAME)</span></span>
                        <span class="font-label-sm text-label-sm font-semibold uppercase tracking-wider" style="color: #047857;">Required</span>
                    </label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3.5 text-outline text-[20px] pointer-events-none">
                            person
                        </span>
                        <input autocomplete="username" class="w-full h-11 pl-11 pr-4 bg-white rounded font-body-md text-body-md shadow-sm focus:outline-none transition-all" id="username" name="username" placeholder="e.g. s65123456 หรือ pusit" required autofocus style="border: 1.5px solid #cbd5e1; color: #0f172a;" onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.2)'" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'" type="text" value="{{ old('username', 'pantakarn') }}">
                    </div>
                </div>

                <!-- Password Field -->
                <div class="flex flex-col gap-1.5">
                    <div class="flex items-center justify-between">
                        <label class="font-label-md text-label-md text-on-surface" for="password">
                            รหัสผ่าน <span class="text-outline font-normal">(BUU PASSWORD)</span>
                        </label>
                        <a class="font-label-sm text-label-sm underline underline-offset-2 transition-colors cursor-pointer" href="javascript:void(0)" onclick="alert('กรุณาติดต่อฝ่ายเทคโนโลยีสารสนเทศ UMS หรือรีเซ็ตรหัสผ่านผ่านระบบ BUU Account Portal')" style="color: #047857;">
                            ลืมรหัสผ่าน?
                        </a>
                    </div>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3.5 text-outline text-[20px] pointer-events-none">
                            key
                        </span>
                        <input autocomplete="current-password" class="w-full h-11 pl-11 pr-11 bg-white rounded font-body-md text-body-md shadow-sm focus:outline-none transition-all tracking-wider" id="password" name="password" placeholder="กรอกรหัสผ่านบัญชี BUU" required style="border: 1.5px solid #cbd5e1; color: #0f172a;" onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.2)'" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'" type="password">
                        <button aria-label="Toggle Password Visibility" class="absolute right-3 text-outline hover:text-on-surface p-1 rounded focus:outline-none" id="togglePasswordBtn" onclick="togglePasswordVisibility()" title="Toggle Password" type="button">
                            <span class="material-symbols-outlined text-[20px]" id="togglePasswordIcon">visibility</span>
                        </button>
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input class="w-4 h-4 rounded text-primary focus:ring-primary focus:ring-offset-0 transition-colors accent-primary cursor-pointer" id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                        <span class="font-body-md text-body-md text-on-surface">
                            จดจำการเข้าสู่ระบบ <span class="text-outline font-body-sm text-body-sm">(Remember Me)</span>
                        </span>
                    </label>
                    <span class="font-label-sm text-label-sm text-outline hidden sm:inline">30 วันบนอุปกรณ์นี้</span>
                </div>

                <!-- Primary Action Button: BUU Account Login -->
                <button class="w-full h-11 mt-2 rounded font-label-lg text-label-lg font-semibold flex items-center justify-center gap-2 text-white active:scale-[0.99] transition-all cursor-pointer focus:outline-none shadow-md" id="loginBtn" style="background-color: #047857; box-shadow: rgba(4, 120, 87, 0.35) 0px 4px 14px 0px;" onmouseover="this.style.backgroundColor='#065f46'" onmouseout="this.style.backgroundColor='#047857'" type="submit">
                    <span class="material-symbols-outlined text-[20px]">login</span>
                    <span id="loginBtnText">เข้าสู่ระบบด้วย BUU Account</span>
                    <span class="hidden animate-spin material-symbols-outlined text-[18px]" id="loginSpinner">progress_activity</span>
                </button>

                <!-- Divider with label -->
                <div class="relative my-1 flex items-center justify-center">
                    <div class="w-full h-px bg-slate-200"></div>
                    <span class="absolute bg-white px-3 font-label-sm text-label-sm text-outline uppercase tracking-wider">
                        หรือยืนยันตัวตนแบบไร้รหัสผ่าน
                    </span>
                </div>

                <!-- Secondary Action Button: Passkey / Biometrics -->
                <button id="btn-biometric-login" class="w-full h-11 rounded font-label-lg text-label-lg flex items-center justify-center gap-2 transition-all group focus:outline-none cursor-pointer" onclick="loginWithBiometrics()" style="background: #ffffff; border: 1.5px solid #10b981; color: #047857;" onmouseover="this.style.background='#f0fdf4'; this.style.borderColor='#047857';" onmouseout="this.style.background='#ffffff'; this.style.borderColor='#10b981';" type="button">
                    <span class="material-symbols-outlined group-hover:scale-110 transition-transform text-[22px]" style="color: #047857;">fingerprint</span>
                    <span class="font-medium" style="color: #047857;">สแกนลายนิ้วมือ / Passkey <span class="text-label-sm font-normal hidden sm:inline" style="color: #059669;">(Windows Hello / Touch ID)</span></span>
                </button>
                <div id="biometric-status" class="small text-center text-secondary d-none mt-2"></div>
            </form>

            <!-- Enterprise Security Compliance Section -->
            <div class="rounded-lg p-4 flex flex-col gap-2.5" style="background: #f0fdf4; border: 1px solid #d1fae5;">
                <div class="flex items-center gap-1.5 font-label-md text-label-md font-semibold" style="color: #047857;">
                    <span class="material-symbols-outlined text-[18px]" style="color: #047857; font-variation-settings: 'FILL' 1;">verified_user</span>
                    <span>มาตรฐานความปลอดภัย UMS BUU:</span>
                </div>
                <ul class="flex flex-col gap-1.5 pl-1.5 font-body-sm text-body-sm" style="color: #1e293b;">
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 rounded-full mt-1.5 shrink-0" style="background: #10b981;"></span>
                        <span>ยืนยันตัวตนผ่าน Active Directory กลางและดึงกลุ่มสิทธิ์จาก <span class="font-medium" style="color: #047857;">UMS Central Gateway</span></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 rounded-full mt-1.5 shrink-0" style="background: #10b981;"></span>
                        <span>รองรับการเข้าสู่ระบบแบบชีวมิติตลับกุญแจ <span class="font-medium" style="color: #047857;">(W3C WebAuthn &amp; FIDO2 Passkey)</span></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 rounded-full mt-1.5 shrink-0" style="background: #ef4444;"></span>
                        <span>ไม่มีบทบาท <code class="px-1.5 py-0.5 rounded font-mono text-label-sm" style="background: #fee2e2; color: #991b1b;">superadmin</code> ในระบบ UMS ตามข้อกำหนดการแยกหน้าที่ความปลอดภัย</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 rounded-full mt-1.5 shrink-0" style="background: #10b981;"></span>
                        <span>จำกัดความถี่การเข้าสู่ระบบ 5 ครั้ง/นาที เพื่อป้องกันการโจมตีแบบ Brute Force</span>
                    </li>
                </ul>
                <div class="mt-1 pt-2 flex items-center justify-between font-label-sm text-label-sm" style="border-top: 1px solid #d1fae5; color: #64748b;">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]" style="color: #10b981;">encrypted</span>SESSION_SEED: 0x9F41…E8A3
                    </span>
                    <span>GATEWAY: UMS-NODE-04</span>
                </div>
            </div>

            <!-- Back to Main Application Link -->
            <div class="flex items-center justify-center pt-1">
                <a class="inline-flex items-center gap-1.5 font-label-md text-label-md transition-colors group text-decoration-none" href="{{ route('demo.index') }}" style="color: #047857;">
                    <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    <span>กลับสู่หน้าหลักแอปพลิเคชัน</span>
                </a>
            </div>
        </div>

        <!-- Security Gateway Footer Meta -->
        <div class="mt-4 flex flex-wrap items-center justify-between px-2 font-label-sm text-label-sm text-slate-500">
            <span class="flex items-center gap-1">
                <span class="w-2 h-2 rounded-full" style="background: #047857;"></span>
                UMS Authentication Cluster Active
            </span>
            <span>Enterprise SLA 99.99%</span>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const pwdInput = document.getElementById('password');
        const pwdIcon = document.getElementById('togglePasswordIcon');
        if (!pwdInput || !pwdIcon) return;

        if (pwdInput.type === 'password') {
            pwdInput.type = 'text';
            pwdIcon.textContent = 'visibility_off';
        } else {
            pwdInput.type = 'password';
            pwdIcon.textContent = 'visibility';
        }
    }

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

    async function loginWithBiometrics() {
        const btnEl = document.getElementById('btn-biometric-login');
        const statusEl = document.getElementById('biometric-status');
        const usernameVal = document.getElementById('username')?.value.trim() || '';
        const csrfToken = '{{ csrf_token() }}';

        if (!window.PublicKeyCredential) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'ไม่รองรับ WebAuthn',
                    text: 'เบราว์เซอร์หรืออุปกรณ์ของคุณไม่รองรับการสแกนลายนิ้วมือ หรือยังไม่ได้เปิดใช้ HTTPS/Localhost',
                    confirmButtonText: 'ตกลง'
                });
            } else {
                alert('เบราว์เซอร์หรืออุปกรณ์ของคุณไม่รองรับ WebAuthn / Passkey');
            }
            return;
        }

        try {
            if (btnEl) btnEl.disabled = true;
            if (statusEl) {
                statusEl.classList.remove('d-none', 'text-danger', 'text-success');
                statusEl.classList.add('text-secondary');
                statusEl.textContent = 'กำลังติดต่อเซิร์ฟเวอร์เพื่อขอ Challenge...';
            }

            const optionsRes = await fetch('{{ route("webauthn.login.options") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ username: usernameVal })
            });

            if (!optionsRes.ok) {
                const errData = await optionsRes.json();
                throw new Error(errData.error || 'ไม่สามารถสร้าง Challenge ได้');
            }

            const options = await optionsRes.json();

            if (options.total_credentials === 0) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'ยังไม่มีข้อมูลลายนิ้วมือในระบบ',
                        html: `
                            <div class="text-start mt-2">
                                <p class="mb-2">ระบบยังไม่พบลายนิ้วมือที่ผูกกับบัญชีผู้ใช้ใดๆ</p>
                                <div class="p-3 rounded bg-light border border-secondary-subtle small text-muted">
                                    <p class="fw-semibold text-emerald-700 mb-1">📌 สำหรับการใช้งานครั้งแรก:</p>
                                    <ol class="mb-0 ps-3">
                                        <li>เข้าสู่ระบบด้วย <b>BUU Account</b> เพื่อเข้าสู่ระบบก่อน</li>
                                        <li>จากนั้นสามารถลงทะเบียนอุปกรณ์หรือ Passkey ในหน้า Demo/Profile ได้</li>
                                    </ol>
                                </div>
                            </div>
                        `,
                        confirmButtonText: 'เข้าสู่ระบบด้วยรหัสผ่าน'
                    }).then(() => {
                        document.getElementById('username')?.focus();
                    });
                } else {
                    alert('ยังไม่มีข้อมูลลายนิ้วมือในระบบ กรุณาเข้าสู่ระบบด้วยรหัสผ่านก่อน');
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

            if (statusEl) statusEl.textContent = 'กรุณาแตะลายนิ้วมือบนอุปกรณ์ของคุณ (Touch ID / Windows Hello)...';

            const assertion = await navigator.credentials.get({
                publicKey: options
            });

            if (!assertion) {
                throw new Error('การสแกนลายนิ้วมือถูกยกเลิก');
            }

            if (statusEl) statusEl.textContent = 'กำลังตรวจสอบความถูกต้องของลายเซ็นดิจิทัล...';

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
                throw new Error(verifyData.error || 'การยืนยันตัวตนไม่สำเร็จ');
            }

            if (statusEl) {
                statusEl.classList.remove('text-secondary');
                statusEl.classList.add('text-emerald-700');
                statusEl.textContent = '✓ ยืนยันตัวตนสำเร็จ กำลังเข้าสู่ระบบ...';
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'ยืนยันตัวตนสำเร็จ',
                    text: 'ยินดีต้อนรับกลับ กำลังนำคุณเข้าสู่ระบบ...',
                    timer: 1200,
                    showConfirmButton: false
                });
            }

            setTimeout(() => {
                window.location.href = verifyData.redirect || '{{ route("demo.index") }}';
            }, 600);
        } catch (err) {
            console.error(err);
            const errMsg = err.message || 'การสแกนลายนิ้วมือไม่สำเร็จ';
            if (statusEl) {
                statusEl.classList.remove('text-secondary');
                statusEl.classList.add('text-danger');
                statusEl.textContent = errMsg;
            }
        } finally {
            if (btnEl) btnEl.disabled = false;
        }
    }
</script>
@endsection
