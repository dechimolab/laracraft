<?php

namespace App\Console\Commands;

use App\Services\Packages\PackageStatsSyncService;
use Illuminate\Console\Command;

class SyncPackageStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator:sync-packages {--trigger=artisan_cli}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync live package statistics (GitHub stars, downloads, versions) from Packagist and npm registries';

    /**
     * Execute the console command.
     */
    public function handle(PackageStatsSyncService $service): int
    {
        $this->info('Starting package stats synchronization...');
        $trigger = (string) $this->option('trigger');

        $result = $service->syncAll($trigger);

        if ($result['status'] === 'locked') {
            $this->warn($result['message']);
            return Command::FAILURE;
        }

        $this->info("Completed sync in {$result['duration_ms']}ms:");
        $this->line("- Total packages: {$result['total']}");
        $this->line("- Synced: {$result['synced']}");
        $this->line("- Failed: {$result['failed']}");

        if (!empty($result['errors'])) {
            $this->warn('Errors encountered:');
            foreach ($result['errors'] as $pkg => $err) {
                $this->error("  * {$pkg}: {$err}");
            }
        }

        return ($result['failed'] === 0) ? Command::SUCCESS : Command::INVALID;
    }
}
