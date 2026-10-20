<?php

namespace Tests\Feature;

use App\Services\Generator\ZipExportService;
use Tests\TestCase;
use ZipArchive;

class ZipExportStep3ModuleDemoMenusTest extends TestCase
{
    public function test_zip_export_generates_module_demo_pages_and_menus_when_step3_modules_enabled(): void
    {
        $zipExportService = app(ZipExportService::class);
        $config = [
            'name' => 'Artisan Enterprise Modular App',
            'slug' => 'artisan-modular-app',
            'env' => 'local',
            'url' => 'http://localhost:8000',
            'key' => 'base64:TestKey123456789012345678901234567890123456=',
            'db_connection' => 'mysql',
            'db_host' => '127.0.0.1',
            'db_port' => 3306,
            'db_name' => 'artisan_demo_db',
            'db_user' => 'root',
            'db_pass' => 'secret',
            'packages' => [],
            'custom_packages' => '',
            'modules' => [
                'buu_ldap' => '1',
                'user_role' => '1',
                'audit_trail' => '1',
                'notifications' => '1',
            ],
            'laravel_version' => '13.x',
            'php_version' => '8.4',
        ];

        $zipPath = $zipExportService->generateZip($config);
        $this->assertFileExists($zipPath);

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($zipPath));

        // 1. Verify Demo Views for each module exist in ZIP
        $this->assertNotFalse($zip->getFromName('resources/views/demo/ldap.blade.php'), 'demo/ldap.blade.php must exist');
        $this->assertNotFalse($zip->getFromName('resources/views/demo/roles.blade.php'), 'demo/roles.blade.php must exist');
        $this->assertNotFalse($zip->getFromName('resources/views/demo/audit.blade.php'), 'demo/audit.blade.php must exist');
        $this->assertNotFalse($zip->getFromName('resources/views/notifications/index.blade.php'), 'notifications/index.blade.php must exist');

        // 2. Check Navbar in layouts/app.blade.php has navigation links for each module
        $appLayout = $zip->getFromName('resources/views/layouts/app.blade.php');
        $this->assertStringContainsString("route('demo.ldap')", $appLayout);
        $this->assertStringContainsString('BUU LDAP &amp; Passkey', $appLayout);
        $this->assertStringContainsString("route('demo.roles')", $appLayout);
        $this->assertStringContainsString('จัดการสิทธิ์ (RBAC)', $appLayout);
        $this->assertStringContainsString("route('demo.audit')", $appLayout);
        $this->assertStringContainsString('ประวัติการใช้งาน', $appLayout);
        $this->assertStringContainsString("route('notifications.index')", $appLayout);
        $this->assertStringContainsString('ศูนย์แจ้งเตือน', $appLayout);

        // 3. Check demo/index.blade.php has the Enterprise Pre-built Modules Demo Hub
        $demoIndex = $zip->getFromName('resources/views/demo/index.blade.php');
        $this->assertStringContainsString('โมดูลสำเร็จรูปประจำโปรเจกต์ (Enterprise Pre-built Modules Demo Hub)', $demoIndex);
        $this->assertStringContainsString("route('demo.ldap')", $demoIndex);
        $this->assertStringContainsString("route('demo.roles')", $demoIndex);
        $this->assertStringContainsString("route('demo.audit')", $demoIndex);
        $this->assertStringContainsString("route('notifications.index')", $demoIndex);

        // 4. Check routes/web.php contains routes for each module demo and simulator
        $routesWeb = $zip->getFromName('routes/web.php');
        $this->assertStringContainsString("Route::get('/demo/ldap', [DemoController::class, 'ldapDemo'])->name('demo.ldap');", $routesWeb);
        $this->assertStringContainsString("Route::get('/demo/roles', [DemoController::class, 'rolesDemo'])->name('demo.roles');", $routesWeb);
        $this->assertStringContainsString("Route::get('/demo/audit', [DemoController::class, 'auditDemo'])->name('demo.audit');", $routesWeb);
        $this->assertStringContainsString("Route::post('/demo/audit/simulate', [DemoController::class, 'simulateAudit'])->name('demo.audit.simulate');", $routesWeb);
        $this->assertStringContainsString("Route::post('/notifications/simulate', [NotificationController::class, 'simulate'])->name('notifications.simulate');", $routesWeb);

        // 5. Check DemoController has action methods
        $demoController = $zip->getFromName('app/Http/Controllers/DemoController.php');
        $this->assertStringContainsString('public function ldapDemo()', $demoController);
        $this->assertStringContainsString('public function rolesDemo()', $demoController);
        $this->assertStringContainsString('public function auditDemo()', $demoController);
        $this->assertStringContainsString('public function simulateAudit(Request $request)', $demoController);

        // 6. Check NotificationController has simulate method
        $notifController = $zip->getFromName('app/Http/Controllers/NotificationController.php');
        $this->assertStringContainsString('public function simulate(Request $request)', $notifController);

        // 7. Check demo/ldap.blade.php content contains Passkey registration functionality
        $ldapBlade = $zip->getFromName('resources/views/demo/ldap.blade.php');
        $this->assertStringContainsString('BUU LDAP & Active Directory', $ldapBlade);
        $this->assertStringContainsString('registerWebauthnBiometric', $ldapBlade);
        $this->assertStringContainsString('loadWebauthnCredentials', $ldapBlade);
        $this->assertStringContainsString('webauthn-support-badge', $ldapBlade);

        // 8. Check demo/roles.blade.php content contains Permissions Matrix
        $rolesBlade = $zip->getFromName('resources/views/demo/roles.blade.php');
        $this->assertStringContainsString('จัดการสิทธิ์และการเข้าถึง (Role & Permission RBAC)', $rolesBlade);
        $this->assertStringContainsString('superadmin', $rolesBlade);
        $this->assertStringContainsString('users.view', $rolesBlade);
        $this->assertStringContainsString('RoleMiddleware', $rolesBlade);

        // 9. Check demo/audit.blade.php content contains 5 Audit Stamps and Simulation Form
        $auditBlade = $zip->getFromName('resources/views/demo/audit.blade.php');
        $this->assertStringContainsString('created_by', $auditBlade);
        $this->assertStringContainsString('created_at', $auditBlade);
        $this->assertStringContainsString('updated_by', $auditBlade);
        $this->assertStringContainsString('updated_at', $auditBlade);
        $this->assertStringContainsString('request_uri', $auditBlade);
        $this->assertStringContainsString("route('demo.audit.simulate')", $auditBlade);

        $zip->close();
        @unlink($zipPath);
    }

    public function test_zip_export_omits_module_demo_pages_and_menus_when_disabled(): void
    {
        $zipExportService = app(ZipExportService::class);
        $config = [
            'name' => 'Plain Artisan App',
            'slug' => 'plain-artisan-app',
            'env' => 'local',
            'url' => 'http://localhost:8000',
            'key' => 'base64:TestKey123456789012345678901234567890123456=',
            'db_connection' => 'sqlite',
            'packages' => [],
            'custom_packages' => '',
            'modules' => [],
            'laravel_version' => '13.x',
            'php_version' => '8.4',
        ];

        $zipPath = $zipExportService->generateZip($config);
        $this->assertFileExists($zipPath);

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($zipPath));

        // When modules are disabled, their demo views must not exist
        $this->assertFalse($zip->getFromName('resources/views/demo/ldap.blade.php'));
        $this->assertFalse($zip->getFromName('resources/views/demo/roles.blade.php'));
        $this->assertFalse($zip->getFromName('resources/views/demo/audit.blade.php'));

        // Navbar must not have those menu links
        $appLayout = $zip->getFromName('resources/views/layouts/app.blade.php');
        $this->assertStringNotContainsString("route('demo.ldap')", $appLayout);
        $this->assertStringNotContainsString("route('demo.roles')", $appLayout);
        $this->assertStringNotContainsString("route('demo.audit')", $appLayout);

        // routes/web.php must not have those routes
        $routesWeb = $zip->getFromName('routes/web.php');
        $this->assertStringNotContainsString("demo.ldap", $routesWeb);
        $this->assertStringNotContainsString("demo.roles", $routesWeb);
        $this->assertStringNotContainsString("demo.audit", $routesWeb);

        $zip->close();
        @unlink($zipPath);
    }
}
