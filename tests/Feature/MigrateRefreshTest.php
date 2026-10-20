<?php

namespace Tests\Feature;

use App\Models\PackageStat;
use App\Models\User;
use App\Services\Auth\LdapAuthService;
use App\Services\Generator\ZipExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class MigrateRefreshTest extends TestCase
{
    public function test_migrate_refresh_command_executes_cleanly(): void
    {
        $exitCode = Artisan::call('migrate:refresh');
        $this->assertSame(0, $exitCode);
    }

    public function test_migrate_refresh_with_seed_populates_core_admins_and_package_stats(): void
    {
        $exitCode = Artisan::call('migrate:refresh', ['--seed' => true]);
        $this->assertSame(0, $exitCode);

        // Verify Core Admins
        $pantakarn = User::where('username', 'pantakarn')->first();
        $this->assertNotNull($pantakarn);
        $this->assertSame('admin', $pantakarn->role);
        $this->assertSame('Y', $pantakarn->active);

        $leadArchitect = User::where('username', 'lead.architect')->first();
        $this->assertNotNull($leadArchitect);
        $this->assertSame('admin', $leadArchitect->role);
        $this->assertSame('Y', $leadArchitect->active);

        $admin = User::where('username', 'admin')->first();
        $this->assertNotNull($admin);
        $this->assertSame('admin', $admin->role);
        $this->assertSame('Y', $admin->active);

        // Verify Package Stats
        $pkgCount = PackageStat::count();
        $this->assertGreaterThanOrEqual(20, $pkgCount);
    }

    public function test_ldap_auth_service_assigns_admin_role_to_initial_admins_on_new_record(): void
    {
        Artisan::call('migrate');
        User::where('username', 'pantakarn')->delete();

        /** @var LdapAuthService $service */
        $service = app(LdapAuthService::class);
        $user = $service->syncAndLoginLdapResponse([
            'username' => 'pantakarn',
            'NAMETH' => 'Pantakarn Manjan',
            'EMAIL' => 'pantakarn@buu.ac.th',
            'IDCARD' => '1234567890123',
        ], 'secret123');

        $this->assertNotNull($user);
        $this->assertSame('admin', $user->role);
        $this->assertSame('pantakarn', $user->username);
    }

    public function test_zip_export_service_drops_sessions_before_users(): void
    {
        /** @var ZipExportService $service */
        $service = app(ZipExportService::class);
        $files = $service->getAllGeneratedFiles([
            'name' => 'Test App',
            'slug' => 'test-app',
            'session_driver' => 'database',
            'modules' => ['buu_ldap' => true],
        ]);

        $usersMigration = $files['database/migrations/0001_01_01_000000_create_users_table.php'] ?? '';
        $this->assertNotEmpty($usersMigration);

        $posSessions = strpos($usersMigration, "Schema::dropIfExists('sessions');");
        $posUsers = strpos($usersMigration, "Schema::dropIfExists('users');");

        $this->assertNotFalse($posSessions, 'sessions drop statement missing');
        $this->assertNotFalse($posUsers, 'users drop statement missing');
        $this->assertLessThan($posUsers, $posSessions, 'sessions must be dropped before users in down() method');
    }
}
