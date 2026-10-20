<?php

namespace App\Services\Packages;

use App\Models\LogSync;
use App\Models\PackageStat;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class PackageStatsSyncService
{
    public function __construct(
        protected PackageStatsRepository $repository
    ) {}

    /**
     * Run full sync for all configured packages.
     */
    public function syncAll(?string $triggeredBy = 'web_admin'): array
    {
        $lock = Cache::lock('package-sync', 120);

        if (!$lock->get()) {
            return [
                'status'  => 'locked',
                'message' => 'มีกระบวนการ Sync กำลังทำงานอยู่ กรุณารอสักครู่',
                'total'   => 0,
                'synced'  => 0,
                'failed'  => 0,
                'duration_ms' => 0,
            ];
        }

        $startTime = microtime(true);
        $packages = config('generator.packages', []);
        $total = count($packages);
        $synced = 0;
        $failed = 0;
        $errorDetails = [];

        try {
            foreach ($packages as $packageName => $config) {
                try {
                    $source = $config['source'] ?? 'composer';

                    if ($source === 'npm') {
                        $statData = $this->syncNpmPackage($packageName, $config);
                    } else {
                        $statData = $this->syncComposerPackage($packageName, $config);
                    }

                    PackageStat::updateOrCreate(
                        ['package_name' => $packageName],
                        array_merge($statData, [
                            'source'      => $source,
                            'category'    => $config['category'] ?? 'devtools',
                            'synced_at'   => now(),
                            'sync_status' => 'success',
                            'sync_error'  => null,
                        ])
                    );

                    $synced++;
                } catch (Throwable $e) {
                    $failed++;
                    $errorDetails[$packageName] = $e->getMessage();
                    Log::warning("Failed to sync package {$packageName}: " . $e->getMessage());

                    PackageStat::updateOrCreate(
                        ['package_name' => $packageName],
                        [
                            'source'      => $config['source'] ?? 'composer',
                            'category'    => $config['category'] ?? 'devtools',
                            'sync_status' => 'failed',
                            'sync_error'  => $e->getMessage(),
                        ]
                    );
                }
            }

            $durationMs = (int) round((microtime(true) - $startTime) * 1000);
            $overallStatus = ($failed === 0) ? 'success' : (($synced > 0) ? 'warning' : 'failed');

            // Record sync audit trail
            LogSync::create([
                'sync_source'    => 'packages_api',
                'sync_status'    => $overallStatus,
                'total_packages' => $total,
                'synced_count'   => $synced,
                'failed_count'   => $failed,
                'error_details'  => !empty($errorDetails) ? $errorDetails : null,
                'triggered_by'   => $triggeredBy,
                'duration_ms'    => $durationMs,
            ]);

            // Clear cache
            $this->repository->clearCache();

            return [
                'status'      => $overallStatus,
                'total'       => $total,
                'synced'      => $synced,
                'failed'      => $failed,
                'duration_ms' => $durationMs,
                'errors'      => $errorDetails,
            ];
        } finally {
            $lock->release();
        }
    }

    /**
     * Fetch Composer package stats from Packagist API.
     */
    protected function syncComposerPackage(string $packageName, array $config): array
    {
        $lookupName = $config['packagist_name'] ?? $packageName;
        $url = "https://packagist.org/packages/{$lookupName}.json";

        $response = Http::timeout(10)->retry(2, 200)->get($url);

        if (!$response->successful()) {
            throw new \RuntimeException("Packagist API HTTP {$response->status()} for {$lookupName}");
        }

        $data = $response->json('package');
        if (!$data) {
            throw new \RuntimeException("Invalid Packagist JSON response for {$lookupName}");
        }

        $stars = (int) ($data['github_stars'] ?? $data['favers'] ?? $config['fallback_stars'] ?? 0);
        $downloadsMonthly = (int) ($data['downloads']['monthly'] ?? 0);
        $downloadsTotal = (int) ($data['downloads']['total'] ?? 0);

        // Analyze latest stable version
        $versions = $data['versions'] ?? [];
        $latestVersion = null;
        $phpReq = null;
        $laravelReq = null;

        foreach ($versions as $verKey => $verData) {
            // Skip dev versions
            if (str_contains($verKey, 'dev') || str_contains($verKey, 'alpha') || str_contains($verKey, 'beta')) {
                continue;
            }

            $latestVersion = $verData['version_normalized'] ?? $verKey;
            $requires = $verData['require'] ?? [];
            $phpReq = $requires['php'] ?? null;

            // Detect Laravel framework requirement
            foreach ($requires as $reqPkg => $reqConstraint) {
                if ($reqPkg === 'laravel/framework' || str_starts_with($reqPkg, 'illuminate/')) {
                    $laravelReq = $reqConstraint;
                    break;
                }
            }

            break; // First non-dev version is the latest
        }

        // Abandoned flag
        $isAbandoned = false;
        $abandonedReplacement = null;
        if (!empty($data['abandoned'])) {
            $isAbandoned = true;
            $abandonedReplacement = is_string($data['abandoned']) ? $data['abandoned'] : null;
        }

        return [
            'stars'                 => $stars,
            'downloads_monthly'     => $downloadsMonthly,
            'downloads_total'       => $downloadsTotal,
            'latest_version'        => $latestVersion,
            'php_requirement'       => $phpReq,
            'laravel_requirement'   => $laravelReq,
            'is_abandoned'          => $isAbandoned,
            'abandoned_replacement' => $abandonedReplacement,
        ];
    }

    /**
     * Fetch npm package stats from npm registry & download API.
     */
    protected function syncNpmPackage(string $packageName, array $config): array
    {
        $npmName = $config['npm_name'] ?? $packageName;
        $regUrl = "https://registry.npmjs.org/{$npmName}";
        $dlUrl = "https://api.npmjs.org/downloads/point/last-month/{$npmName}";

        $regRes = Http::timeout(10)->retry(2, 200)->get($regUrl);
        $latestVersion = null;
        if ($regRes->successful()) {
            $latestVersion = $regRes->json('dist-tags.latest');
        }

        $downloadsMonthly = 0;
        $dlRes = Http::timeout(10)->retry(2, 200)->get($dlUrl);
        if ($dlRes->successful()) {
            $downloadsMonthly = (int) ($dlRes->json('downloads') ?? 0);
        }

        // Check if npm package also exists on Packagist or has fallback stars
        $stars = (int) ($config['fallback_stars'] ?? 0);
        if ($packageName === 'twbs/bootstrap') {
            // Also query Packagist for twbs/bootstrap
            try {
                $pkgRes = Http::timeout(5)->get("https://packagist.org/packages/twbs/bootstrap.json");
                if ($pkgRes->successful()) {
                    $stars = (int) ($pkgRes->json('package.github_stars') ?? $stars);
                }
            } catch (Throwable) {}
        }

        return [
            'stars'                 => $stars,
            'downloads_monthly'     => $downloadsMonthly,
            'downloads_total'       => 0,
            'latest_version'        => $latestVersion,
            'php_requirement'       => null,
            'laravel_requirement'   => null,
            'is_abandoned'          => false,
            'abandoned_replacement' => null,
        ];
    }
}
