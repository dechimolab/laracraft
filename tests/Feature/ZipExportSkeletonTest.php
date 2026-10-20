<?php

namespace Tests\Feature;

use App\Services\Generator\ZipExportService;
use Tests\TestCase;
use ZipArchive;

class ZipExportSkeletonTest extends TestCase
{
    public function test_zip_export_contains_complete_laravel_skeleton(): void
    {
        $zipExportService = app(ZipExportService::class);
        $config = [
            'name' => 'Artisan Test App',
            'slug' => 'artisan-test-app',
            'env' => 'local',
            'url' => 'http://localhost:8000',
            'key' => 'base64:TestKey123456789012345678901234567890123456=',
            'db_connection' => 'mysql',
            'db_host' => '127.0.0.1',
            'db_port' => 3306,
            'db_name' => 'artisan_db',
            'db_user' => 'root',
            'db_pass' => 'secret',
            'packages' => ['spatie/laravel-permission', 'yajra/laravel-datatables'],
            'custom_packages' => '',
            'cache_driver' => 'database',
            'queue_driver' => 'database',
            'session_driver' => 'database',
            'laravel_version' => '13.x',
            'php_version' => '8.4',
        ];

        $zipPath = $zipExportService->generateZip($config);
        $this->assertFileExists($zipPath);

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($zipPath));

        // 1. Root files
        $this->assertNotFalse($zip->getFromName('.env'));
        $this->assertNotFalse($zip->getFromName('.env.example'));
        $this->assertNotFalse($zip->getFromName('.gitignore'));
        $this->assertNotFalse($zip->getFromName('.editorconfig'));
        $this->assertNotFalse($zip->getFromName('artisan'));
        $this->assertNotFalse($zip->getFromName('composer.json'));
        $this->assertNotFalse($zip->getFromName('package.json'));
        $this->assertNotFalse($zip->getFromName('vite.config.js'));
        $this->assertNotFalse($zip->getFromName('phpunit.xml'));
        $this->assertNotFalse($zip->getFromName('README.md'));
        $this->assertFalse($zip->getFromName('setup.bat'));
        $this->assertFalse($zip->getFromName('setup.sh'));
        $this->assertNotFalse($zip->getFromName('docker-run-volume.bat'));
        $this->assertNotFalse($zip->getFromName('docker-run-volume.sh'));
        $this->assertNotFalse($zip->getFromName('docker-run-bind.bat'));
        $this->assertNotFalse($zip->getFromName('docker-run-bind.sh'));
        $this->assertNotFalse($zip->getFromName('docker-compose.yml'));

        // 2. bootstrap/
        $this->assertNotFalse($zip->getFromName('bootstrap/app.php'));
        $this->assertNotFalse($zip->getFromName('bootstrap/providers.php'));
        $this->assertNotFalse($zip->getFromName('bootstrap/cache/.gitignore'));

        // 3. public/ (Crucial for Web Servers & Docker!)
        $this->assertNotFalse($zip->getFromName('public/index.php'));
        $this->assertNotFalse($zip->getFromName('public/.htaccess'));
        $this->assertNotFalse($zip->getFromName('public/robots.txt'));

        // 4. config/
        $this->assertNotFalse($zip->getFromName('config/app.php'));
        $this->assertNotFalse($zip->getFromName('config/auth.php'));
        $this->assertNotFalse($zip->getFromName('config/cache.php'));
        $this->assertNotFalse($zip->getFromName('config/database.php'));
        $this->assertNotFalse($zip->getFromName('config/filesystems.php'));
        $this->assertNotFalse($zip->getFromName('config/logging.php'));
        $this->assertNotFalse($zip->getFromName('config/mail.php'));
        $this->assertNotFalse($zip->getFromName('config/queue.php'));
        $this->assertNotFalse($zip->getFromName('config/session.php'));

        // 5. app/
        $this->assertNotFalse($zip->getFromName('app/Http/Controllers/Controller.php'));
        $this->assertNotFalse($zip->getFromName('app/Models/UsersModel.php'));
        $this->assertNotFalse($zip->getFromName('app/Models/RolesModel.php'));
        $this->assertNotFalse($zip->getFromName('app/Providers/AppServiceProvider.php'));
        $this->assertNotFalse($zip->getFromName('app/Traits/HasAuditStamps.php'));
        $this->assertNotFalse($zip->getFromName('app/Traits/HasRoles.php'));

        // 6. database/
        $this->assertNotFalse($zip->getFromName('database/factories/UserFactory.php'));
        $this->assertNotFalse($zip->getFromName('database/seeders/DatabaseSeeder.php'));
        $this->assertNotFalse($zip->getFromName('database/migrations/0001_01_01_000000_create_roles_table.php'));
        $this->assertNotFalse($zip->getFromName('database/migrations/0001_01_01_000001_create_users_table.php'));
        $this->assertNotFalse($zip->getFromName('database/migrations/0001_01_01_000002_create_users_roles_table.php'));
        $this->assertNotFalse($zip->getFromName('database/migrations/0001_01_01_000003_create_cache_table.php'));
        $this->assertNotFalse($zip->getFromName('database/migrations/0001_01_01_000004_create_jobs_table.php'));

        // 7. resources/
        $this->assertNotFalse($zip->getFromName('resources/css/app.css'));
        $this->assertNotFalse($zip->getFromName('resources/js/app.js'));
        $this->assertNotFalse($zip->getFromName('resources/js/bootstrap.js'));
        $this->assertNotFalse($zip->getFromName('resources/views/layouts/app.blade.php'));
        $this->assertNotFalse($zip->getFromName('resources/views/welcome.blade.php'));

        // 8. routes/
        $this->assertNotFalse($zip->getFromName('routes/web.php'));
        $this->assertNotFalse($zip->getFromName('routes/console.php'));

        // 9. storage/
        $this->assertNotFalse($zip->getFromName('storage/app/.gitignore'));
        $this->assertNotFalse($zip->getFromName('storage/app/public/.gitignore'));
        $this->assertNotFalse($zip->getFromName('storage/framework/cache/.gitignore'));
        $this->assertNotFalse($zip->getFromName('storage/framework/cache/data/.gitignore'));
        $this->assertNotFalse($zip->getFromName('storage/framework/sessions/.gitignore'));
        $this->assertNotFalse($zip->getFromName('storage/framework/views/.gitignore'));
        $this->assertNotFalse($zip->getFromName('storage/logs/.gitignore'));

        // 10. tests/
        $this->assertNotFalse($zip->getFromName('tests/TestCase.php'));
        $this->assertNotFalse($zip->getFromName('tests/Feature/ExampleTest.php'));
        $this->assertNotFalse($zip->getFromName('tests/Unit/ExampleTest.php'));

        // Verify content integrity
        $publicIndex = $zip->getFromName('public/index.php');
        $this->assertStringContainsString("require_once __DIR__.'/../bootstrap/app.php'", $publicIndex);

        $bootstrapApp = $zip->getFromName('bootstrap/app.php');
        $this->assertStringContainsString("Application::configure", $bootstrapApp);

        $zip->close();
        @unlink($zipPath);
    }

    public function test_core_drivers_conditionally_omit_or_include_migrations(): void
    {
        $zipExportService = app(ZipExportService::class);

        // Scenario A: file cache, sync queue, file session
        $fileConfig = [
            'name' => 'File Driver App',
            'slug' => 'file-driver-app',
            'cache_driver' => 'file',
            'queue_driver' => 'sync',
            'session_driver' => 'file',
            'modules' => [],
        ];

        $files = $zipExportService->getAllGeneratedFiles($fileConfig);
        $this->assertArrayNotHasKey('database/migrations/0001_01_01_000003_create_cache_table.php', $files);
        $this->assertArrayNotHasKey('database/migrations/0001_01_01_000004_create_jobs_table.php', $files);
        $this->assertArrayHasKey('database/migrations/0001_01_01_000000_create_roles_table.php', $files);
        $this->assertArrayHasKey('database/migrations/0001_01_01_000001_create_users_table.php', $files);
        $this->assertArrayHasKey('database/migrations/0001_01_01_000002_create_users_roles_table.php', $files);
        $this->assertStringNotContainsString("Schema::create('sessions'", $files['database/migrations/0001_01_01_000001_create_users_table.php']);
        $this->assertStringNotContainsString("Schema::dropIfExists('sessions')", $files['database/migrations/0001_01_01_000001_create_users_table.php']);

        // Scenario B: database cache, database queue, database session
        $dbConfig = [
            'name' => 'DB Driver App',
            'slug' => 'db-driver-app',
            'cache_driver' => 'database',
            'queue_driver' => 'database',
            'session_driver' => 'database',
            'modules' => [],
        ];

        $filesDb = $zipExportService->getAllGeneratedFiles($dbConfig);
        $this->assertArrayHasKey('database/migrations/0001_01_01_000003_create_cache_table.php', $filesDb);
        $this->assertArrayHasKey('database/migrations/0001_01_01_000004_create_jobs_table.php', $filesDb);
        $this->assertArrayHasKey('database/migrations/0001_01_01_000001_create_users_table.php', $filesDb);
        $this->assertStringContainsString("Schema::create('sessions'", $filesDb['database/migrations/0001_01_01_000001_create_users_table.php']);
        $this->assertStringContainsString("Schema::dropIfExists('sessions')", $filesDb['database/migrations/0001_01_01_000001_create_users_table.php']);

        // Scenario C: BUU LDAP with database session vs file session
        $buuLdapFileConfig = [
            'name' => 'BUU LDAP App',
            'slug' => 'buu-ldap-app',
            'cache_driver' => 'file',
            'queue_driver' => 'database',
            'session_driver' => 'file',
            'modules' => ['buu_ldap' => true],
        ];

        $filesBuu = $zipExportService->getAllGeneratedFiles($buuLdapFileConfig);
        $this->assertArrayNotHasKey('database/migrations/0001_01_01_000003_create_cache_table.php', $filesBuu);
        $this->assertArrayHasKey('database/migrations/0001_01_01_000004_create_jobs_table.php', $filesBuu);
        $this->assertStringNotContainsString("Schema::create('sessions'", $filesBuu['database/migrations/0001_01_01_000001_create_users_table.php']);

        $buuLdapDbConfig = [
            'name' => 'BUU LDAP App',
            'slug' => 'buu-ldap-app',
            'cache_driver' => 'file',
            'queue_driver' => 'database',
            'session_driver' => 'database',
            'modules' => ['buu_ldap' => true],
        ];

        $filesBuuDb = $zipExportService->getAllGeneratedFiles($buuLdapDbConfig);
        $this->assertStringContainsString("Schema::create('sessions'", $filesBuuDb['database/migrations/0001_01_01_000001_create_users_table.php']);
        $this->assertStringContainsString("sess_id", $filesBuuDb['database/migrations/0001_01_01_000001_create_users_table.php']);
    }
}
