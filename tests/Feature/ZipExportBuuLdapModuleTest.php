<?php

namespace Tests\Feature;

use App\Services\Generator\ZipExportService;
use Tests\TestCase;
use ZipArchive;

class ZipExportBuuLdapModuleTest extends TestCase
{
    public function test_zip_export_generates_full_stack_buu_ldap_module_when_enabled(): void
    {
        $zipExportService = app(ZipExportService::class);
        $config = [
            'name' => 'Artisan LDAP Enterprise App',
            'slug' => 'artisan-ldap-app',
            'env' => 'local',
            'url' => 'http://localhost:8000',
            'key' => 'base64:TestKey123456789012345678901234567890123456=',
            'db_connection' => 'mysql',
            'db_host' => '127.0.0.1',
            'db_port' => 3306,
            'db_name' => 'artisan_ldap_db',
            'db_user' => 'root',
            'db_pass' => 'secret',
            'packages' => [],
            'custom_packages' => '',
            'modules' => [
                'buu_ldap' => '1',
            ],
            'laravel_version' => '13.x',
            'php_version' => '8.4',
        ];

        $zipPath = $zipExportService->generateZip($config);
        $this->assertFileExists($zipPath);

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($zipPath));

        // 1. Verify Full-Stack BUU LDAP Files exist in ZIP
        $this->assertNotFalse($zip->getFromName('config/ldap.php'), 'config/ldap.php must exist');
        $this->assertNotFalse($zip->getFromName('app/Services/Auth/LdapAuthService.php'), 'LdapAuthService.php must exist');
        $this->assertNotFalse($zip->getFromName('app/Http/Controllers/Auth/LoginController.php'), 'LoginController.php must exist');
        $this->assertNotFalse($zip->getFromName('resources/views/auth/login.blade.php'), 'login.blade.php must exist');
        $this->assertNotFalse($zip->getFromName('app/Models/UsersCredentialsModel.php'), 'UsersCredentialsModel.php must exist');
        $this->assertNotFalse($zip->getFromName('database/migrations/2026_01_01_000001_add_ldap_columns_to_users_table.php'), 'LDAP columns migration must exist');
        $this->assertNotFalse($zip->getFromName('database/migrations/2026_01_01_000004_create_users_credentials_table.php'), 'users_credentials migration must exist');
        $this->assertNotFalse($zip->getFromName('app/Services/Auth/WebauthnService.php'), 'WebauthnService.php must exist');
        $this->assertNotFalse($zip->getFromName('app/Http/Controllers/Auth/WebauthnController.php'), 'WebauthnController.php must exist');

        // 2. Check composer.json contains directorytree/ldaprecord-laravel and spomky-labs/cbor-php
        $composerJson = $zip->getFromName('composer.json');
        $this->assertStringContainsString('directorytree/ldaprecord-laravel', $composerJson);
        $this->assertStringContainsString('spomky-labs/cbor-php', $composerJson);

        // 3. Check .env and .env.example contain LDAP variables matching laragen parity
        $env = $zip->getFromName('.env');
        $this->assertStringContainsString('LDAP_ENABLED=1', $env);
        $this->assertStringContainsString('LDAP_SERVER=10.5.1.80', $env);
        $this->assertStringContainsString('LDAP_DOMAIN=buu.ac.th', $env);
        $this->assertStringContainsString('LDAP_BASEDN="ou=People,dc=buu,dc=ac,dc=th"', $env);
        $this->assertStringContainsString('LDAP_FILTER="(cn=XUID)"', $env);
        $this->assertStringContainsString('LDAP_PORT=389', $env);

        $envExample = $zip->getFromName('.env.example');
        $this->assertStringContainsString('LDAP_SERVER=10.5.1.80', $envExample);
        $this->assertStringContainsString('LDAP_BASEDN="ou=People,dc=buu,dc=ac,dc=th"', $envExample);

        // 4. Check routes/web.php contains Auth & WebAuthn routes
        $routesWeb = $zip->getFromName('routes/web.php');
        $this->assertStringContainsString('use App\Http\Controllers\Auth\LoginController;', $routesWeb);
        $this->assertStringContainsString('use App\Http\Controllers\Auth\WebauthnController;', $routesWeb);
        $this->assertStringContainsString("Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');", $routesWeb);
        $this->assertStringContainsString("Route::post('/login', [LoginController::class, 'login'])->name('login.post');", $routesWeb);
        $this->assertStringContainsString("Route::post('/logout', [LoginController::class, 'logout'])->name('logout');", $routesWeb);
        $this->assertStringContainsString("Route::post('/login/options', [WebauthnController::class, 'loginOptions'])->name('login.options');", $routesWeb);
        $this->assertStringContainsString("Route::post('/login/verify', [WebauthnController::class, 'loginVerify'])->name('login.verify');", $routesWeb);

        // 5. Check app/Models/UsersModel.php has LDAP attributes, role_id, and isActive method
        $userModel = $zip->getFromName('app/Models/UsersModel.php');
        $this->assertStringContainsString("'username'", $userModel);
        $this->assertStringContainsString("'role_id'", $userModel);
        $this->assertStringContainsString("'department'", $userModel);
        $this->assertStringContainsString('public function isActive(): bool', $userModel);
        $this->assertStringContainsString('UsersCredentialsModel::class', $userModel);

        // 6. Check DatabaseSeeder seeds superadmin and admin user
        $seeder = $zip->getFromName('database/seeders/DatabaseSeeder.php');
        $this->assertStringContainsString("UsersModel::firstOrCreate", $seeder);
        $this->assertStringContainsString("'username' => 'admin'", $seeder);
        $this->assertStringContainsString("'name' => 'superadmin'", $seeder);

        // 7. Check Navbar in layouts/app.blade.php contains auth dropdown and login link
        $appLayout = $zip->getFromName('resources/views/layouts/app.blade.php');
        $this->assertStringContainsString('@auth', $appLayout);
        $this->assertStringContainsString('@else', $appLayout);
        $this->assertStringContainsString("route('login')", $appLayout);
        $this->assertStringContainsString("route('logout')", $appLayout);

        // 8. Check README.md has BUU LDAP login guide
        $readme = $zip->getFromName('README.md');
        $this->assertStringContainsString('BUU Active Directory (LDAP)', $readme);
        $this->assertStringContainsString('admin', $readme);

        // 9. Check Security Standards, biometric login button in login.blade.php, and home redirect in LoginController
        $loginBlade = $zip->getFromName('resources/views/auth/login.blade.php');
        $this->assertStringContainsString('btn-biometric-login', $loginBlade);
        $this->assertStringContainsString('bi-fingerprint', $loginBlade);
        $this->assertStringContainsString('loginWithBiometrics()', $loginBlade);

        $loginController = $zip->getFromName('app/Http/Controllers/Auth/LoginController.php');
        $this->assertStringContainsString('RateLimiter::tooManyAttempts', $loginController, 'sec-login-rate-limit compliance');
        $this->assertStringContainsString("redirect()->route('demo.index')", $loginController);
        $this->assertStringContainsString("redirect()->intended(route('demo.index'))", $loginController);

        // 10. Check DemoController, HomeController, and demo/home blade showcase
        $this->assertNotFalse($zip->getFromName('app/Http/Controllers/DemoController.php'));
        $this->assertNotFalse($zip->getFromName('app/Http/Controllers/HomeController.php'));
        $this->assertNotFalse($zip->getFromName('resources/views/demo/index.blade.php'));
        $this->assertNotFalse($zip->getFromName('resources/views/home/index.blade.php'));
        $demoBlade = $zip->getFromName('resources/views/demo/index.blade.php');
        $this->assertStringContainsString('homeTrafficChart', $demoBlade);
        $this->assertStringContainsString('---เลือก---', $demoBlade);
        $this->assertStringContainsString('btn-danger', $demoBlade);
        $this->assertStringContainsString('bi-speedometer2', $demoBlade);
        $this->assertStringContainsString('registerWebauthnBiometric()', $demoBlade);
        $this->assertStringContainsString('demo-input-text', $demoBlade);
        $this->assertStringContainsString('demo-input-password', $demoBlade);
        $this->assertStringContainsString('demo-textarea', $demoBlade);
        $this->assertStringContainsString('form-check-input', $demoBlade);
        $this->assertStringContainsString('demoRadio', $demoBlade);
        $this->assertStringContainsString('form-switch', $demoBlade);
        $this->assertStringContainsString("Route::get('/demo', [DemoController::class, 'index'])->name('demo.index')", $routesWeb);
        // 11. Check WebAuthn transports sequence sanitation (Dual-Layer)
        $webauthnService = $zip->getFromName('app/Services/Auth/WebauthnService.php');
        $this->assertStringNotContainsString("'transports' => \$cred->transports ? json_decode(\$cred->transports, true) : null", $webauthnService);
        $this->assertStringContainsString("\$item['transports'] = array_values(\$transports);", $webauthnService);

        $demoLdapBlade = $zip->getFromName('resources/views/demo/ldap.blade.php');
        $this->assertStringContainsString('Array.isArray(c.transports) && c.transports.length > 0', $demoLdapBlade);
        $this->assertStringContainsString('Array.isArray(cred.transports) && cred.transports.length > 0', $loginBlade);

        // 12. Check Hero Banner in demo/index.blade.php conforms to theme tokens
        $this->assertStringContainsString('hero-banner p-4 rounded-3 shadow-sm border border-theme bg-theme-card', $demoBlade);
        $this->assertStringContainsString('text-theme-primary', $demoBlade);
        $this->assertStringContainsString('btn-theme-primary', $demoBlade);
        $this->assertStringNotContainsString('#131b2e', $demoBlade);

        $themeCss = $zip->getFromName('public/css/theme.css');
        $this->assertStringContainsString('.hero-banner', $themeCss);

        $zip->close();
        @unlink($zipPath);
    }

    public function test_zip_export_omits_buu_ldap_when_disabled(): void
    {
        $zipExportService = app(ZipExportService::class);
        $config = [
            'name' => 'Standard App Without LDAP',
            'slug' => 'standard-app',
            'env' => 'local',
            'modules' => [], // buu_ldap is not set
        ];

        $zipPath = $zipExportService->generateZip($config);
        $zip = new ZipArchive();
        $this->assertTrue($zip->open($zipPath));

        $this->assertFalse($zip->getFromName('config/ldap.php'));
        $this->assertFalse($zip->getFromName('app/Services/Auth/LdapAuthService.php'));
        $this->assertFalse($zip->getFromName('app/Http/Controllers/Auth/LoginController.php'));
        $this->assertFalse($zip->getFromName('resources/views/auth/login.blade.php'));
        $this->assertFalse($zip->getFromName('database/migrations/2026_01_01_000001_add_ldap_columns_to_users_table.php'));

        $composerJson = $zip->getFromName('composer.json');
        $this->assertStringNotContainsString('directorytree/ldaprecord-laravel', $composerJson);

        $zip->close();
        @unlink($zipPath);
    }
}
