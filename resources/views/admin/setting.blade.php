@extends('layouts.artisan')

@section('title', 'System Settings & Package Sync - ArtisanCraft Engine')

@section('content')
<div class="flex flex-col w-full pb-space-2xl">
    <!-- Header Banner -->
    <div class="relative overflow-hidden bg-surface-container-low px-space-lg py-space-xl border-b border-surface-container-high/60">
        <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-primary-container/10 blur-3xl pointer-events-none"></div>
        <div class="absolute left-1/3 -bottom-20 w-80 h-80 rounded-full bg-secondary-container/15 blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col gap-space-lg max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md">
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-space-xs">
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high text-tertiary font-label-sm text-label-sm uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                            Administration Hub
                        </span>
                        <span class="text-outline font-code-inline text-label-sm">|</span>
                        <span class="text-secondary font-code-inline text-label-sm">Packagist &amp; npm Registry Live Sync</span>
                    </div>
                    <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">System Settings &amp; Package Intelligence</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">
                        เชื่อมโยง API ภายนอกเพื่อซิงค์จำนวนดาว GitHub, ยอดดาวน์โหลดรายเดือน, เวอร์ชันล่าสุด และตรวจสอบความเข้ากันได้แบบเรียลไทม์
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-space-sm">
                    <button id="btn-sync-now" onclick="triggerPackageSync()" type="button"
                            class="flex items-center gap-space-xs px-space-lg py-2.5 rounded-lg bg-primary-container hover:bg-inverse-primary text-on-primary font-headline-sm text-headline-sm font-medium transition-all shadow-[0_0_20px_rgba(255,85,66,0.3)] cursor-pointer">
                        <span class="material-symbols-outlined text-[20px]" id="sync-icon">sync</span>
                        <span id="sync-text">Sync Live Stats Now</span>
                    </button>
                </div>
            </div>

            <!-- Summary KPI Badges -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-space-md pt-2">
                <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest/60 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-outline uppercase font-code-block">Total Monitored</span>
                        <span class="font-headline-lg text-headline-lg text-on-surface font-code-block">{{ $totalPackages }}</span>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[20px]">inventory_2</span>
                    </div>
                </div>

                <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest/60 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-tertiary uppercase font-code-block">Healthy Stack</span>
                        <span class="font-headline-lg text-headline-lg text-tertiary font-code-block">{{ $healthyCount }}</span>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-tertiary/15 flex items-center justify-center text-tertiary">
                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    </div>
                </div>

                <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest/60 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-secondary uppercase font-code-block">Version Drift</span>
                        <span class="font-headline-lg text-headline-lg text-secondary font-code-block">{{ $driftCount }}</span>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-secondary/15 flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined text-[20px]">update</span>
                    </div>
                </div>

                <div class="p-space-md rounded-xl bg-surface-container border border-surface-container-highest/60 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-error uppercase font-code-block">Warnings &amp; Depr.</span>
                        <span class="font-headline-lg text-headline-lg text-error font-code-block">{{ $warningCount + $abandonedCount }}</span>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-error/15 flex items-center justify-center text-error">
                        <span class="material-symbols-outlined text-[20px]">warning</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto px-space-lg py-space-xl w-full flex flex-col gap-space-xl">
        <!-- Filter and Evaluation Matrix Controller -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md p-space-md rounded-xl bg-surface-container-low border border-surface-container-high/60">
            <div class="flex items-center gap-space-sm">
                <span class="material-symbols-outlined text-secondary text-[20px]">rule</span>
                <div>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Active Compatibility Matrix Evaluation</h3>
                    <span class="font-body-sm text-body-sm text-on-surface-variant">จำลองการประเมินความเข้ากันได้ตามเวอร์ชันรันไทม์ที่เลือก</span>
                </div>
            </div>
            <form method="GET" action="{{ route('admin.setting') }}" class="flex items-center gap-space-sm m-0">
                <div class="flex items-center gap-1.5 bg-surface-container rounded-lg px-2.5 py-1.5 border border-surface-container-highest">
                    <span class="text-tertiary text-xs font-code-inline">PHP:</span>
                    <select name="eval_php" onchange="this.form.submit()" class="bg-transparent text-xs font-code-inline text-on-surface focus:outline-none cursor-pointer">
                        @foreach($availablePhp as $pKey => $pVal)
                            <option value="{{ $pKey }}" class="bg-surface-container" {{ $selectedPhp === $pKey ? 'selected' : '' }}>{{ $pVal['version'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-1.5 bg-surface-container rounded-lg px-2.5 py-1.5 border border-surface-container-highest">
                    <span class="text-secondary text-xs font-code-inline">Laravel:</span>
                    <select name="eval_laravel" onchange="this.form.submit()" class="bg-transparent text-xs font-code-inline text-on-surface focus:outline-none cursor-pointer">
                        @foreach($availableLaravel as $lKey => $lVal)
                            <option value="{{ $lKey }}" class="bg-surface-container" {{ $selectedLaravel === $lKey ? 'selected' : '' }}>{{ $lVal['version'] }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Package Health Table -->
        <div class="flex flex-col rounded-xl bg-surface-container-low border border-surface-container-high/60 overflow-hidden shadow-xl">
            <div class="flex items-center justify-between px-space-lg py-space-md bg-surface-container border-b border-surface-container-high/60">
                <div class="flex items-center gap-space-sm">
                    <span class="material-symbols-outlined text-primary text-[20px]">table_chart</span>
                    <h2 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Package Intelligence &amp; Live Registry Data</h2>
                </div>
                <span class="text-xs font-code-inline text-outline">Single Source of Truth: config/generator.php &bull; Live: package_stats</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-surface-container-high/60 bg-surface-container/50 font-label-sm text-label-sm text-outline uppercase font-code-block">
                            <th class="py-3 px-space-md">Package Name</th>
                            <th class="py-3 px-space-md">Registry</th>
                            <th class="py-3 px-space-md text-right">GitHub Stars</th>
                            <th class="py-3 px-space-md text-right">Downloads (30d)</th>
                            <th class="py-3 px-space-md">Config vs Latest</th>
                            <th class="py-3 px-space-md">PHP Req</th>
                            <th class="py-3 px-space-md text-center">Health Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-high/40 text-body-sm font-body-sm">
                        @foreach($packages as $name => $pkg)
                            @php
                                $health = $pkg['health'];
                            @endphp
                            <tr class="hover:bg-surface-container/40 transition-colors">
                                <!-- Name -->
                                <td class="py-3.5 px-space-md">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-on-surface">{{ $pkg['title'] }}</span>
                                            @if($pkg['is_dev'])
                                                <span class="px-1.5 py-0.2 rounded bg-surface-container-highest text-secondary text-[10px] font-code-inline">--dev</span>
                                            @endif
                                            @if($pkg['is_abandoned'])
                                                <span class="px-1.5 py-0.2 rounded bg-error-container text-error text-[10px] font-semibold">ABANDONED</span>
                                            @endif
                                        </div>
                                        <a href="https://github.com/{{ $pkg['repo'] }}" target="_blank" rel="noopener noreferrer"
                                           class="text-xs font-code-inline text-outline hover:text-primary transition-colors flex items-center gap-1">
                                            <span>{{ $name }}</span>
                                            <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                                        </a>
                                    </div>
                                </td>

                                <!-- Source -->
                                <td class="py-3.5 px-space-md">
                                    <span class="px-2 py-0.5 rounded text-xs font-code-inline uppercase {{ $pkg['source'] === 'npm' ? 'bg-secondary/15 text-secondary' : 'bg-primary/15 text-primary' }}">
                                        {{ $pkg['source'] }}
                                    </span>
                                </td>

                                <!-- Stars -->
                                <td class="py-3.5 px-space-md text-right font-code-inline font-medium text-tertiary">
                                    <div class="flex items-center justify-end gap-1">
                                        <span class="material-symbols-outlined text-[14px]">star</span>
                                        <span>{{ $pkg['stars_formatted'] }}</span>
                                    </div>
                                </td>

                                <!-- Downloads -->
                                <td class="py-3.5 px-space-md text-right font-code-inline text-on-surface">
                                    {{ $pkg['downloads_formatted'] > 0 ? $pkg['downloads_formatted'] : '-' }}
                                </td>

                                <!-- Config vs Latest -->
                                <td class="py-3.5 px-space-md font-code-inline text-xs">
                                    <div class="flex flex-col gap-0.5">
                                        <span class="text-on-surface font-semibold">Cfg: {{ $pkg['default_constraint'] }}</span>
                                        @if($pkg['latest_version'])
                                            <span class="{{ $health['has_drift'] ? 'text-secondary font-bold' : 'text-outline' }}">
                                                Live: {{ $pkg['clean_version'] ?? $pkg['latest_version'] }}
                                                @if($health['has_drift'])
                                                    <span class="material-symbols-outlined text-[12px] align-middle">north_east</span>
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-outline">Live: -</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- PHP Req -->
                                <td class="py-3.5 px-space-md font-code-inline text-xs text-outline">
                                    {{ $pkg['php_requirement'] ?? '-' }}
                                </td>

                                <!-- Health Status -->
                                <td class="py-3.5 px-space-md text-center">
                                    @if($health['status'] === 'healthy')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-tertiary/15 text-tertiary text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                            Healthy
                                        </span>
                                    @elseif($health['status'] === 'notice')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-secondary/15 text-secondary text-xs font-semibold"
                                              title="{{ collect($health['issues'])->pluck('text')->implode(' | ') }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                            Update Avail.
                                        </span>
                                    @elseif($health['status'] === 'warning')
                                        <div class="inline-flex flex-col items-center">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-500/15 text-amber-400 text-xs font-semibold"
                                                  title="{{ collect($health['issues'])->pluck('text')->implode(' | ') }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                                Warning ({{ count($health['issues']) }})
                                            </span>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-error/15 text-error text-xs font-semibold"
                                              title="{{ collect($health['issues'])->pluck('text')->implode(' | ') }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                            Critical
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sync History Audit Trail (log_sync) -->
        <div class="flex flex-col rounded-xl bg-surface-container-low border border-surface-container-high/60 overflow-hidden shadow-lg">
            <div class="flex items-center justify-between px-space-lg py-space-md bg-surface-container border-b border-surface-container-high/60">
                <div class="flex items-center gap-space-sm">
                    <span class="material-symbols-outlined text-secondary text-[20px]">history</span>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Recent Synchronization Audit Logs (`log_sync`)</h3>
                </div>
                @if($lastSync)
                    <span class="text-xs font-code-inline text-outline">Last Run: {{ $lastSync->created_at->diffForHumans() }} ({{ $lastSync->duration_ms }}ms)</span>
                @endif
            </div>

            <div class="p-space-md flex flex-col gap-2">
                @if($recentLogs->isEmpty())
                    <p class="text-body-sm text-outline py-4 text-center">ยังไม่มีประวัติการซิงค์ข้อมูล กดปุ่ม "Sync Live Stats Now" ด้านบนเพื่อเริ่มซิงค์ครั้งแรก</p>
                @else
                    <div class="divide-y divide-surface-container-high/40">
                        @foreach($recentLogs as $log)
                            <div class="py-2.5 flex items-center justify-between font-code-inline text-xs">
                                <div class="flex items-center gap-3">
                                    <span class="px-2 py-0.5 rounded {{ $log->sync_status === 'success' ? 'bg-tertiary/20 text-tertiary font-bold' : ($log->sync_status === 'warning' ? 'bg-secondary/20 text-secondary' : 'bg-error/20 text-error') }}">
                                        {{ strtoupper($log->sync_status) }}
                                    </span>
                                    <span class="text-on-surface font-semibold">Synced: {{ $log->synced_count }} / {{ $log->total_packages }} pkgs</span>
                                    <span class="text-outline">({{ $log->duration_ms }}ms)</span>
                                </div>
                                <div class="flex items-center gap-3 text-outline">
                                    <span>Triggered by: <span class="text-primary">{{ $log->triggered_by }}</span></span>
                                    <span>{{ $log->created_at->format('Y-m-d H:i:s') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    async function triggerPackageSync() {
        const btn = document.getElementById('btn-sync-now');
        const icon = document.getElementById('sync-icon');
        const text = document.getElementById('sync-text');

        if (!btn) return;

        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-not-allowed');
        icon.classList.add('animate-spin');
        text.textContent = 'Connecting to Registries (Packagist & npm)...';

        try {
            const res = await fetch('{{ route("admin.setting.sync") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();

            if (res.ok) {
                if (window.Swal) {
                    Swal.fire({
                        title: 'Sync สำเร็จเรียบร้อย!',
                        html: `ซิงค์สำเร็จ <b>${data.synced}</b> / <b>${data.total}</b> แพ็กเกจ (ใช้เวลา ${data.duration_ms}ms)`,
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                        customClass: {
                            popup: 'artisan-swal-popup',
                            confirmButton: 'artisan-swal-confirm'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    alert(`Sync สำเร็จ: ${data.synced}/${data.total} แพ็กเกจ (${data.duration_ms}ms)`);
                    window.location.reload();
                }
            } else {
                if (window.Swal) {
                    Swal.fire({
                        title: 'การซิงค์ขัดข้อง',
                        text: data.message || 'ไม่สามารถติดต่อ Packagist/npm registry ได้',
                        icon: 'error',
                        confirmButtonText: 'ตกลง'
                    });
                } else {
                    alert(data.message || 'Sync failed');
                }
            }
        } catch (err) {
            console.error('Sync error', err);
            alert('เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์');
        } finally {
            btn.disabled = false;
            btn.classList.remove('opacity-70', 'cursor-not-allowed');
            icon.classList.remove('animate-spin');
            text.textContent = 'Sync Live Stats Now';
        }
    }
</script>
@endsection
