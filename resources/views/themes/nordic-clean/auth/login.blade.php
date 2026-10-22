@extends(view()->exists('layouts.app') ? 'layouts.app' : 'themes.nordic-clean.layouts.app')

@section('no_sidebar', 'true')
@section('no_header', 'true')

@section('content')
<div class="d-flex flex-column justify-content-between min-vh-100" style="background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 50%, #E2E8F0 100%);">
    <!-- Header -->
    <header class="w-100 bg-white bg-opacity-75 backdrop-blur border-bottom border-light-subtle shadow-sm py-2">
        <div class="container-fluid px-4 px-lg-5 d-flex align-items-center justify-content-between" style="max-width: 1320px; height: 3.5rem;">
            <div class="d-flex align-items-center gap-2">
                <span class="badge rounded-pill d-inline-flex align-items-center gap-2 px-3 py-2 text-uppercase fw-semibold" style="background-color: #0F172A; color: #ffffff; border: none; font-size: 0.75rem; letter-spacing: 0.05em;">
                    <span class="rounded-circle" style="width: 6px; height: 6px; background-color: #ffffff;"></span>NORDIC CLEAN
                </span>
                <div class="vr mx-2 text-secondary opacity-50 d-none d-sm-block"></div>
                <div class="d-flex align-items-center gap-1">
                    <span class="fw-bold fs-6" style="color: #0F172A;">Artisan</span>
                    <span class="fw-semibold text-dark fs-6">{{ preg_replace('/^Artisan\s+/i', '', $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'POS & Inventory Hub')) }}</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 text-secondary">
                <i class="bi bi-shield-check fs-5" style="color: #0F172A;"></i>
                <span class="small d-none d-sm-inline fw-medium">Secure Enterprise Auth Gateway</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow-1 d-flex align-items-center justify-content-center p-3 p-md-4">
        <div class="d-flex flex-column align-items-center justify-content-center w-100 py-3">
            <!-- Ambient Wrapper -->
            <div class="position-relative w-100" style="max-width: 520px;">
                <div class="ambient-glow-1"></div>
                <div class="ambient-glow-2"></div>

                <!-- Main Authentication Card -->
                <div class="card position-relative bg-white rounded-4 shadow-lg p-4 p-sm-5 d-flex flex-column gap-3" style="border: 1px solid #E2E8F0;">
                    <!-- Top Accent Bar -->
                    <div class="card-top-accent"></div>

                    <!-- Header & Crest Section -->
                    <div class="d-flex flex-column align-items-center text-center pt-2">
                        <!-- Shield Badge with Pulse -->
                        <div class="position-relative mb-3 d-flex align-items-center justify-content-center">
                            <div class="crest-shield rounded-4 d-flex align-items-center justify-content-center shadow-sm">
                                <i class="bi bi-shield-lock-fill fs-2" style="color: #0F172A;"></i>
                            </div>
                        </div>
                        <h1 class="fs-4 fw-bold tracking-tight mb-2" style="color: #0F172A;">
                            {{ $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'Artisan POS & Inventory Hub') }}
                        </h1>
                        <!-- Enterprise Protocol Badges -->
                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-1">
                            <span class="badge rounded-pill px-3 py-1 fw-semibold border" style="background-color: #F1F5F9; border-color: #E2E8F0 !important; color: #0F172A;">
                                <span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background-color: #0F172A;"></span>
                                UMS BUU Protocol
                            </span>
                            <span class="badge rounded-pill px-2.5 py-1 fw-semibold border" style="background-color: #F8FAFC; border-color: #E2E8F0 !important; color: #334155;">
                                <i class="bi bi-diagram-3 me-1" style="color: #0F172A;"></i>Active Directory
                            </span>
                            <span class="badge rounded-pill px-2.5 py-1 fw-semibold border text-secondary" style="background-color: #F8FAFC; border-color: #E2E8F0 !important;">
                                <i class="bi bi-lock me-1"></i>256-Bit TLS
                            </span>
                        </div>
                    </div>

                    <!-- Status Alerts -->
                    @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 mb-0" role="alert" style="border-radius: 0.5rem; font-size: 0.875rem;">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-0" role="alert" style="border-radius: 0.5rem; font-size: 0.875rem;">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    @endif

                    <!-- Authentication Form -->
                    <form method="POST" action="{{ Route::has('login.post') ? route('login.post') : '#' }}" class="d-flex flex-column gap-3 mt-1" id="loginForm">
                        @csrf
                        <!-- Username Field -->
                        <div class="d-flex flex-column gap-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="form-label mb-0 fw-semibold small text-dark" for="username">
                                    ชื่อผู้ใช้งาน <span class="text-secondary fw-normal">(BUU ACCOUNT / USERNAME)</span>
                                </label>
                                <span class="badge bg-transparent text-uppercase px-0 fw-bold" style="font-size: 0.75rem; color: #475569 !important;">Required</span>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-secondary">
                                    <i class="bi bi-person fs-5"></i>
                                </span>
                                <input autocomplete="username" class="form-control border-start-0 py-2" id="username" name="username" placeholder="e.g. s65123456 or pantakarn" required autofocus type="text" value="{{ old('username', 'pantakarn') }}">
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="d-flex flex-column gap-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="form-label mb-0 fw-semibold small text-dark" for="password">
                                    รหัสผ่าน <span class="text-secondary fw-normal">(BUU PASSWORD)</span>
                                </label>
                                <a class="small text-decoration-none fw-semibold" href="javascript:void(0)" onclick="alert('กรุณาติดต่อฝ่ายเทคโนโลยีสารสนเทศ UMS หรือรีเซ็ตรหัสผ่านผ่านระบบ BUU Account Portal')" style="color: #0F172A !important;">
                                    ลืมรหัสผ่าน?
                                </a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-secondary">
                                    <i class="bi bi-key fs-5"></i>
                                </span>
                                <input autocomplete="current-password" class="form-control border-start-0 border-end-0 py-2" id="password" name="password" placeholder="กรอกรหัสผ่านบัญชี BUU" required type="password" value="Demo@Password2025">
                                <button aria-label="Toggle Password Visibility" class="input-group-text bg-white border-start-0 text-secondary btn-password-toggle" id="togglePasswordBtn" onclick="togglePasswordVisibility()" title="Toggle Password Visibility" type="button">
                                    <i class="bi bi-eye fs-5" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="d-flex align-items-center justify-content-between pt-1">
                            <div class="form-check d-flex align-items-center gap-2 mb-0">
                                <input class="form-check-input mt-0" id="remember" name="remember" type="checkbox" {{ old('remember', true) ? 'checked' : '' }} style="accent-color: #0F172A; cursor: pointer;">
                                <label class="form-check-label text-dark small" for="remember">
                                    จดจำการเข้าสู่ระบบ <span class="text-secondary">(Remember Me)</span>
                                </label>
                            </div>
                            <span class="text-secondary small d-none d-sm-inline">30 วันบนอุปกรณ์นี้</span>
                        </div>

                        <!-- Primary Action Button: BUU Account Login -->
                        <button class="btn btn-nordic-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2 mt-2 shadow-sm" id="loginBtn" type="submit" style="background-color: #0F172A; border-color: #0F172A; color: #ffffff;">
                            <i class="bi bi-box-arrow-in-right fs-5"></i>
                            <span class="fw-semibold" id="loginBtnText">เข้าสู่ระบบด้วย BUU Account</span>
                            <div class="spinner-border spinner-border-sm text-light d-none" id="loginSpinner" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>

                        <!-- Divider with label -->
                        <div class="position-relative text-center my-2">
                            <hr class="text-secondary opacity-25 m-0"/>
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-secondary text-uppercase fw-medium" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                                หรือยืนยันตัวตนแบบไร้รหัสผ่าน
                            </span>
                        </div>

                        <!-- Secondary Action Button: Passkey / Biometrics -->
                        <button class="btn w-100 py-2 d-flex align-items-center justify-content-center gap-2 border" id="btn-biometric-login" onclick="loginWithBiometrics()" type="button" style="border-color: #E2E8F0 !important; color: #0F172A; background-color: #F8FAFC;">
                            <i class="bi bi-fingerprint fs-4" style="color: #0F172A;"></i>
                            <span>สแกนลายนิ้วมือ / Passkey <span class="small fw-normal text-secondary d-none d-sm-inline">(Windows Hello / Touch ID)</span></span>
                        </button>
                        <div id="biometric-status" class="small text-center text-secondary d-none"></div>
                    </form>

                    <!-- Enterprise Security Compliance Section -->
                    <div class="border rounded-3 p-3 d-flex flex-column gap-2 mt-1" style="background-color: #F8FAFC; border-color: #E2E8F0 !important;">
                        <div class="d-flex align-items-center gap-2 fw-semibold small" style="color: #0F172A;">
                            <i class="bi bi-patch-check-fill" style="color: #0F172A;"></i>
                            <span>มาตรฐานความปลอดภัย UMS BUU:</span>
                        </div>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-1 ps-1 small" style="color: #334155;">
                            <li class="d-flex align-items-start gap-2">
                                <span class="rounded-circle mt-2 flex-shrink-0" style="width: 6px; height: 6px; background-color: #0F172A;"></span>
                                <span>ยืนยันตัวตนผ่าน Active Directory กลางและดึงกลุ่มสิทธิ์จาก <span class="fw-semibold" style="color: #0F172A;">UMS Central Gateway</span></span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <span class="rounded-circle mt-2 flex-shrink-0" style="width: 6px; height: 6px; background-color: #0F172A;"></span>
                                <span>รองรับการเข้าสู่ระบบแบบชีวมิติตลับกุญแจ <span class="fw-semibold" style="color: #0F172A;">(W3C WebAuthn &amp; FIDO2 Passkey)</span></span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <span class="rounded-circle mt-2 flex-shrink-0 bg-danger" style="width: 6px; height: 6px;"></span>
                                <span>ไม่มีบทบาท <code class="px-1.5 py-0.5 rounded text-danger bg-danger-subtle fw-bold" style="font-size: 0.8rem;">superadmin</code> ในระบบ UMS ตามข้อกำหนดการแยกหน้าที่ความปลอดภัย</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <span class="rounded-circle mt-2 flex-shrink-0" style="width: 6px; height: 6px; background-color: #0F172A;"></span>
                                <span>จำกัดความถี่การเข้าสู่ระบบ 5 ครั้ง/นาที เพื่อป้องกันการโจมตีแบบ Brute Force</span>
                            </li>
                        </ul>
                        <div class="mt-1 pt-2 d-flex align-items-center justify-content-between small text-secondary border-top" style="font-size: 0.75rem; border-color: #E2E8F0 !important;">
                            <span class="d-flex align-items-center gap-1">
                                <i class="bi bi-shield-shaded" style="color: #0F172A;"></i>SESSION_SEED: 0x9F41…E8A3
                            </span>
                            <span>GATEWAY: UMS-NODE-04</span>
                        </div>
                    </div>
                </div>

                <!-- Security Gateway Footer Meta -->
                <div class="mt-3 d-flex flex-wrap align-items-center justify-content-between px-2 text-secondary small" style="font-size: 0.8rem;">
                    <span class="d-flex align-items-center gap-1">
                        <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background-color: #0F172A;"></span>
                        UMS Authentication Cluster Active
                    </span>
                    <span>Enterprise SLA 99.99%</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-100 py-3 border-top" style="background-color: #F8FAFC; border-color: #E2E8F0 !important;">
        <div class="container text-center small fw-medium" style="color: #64748B;">
            {{ config('app.name', 'Artisan POS & Inventory Hub') }} • UMS BUU Integrated Enterprise Ecosystem
        </div>
    </footer>
</div>

<script>
    function togglePasswordVisibility() {
        const pwdInput = document.getElementById('password');
        const pwdIcon = document.getElementById('togglePasswordIcon');
        if (!pwdInput || !pwdIcon) return;

        if (pwdInput.type === 'password') {
            pwdInput.type = 'text';
            pwdIcon.className = 'bi bi-eye-slash fs-5';
        } else {
            pwdInput.type = 'password';
            pwdIcon.className = 'bi bi-eye fs-5';
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
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        if (!window.PublicKeyCredential) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'ไม่รองรับ WebAuthn',
                    text: 'เบราว์เซอร์หรืออุปกรณ์ของคุณไม่รองรับการสแกนลายนิ้วมือ หรือยังไม่ได้เปิดใช้ HTTPS/Localhost',
                    confirmButtonColor: '#0F172A',
                    confirmButtonText: 'ตกลง'
                });
            } else {
                alert('เบราว์เซอร์หรืออุปกรณ์ของคุณไม่รองรับการสแกนลายนิ้วมือ');
            }
            return;
        }

        if (btnEl) {
            btnEl.disabled = true;
            btnEl.classList.add('opacity-75');
        }
        if (statusEl) {
            statusEl.classList.remove('d-none');
            statusEl.textContent = 'กำลังขอข้อมูลยืนยันตัวตนชีวมิติจาก UMS...';
        }

        try {
            const optRes = await fetch('{{ Route::has("webauthn.login.options") ? route("webauthn.login.options") : url("/webauthn/login/options") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ username: usernameVal })
            });

            if (!optRes.ok) {
                const errData = await optRes.json().catch(() => ({}));
                throw new Error(errData.error || 'ไม่สามารถรับข้อมูล Passkey Challenge ได้');
            }

            const options = await optRes.json();
            options.challenge = base64urlToUint8Array(options.challenge);
            if (options.allowCredentials && options.allowCredentials.length > 0) {
                options.allowCredentials = options.allowCredentials.map(c => ({
                    ...c,
                    id: base64urlToUint8Array(c.id)
                }));
            }

            if (statusEl) {
                statusEl.textContent = 'กรุณาสแกนลายนิ้วมือบนอุปกรณ์ของคุณ (Windows Hello / Touch ID)...';
            }

            const assertion = await navigator.credentials.get({
                publicKey: options
            });

            if (!assertion) {
                throw new Error('การสแกนลายนิ้วมือถูกยกเลิก');
            }

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

            if (statusEl) {
                statusEl.textContent = 'กำลังตรวจสอบลายเซ็นชีวมิติ...';
            }

            const verifyRes = await fetch('{{ Route::has("webauthn.login.verify") ? route("webauthn.login.verify") : url("/webauthn/login/verify") }}', {
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
                throw new Error(verifyData.error || 'การยืนยันลายนิ้วมือล้มเหลว');
            }

            if (statusEl) {
                statusEl.className = 'small text-center text-success fw-bold';
                statusEl.textContent = 'ยืนยันตัวตนสำเร็จ! กำลังเข้าสู่ระบบ...';
            }

            window.location.href = verifyData.redirect || '{{ Route::has("demo.index") ? route("demo.index") : url("/") }}';
        } catch (err) {
            console.error(err);
            if (statusEl) {
                statusEl.className = 'small text-center text-danger';
                statusEl.textContent = 'เกิดข้อผิดพลาด: ' + (err.message || 'ไม่สามารถยืนยันตัวตนได้');
            }
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'การเข้าสู่ระบบชีวมิติล้มเหลว',
                    text: err.message || 'ไม่สามารถยืนยันลายนิ้วมือได้ กรุณาลองใหม่อีกครั้งหรือใช้รหัสผ่าน BUU',
                    confirmButtonColor: '#0F172A',
                    confirmButtonText: 'ตกลง'
                });
            } else {
                alert('การเข้าสู่ระบบชีวมิติล้มเหลว: ' + err.message);
            }
        } finally {
            if (btnEl) {
                btnEl.disabled = false;
                btnEl.classList.remove('opacity-75');
            }
        }
    }

    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', () => {
            const btn = document.getElementById('loginBtn');
            const btnText = document.getElementById('loginBtnText');
            const spinner = document.getElementById('loginSpinner');
            if (btn && btnText && spinner) {
                btn.disabled = true;
                btn.classList.add('opacity-75');
                btnText.textContent = 'กำลังตรวจสอบสิทธิ์ UMS BUU...';
                spinner.classList.remove('d-none');
            }
        });
    }
</script>
@endsection
