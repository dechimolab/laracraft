@extends(view()->exists('layouts.app') ? 'layouts.app' : 'themes.solar-amber.layouts.app')

@section('no_sidebar', 'true')
@section('no_header', 'true')

@section('content')
<div class="d-flex flex-column justify-content-between min-vh-100" style="background-color: var(--ap-bg-surface, #FDF9E9); background-image: radial-gradient(circle at 15% 15%, rgba(217, 119, 6, 0.08) 0%, transparent 60%), radial-gradient(circle at 85% 85%, rgba(69, 26, 3, 0.06) 0%, transparent 60%), #FDF9E9; background-attachment: fixed;">
    <!-- Top Bar Header -->
    <header class="w-100 bg-white bg-opacity-75 backdrop-blur border-bottom shadow-sm py-2" style="border-color: var(--ap-border-warm, #F3E8D0) !important;">
        <div class="container-fluid px-4 px-lg-5 d-flex align-items-center justify-content-between" style="max-width: 1320px; height: 3.5rem;">
            <div class="d-flex align-items-center gap-2">
                <span class="badge rounded-pill text-uppercase px-3 py-1.5 fw-semibold shadow-sm d-inline-flex align-items-center gap-1.5" style="background-color: #D97706; color: #FFFFFF; letter-spacing: 0.05em; font-size: 0.72rem;">
                    <span class="badge-pulse me-1"></span>SOLAR AMBER &amp; COFFEE
                </span>
                <div class="vr mx-2 text-secondary opacity-50 d-none d-sm-block"></div>
                <div class="d-flex align-items-center gap-1">
                    <span class="fw-bold fs-6" style="color: #451A03;">Artisan</span>
                    <span class="fw-semibold text-dark fs-6">{{ preg_replace('/^Artisan\s+/i', '', $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'POS & Inventory Hub')) }}</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 text-warning fw-semibold" style="font-size: 0.875rem;">
                <i class="bi bi-shield-check text-warning" style="font-size: 1.1rem; color: #D97706 !important;"></i>
                <span class="fw-semibold small d-none d-md-inline" style="color: #78350F;">Secure Enterprise Auth Gateway</span>
                <span class="badge border" style="background-color: #FFFBEB; border-color: #FDE68A !important; color: #78350F;">TLS 1.3 FIPS</span>
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
                <div class="card position-relative bg-white shadow-lg p-4 p-sm-5 d-flex flex-column gap-3 overflow-hidden border" style="border-radius: 20px; box-shadow: 0 20px 45px -10px rgba(69, 26, 3, 0.12), 0 8px 18px -4px rgba(69, 26, 3, 0.06) !important; border-color: #F3E8D0 !important;">
                    <!-- Top Solar Amber Visual Highlight Stripe -->
                    <div class="card-top-accent"></div>

                    <!-- Header & Crest Section -->
                    <div class="d-flex flex-column align-items-center text-center pt-2">
                        <div class="crest-shield rounded-4 d-flex align-items-center justify-content-center mb-3 shadow-sm">
                            <i class="bi bi-shield-lock-fill text-white fs-2"></i>
                        </div>
                        <h1 class="fs-4 fw-bold tracking-tight mb-2 text-dark">
                            {{ $appName ?? ((config('app.name') && config('app.name') !== 'Laravel Generator') ? config('app.name') : 'Artisan POS & Inventory Hub') }}
                        </h1>
                        <p class="small mb-0" style="color: #78350F; font-size: 0.85rem;">ระบบเข้าสู่ระบบกลางสำหรับจัดการคลังสินค้าและหน้าร้าน</p>

                        <!-- Protocol & Security Badges -->
                        <div class="d-flex flex-wrap align-items-center justify-content-center gap-2 mt-3">
                            <span class="badge rounded-pill fw-medium px-2.5 py-1 d-inline-flex align-items-center gap-1" style="background-color: #FFFBEB; color: #78350F; border: 1px solid #FDE68A; font-size: 0.72rem;">
                                <span class="rounded-circle d-inline-block" style="width: 6px; height: 6px; background-color: #10B981;"></span>
                                UMS BUU Protocol
                            </span>
                            <span class="badge rounded-pill fw-medium px-2.5 py-1 d-inline-flex align-items-center gap-1" style="background-color: #FFFBEB; color: #78350F; border: 1px solid #FDE68A; font-size: 0.72rem;">
                                <i class="bi bi-diagram-3" style="font-size: 0.75rem;"></i>
                                Active Directory
                            </span>
                            <span class="badge rounded-pill fw-medium px-2.5 py-1 d-inline-flex align-items-center gap-1" style="background-color: #FFFBEB; color: #78350F; border: 1px solid #FDE68A; font-size: 0.72rem;">
                                <i class="bi bi-lock-fill" style="font-size: 0.7rem; color: #D97706;"></i>
                                256-Bit TLS
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
                    <div class="alert alert-dismissible fade show p-3 mb-0 rounded-3 d-flex align-items-start gap-2.5 border-0" role="alert" style="background-color: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; border-radius: 0.75rem;">
                        <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 mt-0.5" style="width: 22px; height: 22px; background-color: #10B981; color: #FFFFFF;">
                            <i class="bi bi-check-lg fw-bold" style="font-size: 0.85rem;"></i>
                        </div>
                        <div class="flex-grow-1 small">
                            <div class="fw-bold" style="color: #064E3B;">{{ session('success') }}</div>
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
                                <label class="form-label small fw-bold mb-0 text-uppercase" for="username" style="color: #451A03; font-size: 0.72rem; letter-spacing: 0.04em;">
                                    ชื่อผู้ใช้งาน (BUU ACCOUNT / USERNAME)
                                </label>
                                <span class="badge rounded-pill fw-semibold" style="background-color: #FEE2E2; color: #991B1B; font-size: 0.62rem; letter-spacing: 0.05em;">REQUIRED</span>
                            </div>
                            <div class="input-group shadow-none" style="border-radius: 10px; overflow: hidden; border: 1px solid #E7DFCB; background-color: #FFFFFF;">
                                <span class="input-group-text border-0 bg-transparent ps-3 pe-2" style="color: #78350F !important;">
                                    <i class="bi bi-person" style="font-size: 1.15rem;"></i>
                                </span>
                                <input autocomplete="username" class="form-control border-0 py-2.5 ps-1" id="username" name="username" placeholder="ระบุ BUU Username" required autofocus style="color: #451A03; font-size: 0.92rem; background: transparent;" type="text" value="{{ old('username', 'pantakarn') }}"/>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1.5">
                                <label class="form-label small fw-bold mb-0 text-uppercase" for="password" style="color: #451A03; font-size: 0.72rem; letter-spacing: 0.04em;">
                                    รหัสผ่าน (BUU PASSWORD)
                                </label>
                                <a class="text-decoration-none fw-semibold" href="javascript:void(0)" onclick="alert('กรุณาติดต่อแผนกไอที หรือศูนย์บริการ UMS Portal เพื่อรีเซ็ตรหัสผ่าน')" style="color: #D97706; font-size: 0.75rem;">ลืมรหัสผ่าน?</a>
                            </div>
                            <div class="input-group shadow-none" style="border-radius: 10px; overflow: hidden; border: 1px solid #E7DFCB; background-color: #FFFFFF;">
                                <span class="input-group-text border-0 bg-transparent ps-3 pe-2" style="color: #78350F !important;">
                                    <i class="bi bi-key" style="font-size: 1.15rem;"></i>
                                </span>
                                <input autocomplete="current-password" class="form-control border-0 py-2.5 ps-1" id="password" name="password" placeholder="••••••••••••••••" required style="color: #451A03; font-size: 0.92rem; background: transparent;" type="password" value="Demo@Password2025"/>
                                <button aria-label="Toggle Password Visibility" class="btn border-0 bg-transparent pe-3 text-muted" id="togglePasswordBtn" onclick="togglePasswordVisibility()" style="color: #78350F !important;" title="แสดง/ซ่อนรหัสผ่าน" type="button">
                                    <i class="bi bi-eye" id="togglePasswordIcon" style="font-size: 1.1rem;"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <div class="form-check d-flex align-items-center m-0">
                                <input checked class="form-check-input mt-0 me-2" id="remember" name="remember" style="border-color: #FDE68A; width: 1.05rem; height: 1.05rem; cursor: pointer; accent-color: #D97706;" type="checkbox" value="1"/>
                                <label class="form-check-label fw-medium user-select-none" for="remember" style="font-size: 0.8rem; color: #451A03; cursor: pointer;">
                                    จดจำการเข้าสู่ระบบ (Remember Me)
                                </label>
                            </div>
                            <span class="text-muted" style="font-size: 0.74rem;">30 วันบนอุปกรณ์นี้</span>
                        </div>

                        <!-- Primary Submit Button -->
                        <button class="btn btn-solar-primary w-100 py-2.5 fw-bold d-flex align-items-center justify-content-center shadow-sm mt-2" id="submitAuthBtn" style="border-radius: 10px; font-size: 0.95rem;" type="submit">
                            <i class="bi bi-box-arrow-in-right me-2" style="font-size: 1.15rem;"></i>
                            <span id="loginBtnText">เข้าสู่ระบบด้วย BUU Account</span>
                            <div class="spinner-border spinner-border-sm text-light d-none ms-2" id="loginSpinner" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>

                        <!-- Divider with Label -->
                        <div class="position-relative text-center my-3">
                            <hr style="border-top: 1px solid #F3E8D0; opacity: 1; margin: 0;"/>
                            <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted small" style="font-size: 0.75rem; color: #78350F !important;">
                                หรือยืนยันตัวตนแบบไร้รหัสผ่าน
                            </span>
                        </div>

                        <!-- Biometrics / Passkey Action Button -->
                        <button class="btn w-100 py-2.5 d-flex align-items-center justify-content-center fw-semibold" id="btn-biometric-login" onclick="simulatePasskey()" style="background-color: #FDFAF3; border: 1.5px solid #EBD9BF; color: #451A03; border-radius: 10px; font-size: 0.88rem; transition: all 0.15s ease;" type="button">
                            <i class="bi bi-fingerprint me-2 fs-5" style="color: #D97706;"></i>
                            <span>สแกนลายนิ้วมือ / Passkey</span>
                            <span class="text-muted ms-1 fw-normal" style="font-size: 0.8rem;">(Windows Hello / Touch ID)</span>
                        </button>
                    </form>

                    <!-- Security & Info Disclaimer Card -->
                    <div class="p-3 rounded-3 mt-2" style="background-color: #FCF9EE; border: 1px solid #F3E8D0;">
                        <div class="d-flex align-items-center gap-2 mb-2 pb-1 border-bottom" style="border-color: #ECE0C8 !important;">
                            <i class="bi bi-shield-check text-warning" style="font-size: 1rem; color: #D97706 !important;"></i>
                            <span class="fw-bold" style="font-size: 0.82rem; color: #451A03;">
                                มาตรฐานความปลอดภัย UMS BUU:
                            </span>
                        </div>
                        <ul class="list-unstyled mb-0 pe-1" style="font-size: 0.76rem; color: #554336; line-height: 1.6;">
                            <li class="d-flex align-items-start gap-2 mb-1">
                                <span class="rounded-circle mt-1.5 flex-shrink-0" style="width: 5px; height: 5px; background-color: #D97706;"></span>
                                <span>ยืนยันตัวตนผ่าน <strong>Active Directory</strong> กลางและดึงกลุ่มสิทธิ์จาก UMS Central Gateway</span>
                            </li>
                            <li class="d-flex align-items-start gap-2 mb-1">
                                <span class="rounded-circle mt-1.5 flex-shrink-0" style="width: 5px; height: 5px; background-color: #D97706;"></span>
                                <span>ตัดการเชื่อมต่ออัตโนมัติเมื่อไม่มีการใช้งานต่อเนื่องเกิน <strong>15 นาที</strong></span>
                            </li>
                            <li class="d-flex align-items-start gap-2">
                                <span class="rounded-circle mt-1.5 flex-shrink-0" style="width: 5px; height: 5px; background-color: #D97706;"></span>
                                <span>บันทึกประวัติการเข้าใช้งานและตรวจสอบสิทธิ์เข้าถึงตามมาตรฐาน <strong>Audit Log (FIFO)</strong></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bottom Mini Footer -->
    <footer class="w-100 py-3 text-center border-top bg-white bg-opacity-50" style="border-color: #F3E8D0 !important; font-size: 0.75rem; color: #78350F;">
        <div>&copy; {{ date('Y') }} Burapha University Enterprise Architecture. All rights reserved.</div>
        <div class="mt-0.5" style="font-size: 0.7rem; color: #92400E;">ArtisanCraft Engine &bull; Solar Amber &amp; Coffee Theme &bull; PHP 8.4 JIT</div>
    </footer>
</div>

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            passwordInput.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }

    function simulatePasskey() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Passkey Authentication',
                text: 'กำลังรอการสแกนลายนิ้วมือหรือ Windows Hello...',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#D97706',
                confirmButtonText: 'จำลองสำเร็จ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'ยืนยันตัวตนสำเร็จ',
                        text: 'เข้าสู่ระบบด้วย Passkey เรียบร้อยแล้ว',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        } else {
            alert('Passkey verification initiated.');
        }
    }
</script>
@endpush
@endsection