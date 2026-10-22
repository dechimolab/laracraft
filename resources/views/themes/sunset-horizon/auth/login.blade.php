@extends(view()->exists('layouts.app') ? 'layouts.app' : 'themes.sunset-horizon.layouts.app')

@section('no_sidebar', 'true')
@section('no_header', 'true')

@section('content')
<div class="d-flex flex-column justify-content-between min-vh-100" style="background-color: var(--sunset-bg, #FFFBEB); background-image: radial-gradient(at 0% 0%, rgba(254, 215, 170, 0.4) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(255, 237, 213, 0.5) 0px, transparent 50%), radial-gradient(at 50% 20%, rgba(254, 243, 199, 0.6) 0px, transparent 60%); background-attachment: fixed;">
    <!-- Top Bar Header -->
    <header class="w-100 bg-white bg-opacity-75 backdrop-blur border-bottom shadow-sm py-2" style="border-color: var(--sunset-border, #FED7AA) !important;">
        <div class="container-fluid px-4 px-lg-5 d-flex align-items-center justify-content-between" style="max-width: 1320px; height: 3.5rem;">
            <div class="d-flex align-items-center gap-2">
                <span class="badge rounded-pill d-inline-flex align-items-center gap-2 px-3 py-2 text-uppercase fw-semibold" style="background: linear-gradient(135deg, #EA580C 0%, #F43F5E 100%); color: #ffffff; border: none; font-size: 0.75rem; letter-spacing: 0.05em; box-shadow: 0 2px 6px rgba(234, 88, 12, 0.3);">
                    <span class="rounded-circle" style="width: 6px; height: 6px; background-color: #ffffff;"></span>SUNSET HORIZON
                </span>
                <div class="vr mx-2 text-secondary opacity-50 d-none d-sm-block"></div>
                <div class="d-flex align-items-center gap-1">
                    <span class="fw-bold fs-6" style="color: var(--sunset-primary, #EA580C);">Artisan</span>
                    <span class="fw-semibold text-dark fs-6">{{ preg_replace('/^Artisan\s+/i', '', $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'POS & Inventory Hub')) }}</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 text-secondary">
                <i class="bi bi-shield-check fs-5" style="color: var(--sunset-primary, #EA580C);"></i>
                <span class="small d-none d-sm-inline fw-medium">Secure Enterprise Auth Gateway</span>
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
                <div class="card position-relative bg-white rounded-4 shadow-lg p-4 p-sm-5 d-flex flex-column gap-3 overflow-hidden" style="border: 1.5px solid var(--sunset-border, #FED7AA); box-shadow: 0 10px 30px -5px rgba(234, 88, 12, 0.08), 0 20px 25px -5px rgba(0, 0, 0, 0.04) !important;">
                    <!-- Top Accent Bar (Sunset Linear Gradient) -->
                    <div class="card-top-accent"></div>

                    <!-- Header & Crest Section -->
                    <div class="d-flex flex-column align-items-center text-center pt-2">
                        <!-- Shield Badge Wrapper -->
                        <div class="crest-shield rounded-4 d-flex align-items-center justify-content-center mb-3 shadow-sm">
                            <i class="bi bi-shield-lock-fill text-white fs-2"></i>
                        </div>
                        <h1 class="fs-4 fw-bold tracking-tight mb-2" style="color: var(--sunset-text-dark, #431407);">
                            {{ $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'Artisan POS & Inventory Hub') }}
                        </h1>
                        <!-- Enterprise Protocol Badges -->
                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-1">
                            <span class="badge rounded-pill px-3 py-1 fw-semibold border" style="background-color: #FFF7ED; border-color: #FED7AA !important; color: #EA580C;">
                                <span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background-color: #10B981;"></span>
                                UMS BUU Protocol
                            </span>
                            <span class="badge rounded-pill px-2.5 py-1 fw-semibold border" style="background-color: #FFFDF9; border-color: #FED7AA !important; color: #7C2D12;">
                                <i class="bi bi-diagram-3 me-1" style="color: #EA580C;"></i>Active Directory
                            </span>
                            <span class="badge rounded-pill px-2.5 py-1 fw-semibold border text-secondary" style="background-color: #FFFDF9; border-color: #FED7AA !important;">
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
                                <label class="form-label mb-0 fw-semibold small" for="username" style="color: var(--sunset-text-dark, #431407);">
                                    ชื่อผู้ใช้งาน <span class="text-secondary fw-normal">(BUU ACCOUNT / USERNAME)</span>
                                </label>
                                <span class="badge bg-transparent text-uppercase px-0 fw-bold" style="font-size: 0.75rem; color: #EA580C !important;">Required</span>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-secondary" style="border-color: #FED7AA;">
                                    <i class="bi bi-person fs-5" style="color: #EA580C;"></i>
                                </span>
                                <input autocomplete="username" class="form-control border-start-0 py-2" id="username" name="username" placeholder="e.g. s65123456 or pantakarn" required autofocus type="text" value="{{ old('username', 'pantakarn') }}" style="border-color: #FED7AA;">
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="d-flex flex-column gap-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="form-label mb-0 fw-semibold small" for="password" style="color: var(--sunset-text-dark, #431407);">
                                    รหัสผ่าน <span class="text-secondary fw-normal">(BUU PASSWORD)</span>
                                </label>
                                <a class="small text-decoration-none fw-semibold" href="javascript:void(0)" onclick="alert('กรุณาติดต่อฝ่ายเทคโนโลยีสารสนเทศ UMS หรือรีเซ็ตรหัสผ่านผ่านระบบ BUU Account Portal')" style="color: #EA580C;">
                                    ลืมรหัสผ่าน?
                                </a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-secondary" style="border-color: #FED7AA;">
                                    <i class="bi bi-key fs-5" style="color: #EA580C;"></i>
                                </span>
                                <input autocomplete="current-password" class="form-control border-start-0 border-end-0 py-2" id="password" name="password" placeholder="กรอกรหัสผ่านบัญชี BUU" required type="password" value="Demo@Password2025" style="border-color: #FED7AA;">
                                <button aria-label="Toggle Password Visibility" class="input-group-text bg-white border-start-0 text-secondary btn-password-toggle" id="togglePasswordBtn" onclick="togglePasswordVisibility()" title="Toggle Password Visibility" type="button" style="border-color: #FED7AA;">
                                    <i class="bi bi-eye fs-5" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="d-flex align-items-center justify-content-between pt-1">
                            <div class="form-check d-flex align-items-center gap-2 mb-0">
                                <input class="form-check-input mt-0" id="remember" name="remember" type="checkbox" {{ old('remember', true) ? 'checked' : '' }} style="accent-color: var(--sunset-primary, #EA580C); cursor: pointer;">
                                <label class="form-check-label small" for="remember" style="color: var(--sunset-text-dark, #431407); cursor: pointer;">
                                    จดจำการเข้าสู่ระบบ <span class="text-secondary">(Remember Me)</span>
                                </label>
                            </div>
                            <span class="text-secondary small d-none d-sm-inline">30 วันบนอุปกรณ์นี้</span>
                        </div>

                        <!-- Primary Action Button: BUU Account Login -->
                        <button class="btn btn-sunset-primary w-100 py-2.5 d-flex align-items-center justify-content-center gap-2 mt-2 shadow-sm rounded-pill fw-semibold" id="loginBtn" type="submit">
                            <i class="bi bi-box-arrow-in-right fs-5"></i>
                            <span id="loginBtnText">เข้าสู่ระบบด้วย BUU Account</span>
                            <div class="spinner-border spinner-border-sm text-light d-none" id="loginSpinner" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>

                        <!-- Divider with label -->
                        <div class="position-relative text-center my-2">
                            <hr class="text-secondary opacity-25 m-0" style="border-color: #FED7AA;"/>
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-secondary text-uppercase fw-medium" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                                หรือยืนยันตัวตนแบบไร้รหัสผ่าน
                            </span>
                        </div>

                        <!-- Secondary Action Button: Passkey / Biometrics -->
                        <button class="btn w-100 py-2 d-flex align-items-center justify-content-center gap-2 border rounded-pill fw-medium" id="btn-biometric-login" onclick="loginWithBiometrics()" type="button" style="border-color: #FED7AA !important; color: #7C2D12; background-color: #FFFAF0;">
                            <i class="bi bi-fingerprint fs-4 text-warning-emphasis"></i>
                            <span>สแกนลายนิ้วมือ / Passkey <span class="small fw-normal text-secondary d-none d-sm-inline">(Windows Hello / Touch ID)</span></span>
                        </button>
                        <div id="biometric-status" class="small text-center text-secondary d-none"></div>
                    </form>

                    <!-- Enterprise Security Compliance Section -->
                    <div class="border rounded-3 p-3 d-flex flex-column gap-2 mt-1" style="background-color: #FFFAF0; border-color: #FED7AA !important;">
                        <div class="d-flex align-items-center gap-2 fw-semibold small" style="color: #7C2D12;">
                            <i class="bi bi-patch-check-fill" style="color: #EA580C;"></i>
                            <span>มาตรฐานความปลอดภัย UMS BUU:</span>
                        </div>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-1 ps-1 small" style="color: #5A4138;">
                            <li class="d-flex align-items-start gap-2">
                                <span class="rounded-circle mt-2 flex-shrink-0" style="width: 6px; height: 6px; background-color: #EA580C;"></span>
                                <span>ยืนยันตัวตนผ่าน Active Directory กลางและดึงกลุ่มสิทธิ์จาก <span class="fw-semibold" style="color: #7C2D12;">UMS Central Gateway</span></span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <span class="rounded-circle mt-2 flex-shrink-0" style="width: 6px; height: 6px; background-color: #EA580C;"></span>
                                <span>รองรับการเข้าสู่ระบบแบบชีวมิติตลับกุญแจ <span class="fw-semibold" style="color: #7C2D12;">(W3C WebAuthn &amp; FIDO2 Passkey)</span></span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <span class="rounded-circle mt-2 flex-shrink-0 bg-danger" style="width: 6px; height: 6px;"></span>
                                <span>ไม่มีบทบาท <code class="px-1.5 py-0.5 rounded text-danger bg-danger-subtle fw-bold" style="font-size: 0.8rem;">superadmin</code> ในระบบ UMS ตามข้อกำหนดการแยกหน้าที่ความปลอดภัย</span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <span class="rounded-circle mt-2 flex-shrink-0" style="width: 6px; height: 6px; background-color: #10B981;"></span>
                                <span>จำกัดความถี่การเข้าสู่ระบบ 5 ครั้ง/นาที เพื่อป้องกันการโจมตีแบบ Brute Force</span>
                            </li>
                        </ul>
                        <div class="mt-1 pt-2 d-flex align-items-center justify-content-between small text-secondary border-top" style="font-size: 0.75rem; border-color: #FED7AA !important;">
                            <span class="d-flex align-items-center gap-1">
                                <i class="bi bi-shield-shaded" style="color: #EA580C;"></i>SESSION_SEED: 0x9F41…E8A3
                            </span>
                            <span>GATEWAY: BUU-FIN-CLUSTER-04</span>
                        </div>
                    </div>
                </div>

                <!-- Security Gateway Footer Meta -->
                <div class="mt-3 d-flex flex-wrap align-items-center justify-content-between px-2 text-secondary small" style="font-size: 0.8rem;">
                    <span class="d-flex align-items-center gap-1">
                        <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background-color: #10B981;"></span>
                        UMS Authentication Cluster Active
                    </span>
                    <span>Enterprise SLA 99.99%</span>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-100 py-3 text-center text-secondary small border-top" style="border-color: var(--sunset-border, #FED7AA) !important; background-color: rgba(255, 255, 255, 0.6);">
        <div class="container d-flex flex-wrap align-items-center justify-content-between gap-2" style="max-width: 1320px;">
            <span>&copy; {{ date('Y') }} Burapha University. All rights reserved.</span>
            <div class="d-flex align-items-center gap-3">
                <span>Enterprise Architecture Standard</span>
                <span>PHP 8.4 JIT</span>
                <span>Laravel 13.x</span>
            </div>
        </div>
    </footer>
</div>
@endsection

@push('scripts')
<script>
    // Password Visibility Toggle
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');
        if (passwordInput && toggleIcon) {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
    }

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

    // WebAuthn Passkey Login Execution
    async function loginWithBiometrics() {
        const statusBox = document.getElementById('biometric-status');
        const btn = document.getElementById('btn-biometric-login');
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
                    confirmButtonColor: '#EA580C'
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
                        text: 'ระบบจำลองการเข้าสู่ระบบด้วย Passkey สำหรับหน้าพรีวิวธีม Sunset Horizon สำเร็จ!',
                        confirmButtonColor: '#EA580C'
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
            const credentialData = {
                id: assertion.id,
                rawId: bufferToBase64url(assertion.rawId),
                type: assertion.type,
                response: {
                    authenticatorData: bufferToBase64url(assertion.response.authenticatorData),
                    clientDataJSON: bufferToBase64url(assertion.response.clientDataJSON),
                    signature: bufferToBase64url(assertion.response.signature),
                    userHandle: assertion.response.userHandle ? bufferToBase64url(assertion.response.userHandle) : null
                }
            };

            const verifyRes = await fetch("{{ Route::has('webauthn.login') ? route('webauthn.login') : url('/webauthn/login') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(credentialData)
            });

            const result = await verifyRes.json();
            if (result.success) {
                window.location.href = result.redirect || "{{ Route::has('demo.index') ? route('demo.index') : url('/') }}";
            } else {
                throw new Error(result.message || 'การยืนยันลายนิ้วมือไม่ถูกต้อง');
            }
        } catch (err) {
            console.error('WebAuthn Error:', err);
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'info',
                    title: 'โหมดทดสอบลายนิ้วมือ (Preview)',
                    text: 'ตรวจพบสัญญาณเซ็นเซอร์ชีวมิติ หรืออยู่ในสภาพแวดล้อมทดสอบ พรีวิวจำลองทำงานปกติ',
                    confirmButtonColor: '#EA580C'
                });
            } else {
                alert('ทดสอบลายนิ้วมือ: ' + (err.message || 'พร้อมทำงาน'));
            }
        } finally {
            if (statusBox) statusBox.classList.add('d-none');
        }
    }
</script>
@endpush
