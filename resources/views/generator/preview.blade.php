<!DOCTYPE html>
<html lang="th" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $projectConfig['name'] ?? 'Artisan App' }} - Live UI Preview</title>
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #0b1326;
            color: #e2e8f0;
            min-height: 100vh;
        }
        code, pre, .font-monospace {
            font-family: 'JetBrains Mono', monospace;
        }
        .navbar-custom {
            background-color: #070d1a !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .card-custom {
            background-color: #131b2e;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
        }
        .table-custom {
            --bs-table-bg: transparent;
            --bs-table-hover-bg: rgba(255, 255, 255, 0.04);
            color: #cbd5e1;
        }
        .btn-primary-custom {
            background-color: #ff5542;
            border-color: #ff5542;
            color: #ffffff;
            font-weight: 500;
        }
        .btn-primary-custom:hover {
            background-color: #e04432;
            border-color: #e04432;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <!-- Application Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top py-2.5">
        <div class="container-fluid px-3 px-lg-4">
            <a class="navbar-brand d-flex items-center gap-2 text-white fw-bold" href="?view=dashboard">
                <span class="badge bg-danger rounded-pill px-2 py-1"><i class="bi bi-cpu-fill"></i></span>
                <span>{{ $projectConfig['name'] ?? 'Artisan App' }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ $view === 'dashboard' ? 'active fw-semibold text-white' : 'text-secondary' }}" href="?view=dashboard">
                            <i class="bi bi-house-door me-1"></i> Dashboard
                        </a>
                    </li>
                    @if(!empty($projectConfig['modules']['user_role']))
                    <li class="nav-item">
                        <a class="nav-link {{ $view === 'users' ? 'active fw-semibold text-white' : 'text-secondary' }}" href="?view=users">
                            <i class="bi bi-people me-1"></i> Users &amp; Roles
                        </a>
                    </li>
                    @endif
                    @if(!empty($projectConfig['modules']['system_settings']))
                    <li class="nav-item">
                        <a class="nav-link {{ $view === 'settings' ? 'active fw-semibold text-white' : 'text-secondary' }}" href="?view=settings">
                            <i class="bi bi-gear me-1"></i> Settings
                        </a>
                    </li>
                    @endif
                    @if(!empty($projectConfig['modules']['notifications']))
                    <li class="nav-item">
                        <a class="nav-link {{ $view === 'notifications' ? 'active fw-semibold text-white' : 'text-secondary' }}" href="?view=notifications">
                            <i class="bi bi-bell me-1"></i> Notifications
                            <span class="badge bg-danger rounded-pill ms-1">3</span>
                        </a>
                    </li>
                    @endif
                    @if(!empty($projectConfig['modules']['media_storage']))
                    <li class="nav-item">
                        <a class="nav-link {{ $view === 'media' ? 'active fw-semibold text-white' : 'text-secondary' }}" href="?view=media">
                            <i class="bi bi-folder me-1"></i> Media Vault
                        </a>
                    </li>
                    @endif
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-2">
                    @if(!empty($projectConfig['modules']['buu_ldap']))
                        @if($view === 'login')
                            <li class="nav-item">
                                <span class="badge bg-secondary py-2 px-3 text-white"><i class="bi bi-lock me-1"></i> Login Gateway</span>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2 py-1 px-2 rounded hover:bg-white/5" href="#" role="button" data-bs-toggle="dropdown">
                                    <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 13px;">AD</div>
                                    <span>Administrator</span>
                                    <span class="badge bg-primary text-uppercase" style="font-size: 10px;">Superadmin</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark card-custom shadow-lg">
                                    <li><h6 class="dropdown-header text-muted">somchai.sa@buu.ac.th</h6></li>
                                    <li><hr class="dropdown-divider border-secondary"></li>
                                    <li><a class="dropdown-item" href="?view=settings"><i class="bi bi-gear me-2"></i> Settings</a></li>
                                    <li><a class="dropdown-item text-danger" href="?view=login"><i class="bi bi-box-arrow-right me-2"></i> Sign Out</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="?view=login" class="btn btn-sm btn-outline-secondary text-white-50"><i class="bi bi-door-open me-1"></i> Switch to Login</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <span class="badge badge-active py-1.5 px-2.5">Clean Framework</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="container-fluid px-3 px-lg-4 py-4">

        @if($view === 'login')
            <!-- LOGIN VIEW -->
            <div class="row justify-content-center align-items-center my-4">
                <div class="col-12 col-md-7 col-lg-5 col-xl-4">
                    <div class="card card-custom shadow-2xl p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger/10 text-danger p-3 mb-3 border border-danger/20">
                                <i class="bi bi-shield-lock-fill fs-2"></i>
                            </div>
                            <h3 class="fw-bold text-white mb-1">BUU Active Directory</h3>
                            <p class="text-secondary small">เข้าสู่ระบบด้วยบัญชีผู้ใช้มหาวิทยาลัยบูรพา</p>
                        </div>

                        <form onsubmit="event.preventDefault(); alert('Live Emulation: ระบบพร้อมรับการยืนยันตัวตน Active Directory');">
                            <div class="mb-3">
                                <label class="form-label text-light small fw-semibold">ชื่อผู้ใช้ (BUU Account / Username)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-black/40 border-secondary text-secondary"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control bg-black/40 border-secondary text-white" value="somchai.sa" placeholder="เช่น somchai.sa" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-light small fw-semibold">รหัสผ่าน (Password)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-black/40 border-secondary text-secondary"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control bg-black/40 border-secondary text-white" value="password123" placeholder="••••••••••••" required>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4 small">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe" checked>
                                    <label class="form-check-label text-secondary" for="rememberMe">จดจำการใช้งาน 30 วัน</label>
                                </div>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis font-monospace" style="font-size: 10px;">Limit: 5/min</span>
                            </div>
                            <button type="submit" class="btn btn-primary-custom w-full py-2.5 mb-3 shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบ (Sign In)
                            </button>
                            <button type="button" class="btn btn-outline-info w-full py-2 small" onclick="alert('Live Emulation: จำลองการตรวจสอบ W3C WebAuthn Passkey')">
                                <i class="bi bi-fingerprint me-1"></i> เข้าสู่ระบบด้วย Passkey / กุญแจความปลอดภัย
                            </button>
                        </form>

                        <div class="mt-4 pt-3 border-top border-secondary text-center small text-secondary">
                            <div><i class="bi bi-info-circle me-1 text-info"></i> รองรับ LDAP Fallback สำหรับโหมด Developer</div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($view === 'users')
            <!-- USERS & ROLES VIEW -->
            <div class="d-flex flex-column gap-3">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h2 class="h3 fw-bold text-white mb-1"><i class="bi bi-people-fill text-danger me-2"></i> User &amp; Role Management</h2>
                        <p class="text-secondary small mb-0">จัดการผู้ใช้งาน, สิทธิ์การเข้าถึง (Roles &amp; Permissions) และสถานะบัญชี</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary-custom btn-sm"><i class="bi bi-person-plus-fill me-1"></i> Add User</button>
                        <button class="btn btn-outline-secondary btn-sm text-white"><i class="bi bi-shield-lock me-1"></i> Manage Roles</button>
                    </div>
                </div>

                <div class="card card-custom overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead class="table-dark text-secondary font-monospace" style="font-size: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                                <tr>
                                    <th class="ps-3" style="width: 70px;">ID</th>
                                    <th>ชื่อ-นามสกุล / ชื่อผู้ใช้</th>
                                    <th>อีเมล</th>
                                    <th>บทบาท (Role)</th>
                                    <th>สังกัด / ส่วนงาน</th>
                                    <th>สถานะ</th>
                                    <th class="text-end pe-3" style="width: 140px;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-3 font-monospace text-secondary">1</td>
                                    <td>
                                        <div class="fw-semibold text-white">สมชาย สายธาร</div>
                                        <div class="small font-monospace text-secondary">somchai.sa (BUU AD)</div>
                                    </td>
                                    <td class="font-monospace text-secondary">somchai.sa@buu.ac.th</td>
                                    <td><span class="badge bg-danger">superadmin</span></td>
                                    <td class="small text-secondary">สำนักคอมพิวเตอร์</td>
                                    <td><span class="badge badge-active"><i class="bi bi-check-circle me-1"></i> Active</span></td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-outline-info me-1" title="แก้ไข"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" title="ระงับ"><i class="bi bi-slash-circle"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-3 font-monospace text-secondary">2</td>
                                    <td>
                                        <div class="fw-semibold text-white">กานดา นภาลัย</div>
                                        <div class="small font-monospace text-secondary">kanda.na (BUU AD)</div>
                                    </td>
                                    <td class="font-monospace text-secondary">kanda.na@buu.ac.th</td>
                                    <td><span class="badge bg-primary">developer</span></td>
                                    <td class="small text-secondary">คณะวิทยาการสารสนเทศ</td>
                                    <td><span class="badge badge-active"><i class="bi bi-check-circle me-1"></i> Active</span></td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-outline-info me-1" title="แก้ไข"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" title="ระงับ"><i class="bi bi-slash-circle"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-3 font-monospace text-secondary">3</td>
                                    <td>
                                        <div class="fw-semibold text-white">ผู้ใช้งานทั่วไป</div>
                                        <div class="small font-monospace text-secondary">user.demo (Local)</div>
                                    </td>
                                    <td class="font-monospace text-secondary">user@example.com</td>
                                    <td><span class="badge bg-secondary">user</span></td>
                                    <td class="small text-secondary">งานพัสดุและอาคาร</td>
                                    <td><span class="badge bg-secondary text-white-50">Inactive</span></td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-outline-info me-1" title="แก้ไข"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" title="ระงับ"><i class="bi bi-slash-circle"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        @elseif($view === 'settings')
            <!-- SETTINGS VIEW -->
            <div class="d-flex flex-column gap-3 max-w-4xl">
                <div>
                    <h2 class="h3 fw-bold text-white mb-1"><i class="bi bi-gear-fill text-warning me-2"></i> System Settings &amp; Configuration</h2>
                    <p class="text-secondary small mb-0">ปรับแต่งการตั้งค่ารันไทม์ เซสชัน อีเมล และพารามิเตอร์ของระบบ</p>
                </div>

                <div class="card card-custom p-4">
                    <form onsubmit="event.preventDefault(); alert('Live Emulation: ค่าพารามิเตอร์ถูกบันทึกลงตาราง settings เรียบร้อย');">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-light small fw-semibold">ชื่อระบบ (Application Title)</label>
                                <input type="text" class="form-control bg-black/40 border-secondary text-white" value="{{ $projectConfig['name'] ?? 'Artisan App' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-light small fw-semibold">Application URL</label>
                                <input type="text" class="form-control bg-black/40 border-secondary text-white font-monospace" value="{{ $projectConfig['url'] ?? 'http://localhost:8000' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-light small fw-semibold">Session Lifetime (นาที)</label>
                                <input type="number" class="form-control bg-black/40 border-secondary text-white" value="120">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-light small fw-semibold">Session Driver</label>
                                <select class="form-select bg-black/40 border-secondary text-white">
                                    <option value="database" selected>Database (sessions table)</option>
                                    <option value="redis">Redis Cluster</option>
                                    <option value="file">File Storage</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-light small fw-semibold">Log Level</label>
                                <select class="form-select bg-black/40 border-secondary text-white">
                                    <option value="debug" selected>debug</option>
                                    <option value="info">info</option>
                                    <option value="error">error</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch pt-2">
                                    <input class="form-check-input" type="checkbox" id="maintMode">
                                    <label class="form-check-label text-light" for="maintMode">โหมดปิดปรับปรุงระบบชั่วคราว (Maintenance Mode)</label>
                                </div>
                            </div>
                            <div class="col-12 pt-3">
                                <button type="submit" class="btn btn-primary-custom px-4"><i class="bi bi-check2-circle me-1"></i> บันทึกการตั้งค่า</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @elseif($view === 'notifications')
            <!-- NOTIFICATIONS VIEW -->
            <div class="d-flex flex-column gap-3">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h2 class="h3 fw-bold text-white mb-1"><i class="bi bi-bell-fill text-danger me-2"></i> Notifications Engine</h2>
                        <p class="text-secondary small mb-0">ศูนย์แจ้งเตือนกิจกรรมและข้อความเตือนภัยระบบ</p>
                    </div>
                    <button class="btn btn-outline-info btn-sm" onclick="alert('Live Emulation: ทำเครื่องหมายอ่านแล้วทั้งหมด')"><i class="bi bi-check-all me-1"></i> Mark All as Read</button>
                </div>

                <div class="card card-custom overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead class="table-dark text-secondary font-monospace" style="font-size: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                                <tr>
                                    <th class="ps-3" style="width: 70px;">สถานะ</th>
                                    <th>ประเภท</th>
                                    <th>รายละเอียดข้อความ</th>
                                    <th>เวลาที่ส่ง</th>
                                    <th class="text-end pe-3" style="width: 120px;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-active">
                                    <td class="ps-3"><span class="badge bg-warning text-dark"><i class="bi bi-circle-fill me-1"></i> ใหม่</span></td>
                                    <td><code class="text-info">SecurityAlertNotification</code></td>
                                    <td>
                                        <div class="fw-semibold text-white">พบการล็อกอินจาก IP ใหม่ 192.168.1.150</div>
                                        <div class="small text-secondary">Target: App\Models\UsersModel #1</div>
                                    </td>
                                    <td class="small text-secondary font-monospace">5 นาทีที่แล้ว</td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-outline-info me-1" title="อ่าน"><i class="bi bi-check-lg"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" title="ลบ"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-3"><span class="badge bg-secondary"><i class="bi bi-check2"></i> อ่านแล้ว</span></td>
                                    <td><code class="text-info">ProjectBackupCompleted</code></td>
                                    <td>
                                        <div class="fw-semibold text-white">สำรองข้อมูลประจำสัปดาห์สำเร็จ (ขนาด 48.2 MB)</div>
                                        <div class="small text-secondary">Target: System Task</div>
                                    </td>
                                    <td class="small text-secondary font-monospace">2 ชั่วโมงที่แล้ว</td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-outline-danger" title="ลบ"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        @elseif($view === 'media')
            <!-- MEDIA VIEW -->
            <div class="d-flex flex-column gap-3">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h2 class="h3 fw-bold text-white mb-1"><i class="bi bi-folder-fill text-info me-2"></i> Media &amp; Attachment Vault</h2>
                        <p class="text-secondary small mb-0">คลังเอกสารและไฟล์แนบพร้อมระบบจัดเก็บแบบสากลและ 5 Audit Stamps</p>
                    </div>
                    <button class="btn btn-primary-custom btn-sm" onclick="alert('Live Emulation: เปิดหน้าต่างเลือกไฟล์เพื่ออัปโหลด')">
                        <i class="bi bi-cloud-arrow-up-fill me-1"></i> Upload File
                    </button>
                </div>

                <div class="card card-custom overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead class="table-dark text-secondary font-monospace" style="font-size: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                                <tr>
                                    <th class="ps-3">ชื่อไฟล์</th>
                                    <th>ขนาด</th>
                                    <th>ชนิด MIME</th>
                                    <th>คำอธิบาย</th>
                                    <th>วันที่อัปโหลด</th>
                                    <th class="text-end pe-3" style="width: 100px;">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-5"></i>
                                            <span class="fw-semibold text-white">TOR-Artisan-Project-Specification.pdf</span>
                                        </div>
                                    </td>
                                    <td class="font-monospace text-secondary">1.84 MB</td>
                                    <td><code class="text-secondary" style="font-size: 11px;">application/pdf</code></td>
                                    <td class="text-secondary small">เอกสารข้อกำหนดทางเทคนิคโครงการ</td>
                                    <td class="small text-secondary font-monospace">2026-10-14 10:20:00</td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-outline-danger" title="ลบ"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-file-earmark-image-fill text-success fs-5"></i>
                                            <span class="fw-semibold text-white">system-architecture-diagram.png</span>
                                        </div>
                                    </td>
                                    <td class="font-monospace text-secondary">620.4 KB</td>
                                    <td><code class="text-secondary" style="font-size: 11px;">image/png</code></td>
                                    <td class="text-secondary small">แผนภาพสถาปัตยกรรมระบบ</td>
                                    <td class="small text-secondary font-monospace">2026-10-14 11:05:00</td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-outline-danger" title="ลบ"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        @else
            <!-- DASHBOARD VIEW (DEFAULT) -->
            <div class="d-flex flex-column gap-4">
                <div class="card card-custom p-4 p-md-5 border-primary/20 shadow-xl">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                        <span class="badge bg-danger px-2.5 py-1.5"><i class="bi bi-lightning-charge-fill me-1"></i> ArtisanCraft Engine</span>
                        <span class="badge badge-audit px-2.5 py-1.5">PHP {{ $projectConfig['php_version'] ?? '8.4' }} JIT</span>
                        <span class="badge bg-primary px-2.5 py-1.5">Laravel {{ $projectConfig['laravel_version'] ?? '13.x' }}</span>
                        <span class="badge bg-secondary px-2.5 py-1.5 text-uppercase">{{ $projectConfig['db_connection'] ?? 'mysql' }}</span>
                    </div>
                    <h1 class="display-6 fw-bold text-white mb-2">{{ $projectConfig['name'] ?? 'Artisan App' }}</h1>
                    <p class="fs-5 text-secondary col-lg-10 mb-4">
                        โครงสร้างโปรเจกต์พร้อมสำหรับการพัฒนา (Production Ready) ครบถ้วนทั้งคอนโทรลเลอร์ โมเดล ไมเกรชัน และชุดคำสั่งคอนเทนเนอร์ Docker
                    </p>

                    <div class="d-flex flex-wrap gap-2 pt-2 border-top border-secondary/40">
                        @if(!empty($projectConfig['modules']['buu_ldap']))
                        <a href="?view=login" class="btn btn-primary-custom"><i class="bi bi-shield-check me-1"></i> หน้าจอ Login (BUU LDAP)</a>
                        @endif
                        @if(!empty($projectConfig['modules']['user_role']))
                        <a href="?view=users" class="btn btn-outline-light"><i class="bi bi-people me-1"></i> จัดการ Users &amp; Roles</a>
                        @endif
                        @if(!empty($projectConfig['modules']['system_settings']))
                        <a href="?view=settings" class="btn btn-outline-warning"><i class="bi bi-gear me-1"></i> การตั้งค่าระบบ</a>
                        @endif
                        @if(!empty($projectConfig['modules']['notifications']))
                        <a href="?view=notifications" class="btn btn-outline-danger"><i class="bi bi-bell me-1"></i> ศูนย์แจ้งเตือน</a>
                        @endif
                        @if(!empty($projectConfig['modules']['media_storage']))
                        <a href="?view=media" class="btn btn-outline-success"><i class="bi bi-folder me-1"></i> คลังเอกสาร</a>
                        @endif
                    </div>
                </div>

                <!-- Feature Grid Overview -->
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card card-custom p-3 h-100">
                            <div class="d-flex align-items-center gap-2 mb-2 text-primary">
                                <i class="bi bi-shield-lock fs-4"></i>
                                <h6 class="fw-bold mb-0 text-white">Active Directory &amp; RBAC</h6>
                            </div>
                            <p class="small text-secondary mb-0">รองรับการยืนยันตัวตน BUU LDAP พร้อม Spatie Role &amp; Permission และ Passkey</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom p-3 h-100">
                            <div class="d-flex align-items-center gap-2 mb-2 text-success">
                                <i class="bi bi-patch-check fs-4"></i>
                                <h6 class="fw-bold mb-0 text-white">5 Mandatory Audit Stamps</h6>
                            </div>
                            <p class="small text-secondary mb-0">ตารางและโมเดลทั้งหมดมีคอลัมน์ created_by, created_at, updated_by, updated_at, request_uri</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom p-3 h-100">
                            <div class="d-flex align-items-center gap-2 mb-2 text-info">
                                <i class="bi bi-box-seam fs-4"></i>
                                <h6 class="fw-bold mb-0 text-white">Docker Automation</h6>
                            </div>
                            <p class="small text-secondary mb-0">พร้อมสคริปต์ docker-run.sh, docker-compose.yml สำหรับบูตเครื่องในเสี้ยววินาที</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </main>

    <!-- Bootstrap 5.3.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
