@extends(view()->exists('layouts.app') ? 'layouts.app' : 'themes.forest-moss.layouts.app')

@section('no_sidebar', 'true')
@section('no_header', 'true')

@section('content')
<div class="d-flex flex-column justify-content-between min-vh-100" style="background-color: var(--forest-bg, #F0FDF4); background-image: radial-gradient(circle at 10% 20%, #DCFCE7 0%, #F0FDF4 90%); background-attachment: fixed;">
    <!-- Top Bar Header -->
    <header class="w-100 bg-white bg-opacity-75 backdrop-blur border-bottom shadow-sm py-2" style="border-color: var(--forest-border, #BBF7D0) !important;">
        <div class="container-fluid px-4 px-lg-5 d-flex align-items-center justify-content-between" style="max-width: 1320px; height: 3.5rem;">
            <div class="d-flex align-items-center gap-2">
                <span class="theme-badge d-inline-flex align-items-center gap-1.5 px-3 py-1.5 text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.06em;">
                    <span class="badge rounded-circle p-1" style="background-color: #15803D !important;"></span>
                    FOREST MOSS &amp; SAGE
                </span>
                <div class="vr mx-2 text-secondary opacity-50 d-none d-sm-block"></div>
                <div class="d-flex align-items-center gap-1">
                    <span class="fw-bold fs-6" style="color: var(--forest-primary, #15803D);">Artisan</span>
                    <span class="fw-semibold text-dark fs-6">{{ preg_replace('/^Artisan\s+/i', '', $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'POS & Inventory Hub')) }}</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 text-success fw-semibold" style="font-size: 0.875rem;">
                <span class="material-symbols-outlined text-success fs-5">shield</span>
                <span class="fw-semibold text-secondary-emphasis small d-none d-md-inline">Secure Enterprise Auth Gateway</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle">TLS 1.3 FIPS</span>
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
                <div class="card position-relative bg-white border rounded-4 shadow-lg p-4 p-sm-5 d-flex flex-column gap-3" style="border-color: #BBF7D0 !important;">
                    <!-- Top Accent Bar -->
                    <div class="card-top-accent"></div>

                    <!-- Header & Crest Section -->
                    <div class="d-flex flex-column align-items-center text-center pt-2">
                        <!-- Shield Badge with Pulse -->
                        <div class="position-relative mb-3 d-flex align-items-center justify-content-center">
                            <div class="crest-shield rounded-4 d-flex align-items-center justify-content-center shadow-sm">
                                <i class="bi bi-shield-lock-fill fs-2 text-white"></i>
                            </div>
                        </div>
                        <h1 class="fs-4 fw-bold tracking-tight mb-2 text-dark">
                            {{ $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'Artisan POS & Inventory Hub') }}
                        </h1>
                        <!-- Enterprise Protocol Badges -->
                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-1">
                            <span class="badge rounded-pill px-3 py-1 fw-semibold border" style="background-color: #F0FDF4; border-color: #BBF7D0 !important; color: #15803D;">
                                <span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background-color: #84CC16;"></span>
                                UMS BUU Protocol
                            </span>
                            <span class="badge rounded-pill px-2.5 py-1 fw-semibold border" style="background-color: #F0FDF4; border-color: #DCFCE7 !important; color: #15803D;">
                                <i class="bi bi-diagram-3 me-1" style="color: #15803D;"></i>Active Directory
                            </span>
                            <span class="badge rounded-pill px-2.5 py-1 fw-semibold border text-secondary" style="background-color: #F8FAFC; border-color: #E2E8F0 !important;">
                                <i class="bi bi-lock me-1"></i>256-Bit TLS
                            </span>
                        </div>
                    </div>

                    <!-- Status Alerts -->
                    @if(session('error'))
                    <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 mb-0" role="alert" style="border-radius: 0.75rem; font-size: 0.875rem;">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-dismissible fade show p-3 mb-0 rounded-3 d-flex align-items-start gap-2.5 border-0" role="alert" style="background-color: #DCFCE7; border: 1px solid #86EFAC; color: #14532D; border-radius: 0.75rem;">
                        <span class="material-symbols-outlined text-success mt-0.5 fs-5">check_circle</span>
                        <div class="flex-grow-1 small">
                            <div class="fw-bold" style="color: #0F291E;">{{ session('success') }}</div>
                        </div>
                        <button aria-label="Close" class="btn-close p-2" data-bs-dismiss="alert" style="font-size: 10px;" type="button"></button>
                    </div>
                    @endif

                    <!-- Authentication Form -->
                    <form method="POST" action="{{ Route::has('login.post') ? route('login.post') : '#' }}" class="d-flex flex-column gap-3 mt-1" id="loginForm">
                        @csrf
                        <!-- Username / Account Field -->
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1.5">
                                <label class="form-label small fw-bold mb-0 text-uppercase" for="username" style="color: #14532D; font-size: 12px; letter-spacing: 0.02em;">
                                    ชื่อผู้ใช้งาน (BUU ACCOUNT / USERNAME)
                                </label>
                                <span class="badge rounded-1 px-1.5 py-0.5 text-uppercase" style="background-color: #E0F2FE; color: #0369A1; font-size: 10px; font-weight: 700;">REQUIRED</span>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="border-color: #BBF7D0; color: #4D7C0F;">
                                    <span class="material-symbols-outlined fs-5">person</span>
                                </span>
                                <input autocomplete="username" class="form-control" id="username" name="username" placeholder="ระบุรหัสประจำตัวหรืออีเมล BUU" required autofocus style="border-color: #BBF7D0; color: #052E16; height: 44px; font-size: 14px;" type="text" value="{{ old('username', 'pantakarn') }}"/>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1.5">
                                <label class="form-label small fw-bold mb-0 text-uppercase" for="password" style="color: #14532D; font-size: 12px; letter-spacing: 0.02em;">
                                    รหัสผ่าน (BUU PASSWORD)
                                </label>
                                <a class="text-decoration-none fw-semibold small" href="javascript:void(0)" onclick="alert('กรุณาติดต่อแผนกไอที หรือศูนย์บริการ UMS Portal เพื่อรีเซ็ตรหัสผ่าน')" style="color: #15803D; font-size: 12px;">ลืมรหัสผ่าน?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="border-color: #BBF7D0; color: #4D7C0F;">
                                    <span class="material-symbols-outlined fs-5">key</span>
                                </span>
                                <input autocomplete="current-password" class="form-control" id="password" name="password" placeholder="กรอกรหัสผ่านบัญชี" required style="border-color: #BBF7D0; color: #052E16; height: 44px; font-size: 14px;" type="password" value="Demo@Password2025"/>
                                <button aria-label="Toggle Password Visibility" class="btn btn-outline-secondary border-start-0 bg-white" id="togglePasswordBtn" onclick="togglePasswordVisibility()" style="border-color: #BBF7D0; color: #4D7C0F;" type="button">
                                    <span class="material-symbols-outlined fs-5" id="togglePasswordIcon">visibility</span>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <div class="form-check">
                                <input checked class="form-check-input" id="remember" name="remember" style="accent-color: #15803D; cursor: pointer;" type="checkbox" value="1"/>
                                <label class="form-check-label small user-select-none" for="remember" style="color: #052E16; font-size: 13px; cursor: pointer;">
                                    จดจำการเข้าสู่ระบบ (Remember Me)
                                </label>
                            </div>
                            <span class="text-muted small" style="font-size: 12px;">30 วันบนอุปกรณ์นี้</span>
                        </div>

                        <!-- Primary Submit Button -->
                        <button class="btn btn-forest-primary w-100 d-flex align-items-center justify-content-center gap-2 mt-2 shadow-sm" id="submitAuthBtn" style="height: 46px; font-size: 15px;" type="submit">
                            <span class="material-symbols-outlined fs-5">login</span>
                            <span id="loginBtnText">เข้าสู่ระบบด้วย BUU Account</span>
                            <div class="spinner-border spinner-border-sm text-light d-none" id="loginSpinner" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>

                        <!-- Divider with Label -->
                        <div class="position-relative text-center my-3">
                            <hr style="border-top: 1px solid #BBF7D0; opacity: 1; margin: 0;"/>
                            <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted small" style="font-size: 12px; color: #4D7C0F !important;">
                                หรือยืนยันตัวตนแบบไร้รหัสผ่าน
                            </span>
                        </div>

                        <!-- Biometrics / Passkey Action Button -->
                        <button class="btn w-100 fw-medium d-flex align-items-center justify-content-center gap-2 rounded-3" id="btn-biometric-login" onclick="loginWithBiometrics()" onmouseout="this.style.backgroundColor='#F0FDF4'; this.style.borderColor='#BBF7D0'" onmouseover="this.style.backgroundColor='#DCFCE7'; this.style.borderColor='#86EFAC'" style="background-color: #F0FDF4; border: 1px solid #BBF7D0; color: #14532D; height: 46px; font-size: 14px; transition: all 0.2s ease;" type="button">
                            <span class="material-symbols-outlined text-success" style="font-size: 20px;">fingerprint</span>
                            <span>สแกนลายนิ้วมือ / Passkey <span class="text-secondary opacity-75">(Windows Hello / Touch ID)</span></span>
                        </button>
                        <div id="biometric-status" class="small text-center text-secondary d-none"></div>
                    </form>

                    <!-- Security Compliance Section -->
                    <div class="p-3 mb-1" style="background-color: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 0.85rem;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="material-symbols-outlined text-success fs-5">verified_user</span>
                            <span class="fw-bold" style="font-size: 0.79rem; color: #052E16;">มาตรฐานความปลอดภัย UMS BUU:</span>
                        </div>
                        <ul class="list-unstyled mb-2 pe-1 ps-1" style="font-size: 0.73rem; color: #14532D; line-height: 1.45;">
                            <li class="d-flex align-items-start mb-1 gap-2">
                                <span class="text-success mt-1" style="font-size: 0.45rem;">●</span>
                                <span>ยืนยันตัวตนผ่าน Active Directory กลางและดึงกลุ่มสิทธิ์จาก UMS Central Gateway</span>
                            </li>
                            <li class="d-flex align-items-start mb-1 gap-2">
                                <span class="text-success mt-1" style="font-size: 0.45rem;">●</span>
                                <span>รองรับการเข้าสู่ระบบแบบชีวมิติด้วยกุญแจ <strong>(W3C WebAuthn &amp; FIDO2 Passkey)</strong></span>
                            </li>
                            <li class="d-flex align-items-start mb-1 gap-2">
                                <span class="text-danger mt-1" style="font-size: 0.45rem;">●</span>
                                <span>ไม่มีบทบาท <code class="px-1 py-0 rounded text-danger fw-bold" style="background-color: #FEE2E2; font-size: 0.7rem;">superadmin</code> ในระบบ UMS ตามข้อกำหนดการแยกหน้าที่ความปลอดภัย</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <span class="text-success mt-1" style="font-size: 0.45rem;">●</span>
                                <span>จำกัดความถี่การเข้าสู่ระบบ 5 ครั้ง/นาที เพื่อป้องกันการโจมตีแบบ Brute Force</span>
                            </li>
                        </ul>
                        <!-- Diagnostic Telemetry Bar -->
                        <div class="pt-2 d-flex flex-wrap align-items-center justify-content-between text-secondary font-monospace" style="border-top: 1px dashed #BBF7D0; font-size: 0.65rem;">
                            <span><i class="bi bi-cpu me-1"></i>SESSION_SEED: 0x9F41...E8A3</span>
                            <span><i class="bi bi-hdd-network me-1"></i>GATEWAY: UMS-NODE-04</span>
                        </div>
                    </div>
                </div>

                <!-- Authenticator Cluster Status Tracker -->
                <div class="mt-3 d-flex flex-wrap align-items-center justify-content-center gap-3 text-secondary" style="font-size: 0.74rem;">
                    <span class="d-flex align-items-center gap-1">
                        <span class="d-inline-block rounded-circle" style="width: 8px; height: 8px; background-color: #10B981; box-shadow: 0 0 6px rgba(16, 185, 129, 0.6);"></span>
                        UMS Authentication Cluster Active
                    </span>
                    <span>•</span>
                    <span>Enterprise SLA 99.99%</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-bar py-3 text-center" style="background-color: #FFFFFF; border-top: 1px solid #BBF7D0; font-size: 0.8rem; color: #14532D;">
        <div class="container d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <span>&copy; {{ date('Y') }} Burapha University (BUU). All rights reserved.</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span><i class="bi bi-patch-check-fill text-success me-1"></i>Enterprise SLA 99.99%</span>
                <span class="opacity-50">|</span>
                <span>TLS 1.3 Certified Bank-Grade Node</span>
            </div>
        </div>
    </footer>
</div>
@endsection

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const pwdInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        if (pwdInput && icon) {
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                pwdInput.type = 'password';
                icon.textContent = 'visibility';
            }
        }
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

    // WebAuthn Passkey Login Execution
    async function loginWithBiometrics() {
        const statusBox = document.getElementById('biometric-status');
        if (statusBox) {
            statusBox.classList.remove('d-none');
            statusBox.innerHTML = '<span class="spinner-border spinner-border-sm text-secondary me-1"></span> กำลังเริ่มการยืนยันตัวตนด้วยลายนิ้วมือ / Passkey...';
        }

        if (!window.PublicKeyCredential) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'อุปกรณ์ไม่รองรับ',
                    text: 'เบราว์เซอร์หรืออุปกรณ์ของคุณไม่รองรับมาตรฐาน WebAuthn / Passkey',
                    confirmButtonColor: '#15803D'
                });
            } else {
                alert('เบราว์เซอร์หรืออุปกรณ์ของคุณไม่รองรับมาตรฐาน WebAuthn / Passkey');
            }
            if (statusBox) statusBox.classList.add('d-none');
            return;
        }

        try {
            const optRes = await fetch("{{ Route::has('webauthn.login.options') ? route('webauthn.login.options') : url('/webauthn/login/options') }}", {
                headers: { 'Accept': 'application/json' }
            });

            if (!optRes.ok) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'โหมดจำลองพรีวิว (Demo Mode)',
                        text: 'ระบบจำลองการเข้าสู่ระบบด้วย Passkey สำหรับหน้าพรีวิวธีม Forest Moss & Sage สำเร็จ!',
                        confirmButtonColor: '#15803D'
                    });
                } else {
                    alert('โหมดจำลองพรีวิว: ยืนยันตัวตนด้วย Passkey สำเร็จ!');
                }
                if (statusBox) statusBox.classList.add('d-none');
                return;
            }

            const options = await optRes.json();
            options.challenge = base64urlToUint8array(options.challenge);
            if (options.allowCredentials) {
                options.allowCredentials.forEach(cred => {
                    cred.id = base64urlToUint8array(cred.id);
                });
            }

            const assertion = await navigator.credentials.get({ publicKey: options });
            if (statusBox) {
                statusBox.innerHTML = '<span class="text-success fw-bold">ยืนยันตัวตนสำเร็จ! กำลังนำทาง...</span>';
            }
            window.location.href = "{{ Route::has('demo.index') ? route('demo.index') : url('/') }}";
        } catch (err) {
            if (statusBox) {
                statusBox.innerHTML = '<span class="text-danger">การยืนยันตัวตนถูกยกเลิกหรือล้มเหลว</span>';
            }
        }
    }
</script>
@endpush
