<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogSync;
use App\Services\Packages\PackageStatsRepository;
use App\Services\Packages\PackageStatsSyncService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the System Settings & Package Synchronization Dashboard.
     */
    public function index(PackageStatsRepository $repository, Request $request): View
    {
        $allPackages = $repository->getAllStats();

        // Default to active LTS matrix for health evaluation
        $selectedPhp = $request->input('eval_php', config('generator.default_php', '8.4'));
        $selectedLaravel = $request->input('eval_laravel', config('generator.default_laravel', '13.x'));

        $evaluatedPackages = [];
        $healthyCount = 0;
        $driftCount = 0;
        $warningCount = 0;
        $abandonedCount = 0;

        foreach ($allPackages as $name => $pkg) {
            $health = $repository->evaluateHealth($pkg, $selectedPhp, $selectedLaravel);
            $pkg['health'] = $health;
            $evaluatedPackages[$name] = $pkg;

            if ($health['status'] === 'healthy' || $health['status'] === 'notice') {
                $healthyCount++;
            }
            if ($health['has_drift']) {
                $driftCount++;
            }
            if (!empty($pkg['is_abandoned'])) {
                $abandonedCount++;
            }
            if ($health['status'] === 'warning' || $health['status'] === 'danger') {
                $warningCount++;
            }
        }

        $lastSync = LogSync::query()->latest('created_at')->first();
        $recentLogs = LogSync::query()->latest('created_at')->take(10)->get();

        return view('admin.setting', [
            'packages'          => $evaluatedPackages,
            'totalPackages'     => count($evaluatedPackages),
            'healthyCount'      => $healthyCount,
            'driftCount'        => $driftCount,
            'warningCount'      => $warningCount,
            'abandonedCount'    => $abandonedCount,
            'lastSync'          => $lastSync,
            'recentLogs'        => $recentLogs,
            'selectedPhp'       => $selectedPhp,
            'selectedLaravel'   => $selectedLaravel,
            'availablePhp'      => config('generator.php_versions', []),
            'availableLaravel'  => config('generator.laravel_versions', []),
        ]);
    }

    /**
     * Trigger live synchronization via AJAX/JSON.
     */
    public function sync(PackageStatsSyncService $syncService): JsonResponse
    {
        $result = $syncService->syncAll('web_admin');

        $statusCode = ($result['status'] === 'locked') ? 429 : 200;

        return response()->json($result, $statusCode);
    }
}
