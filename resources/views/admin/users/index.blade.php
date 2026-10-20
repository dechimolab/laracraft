@extends('layouts.artisan')

@section('title', 'User Management & Role Permissions - ArtisanCraft Engine')

@section('content')
<div class="flex flex-col w-full pb-space-2xl">
    <!-- Header Banner -->
    <div class="relative overflow-hidden bg-surface-container-low px-space-lg py-space-xl border-b border-surface-container-high/60">
        <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-secondary-container/10 blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/3 -bottom-20 w-80 h-80 rounded-full bg-primary-container/10 blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col gap-space-lg max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md">
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-space-xs">
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high text-secondary font-label-sm text-label-sm uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span>
                            Administration Hub
                        </span>
                        <span class="text-outline font-code-inline text-label-sm">|</span>
                        <span class="text-tertiary font-code-inline text-label-sm">User &amp; Access Governance</span>
                    </div>
                    <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">User Management &amp; Role Permissions</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">
                        ศูนย์กลางจัดการข้อมูลผู้ใช้งานในระบบ กำหนดสิทธิ์บทบาท (Admin / Developer) เปิด-ปิดระงับบัญชี และลบบัญชีผู้ใช้งานตามนโยบายความปลอดภัย
                    </p>
                </div>
            </div>

            <!-- Summary KPI Badges -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-space-md pt-2">
                <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest/60 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-outline uppercase font-code-block">Total Users</span>
                        <span class="font-headline-lg text-headline-lg text-on-surface font-code-block">{{ $totalUsers }}</span>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined text-[20px]">group</span>
                    </div>
                </div>

                <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest/60 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-primary uppercase font-code-block">Administrators</span>
                        <span class="font-headline-lg text-headline-lg text-primary font-code-block">{{ $adminCount }}</span>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-primary-container/20 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[20px]">shield_person</span>
                    </div>
                </div>

                <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest/60 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-tertiary uppercase font-code-block">Developers</span>
                        <span class="font-headline-lg text-headline-lg text-tertiary font-code-block">{{ $devCount }}</span>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-tertiary/15 flex items-center justify-center text-tertiary">
                        <span class="material-symbols-outlined text-[20px]">code</span>
                    </div>
                </div>

                <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest/60 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-error uppercase font-code-block">Deactivated</span>
                        <span class="font-headline-lg text-headline-lg text-error font-code-block">{{ $inactiveCount }}</span>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-error/15 flex items-center justify-center text-error">
                        <span class="material-symbols-outlined text-[20px]">person_off</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto px-space-lg py-space-xl w-full flex flex-col gap-space-xl">
        <!-- Search & Filter Controls -->
        <div class="p-space-md rounded-xl bg-surface-container-low border border-surface-container-high/60 shadow-md">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-space-md m-0">
                <div class="flex flex-col md:flex-row items-stretch md:items-center gap-space-md flex-1">
                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[18px]">search</span>
                        <input type="text" name="search" value="{{ $search }}"
                               placeholder="ค้นหาชื่อ, username หรือ email..."
                               class="w-full pl-9 pr-3 py-2 rounded-lg bg-surface-container border border-surface-container-highest text-body-sm font-body-sm text-on-surface focus:outline-none focus:border-secondary transition-colors">
                    </div>

                    <!-- Role Dropdown -->
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-code-inline text-outline whitespace-nowrap">บทบาท:</span>
                        <select name="role" class="px-3 py-2 rounded-lg bg-surface-container border border-surface-container-highest text-xs font-code-inline text-on-surface focus:outline-none focus:border-secondary cursor-pointer">
                            <option value="">---เลือก---</option>
                            <option value="admin" {{ $roleFilter === 'admin' ? 'selected' : '' }}>Admin (ผู้ดูแลระบบ)</option>
                            <option value="developer" {{ $roleFilter === 'developer' ? 'selected' : '' }}>Developer (นักพัฒนา)</option>
                        </select>
                    </div>

                    <!-- Status Dropdown -->
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-code-inline text-outline whitespace-nowrap">สถานะ:</span>
                        <select name="status" class="px-3 py-2 rounded-lg bg-surface-container border border-surface-container-highest text-xs font-code-inline text-on-surface focus:outline-none focus:border-secondary cursor-pointer">
                            <option value="">---เลือก---</option>
                            <option value="Y" {{ $statusFilter === 'Y' ? 'selected' : '' }}>Active (ใช้งานปกติ)</option>
                            <option value="N" {{ $statusFilter === 'N' ? 'selected' : '' }}>Inactive (ปิดบัญชี/ระงับ)</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-2 justify-end">
                    <button type="submit" class="px-4 py-2 rounded-lg bg-secondary hover:bg-secondary/90 text-on-secondary text-xs font-semibold flex items-center gap-1.5 transition-colors cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">filter_alt</span>
                        <span>กรองข้อมูล</span>
                    </button>
                    @if($search !== '' || $roleFilter !== '' || $statusFilter !== '')
                        <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-outline hover:text-on-surface text-xs font-semibold transition-colors">
                            ล้างตัวกรอง
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="flex flex-col rounded-xl bg-surface-container-low border border-surface-container-high/60 overflow-hidden shadow-xl">
            <div class="flex items-center justify-between px-space-lg py-space-md bg-surface-container border-b border-surface-container-high/60">
                <div class="flex items-center gap-space-sm">
                    <span class="material-symbols-outlined text-secondary text-[20px]">manage_accounts</span>
                    <h2 class="font-headline-sm text-headline-sm text-on-surface font-semibold">User Accounts Directory</h2>
                </div>
                <span class="text-xs font-code-inline text-outline">แสดง {{ $users->count() }} จากทั้งหมด {{ $users->total() }} บัญชี</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-surface-container-high/60 bg-surface-container/50 font-label-sm text-label-sm text-outline uppercase font-code-block">
                            <th class="py-3 px-space-md">User Details</th>
                            <th class="py-3 px-space-md">Role &amp; Privilege</th>
                            <th class="py-3 px-space-md text-center">Status</th>
                            <th class="py-3 px-space-md">Authentication / Security</th>
                            <th class="py-3 px-space-md">Joined Date</th>
                            <th class="py-3 px-space-md text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-high/40 text-body-sm font-body-sm">
                        @forelse($users as $u)
                            @php
                                $isSelf = ((int)$u->user_id === (int)Auth::id());
                                $initials = mb_substr($u->name ?? $u->username, 0, 2);
                            @endphp
                            <tr class="hover:bg-surface-container/40 transition-colors {{ !$u->isActive() ? 'opacity-70 bg-surface-container-lowest/30' : '' }}" id="user-row-{{ $u->user_id }}">
                                <!-- User Details -->
                                <td class="py-3.5 px-space-md">
                                    <div class="flex items-center gap-space-sm">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs uppercase font-code-inline {{ $u->isAdmin() ? 'bg-primary-container/30 text-primary border border-primary/40' : 'bg-surface-container-highest text-secondary border border-secondary/30' }}">
                                            {{ $initials }}
                                        </div>
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-1.5">
                                                <span class="font-headline-sm text-headline-sm text-on-surface font-medium">{{ $u->name }}</span>
                                                @if($isSelf)
                                                    <span class="px-1.5 py-0.2 rounded bg-tertiary/20 text-tertiary font-code-inline text-[10px] font-bold uppercase tracking-wider">YOU</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2 font-code-inline text-xs text-outline">
                                                <span>{{ '@' . ($u->username ?? 'local_user') }}</span>
                                                <span>&bull;</span>
                                                <span>{{ $u->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Role -->
                                <td class="py-3.5 px-space-md">
                                    @if($u->isAdmin())
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary-container/20 border border-primary/30 text-primary text-xs font-semibold font-code-inline">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                            ADMIN
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary-container/20 border border-secondary/30 text-secondary text-xs font-semibold font-code-inline">
                                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                            DEVELOPER
                                        </span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="py-3.5 px-space-md text-center">
                                    @if($u->isActive())
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-tertiary/15 text-tertiary text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-error/15 text-error text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                            Deactivated
                                        </span>
                                    @endif
                                </td>

                                <!-- Authentication / Security -->
                                <td class="py-3.5 px-space-md font-code-inline text-xs">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-1 text-on-surface-variant">
                                            <span class="material-symbols-outlined text-[14px] text-outline">domain</span>
                                            <span>BUU Central AD Auth</span>
                                        </div>
                                        @if(($u->webauthn_credentials_count ?? 0) > 0)
                                            <span class="text-tertiary flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[13px]">fingerprint</span>
                                                {{ $u->webauthn_credentials_count }} Passkey
                                            </span>
                                        @else
                                            <span class="text-outline-variant flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[13px]">key_off</span>
                                                No Passkey
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Joined Date -->
                                <td class="py-3.5 px-space-md font-code-inline text-xs text-outline">
                                    {{ $u->created_at ? $u->created_at->format('Y-m-d H:i') : '-' }}
                                </td>

                                <!-- Actions -->
                                <td class="py-3.5 px-space-md text-right whitespace-nowrap">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        <!-- Edit Role & Status Modal Trigger -->
                                        <button type="button"
                                                onclick="openEditUserModal({{ $u->user_id }}, '{{ addslashes($u->username) }}', '{{ addslashes($u->name) }}', '{{ addslashes($u->email) }}', '{{ $u->role }}', '{{ $u->active }}', {{ $isSelf ? 'true' : 'false' }})"
                                                title="แก้ไขสิทธิ์และสถานะบัญชี"
                                                class="px-2.5 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high border border-surface-container-highest/70 text-on-surface hover:text-secondary inline-flex items-center gap-1 transition-colors cursor-pointer text-xs font-semibold">
                                            <span class="material-symbols-outlined text-[16px]">edit_note</span>
                                            <span>แก้ไขสิทธิ์</span>
                                        </button>

                                        <!-- Toggle Active Button -->
                                        @if($isSelf)
                                            <button type="button" disabled title="ไม่สามารถระงับบัญชีตนเองได้"
                                                    class="p-1.5 rounded-lg bg-surface-container border border-surface-container-highest/40 text-outline-variant opacity-30 flex items-center justify-center cursor-not-allowed">
                                                <span class="material-symbols-outlined text-[18px]">block</span>
                                            </button>
                                        @else
                                            <button type="button"
                                                    onclick="toggleUserActive({{ $u->user_id }}, '{{ addslashes($u->username) }}', '{{ $u->active }}')"
                                                    title="{{ $u->isActive() ? 'คลิกเพื่อระงับ/ปิดบัญชี' : 'คลิกเพื่อเปิดใช้งานบัญชี' }}"
                                                    class="p-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high border border-surface-container-highest/70 {{ $u->isActive() ? 'text-outline hover:text-error hover:border-error/40' : 'text-tertiary hover:bg-tertiary/20 hover:border-tertiary/40' }} flex items-center justify-center transition-colors cursor-pointer">
                                                <span class="material-symbols-outlined text-[18px]">{{ $u->isActive() ? 'block' : 'check_circle' }}</span>
                                            </button>
                                        @endif

                                        <!-- Delete Button -->
                                        @if($isSelf)
                                            <button type="button" disabled title="ไม่สามารถลบบัญชีตนเองได้"
                                                    class="p-1.5 rounded-lg bg-surface-container border border-surface-container-highest/40 text-outline-variant opacity-30 flex items-center justify-center cursor-not-allowed">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        @else
                                            <button type="button"
                                                    onclick="deleteUser({{ $u->user_id }}, '{{ addslashes($u->username) }}')"
                                                    title="ลบบัญชีผู้ใช้งานถาวร"
                                                    class="p-1.5 rounded-lg bg-surface-container hover:bg-error-container/20 border border-surface-container-highest/70 hover:border-error/40 text-outline hover:text-error flex items-center justify-center transition-colors cursor-pointer">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-outline font-body-md">
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="material-symbols-outlined text-[36px] text-outline-variant">person_search</span>
                                        <span>ไม่พบบัญชีผู้ใช้งานที่ตรงกับเงื่อนไขการค้นหา</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="px-space-lg py-space-md bg-surface-container border-t border-surface-container-high/60">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div id="edit-user-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm animate-fade-in">
    <div class="relative w-full max-w-lg rounded-2xl bg-surface-container-low border border-surface-container-high shadow-2xl overflow-hidden">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-space-lg py-space-md border-b border-surface-container-high bg-surface-container">
            <div class="flex items-center gap-space-sm">
                <span class="material-symbols-outlined text-secondary text-[22px]">manage_accounts</span>
                <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">แก้ไขสิทธิ์และสถานะบัญชี</h3>
            </div>
            <button type="button" onclick="closeEditUserModal()" class="text-outline hover:text-on-surface transition-colors cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Modal Body / Form -->
        <form id="edit-user-form" onsubmit="submitEditUser(event)" class="p-space-lg flex flex-col gap-space-md m-0">
            @csrf
            <input type="hidden" id="edit-user-id" name="user_id">

            <!-- Target User Info Card -->
            <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="font-label-sm text-label-sm text-outline uppercase font-code-block">บัญชีเป้าหมาย</span>
                    <span id="modal-user-name" class="font-headline-sm text-headline-sm text-on-surface font-medium">-</span>
                    <span id="modal-user-email" class="font-code-inline text-xs text-secondary">-</span>
                </div>
                <div class="w-9 h-9 rounded-lg bg-surface-container-highest flex items-center justify-center text-outline">
                    <span class="material-symbols-outlined text-[20px]">badge</span>
                </div>
            </div>

            <!-- Role Selector -->
            <div class="flex flex-col gap-1.5">
                <label for="edit-role-select" class="font-label-sm text-label-sm text-outline uppercase font-code-block">
                    บทบาทและสิทธิ์การใช้งาน (Role Permissions) <span class="text-error">*</span>
                </label>
                <select id="edit-role-select" name="role" required class="w-full px-3 py-2.5 rounded-lg bg-surface-container border border-surface-container-highest text-body-sm font-code-inline text-on-surface focus:outline-none focus:border-secondary cursor-pointer">
                    <option value="developer">DEVELOPER (นักพัฒนา - สิทธิ์สร้างโปรเจกต์และตั้งค่าส่วนตัว)</option>
                    <option value="admin">ADMIN (ผู้ดูแลระบบ - Full Access เข้าถึง System Settings และจัดการบุคคล)</option>
                </select>
                <span class="text-xs text-outline font-body-sm">Admin สามารถเข้าถึง `/admin/setting` และจัดการบัญชีผู้ใช้อื่นได้ทั้งหมด</span>
            </div>

            <!-- Active Status Selector -->
            <div class="flex flex-col gap-1.5">
                <label for="edit-active-select" class="font-label-sm text-label-sm text-outline uppercase font-code-block">
                    สถานะการใช้งานบัญชี (Account Active Status) <span class="text-error">*</span>
                </label>
                <select id="edit-active-select" name="active" required class="w-full px-3 py-2.5 rounded-lg bg-surface-container border border-surface-container-highest text-body-sm font-code-inline text-on-surface focus:outline-none focus:border-secondary cursor-pointer">
                    <option value="Y">Y - Active (เปิดใช้งานปกติ เข้าสู่ระบบได้ทุกช่องทาง)</option>
                    <option value="N">N - Inactive (ปิด/ระงับบัญชี - ตัดเซสชันทันทีและไม่อนุญาตให้ล็อกอิน)</option>
                </select>
            </div>

            <div id="self-warning-box" class="hidden p-space-sm rounded-lg bg-primary-container/15 border border-primary/30 text-primary text-xs flex items-start gap-2">
                <span class="material-symbols-outlined text-[16px] shrink-0 mt-0.5">info</span>
                <span>นี่คือบัญชีของคุณเอง ระบบจะไม่อนุญาตให้ลดระดับสิทธิ์หรือระงับบัญชีตนเองเพื่อความปลอดภัย</span>
            </div>

            <!-- Modal Footer Buttons -->
            <div class="flex items-center justify-end gap-space-sm pt-space-sm border-t border-surface-container-high">
                <button type="button" onclick="closeEditUserModal()" class="px-4 py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface text-xs font-semibold transition-colors cursor-pointer">
                    ยกเลิก
                </button>
                <button type="submit" id="btn-save-user" class="px-5 py-2 rounded-lg bg-primary-container hover:bg-inverse-primary text-on-primary text-xs font-semibold transition-colors flex items-center gap-1.5 cursor-pointer">
                    <span class="material-symbols-outlined text-[16px]">save</span>
                    <span>บันทึกการเปลี่ยนแปลง</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    function openEditUserModal(userId, username, name, email, role, active, isSelf) {
        document.getElementById('edit-user-id').value = userId;
        document.getElementById('modal-user-name').innerText = name + ' (@' + username + ')';
        document.getElementById('modal-user-email').innerText = email;
        document.getElementById('edit-role-select').value = role;
        document.getElementById('edit-active-select').value = active;

        const warningBox = document.getElementById('self-warning-box');
        const roleSelect = document.getElementById('edit-role-select');
        const activeSelect = document.getElementById('edit-active-select');

        if (isSelf) {
            warningBox.classList.remove('hidden');
            roleSelect.setAttribute('disabled', 'disabled');
            activeSelect.setAttribute('disabled', 'disabled');
            document.getElementById('btn-save-user').setAttribute('disabled', 'disabled');
        } else {
            warningBox.classList.add('hidden');
            roleSelect.removeAttribute('disabled');
            activeSelect.removeAttribute('disabled');
            document.getElementById('btn-save-user').removeAttribute('disabled');
        }

        document.getElementById('edit-user-modal').classList.remove('hidden');
    }

    function closeEditUserModal() {
        document.getElementById('edit-user-modal').classList.add('hidden');
    }

    async function submitEditUser(e) {
        e.preventDefault();
        const userId = document.getElementById('edit-user-id').value;
        const role = document.getElementById('edit-role-select').value;
        const active = document.getElementById('edit-active-select').value;

        try {
            const res = await fetch(`/admin/users/${userId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ role, active })
            });

            const data = await res.json();
            if (res.ok && data.success) {
                closeEditUserModal();
                Swal.fire({
                    icon: 'success',
                    title: 'บันทึกสำเร็จ',
                    text: data.message,
                    background: '#131b2e',
                    color: '#e0e7ff',
                    confirmButtonColor: '#4edea3',
                    confirmButtonText: 'ตกลง'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถดำเนินการได้',
                    text: data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
                    background: '#131b2e',
                    color: '#e0e7ff',
                    confirmButtonColor: '#ff5542'
                });
            }
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาดในการเชื่อมต่อ',
                text: err.message,
                background: '#131b2e',
                color: '#e0e7ff',
                confirmButtonColor: '#ff5542'
            });
        }
    }

    async function toggleUserActive(userId, username, currentActive) {
        const isDeactivating = (currentActive === 'Y');
        const confirmTitle = isDeactivating ? `ยืนยันการปิด/ระงับบัญชี [${username}]?` : `ยืนยันการเปิดใช้งานบัญชี [${username}]?`;
        const confirmText = isDeactivating 
            ? 'ผู้ใช้จะไม่สามารถเข้าสู่ระบบได้ และเซสชันการเข้าใช้งานเดิมจะถูกตัดทันที' 
            : 'ผู้ใช้จะสามารถเข้าสู่ระบบและใช้งานเครื่องมือต่างๆ ได้ตามปกติ';

        const result = await Swal.fire({
            title: confirmTitle,
            text: confirmText,
            icon: isDeactivating ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonText: isDeactivating ? 'ระงับบัญชี' : 'เปิดใช้งาน',
            cancelButtonText: 'ยกเลิก',
            background: '#131b2e',
            color: '#e0e7ff',
            confirmButtonColor: isDeactivating ? '#ff5542' : '#4edea3',
            cancelButtonColor: '#222a3d'
        });

        if (!result.isConfirmed) return;

        try {
            const res = await fetch(`/admin/users/${userId}/toggle-active`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const data = await res.json();
            if (res.ok && data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: data.message,
                    background: '#131b2e',
                    color: '#e0e7ff',
                    confirmButtonColor: '#4edea3',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด',
                    text: data.message || 'ไม่สามารถเปลี่ยนสถานะได้',
                    background: '#131b2e',
                    color: '#e0e7ff',
                    confirmButtonColor: '#ff5542'
                });
            }
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: err.message,
                background: '#131b2e',
                color: '#e0e7ff',
                confirmButtonColor: '#ff5542'
            });
        }
    }

    async function deleteUser(userId, username) {
        const result = await Swal.fire({
            title: `ยืนยันการลบบัญชี [${username}]?`,
            text: 'การกระทำนี้จะลบบัญชีผู้ใช้, ข้อมูลกุญแจ Passkey และเซสชันทั้งหมดถาวร ไม่สามารถย้อนกลับได้!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่, ลบบัญชีนี้ทันที',
            cancelButtonText: 'ยกเลิก',
            background: '#131b2e',
            color: '#e0e7ff',
            confirmButtonColor: '#ff5542',
            cancelButtonColor: '#222a3d'
        });

        if (!result.isConfirmed) return;

        try {
            const res = await fetch(`/admin/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const data = await res.json();
            if (res.ok && data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'ลบบัญชีสำเร็จ',
                    text: data.message,
                    background: '#131b2e',
                    color: '#e0e7ff',
                    confirmButtonColor: '#4edea3',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถลบได้',
                    text: data.message || 'เกิดข้อผิดพลาดในการลบบัญชี',
                    background: '#131b2e',
                    color: '#e0e7ff',
                    confirmButtonColor: '#ff5542'
                });
            }
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: err.message,
                background: '#131b2e',
                color: '#e0e7ff',
                confirmButtonColor: '#ff5542'
            });
        }
    }
</script>
@endpush
