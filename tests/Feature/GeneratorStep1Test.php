<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneratorStep1Test extends TestCase
{
    use RefreshDatabase;

    public function test_generator_step1_screen_renders_successfully(): void
    {
        $response = $this->get('/generator/step1');

        $response->assertStatus(200);
        $response->assertSee('Project Core &amp; Environment Setup', false);
        $response->assertSee('Full-Stack Monolith');
        $response->assertSee('Database Engine (MySQL 8.4 LTS)');
        $response->assertSee('Docker Container Specification');
        $response->assertSee('bucchub/php-apache-dev:8.4');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_user_can_save_step1_configuration_and_redirect_to_step2(): void
    {
        $response = $this->post('/generator/step1', [
            'project_name' => 'artisan-pos-system',
            'app_title' => 'Artisan POS & Inventory Hub',
            'app_env' => 'local',
            'app_url' => 'https://localhost',
            'app_timezone' => 'Asia/Bangkok',
            'log_channel' => 'stack',
            'db_host' => '127.0.0.1',
            'db_port' => '3306',
            'db_name' => 'artisan_pos_db',
            'db_user' => 'root',
            'db_pass' => 'secret123',
            'cache_driver' => 'file',
            'queue_driver' => 'database',
            'session_driver' => 'file',
            'icon_set' => 'bootstrap_icons',
            'docker_image' => 'bucchub/php-apache-dev:8.4',
            'docker_https_port' => 443,
            'docker_ssh_port' => 22,
            'docker_volume' => 'artisan-pos-system-code',
        ]);

        $response->assertRedirect(route('generator.step2'));
        $this->assertEquals('artisan-pos-system', session('project.slug'));
        $this->assertEquals('Artisan POS & Inventory Hub', session('project.name'));
        $this->assertEquals('artisan_pos_db', session('project.db_name'));
        $this->assertEquals('bucchub/php-apache-dev:8.4', session('project.docker_image'));
        $this->assertEquals(443, session('project.docker_https_port'));
        $this->assertEquals(22, session('project.docker_ssh_port'));
        $this->assertEquals('artisan-pos-system-code', session('project.docker_volume'));
    }

    public function test_docker_volume_must_match_code_suffix_pattern(): void
    {
        $response = $this->post('/generator/step1', [
            'project_name' => 'aps-project',
            'app_title' => 'APS Web',
            'app_env' => 'local',
            'app_url' => 'https://localhost',
            'db_host' => '127.0.0.1',
            'db_port' => '3306',
            'db_name' => 'aps_db',
            'db_user' => 'root',
            'cache_driver' => 'file',
            'queue_driver' => 'database',
            'session_driver' => 'file',
            'docker_volume' => 'invalid-volume-name', // missing -code suffix
        ]);

        $response->assertSessionHasErrors(['docker_volume']);
    }

    public function test_user_can_reset_and_start_new_project(): void
    {
        session(['project' => ['name' => 'Existing Project', 'slug' => 'existing-project']]);
        $this->assertNotEmpty(session('project'));

        $response = $this->get(route('generator.new'));

        $response->assertRedirect(route('generator.step1'));
        $this->assertNull(session('project'));
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_test_db_connection_validation_requires_mandatory_fields(): void
    {
        $response = $this->postJson(route('generator.testDb'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['db_host', 'db_port', 'db_user']);
    }

    public function test_test_db_connection_reports_failure_on_invalid_credentials(): void
    {
        $response = $this->postJson(route('generator.testDb'), [
            'db_host' => '127.0.0.1',
            'db_port' => 3306,
            'db_name' => 'non_existent_db',
            'db_user' => 'invalid_user_xyz',
            'db_pass' => 'wrong_password_123',
        ]);

        $response->assertStatus(200);
        $this->assertFalse($response->json('success'));
        $this->assertNotEmpty($response->json('message'));
        $this->assertArrayHasKey('latency_ms', $response->json());
    }

    public function test_test_db_connection_success_with_active_database(): void
    {
        $dbConfig = config('database.connections.' . config('database.default'));
        if (!isset($dbConfig['host'])) {
            $this->markTestSkipped('No MySQL/MariaDB connection configured.');
        }

        $response = $this->postJson(route('generator.testDb'), [
            'db_host' => $dbConfig['host'],
            'db_port' => $dbConfig['port'] ?? 3306,
            'db_name' => $dbConfig['database'] ?? '',
            'db_user' => $dbConfig['username'] ?? 'root',
            'db_pass' => $dbConfig['password'] ?? '',
        ]);

        $response->assertStatus(200);
        $this->assertTrue($response->json('success'));
        $this->assertNotEmpty($response->json('version'));
        $this->assertArrayHasKey('latency_ms', $response->json());
    }

    public function test_user_can_set_and_sync_active_preset_session(): void
    {
        $response = $this->postJson(route('generator.activePreset'), [
            'preset_id' => 'preset_custom_101',
            'preset_name' => 'Custom Hub Preset',
            'config' => [
                'project_name' => 'custom-hub',
                'app_title' => 'Custom Hub POS',
                'app_env' => 'production',
                'app_url' => 'https://hub.example.com',
                'db_host' => '192.168.1.100',
                'db_port' => 3306,
                'db_name' => 'hub_production_db',
                'db_user' => 'hub_admin',
                'cache_driver' => 'redis',
                'queue_driver' => 'redis',
                'session_driver' => 'redis',
            ],
        ]);

        $response->assertStatus(200);
        $this->assertTrue($response->json('success'));
        $this->assertEquals('preset_custom_101', session('active_preset.id'));
        $this->assertEquals('Custom Hub Preset', session('active_preset.name'));
        $this->assertEquals('custom-hub', session('project.slug'));
        $this->assertEquals('Custom Hub POS', session('project.name'));
        $this->assertEquals('redis', session('project.cache_driver'));
    }

    public function test_user_can_clear_active_preset_session(): void
    {
        session(['active_preset' => ['id' => 'p1', 'name' => 'Preset 1']]);
        $this->assertNotNull(session('active_preset'));

        $response = $this->postJson(route('generator.clearPreset'));

        $response->assertStatus(200);
        $this->assertTrue($response->json('success'));
        $this->assertNull(session('active_preset'));
    }

    public function test_generator_step1_displays_active_preset_and_indicators(): void
    {
        session([
            'active_preset' => [
                'id' => 'builtin_enterprise_production',
                'name' => 'Enterprise Production (High-Performance Redis)',
            ],
            'project' => [
                'slug' => 'enterprise-core',
                'name' => 'Enterprise Core System',
                'cache_driver' => 'redis',
            ],
        ]);

        $response = $this->get(route('generator.step1'));

        $response->assertStatus(200);
        $response->assertSee('hero-active-preset-badge', false);
        $response->assertSee('bottom-active-preset-chip', false);
        $response->assertSee('Enterprise Production (High-Performance Redis)', false);
    }

    public function test_user_can_save_step1_with_custom_app_key_and_db_connection(): void
    {
        $customKey = 'base64:7K5mP3L0wR1tY5uI6oP8aS0dF2gH4jK6lZ8v84X9J2q=';
        $response = $this->post('/generator/step1', [
            'project_name' => 'artisan-pos-system',
            'app_title' => 'Artisan POS & Inventory Hub',
            'app_env' => 'local',
            'app_url' => 'https://localhost',
            'app_key' => $customKey,
            'app_timezone' => 'Asia/Bangkok',
            'log_channel' => 'stack',
            'db_connection' => 'pgsql',
            'db_host' => '127.0.0.1',
            'db_port' => 5432,
            'db_name' => 'artisan_pgsql_db',
            'db_user' => 'postgres',
            'db_pass' => 'secret123',
            'cache_driver' => 'file',
            'queue_driver' => 'database',
            'session_driver' => 'file',
            'icon_set' => 'bootstrap_icons',
            'docker_image' => 'bucchub/php-apache-dev:8.4',
            'docker_https_port' => 443,
            'docker_ssh_port' => 22,
            'docker_volume' => 'artisan-pos-system-code',
        ]);

        $response->assertRedirect(route('generator.step2'));
        $this->assertEquals($customKey, session('project.key'));
        $this->assertEquals('pgsql', session('project.db_connection'));
        $this->assertEquals(5432, session('project.db_port'));
        $this->assertEquals('artisan_pgsql_db', session('project.db_name'));
    }

    public function test_test_db_connection_sqlite_returns_ready(): void
    {
        $response = $this->postJson(route('generator.testDb'), [
            'db_connection' => 'sqlite',
            'db_name' => 'database/database.sqlite',
        ]);

        $response->assertStatus(200);
        $this->assertTrue($response->json('success'));
        $this->assertStringContainsString('SQLite', $response->json('message'));
        $this->assertEquals('ready', $response->json('database_status'));
    }

    public function test_user_can_save_step1_with_custom_typed_database_driver(): void
    {
        $response = $this->post('/generator/step1', [
            'project_name' => 'artisan-pos-system',
            'app_title' => 'Artisan POS & Inventory Hub',
            'app_env' => 'local',
            'app_url' => 'https://localhost',
            'app_key' => 'base64:7K5mP3L0wR1tY5uI6oP8aS0dF2gH4jK6lZ8v84X9J2q=',
            'app_timezone' => 'Asia/Bangkok',
            'log_channel' => 'stack',
            'db_connection' => 'custom',
            'db_connection_custom' => 'clickhouse',
            'db_host' => '127.0.0.1',
            'db_port' => 8123,
            'db_name' => 'analytics_warehouse',
            'db_user' => 'default',
            'db_pass' => '',
            'cache_driver' => 'file',
            'queue_driver' => 'database',
            'session_driver' => 'file',
            'icon_set' => 'bootstrap_icons',
            'docker_image' => 'bucchub/php-apache-dev:8.4',
            'docker_https_port' => 443,
            'docker_ssh_port' => 22,
            'docker_volume' => 'artisan-pos-system-code',
        ]);

        $response->assertRedirect(route('generator.step2'));
        $this->assertEquals('clickhouse', session('project.db_connection'));
        $this->assertEquals(8123, session('project.db_port'));
        $this->assertEquals('analytics_warehouse', session('project.db_name'));
    }

    public function test_test_db_connection_custom_driver_returns_manual_ready(): void
    {
        $response = $this->postJson(route('generator.testDb'), [
            'db_connection' => 'custom',
            'db_connection_custom' => 'mongodb',
            'db_host' => '127.0.0.1',
            'db_port' => 27017,
            'db_name' => 'catalog_store',
        ]);

        $response->assertStatus(200);
        $this->assertTrue($response->json('success'));
        $this->assertStringContainsStringIgnoringCase('mongodb', $response->json('message'));
        $this->assertEquals('ready', $response->json('database_status'));
    }

    public function test_step1_renders_laravel_and_php_version_dropdowns(): void
    {
        $response = $this->get('/generator/step1');
        $response->assertStatus(200);
        $response->assertSee('id="laravel-version"', false);
        $response->assertSee('id="php-version"', false);
        $response->assertSee('Laravel 13.x (Current Stable)');
        $response->assertSee('Laravel 14.x (Upcoming Preview)');
        $response->assertSee('PHP 8.4 (JIT Enabled - BUCC Recommended)');
        $response->assertSee('PHP 8.5 (Next Generation)');
    }

    public function test_user_can_save_step1_with_php_85_and_laravel_14_and_auto_updates_docker_image(): void
    {
        $response = $this->post('/generator/step1', [
            'project_name' => 'artisan-next-gen',
            'app_title' => 'Artisan Next Gen',
            'laravel_version' => '14.x',
            'php_version' => '8.5',
            'app_env' => 'local',
            'app_url' => 'https://localhost',
            'db_name' => 'nextgen_db',
            'cache_driver' => 'file',
            'queue_driver' => 'database',
            'session_driver' => 'file',
        ]);

        $response->assertRedirect(route('generator.step2'));
        $this->assertEquals('14.x', session('project.laravel_version'));
        $this->assertEquals('8.5', session('project.php_version'));
        $this->assertEquals('bucchub/php-apache-dev:8.5', session('project.docker_image'));
    }

    public function test_step1_renders_https_localhost_as_default_app_url(): void
    {
        $response = $this->get('/generator/step1');
        $response->assertStatus(200);
        $response->assertSee('value="https://localhost"', false);
        $response->assertDontSee('value="http://localhost:8000"', false);
    }

    public function test_step1_renders_custom_https_port_synced_app_url_from_session(): void
    {
        session([
            'project' => [
                'docker_https_port' => 7000,
            ]
        ]);
        $response = $this->get('/generator/step1');
        $response->assertStatus(200);
        $response->assertSee('value="https://localhost:7000"', false);
    }

    public function test_zip_export_service_defaults_app_url_to_https_with_matching_docker_port(): void
    {
        $zipService = app(\App\Services\Generator\ZipExportService::class);

        // 1. Default port 443 -> https://localhost
        $files443 = $zipService->getAllGeneratedFiles([
            'name' => 'Test App',
            'slug' => 'test-app',
            'docker_https_port' => 443,
        ]);
        $this->assertStringContainsString('APP_URL=https://localhost', $files443['.env']);
        $this->assertStringNotContainsString('http://localhost:8000', $files443['.env']);
        $this->assertStringContainsString("'url' => env('APP_URL', 'https://localhost')", $files443['config/app.php']);

        // 2. Custom port 7000 -> https://localhost:7000
        $files7000 = $zipService->getAllGeneratedFiles([
            'name' => 'Test App',
            'slug' => 'test-app',
            'docker_https_port' => 7000,
        ]);
        $this->assertStringContainsString('APP_URL=https://localhost:7000', $files7000['.env']);

        // 3. If legacy http://localhost:8000 was passed, normalize to https port
        $filesLegacy = $zipService->getAllGeneratedFiles([
            'name' => 'Test App',
            'slug' => 'test-app',
            'url' => 'http://localhost:8000',
            'docker_https_port' => 443,
        ]);
        $this->assertStringContainsString('APP_URL=https://localhost', $filesLegacy['.env']);
    }

    public function test_generator_step1_displays_ums_buu_toggle_and_credentials_inputs(): void
    {
        $response = $this->get('/generator/step1');
        $response->assertStatus(200);
        $response->assertSee('id="ums-spec-card"', false);
        $response->assertSee('id="use-ums-buu"', false);
        $response->assertSee('UMS BUU &amp; Kong API Gateway', false);
        $response->assertSee('id="ums-system-id"', false);
        $response->assertSee('id="ums-service-key"', false);
        $response->assertSee('id="ums-service-url"', false);
        $response->assertSee('id="kong-domain-prod"', false);
        $response->assertSee('id="kong-pk-glgroup"', false);
        $response->assertSee('id="env-preview-ums-block"', false);
    }

    public function test_user_can_save_step1_with_ums_buu_enabled_and_syncs_session(): void
    {
        $response = $this->post('/generator/step1', [
            'project_name' => 'ums-app',
            'app_title' => 'UMS Test System',
            'app_env' => 'local',
            'app_url' => 'https://localhost',
            'db_name' => 'ums_db',
            'cache_driver' => 'file',
            'queue_driver' => 'database',
            'session_driver' => 'file',
            'use_ums_buu' => '1',
            'ums_system_id' => '149',
            'ums_service_key' => '42963d28e7e0996c39d4a1658f8bd763',
            'ums_service_url' => 'https://ums.buu.ac.th/index.php',
            'kong_domain_prod' => 'https://api-gw.buu.ac.th',
            'kong_pk_ums_glgroupinsystem' => 'test-pk-glgroup',
            'kong_pk_ums_cusergroup' => 'test-pk-cusergroup',
            'kong_pk_ums_glpersonfromcitizenid' => 'test-pk-glperson',
            'kong_pk_ums_ausergroup' => 'test-pk-ausergroup',
            'kong_pk_ums_dusergroup' => 'test-pk-dusergroup',
        ]);

        $response->assertRedirect(route('generator.step2'));
        $this->assertTrue(session('project.use_ums_buu'));
        $this->assertEquals('149', session('project.ums_config.system_id'));
        $this->assertEquals('42963d28e7e0996c39d4a1658f8bd763', session('project.ums_config.service_key'));
        $this->assertEquals('https://api-gw.buu.ac.th', session('project.ums_config.kong_domain_prod'));
        $this->assertEquals('test-pk-glgroup', session('project.ums_config.kong_pk_ums_glgroupinsystem'));
        $this->assertEquals('1', session('project.modules.ums_buu'));
        $this->assertArrayNotHasKey('buu_ldap', session('project.modules', []));
    }

    public function test_generator_step1_displays_ums_connection_test_button(): void
    {
        $response = $this->get('/generator/step1');

        $response->assertStatus(200);
        $response->assertSee('test-ums-connection-btn', false);
        $response->assertSee('Test UMS &amp; Kong Connection', false);
        $response->assertSee('testUmsConnection', false);
        $response->assertSee('ums-connection-result', false);
    }

    public function test_generator_test_ums_connection_requires_parameters(): void
    {
        $response = $this->postJson(route('generator.testUms'), []);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => false,
            'ums_status' => 'missing_params',
        ]);
    }

    public function test_generator_test_ums_connection_endpoint(): void
    {
        $response = $this->postJson(route('generator.testUms'), [
            'ums_system_id' => '149',
            'ums_service_key' => '42963d28e7e0996c39d4a1658f8bd763',
            'ums_service_url' => 'https://ums.buu.ac.th/index.php',
            'kong_domain_prod' => 'https://api-gw.buu.ac.th',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('success', $response->json());
        $this->assertArrayHasKey('message', $response->json());
        $this->assertArrayHasKey('latency_ms', $response->json());
        $this->assertArrayHasKey('ums_status', $response->json());
    }
}

