<?php

namespace App\Services\Packages;

use App\Models\PackageStat;
use Illuminate\Support\Facades\Cache;

class PackageStatsRepository
{
    /**
     * Get statistics for a specific package, falling back to config if not synced.
     */
    public function getStats(string $packageName): array
    {
        $all = $this->getAllStats();
        return $all[$packageName] ?? $this->getFallbackStats($packageName);
    }

    /**
     * Get all package stats keyed by package name.
     */
    public function getAllStats(): array
    {
        return Cache::remember('generator_all_package_stats', 300, function () {
            $configs = config('generator.packages', []);
            $dbStats = collect();

            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('package_stats')) {
                    $dbStats = PackageStat::query()->get()->keyBy('package_name');
                }
            } catch (\Throwable $e) {
                $dbStats = collect();
            }

            $result = [];
            foreach ($configs as $name => $cfg) {
                /** @var PackageStat|null $stat */
                $stat = $dbStats->get($name);

                if ($stat) {
                    $stars = (int) $stat->stars;
                    $downloads = (int) $stat->downloads_monthly;
                    $latestVersion = $stat->latest_version;
                    $isAbandoned = (bool) $stat->is_abandoned;
                    $isArchived = (bool) $stat->is_archived;
                    $phpReq = $stat->php_requirement;
                    $laravelReq = $stat->laravel_requirement;
                    $syncedAt = $stat->synced_at ? $stat->synced_at->toDateTimeString() : null;
                    $syncStatus = $stat->sync_status;
                } else {
                    $stars = (int) ($cfg['fallback_stars'] ?? 0);
                    $downloads = 0;
                    $latestVersion = null;
                    $isAbandoned = false;
                    $isArchived = false;
                    $phpReq = null;
                    $laravelReq = null;
                    $syncedAt = null;
                    $syncStatus = 'fallback';
                }

                $cleanVersion = $this->cleanVersion($latestVersion);
                $majorConstraint = $this->toMajorConstraint($cleanVersion);
                $activeVersion = $this->resolveVersionConstraint($name, $cleanVersion, $cfg);

                $result[$name] = [
                    'name'                => $name,
                    'title'               => $cfg['title'] ?? $name,
                    'source'              => $cfg['source'] ?? 'composer',
                    'category'            => $cfg['category'] ?? 'devtools',
                    'repo'                => $cfg['repo'] ?? $name,
                    'default_constraint'  => $cfg['default_constraint'] ?? '*',
                    'is_dev'              => (bool) ($cfg['is_dev'] ?? false),
                    'stars'               => $stars,
                    'stars_formatted'     => $this->formatNumber($stars) . ($cfg['source'] === 'npm' ? ' ★' : ''),
                    'downloads_monthly'   => $downloads,
                    'downloads_formatted' => $this->formatNumber($downloads),
                    'latest_version'      => $latestVersion,
                    'clean_version'       => $cleanVersion,
                    'major_constraint'    => $majorConstraint,
                    'active_version'      => $activeVersion,
                    'php_requirement'     => $phpReq,
                    'laravel_requirement' => $laravelReq,
                    'is_abandoned'        => $isAbandoned,
                    'is_archived'         => $isArchived,
                    'synced_at'           => $syncedAt,
                    'sync_status'         => $syncStatus,
                ];
            }

            return $result;
        });
    }

    /**
     * Clear the cache.
     */
    public function clearCache(): void
    {
        Cache::forget('generator_all_package_stats');
    }

    /**
     * Resolve the active version constraint for a package.
     */
    public function resolvePackageVersion(string $packageName, ?string $laravelMajor = null): string
    {
        $aligned = config('generator.laravel_aligned_packages', []);
        $all = $this->getAllStats();
        $pkg = $all[$packageName] ?? null;

        if ($pkg && !empty($pkg['clean_version'])) {
            $clean = $pkg['clean_version'];
            if (($pkg['source'] ?? '') === 'npm') {
                return $clean;
            }
            // If framework major is explicitly specified and differs from clean version's major (e.g. upcoming Laravel 14 preview):
            if (isset($aligned[$packageName]) && $laravelMajor !== null) {
                $cleanMajor = (int) explode('.', $clean)[0];
                if ((int) $laravelMajor !== $cleanMajor) {
                    return str_replace('{major}', (string) $laravelMajor, $aligned[$packageName]['template']);
                }
            }
            return $this->toMajorConstraint($clean) ?? "^{$clean}";
        }

        if (isset($aligned[$packageName])) {
            $major = $laravelMajor ?? (string) (config("generator.laravel_versions." . config('generator.default_laravel', '13.x') . ".major") ?? 13);
            return str_replace('{major}', $major, $aligned[$packageName]['template']);
        }

        $cfg = config("generator.packages.{$packageName}", []);
        $default = $cfg['default_constraint'] ?? '^1.0';
        if (($cfg['source'] ?? '') === 'npm') {
            return $default;
        }

        return $this->toMajorConstraint($default) ?? $default;
    }

    /**
     * Convert any semver version into a major constraint (^x.0).
     * e.g. 13.3.1 -> ^13.0, 5.3.2 -> ^5.0, ^8.3.0 -> ^8.0
     */
    public function toMajorConstraint(?string $version): ?string
    {
        if (!$version) {
            return null;
        }

        $v = ltrim(trim($version), 'v^~');
        if (preg_match('/^(\d+)/', $v, $matches)) {
            return "^{$matches[1]}.0";
        }

        return "^{$v}";
    }

    /**
     * Clean version string (strip leading 'v', remove 4th trailing .0 from normalized packagist version).
     */
    public function cleanVersion(?string $version): ?string
    {
        if (!$version) {
            return null;
        }

        $v = ltrim(trim($version), 'v^~');

        // Remove trailing .0 from 4-part normalized semver (e.g. 13.3.1.0 -> 13.3.1)
        return preg_replace('/(\.\d+)\.0$/', '$1', $v);
    }

    /**
     * Resolve active version constraint based on clean version and package config.
     */
    public function resolveVersionConstraint(string $packageName, ?string $cleanVersion, array $config): string
    {
        $aligned = config('generator.laravel_aligned_packages', []);
        if (isset($aligned[$packageName])) {
            $major = (string) (config("generator.laravel_versions." . config('generator.default_laravel', '13.x') . ".major") ?? 13);
            return str_replace('{major}', $major, $aligned[$packageName]['template']);
        }

        if (!empty($cleanVersion)) {
            if (($config['source'] ?? 'composer') === 'npm') {
                return $cleanVersion;
            }
            return $this->toMajorConstraint($cleanVersion) ?? "^{$cleanVersion}";
        }

        $default = $config['default_constraint'] ?? '^1.0';
        if (($config['source'] ?? 'composer') === 'npm') {
            return $default;
        }

        return $this->toMajorConstraint($default) ?? $default;
    }

    /**
     * Fallback stats generator from config.
     */
    protected function getFallbackStats(string $packageName): array
    {
        $cfg = config("generator.packages.{$packageName}", []);
        $stars = (int) ($cfg['fallback_stars'] ?? 0);
        $defaultConstraint = $cfg['default_constraint'] ?? '*';

        return [
            'name'                => $packageName,
            'title'               => $cfg['title'] ?? $packageName,
            'source'              => $cfg['source'] ?? 'composer',
            'category'            => $cfg['category'] ?? 'devtools',
            'repo'                => $cfg['repo'] ?? $packageName,
            'default_constraint'  => $defaultConstraint,
            'is_dev'              => (bool) ($cfg['is_dev'] ?? false),
            'stars'               => $stars,
            'stars_formatted'     => $this->formatNumber($stars),
            'downloads_monthly'   => 0,
            'downloads_formatted' => '0',
            'latest_version'      => null,
            'clean_version'       => null,
            'major_constraint'    => $this->toMajorConstraint($defaultConstraint),
            'active_version'      => $defaultConstraint,
            'php_requirement'     => null,
            'laravel_requirement' => null,
            'is_abandoned'        => false,
            'is_archived'         => false,
            'synced_at'           => null,
            'sync_status'         => 'fallback',
        ];
    }

    /**
     * Evaluate real compatibility (Idea A), drift alert (Idea B), and abandoned flag (Idea C).
     */
    public function evaluateHealth(array $packageData, string $selectedPhp = '8.4', string $selectedLaravel = '13.x'): array
    {
        $issues = [];
        $isCompatible = true;
        $hasDrift = false;

        // Idea C: Abandoned / Archived Warning
        if (!empty($packageData['is_abandoned'])) {
            $issues[] = [
                'type' => 'danger',
                'code' => 'abandoned',
                'text' => 'Package ถูกระบุเป็น Abandoned บน Packagist แล้ว',
            ];
            $isCompatible = false;
        }

        if (!empty($packageData['is_archived'])) {
            $issues[] = [
                'type' => 'warning',
                'code' => 'archived',
                'text' => 'Repository ต้นทางถูก Archive บน GitHub แล้ว',
            ];
        }

        // Idea A: Real Compatibility Check
        // Check PHP constraint if available (e.g., ^8.2, >=8.2)
        if (!empty($packageData['php_requirement'])) {
            $phpReq = $packageData['php_requirement'];
            if (!$this->checkConstraintMatch($selectedPhp, $phpReq)) {
                $issues[] = [
                    'type' => 'warning',
                    'code' => 'php_incompatible',
                    'text' => "ต้องการ PHP {$phpReq} (ระบบเลือกใช้ PHP {$selectedPhp})",
                ];
            }
        }

        // Check Laravel constraint if available (e.g. ^11.0, ^12.0)
        if (!empty($packageData['laravel_requirement'])) {
            $major = (string) (config("generator.laravel_versions.{$selectedLaravel}.major") ?? 13);
            $larReq = $packageData['laravel_requirement'];
            if (!$this->checkConstraintMatch($major, $larReq)) {
                $issues[] = [
                    'type' => 'warning',
                    'code' => 'laravel_incompatible',
                    'text' => "อาจยังไม่รองรับ Laravel {$selectedLaravel} (ความต้องการล่าสุด: {$larReq})",
                ];
            }
        }

        // Idea B: Version Drift Alert
        if (!empty($packageData['latest_version']) && !empty($packageData['default_constraint'])) {
            $configVer = ltrim($packageData['default_constraint'], '^~v');
            $latestVer = ltrim($packageData['clean_version'] ?? $packageData['latest_version'], '^~v');
            if (version_compare($latestVer, $configVer, '>')) {
                $hasDrift = true;
                $issues[] = [
                    'type' => 'info',
                    'code' => 'version_drift',
                    'text' => "มีเวอร์ชันใหม่ {$latestVer} (คอนฟิกปัจจุบันใช้ {$packageData['default_constraint']})",
                ];
            }
        }

        $status = 'healthy';
        if (!$isCompatible) {
            $status = 'danger';
        } elseif (collect($issues)->contains('type', 'warning')) {
            $status = 'warning';
        } elseif ($hasDrift) {
            $status = 'notice';
        }

        return [
            'is_compatible' => $isCompatible,
            'has_drift'     => $hasDrift,
            'issues'        => $issues,
            'status'        => $status,
        ];
    }

    /**
     * Basic semver constraint matcher for PHP/Laravel versions.
     */
    protected function checkConstraintMatch(string $currentVersion, string $constraint): bool
    {
        // Simple regex check for major/minor matching
        // e.g. "^8.2" matches "8.4", "8.5"
        // "^11.0" does not match "13"
        if (str_contains($constraint, '*')) {
            return true;
        }

        // Extract numbers
        preg_match_all('/\d+(\.\d+)?/', $constraint, $matches);
        if (empty($matches[0])) {
            return true;
        }

        $minVersion = $matches[0][0];
        if (version_compare($currentVersion, $minVersion, '<')) {
            return false;
        }

        // Check upper bound if strictly ^11.0 and current is 13
        if (str_starts_with($constraint, '^')) {
            $parts = explode('.', $minVersion);
            $nextMajor = ((int) $parts[0]) + 1;
            $currMajor = (int) explode('.', $currentVersion)[0];
            if ($currMajor >= $nextMajor && !str_contains($constraint, '|')) {
                return false;
            }
        }

        return true;
    }

    /**
     * Format numbers into 14.8k, 1.2M
     */
    protected function formatNumber(int $num): string
    {
        if ($num >= 1000000) {
            $formatted = number_format($num / 1000000, 1);
            return rtrim(rtrim($formatted, '0'), '.') . 'M';
        }
        if ($num >= 1000) {
            $formatted = number_format($num / 1000, 1);
            return rtrim(rtrim($formatted, '0'), '.') . 'k';
        }
        return (string) $num;
    }
}
