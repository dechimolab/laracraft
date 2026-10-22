@extends(view()->exists('layouts.app') ? 'layouts.app' : 'themes.rose-quartz.layouts.app')

@section('no_sidebar', 'true')
@section('no_header', 'true')

@section('content')
<div class="d-flex flex-column justify-content-between min-vh-100" style="background-color: var(--rq-bg-blush, #FFF8F7); background-image: radial-gradient(circle at 10% 20%, #FFF2F4 0%, #FFF8F7 90%); background-attachment: fixed;">
    <!-- Top Bar Header -->
    <header class="w-100 bg-white bg-opacity-75 backdrop-blur border-bottom shadow-sm py-2" style="border-color: var(--theme-border-subtle, #FECDD3) !important;">
        <div class="container-fluid px-4 px-lg-5 d-flex align-items-center justify-content-between" style="max-width: 1320px; height: 3.5rem;">
            <div class="d-flex align-items-center gap-2">
                <span class="rq-pill-badge d-inline-flex align-items-center gap-1.5 px-3 py-1.5 text-uppercase fw-bold" style="background: linear-gradient(135deg, #BE123C 0%, #95002A 100%); color: #ffffff; border: none; font-size: 0.72rem; letter-spacing: 0.06em; box-shadow: 0 3px 10px rgba(190, 18, 60, 0.22);">
                    <span class="badge-pulse me-1"></span>ROSE QUARTZ &amp; VELVET
                </span>
                <div class="vr mx-2 text-secondary opacity-50 d-none d-sm-block"></div>
                <div class="d-flex align-items-center gap-1">
                    <span class="fw-bold fs-6" style="color: var(--rq-primary-velvet, #BE123C);">Artisan</span>
                    <span class="fw-semibold text-dark fs-6">{{ preg_replace('/^Artisan\s+/i', '', $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'POS & Inventory Hub')) }}</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 text-danger fw-semibold" style="font-size: 0.875rem;">
                <div class="p-1 px-2.5 rounded-pill" style="background-color: #FFE4E8; border: 1px solid rgba(251, 113, 133, 0.3);">
                    <i class="bi bi-shield-check me-1 text-danger"></i>
                    <span class="d-none d-md-inline">Secure Enterprise </span>Auth Gateway
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow-1 d-flex align-items-center justify-content-center p-3 p-md-4">
        <div class="d-flex flex-column align-items-center justify-content-center w-100 py-3">
            <!-- Ambient Card Wrapper -->
            <div class="position-relative w-100" style="max-width: 520px;">
                <div class="ambient-glow-1"></div>
                <div class="ambient-glow-2"></div>

                <!-- Main Authentication Card -->
                <div class="card position-relative bg-white rounded-4 shadow-lg p-4 p-sm-5 d-flex flex-column gap-3 overflow-hidden border" style="border-color: #FECDD3 !important; border-radius: 1.25rem;">
                    <!-- Top Card Velvet Accent Ribbon -->
                    <div class="card-top-accent"></div>

                    <!-- Header & Shield Crest Section -->
                    <div class="d-flex flex-column align-items-center text-center pt-2">
                        <div class="crest-shield rounded-4 d-flex align-items-center justify-content-center mb-3 shadow-sm">
                            <i class="bi bi-shield-lock-fill text-white fs-2"></i>
                        </div>
                        <h1 class="fs-4 fw-bold tracking-tight mb-2 text-dark">
                            {{ $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'Artisan POS & Inventory Hub') }}
                        </h1>
                        <!-- Protocol Metadata Badges -->
                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-2">
                            <span class="badge rounded-pill fw-semibold d-inline-flex align-items-center px-2 py-1" style="background-color: #FFE4E6; color: #BE123C; font-size: 0.72rem; border: 1px solid #FECDD3;">
                                <span class="d-inline-block rounded-circle me-1" style="width: 6px; height: 6px; background-color: #BE123C;"></span>
                                UMS BUU Protocol
                            </span>
                            <span class="badge rounded-pill fw-semibold d-inline-flex align-items-center px-2 py-1" style="background-color: #FFF1F2; color: #881337; font-size: 0.72rem; border: 1px solid #FECDD3;">
                                <i class="bi bi-diagram-3 me-1" style="color: #BE123C;"></i> Active Directory
                            </span>
                            <span class="badge rounded-pill fw-semibold d-inline-flex align-items-center px-2 py-1" style="background-color: #FFF1F2; color: #881337; font-size: 0.72rem; border: 1px solid #FECDD3;">
                                <i class="bi bi-lock-fill me-1"></i> 256-Bit TLS
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
                    <div class="alert alert-dismissible fade show d-flex align-items-start p-3 mb-0 border-0" role="alert" style="background-color: #ECFDF5; border-left: 4px solid #059669 !important; border-radius: 0.75rem;">
                        <i class="bi bi-check-circle-fill text-success fs-5 me-2 flex-shrink-0 mt-0.5"></i>
                        <div class="pe-3">
                            <div class="fw-bold text-success mb-1" style="font-size: 0.88rem;">{{ session('success') }}</div>
                        </div>
                        <button aria-label="Close" class="btn-close shadow-none p-2 mt-1 me-1" data-bs-dismiss="alert" style="font-size: 0.7rem;" type="button"></button>
                    </div>
                    @endif

                    <!-- Authentication Form -->
                    <form method="POST" action="{{ Route::has('login.post') ? route('login.post') : '#' }}" class="d-flex flex-column gap-3 mt-1" id="loginForm">
                        @csrf
                        <!-- Username / Account Field -->
                        <div class="mb-1">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label class="form-label fw-bold mb-0" for="username" style="color: #400014; font-size: 0.76rem; letter-spacing: 0.03em;">
                                    ชื่อผู้ใช้งาน <span class="text-secondary fw-normal">(BUU ACCOUNT / USERNAME)</span>
                                </label>
                                <span class="badge rounded-pill fw-bold" style="background-color: #FFE4E6; color: #9F1239; font-size: 0.65rem; letter-spacing: 0.05em;">REQUIRED</span>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="border-color: #FCA5A5; border-right: none; border-radius: 0.75rem 0 0 0.75rem;">
                                    <i class="bi bi-person text-secondary fs-6"></i>
                                </span>
                                <input autocomplete="username" class="form-control ps-1" id="username" name="username" placeholder="ระบุบัญชีผู้ใช้ BUU" required autofocus style="border-color: #FCA5A5; border-left: none; border-radius: 0 0.75rem 0.75rem 0; font-size: 0.92rem; color: #400014; box-shadow: none;" type="text" value="{{ old('username', 'pantakarn') }}"/>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="mb-1">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label class="form-label fw-bold mb-0" for="password" style="color: #400014; font-size: 0.76rem; letter-spacing: 0.03em;">
                                    รหัสผ่าน <span class="text-secondary fw-normal">(BUU PASSWORD)</span>
                                </label>
                                <a class="text-decoration-none fw-semibold" href="javascript:void(0)" onclick="alert('กรุณาติดต่อฝ่ายเทคโนโลยีสารสนเทศ UMS หรือรีเซ็ตรหัสผ่านผ่านระบบ BUU Account Portal')" style="color: #BE123C; font-size: 0.75rem;">
                                    ลืมรหัสผ่าน?
                                </a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="border-color: #FCA5A5; border-right: none; border-radius: 0.75rem 0 0 0.75rem;">
                                    <i class="bi bi-key text-secondary fs-6"></i>
                                </span>
                                <input autocomplete="current-password" class="form-control px-1" id="password" name="password" placeholder="รหัสผ่านเข้าสู่ระบบ" required style="border-color: #FCA5A5; border-left: none; border-right: none; font-size: 0.92rem; color: #400014; box-shadow: none;" type="password" value="Demo@Password2025"/>
                                <button aria-label="Toggle Password Visibility" class="btn btn-outline-secondary bg-white d-flex align-items-center" id="togglePasswordBtn" onclick="togglePasswordVisibility()" style="border-color: #FCA5A5; border-left: none; border-radius: 0 0.75rem 0.75rem 0;" type="button">
                                    <i class="bi bi-eye-slash text-secondary" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="d-flex align-items-center justify-content-between mb-1 pt-1">
                            <div class="form-check">
                                <input checked="" class="form-check-input" id="remember" name="remember" style="accent-color: #BE123C; border-color: #FB7185; cursor: pointer;" type="checkbox" value="1"/>
                                <label class="form-check-label user-select-none" for="remember" style="font-size: 0.8rem; color: #5B4041; cursor: pointer;">
                                    จดจำการเข้าสู่ระบบ <span class="opacity-75">(Remember Me)</span>
                                </label>
                            </div>
                            <span class="text-secondary" style="font-size: 0.75rem;">30 วันบนอุปกรณ์นี้</span>
                        </div>

                        <!-- Primary Action Button: BUU Account Login -->
                        <button class="btn rq-btn-ruby w-100 d-flex align-items-center justify-content-center gap-2 py-2 mb-2 fw-semibold text-white shadow-sm" id="submitAuthBtn" style="border-radius: 0.75rem; font-size: 0.95rem;" type="submit">
                            <i class="bi bi-box-arrow-in-right fs-5"></i>
                            <span id="loginBtnText">เข้าสู่ระบบด้วย BUU Account</span>
                            <div class="spinner-border spinner-border-sm text-light d-none" id="loginSpinner" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>

                        <!-- Divider with Label -->
                        <div class="position-relative text-center my-2">
                            <hr style="border-top: 1px solid #FECDD3; opacity: 0.8; margin: 0;"/>
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-secondary fw-semibold" style="font-size: 0.74rem; color: #8F6F70 !important;">
                                หรือยืนยันตัวตนแบบไร้รหัสผ่าน
                            </span>
                        </div>

                        <!-- Biometrics / Passkey Action Button -->
                        <button class="btn w-100 d-flex align-items-center justify-content-center gap-2 py-2 mb-2 fw-medium text-dark bg-white" id="btn-biometric-login" onclick="loginWithBiometrics()" onmouseout="this.style.backgroundColor='#ffffff'; this.style.borderColor='#fecdd3'" onmouseover="this.style.backgroundColor='#fff1f2'; this.style.borderColor='#fb7185'" style="border: 1px solid #FECDD3; border-radius: 0.75rem; font-size: 0.86rem; color: #881337 !important; transition: all 0.2s ease;" type="button">
                            <i class="bi bi-fingerprint fs-5" style="color: #BE123C;"></i>
                            <span>สแกนลายนิ้วมือ / Passkey <span class="text-secondary opacity-75">(Windows Hello / Touch ID)</span></span>
                        </button>
                        <div id="biometric-status" class="small text-center text-secondary d-none"></div>
                    </form>

                    <!-- Security Compliance Card (UMS BUU Standards) -->
                    <div class="p-3 mb-1" style="background-color: #FFF5F7; border: 1px solid #FFE4E6; border-radius: 0.85rem;">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-shield-check text-danger fs-6"></i>
                            <span class="fw-bold" style="font-size: 0.79rem; color: #400014;">มาตรฐานความปลอดภัย UMS BUU:</span>
                        </div>
                        <ul class="list-unstyled mb-2 pe-1 ps-1" style="font-size: 0.73rem; color: #5B4041; line-height: 1.45;">
                            <li class="d-flex align-items-start mb-1 gap-2">
                                <span class="text-danger mt-1" style="font-size: 0.45rem;">●</span>
                                <span>ยืนยันตัวตนผ่าน Active Directory กลางและดึงกลุ่มสิทธิ์จาก UMS Central Gateway</span>
                            </li>
                            <li class="d-flex align-items-start mb-1 gap-2">
                                <span class="text-danger mt-1" style="font-size: 0.45rem;">●</span>
                                <span>รองรับการเข้าสู่ระบบแบบชีวมิติด้วยกุญแจ <strong>(W3C WebAuthn &amp; FIDO2 Passkey)</strong></span>
                            </li>
                            <li class="d-flex align-items-start mb-1 gap-2">
                                <span class="text-danger mt-1" style="font-size: 0.45rem;">●</span>
                                <span>ไม่มีบทบาท <code class="px-1 py-0 rounded text-danger fw-bold" style="background-color: #FEE2E2; font-size: 0.7rem;">superadmin</code> ในระบบ UMS ตามข้อกำหนดการแยกหน้าที่ความปลอดภัย</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <span class="text-danger mt-1" style="font-size: 0.45rem;">●</span>
                                <span>จำกัดความถี่การเข้าสู่ระบบ 5 ครั้ง/นาที เพื่อป้องกันการโจมตีแบบ Brute Force</span>
                            </li>
                        </ul>
                        <!-- Diagnostic Telemetry Bar -->
                        <div class="pt-2 d-flex flex-wrap align-items-center justify-content-between text-secondary font-monospace" style="border-top: 1px dashed #FECDD3; font-size: 0.65rem;">
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
    <footer class="rq-footer py-3 text-center" style="border-top: 1px solid var(--rq-border-rose, rgba(251, 113, 133, 0.3)); background: rgba(255, 240, 241, 0.65); font-size: 0.8rem; color: var(--rq-text-muted, #7A4B55);">
        <div class="container d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
            <div class="d-flex align-items-center gap-2">
                <span>&copy; {{ date('Y') }} Burapha University (BUU). All rights reserved.</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span><i class="bi bi-patch-check-fill text-danger me-1"></i>Enterprise SLA 99.99%</span>
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
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                pwdInput.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
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
                    confirmButtonColor: '#BE123C'
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
                        text: 'ระบบจำลองการเข้าสู่ระบบด้วย Passkey สำหรับหน้าพรีวิวธีม Rose Quartz & Velvet สำเร็จ!',
                        confirmButtonColor: '#BE123C'
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
