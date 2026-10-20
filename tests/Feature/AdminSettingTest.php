<?php

namespace Tests\Feature;

use App\Models\LogSync;
use App\Models\PackageStat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AdminSettingTest extends TestCase
{
    use RefreshDatabase;

    protected function createAdminUser(array $overrides = []): User
    {
        return User::factory()->create(array_merge([
            'username' => 'superadmin',
            'name' => 'System Administrator',
            'email' => 'admin@buu.ac.th',
            'role' => 'admin',
            'active' => 'Y',
        ], $overrides));
    }

    protected function createDevUser(array $overrides = []): User
    {
        return User::factory()->create(array_merge([
            'username' => 'somchai.dev',
            'name' => 'Somchai Developer',
            'email' => 'somchai@buu.ac.th',
            'role' => 'developer',
            'active' => 'Y',
        ], $overrides));
    }

    public function test_guest_is_redirected_to_login_when_accessing_admin_setting(): void
    {
        $response = $this->get('/admin/setting');

        $response->assertRedirect('/login');
    }

    public function test_non_admin_user_gets_403_forbidden_on_admin_setting(): void
    {
        $dev = $this->createDevUser();

        $response = $this->actingAs($dev)->get('/admin/setting');

        $response->assertStatus(403);
    }

    public function test_admin_user_can_access_admin_setting_dashboard(): void
    {
        $admin = $this->createAdminUser();

        PackageStat::create([
            'package_name' => 'laravel/framework',
            'source' => 'composer',
            'category' => 'core',
            'stars' => 32000,
            'downloads_monthly' => 5000000,
            'downloads_total' => 300000000,
            'latest_version' => 'v12.5.0',
            'sync_status' => 'success',
            'synced_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get('/admin/setting');

        $response->assertStatus(200);
        $response->assertSee('System Settings &amp; Package Intelligence', false);
        $response->assertSee('Sync Live Stats Now');
        $response->assertSee('Active Compatibility Matrix Evaluation');
        $response->assertSee('Package Intelligence &amp; Live Registry Data', false);
        $response->assertSee('Recent Synchronization Audit Logs');
        $this->assertStringContainsString('no-store', (string) $response->headers->get('Cache-Control'));
    }

    public function test_admin_can_trigger_package_sync_via_post_endpoint(): void
    {
        $admin = $this->createAdminUser();

        Http::fake([
            'https://repo.packagist.org/p2/*' => Http::response([
                'packages' => [
                    'laravel/framework' => [
                        [
                            'version' => 'v12.5.0',
                            'require' => ['php' => '^8.2', 'illuminate/contracts' => '^12.0'],
                        ],
                    ],
                ],
            ], 200),
            'https://packagist.org/packages/*.json' => Http::response([
                'package' => [
                    'github_stars' => 32500,
                    'downloads' => ['total' => 305000000],
                    'abandoned' => false,
                ],
            ], 200),
            'https://registry.npmjs.org/*' => Http::response([
                'dist-tags' => ['latest' => '5.3.3'],
                'versions' => ['5.3.3' => ['version' => '5.3.3']],
            ], 200),
            'https://api.npmjs.org/downloads/point/last-month/*' => Http::response([
                'downloads' => 1500000,
            ], 200),
        ]);

        $response = $this->actingAs($admin)->postJson('/admin/setting/sync');

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
        ]);

        $this->assertDatabaseHas('log_sync', [
            'sync_source' => 'packages_api',
            'sync_status' => 'success',
            'created_by' => 'superadmin',
        ]);
    }

    public function test_artisan_make_admin_command_promotes_user_role(): void
    {
        $dev = $this->createDevUser(['username' => 'sompong.arch']);
        $this->assertEquals('developer', $dev->role);

        $this->artisan('generator:make-admin sompong.arch')
            ->expectsOutputToContain("User 'sompong.arch' has been promoted to 'admin' role successfully.")
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'username' => 'sompong.arch',
            'role' => 'admin',
        ]);
    }

    public function test_artisan_sync_packages_command_runs_successfully(): void
    {
        Http::fake([
            'https://repo.packagist.org/p2/*' => Http::response([
                'packages' => [
                    'sample/pkg' => [
                        [
                            'version' => 'v1.0.0',
                            'require' => ['php' => '^8.2'],
                        ],
                    ],
                ],
            ], 200),
            'https://packagist.org/packages/*.json' => Http::response([
                'package' => [
                    'github_stars' => 1200,
                    'downloads' => ['total' => 50000],
                    'abandoned' => false,
                ],
            ], 200),
            'https://registry.npmjs.org/*' => Http::response([
                'dist-tags' => ['latest' => '1.0.0'],
                'versions' => ['1.0.0' => []],
            ], 200),
            'https://api.npmjs.org/downloads/point/last-month/*' => Http::response([
                'downloads' => 2000,
            ], 200),
        ]);

        $this->artisan('generator:sync-packages')
            ->expectsOutputToContain('Starting package stats synchronization')
            ->expectsOutputToContain('Completed sync in')
            ->assertSuccessful();
    }
}
