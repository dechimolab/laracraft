<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneratorStep5ExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_access_step5_without_completing_steps(): void
    {
        // 1. Without session
        $res1 = $this->get('/generator/step5');
        $res1->assertRedirect(route('generator.step1'));

        // 2. Step 1 completed
        $res2 = $this->withSession([
            'project.step_completed' => 1,
            'project.slug' => 'test-app',
        ])->get('/generator/step5');
        $res2->assertRedirect(route('generator.step2'));

        // 3. Step 2 completed
        $res3 = $this->withSession([
            'project.step_completed' => 2,
            'project.slug' => 'test-app',
        ])->get('/generator/step5');
        $res3->assertRedirect(route('generator.step3'));

        // 4. Step 3 completed but step 4 not completed
        $res4 = $this->withSession([
            'project.step_completed' => 3,
            'project.slug' => 'test-app',
        ])->get('/generator/step5');
        $res4->assertRedirect(route('generator.step4'));
    }

    public function test_cannot_export_zip_without_completing_step4(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 3,
            'project.slug' => 'test-app',
        ])->get('/generator/export');

        $response->assertRedirect(route('generator.step1'));
        $response->assertSessionHas('step_warning');
    }

    public function test_generator_step5_screen_renders_successfully(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 4,
            'project.slug' => 'test-app',
            'project.name' => 'Test App',
            'project.theme_key' => 'nordic-clean',
            'project.theme_mode' => 'light',
            'project.modules' => [
                'buu_ldap' => 1,
            ],
        ])->get('/generator/step5');

        $response->assertStatus(200);
        $response->assertSee('Workspace Explorer');
        $response->assertSee('LoginController.php');
        $response->assertSee('UsersModel.php');
        $response->assertSee('UsersCredentialsModel.php');
        $response->assertSee('EnsureActiveUser.php');
        $response->assertSee('Export .ZIP');
        $response->assertSee('Live Blade UI Preview');
        $response->assertSee('HomeController.php');
        $response->assertSee('docker-run-volume.sh');
        $response->assertSee('docker-run-bind.sh');
        $response->assertSee('docker-compose.yml');
        $response->assertSee('package.json');
        $response->assertSee('Nordic Clean');
        $response->assertSee('px-6 md:px-8 lg:px-10', false);
        $response->assertSee('ย้อนกลับ: Step 4 (Theme Studio)');
        $response->assertSee('Ready for Export • 100% Real Engine');
        $response->assertSee('Copy One-Liner');
        $response->assertSee('ml-auto justify-end', false);
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
    }

    public function test_generator_preview_ui_renders_live_blade(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 4,
            'project.slug' => 'test-ui-app',
            'project.name' => 'Test UI App',
            'project.theme_key' => 'emerald-enterprise',
            'project.theme_mode' => 'light',
            'project.modules' => [
                'buu_ldap' => 1,
                'user_role' => 1,
            ],
        ])->get('/generator/preview-ui?view=dashboard');

        $response->assertStatus(200);
        $response->assertSee('5 Mandatory Audit Stamps');
        $response->assertSee('Test UI App');
        $response->assertSee('data-bs-theme="light"', false);
        $response->assertSee('data-theme="emerald-enterprise"', false);
        $response->assertSee('Emerald Enterprise', false);
        $response->assertSee('#047857', false);
        $response->assertSee('#F0FDF4', false);
    }

    public function test_generator_preview_file_returns_json_content(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 4,
            'project.slug' => 'test-preview-file-app',
            'project.name' => 'Test Preview File App',
        ])->getJson('/generator/preview-file?path=.env');

        $response->assertStatus(200);
        $response->assertJson(['path' => '.env']);
        $this->assertStringContainsString('APP_NAME="Test Preview File App"', $response->json('content'));
    }

    public function test_generator_dry_run_executes_successfully(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 4,
            'project.slug' => 'dry-run-app',
            'project.name' => 'Dry Run App',
            'project.modules' => [
                'buu_ldap' => 1,
                'user_role' => 1,
            ],
        ])->postJson('/generator/dry-run');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_zip_export_app_layout_contains_selected_theme_tokens(): void
    {
        $service = new \App\Services\Generator\ZipExportService();
        $zipPath = $service->generateZip([
            'slug' => 'themed-export-app',
            'name' => 'Themed Export App',
            'env' => 'local',
            'url' => 'http://localhost:8000',
            'db_host' => '127.0.0.1',
            'db_port' => '3306',
            'db_name' => 'theme_db',
            'db_user' => 'root',
            'db_pass' => '',
            'theme_key' => 'emerald-matrix',
            'theme_mode' => 'dark',
            'modules' => [
                'buu_ldap' => 1,
            ],
        ]);

        $this->assertFileExists($zipPath);

        $zip = new \ZipArchive();
        $this->assertTrue($zip->open($zipPath));

        $this->assertNotFalse($zip->locateName('resources/views/layouts/app.blade.php'));
        $appBlade = $zip->getFromName('resources/views/layouts/app.blade.php');

        $this->assertStringContainsString('data-bs-theme="dark"', $appBlade);
        $this->assertStringContainsString('data-theme="emerald-matrix"', $appBlade);
        $this->assertStringContainsString("secure_asset('css/theme.css')", $appBlade);
        $this->assertStringContainsString("secure_asset('css/style.css')", $appBlade);
        $this->assertStringContainsString("secure_asset('js/theme.js')", $appBlade);
        $this->assertStringContainsString("secure_asset('js/function.js')", $appBlade);
        $this->assertStringContainsString('Emerald Matrix', $appBlade);
        $this->assertStringNotContainsString('themeToggleBtn', $appBlade);
        $this->assertStringNotContainsString('applyThemeMode', $appBlade);

        // Verify Modular Theme Architecture (Tier 2 & 3)
        $this->assertNotFalse($zip->locateName('public/css/themes/emerald-matrix.css'));
        $this->assertNotFalse($zip->locateName('public/css/themes/emerald-enterprise.css'));
        $this->assertNotFalse($zip->locateName('public/css/themes/deep-oceanic.css'));
        $this->assertNotFalse($zip->locateName('public/css/theme-core.css'));
        $this->assertNotFalse($zip->locateName('config/theme.php'));

        $themeMatrixCss = $zip->getFromName('public/css/themes/emerald-matrix.css');
        $this->assertStringContainsString('--sys-primary', $themeMatrixCss);
        $this->assertStringContainsString('emerald-matrix', $themeMatrixCss);

        $themeCoreCss = $zip->getFromName('public/css/theme-core.css');
        $this->assertStringContainsString('ArtisanCraft Theme Core Stylesheet', $themeCoreCss);

        $configTheme = $zip->getFromName('config/theme.php');
        $this->assertStringContainsString("env('APP_THEME', 'emerald-matrix')", $configTheme);

        $envFile = $zip->getFromName('.env');
        $this->assertStringContainsString('APP_THEME=emerald-matrix', $envFile);

        // Verify public/css/theme.css
        $this->assertNotFalse($zip->locateName('public/css/theme.css'));
        $themeCss = $zip->getFromName('public/css/theme.css');
        $this->assertStringContainsString('--sys-primary', $themeCss);
        $this->assertStringContainsString('--sys-secondary', $themeCss);
        $this->assertStringContainsString('--bs-body-bg', $themeCss);
        $this->assertStringContainsString('--bs-primary-rgb', $themeCss);
        $this->assertStringContainsString('.form-control, .form-select, textarea.form-control', $themeCss);
        $this->assertStringContainsString('.form-control::placeholder', $themeCss);
        $this->assertStringContainsString('.input-group-text', $themeCss);

        // Verify public/css/style.css (Custom Stylesheet Template)
        $this->assertNotFalse($zip->locateName('public/css/style.css'));
        $styleCss = $zip->getFromName('public/css/style.css');
        $this->assertStringContainsString('Global Custom Stylesheet', $styleCss);
        $this->assertStringContainsString('.hero-banner', $styleCss);

        // Verify public/js/theme.js
        $this->assertNotFalse($zip->locateName('public/js/theme.js'));
        $themeJs = $zip->getFromName('public/js/theme.js');
        $this->assertStringContainsString('emerald-matrix', $themeJs);
        $this->assertStringContainsString("data-bs-theme", $themeJs);

        // Verify public/js/function.js (Clean Custom Functions Template)
        $this->assertNotFalse($zip->locateName('public/js/function.js'));
        $functionJs = $zip->getFromName('public/js/function.js');
        $this->assertStringContainsString('Global JavaScript Functions', $functionJs);

        // Verify resources/views/auth/login.blade.php is theme-driven and uses window.artisanCrypto
        $this->assertNotFalse($zip->locateName('resources/views/auth/login.blade.php'));
        $loginBlade = $zip->getFromName('resources/views/auth/login.blade.php');
        $this->assertStringNotContainsString('card bg-dark text-light border-secondary', $loginBlade);
        $this->assertStringContainsString('card shadow-lg border-theme', $loginBlade);
        $this->assertStringContainsString('btn-theme-primary', $loginBlade);
        $this->assertStringContainsString('window.artisanCrypto', $loginBlade);

        // Verify resources/views/demo/index.blade.php has clean theme-driven form controls
        if ($zip->locateName('resources/views/demo/index.blade.php') !== false) {
            $demoBlade = $zip->getFromName('resources/views/demo/index.blade.php');
            $this->assertStringNotContainsString('class="form-control bg-dark text-light border-secondary datepicker"', $demoBlade);
            $this->assertStringNotContainsString('class="form-control bg-dark text-light border-secondary" placeholder="ระบุชื่อ-นามสกุล', $demoBlade);
            $this->assertStringContainsString('class="form-control datepicker"', $demoBlade);
            $this->assertStringContainsString('class="form-control" placeholder="ระบุชื่อ-นามสกุล', $demoBlade);
        }

        $zip->close();
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    }

    public function test_zip_export_with_user_role_module_includes_native_has_roles_trait_and_clean_user_model(): void
    {
        $service = new \App\Services\Generator\ZipExportService();
        $zipPath = $service->generateZip([
            'slug' => 'role-test-app',
            'name' => 'Role Test App',
            'env' => 'local',
            'url' => 'http://localhost:8000',
            'db_host' => '127.0.0.1',
            'db_port' => '3306',
            'db_name' => 'role_test_db',
            'db_user' => 'root',
            'db_pass' => '',
            'modules' => [
                'user_role' => 1,
            ],
        ]);

        $this->assertFileExists($zipPath);

        $zip = new \ZipArchive();
        $this->assertTrue($zip->open($zipPath));

        // 1. Verify app/Traits/HasRoles.php exists and contains key methods
        $this->assertNotFalse($zip->locateName('app/Traits/HasRoles.php'));
        $traitContent = $zip->getFromName('app/Traits/HasRoles.php');
        $this->assertStringContainsString('namespace App\Traits;', $traitContent);
        $this->assertStringContainsString('trait HasRoles', $traitContent);
        $this->assertStringContainsString('public function roles(): BelongsToMany', $traitContent);
        $this->assertStringContainsString('public function assignRole(...$roles): self', $traitContent);
        $this->assertStringContainsString('public function removeRole(...$roles): self', $traitContent);
        $this->assertStringContainsString('public function hasRole(string|RolesModel $role): bool', $traitContent);
        $this->assertStringContainsString('public function hasAnyRole(array|string ...$roles): bool', $traitContent);
        $this->assertStringContainsString('public function hasPermissionTo(string|PermissionsModel $permission): bool', $traitContent);

        // 2. Verify app/Models/UsersModel.php uses App\Traits\HasRoles and NOT Spatie
        $this->assertNotFalse($zip->locateName('app/Models/UsersModel.php'));
        $userModelContent = $zip->getFromName('app/Models/UsersModel.php');
        $this->assertStringContainsString('use App\Traits\HasRoles;', $userModelContent);
        $this->assertStringContainsString('use HasRoles;', $userModelContent);
        $this->assertStringNotContainsString('Spatie\Permission\Traits\HasRoles', $userModelContent);

        // 3. Verify roles migration and models exist
        $this->assertNotFalse($zip->locateName('app/Models/RolesModel.php'));
        $this->assertNotFalse($zip->locateName('app/Models/PermissionsModel.php'));
        $this->assertNotFalse($zip->locateName('database/migrations/0001_01_01_000000_create_roles_table.php'));
        $this->assertNotFalse($zip->locateName('database/migrations/0001_01_01_000002_create_users_roles_table.php'));
        $this->assertNotFalse($zip->locateName('database/migrations/2026_01_01_000002_create_permissions_tables.php'));

        $zip->close();
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    }

    public function test_zip_export_with_ums_buu_module(): void
    {
        $exportService = app(\App\Services\Generator\ZipExportService::class);
        $config = [
            'name' => 'UMS Test App',
            'slug' => 'ums-test-app',
            'use_ums_buu' => true,
            'ums_config' => [
                'system_id' => '149',
                'service_key' => '42963d28e7e0996c39d4a1658f8bd763',
                'service_url' => 'https://ums.buu.ac.th/index.php',
                'kong_domain_prod' => 'https://api-gw.buu.ac.th',
                'kong_pk_ums_glgroupinsystem' => 'test-pk-glgroup',
                'kong_pk_ums_cusergroup' => 'test-pk-cusergroup',
                'kong_pk_ums_glpersonfromcitizenid' => 'test-pk-glperson',
                'kong_pk_ums_ausergroup' => 'test-pk-ausergroup',
                'kong_pk_ums_dusergroup' => 'test-pk-dusergroup',
            ],
            'modules' => [
                'ums_buu' => 1,
            ],
            'packages' => [],
            'custom_packages' => '',
            'schemas' => [],
            'theme_key' => 'sunset-horizon',
            'theme_mode' => 'light',
        ];

        $zipPath = $exportService->generateZip($config);
        $this->assertFileExists($zipPath);

        $zip = new \ZipArchive();
        $this->assertTrue($zip->open($zipPath));

        // 1. Verify UMS config & constants.php
        $this->assertNotFalse($zip->locateName('config/ums.php'));
        $configContent = $zip->getFromName('config/ums.php');
        $this->assertStringContainsString('system_id', $configContent);
        $this->assertStringContainsString('service_key', $configContent);
        $this->assertStringContainsString('service_url', $configContent);

        $this->assertNotFalse($zip->locateName('config/constants.php'));
        $constantsContent = $zip->getFromName('config/constants.php');
        $this->assertStringContainsString('configUms', $constantsContent);
        $this->assertStringContainsString('UMS_SYSTEM_ID', $constantsContent);
        $this->assertStringContainsString('KONG_DOMAIN_PROD', $constantsContent);
        $this->assertStringContainsString('ums.GLGroupInSystem', $constantsContent);
        $this->assertStringContainsString('ums.CUserGroup', $constantsContent);
        $this->assertStringContainsString('ums.GLPersonFromCitizenID', $constantsContent);
        $this->assertStringContainsString('ums.AUserGroup', $constantsContent);
        $this->assertStringContainsString('ums.DUserGroup', $constantsContent);

        // 2. Verify .env contains UMS & Kong variables
        $this->assertNotFalse($zip->locateName('.env'));
        $envContent = $zip->getFromName('.env');
        $this->assertStringContainsString('UMS_SYSTEM_ID=149', $envContent);
        $this->assertStringContainsString('UMS_SERVICE_KEY=42963d28e7e0996c39d4a1658f8bd763', $envContent);
        $this->assertStringContainsString('UMS_SERVICE_URL=https://ums.buu.ac.th/index.php', $envContent);
        $this->assertStringContainsString('KONG_DOMAIN_PROD=https://api-gw.buu.ac.th', $envContent);
        $this->assertStringContainsString('KONG_PK_UMS_GLGROUPINSYSTEM=test-pk-glgroup', $envContent);

        // 3. Verify Generic UmsBuuAuthService & LoginUmsController & Blade Views
        $this->assertNotFalse($zip->locateName('app/Services/Auth/UmsBuuAuthService.php'));
        $serviceContent = $zip->getFromName('app/Services/Auth/UmsBuuAuthService.php');
        $this->assertStringContainsString('check_from_ad', $serviceContent);
        $this->assertStringContainsString('check_person_from_idcard', $serviceContent);
        $this->assertStringContainsString('get_group_in_system', $serviceContent);
        $this->assertStringContainsString('syncRolesFromUms', $serviceContent);
        $this->assertStringContainsString('my_encrypt', $serviceContent);
        // Verify NO dev mock accounts or hardcoded roles in service
        $this->assertStringNotContainsString('getDevMockAccounts', $serviceContent);
        $this->assertStringNotContainsString('checkDevMockLogin', $serviceContent);
        $this->assertStringNotContainsString('getDefaultUmsRoles', $serviceContent);

        $this->assertNotFalse($zip->locateName('app/Http/Controllers/Auth/LoginUmsController.php'));
        $controllerContent = $zip->getFromName('app/Http/Controllers/Auth/LoginUmsController.php');
        $this->assertStringContainsString('class LoginUmsController', $controllerContent);
        $this->assertStringContainsString('checklogin', $controllerContent);
        $this->assertStringContainsString('switchGroup', $controllerContent);

        $this->assertNotFalse($zip->locateName('resources/views/auth/login.blade.php'));
        $loginBladeContent = $zip->getFromName('resources/views/auth/login.blade.php');
        $this->assertStringContainsString('route(\'login.post\')', $loginBladeContent);
        // Verify NO mock personas in login blade
        $this->assertStringNotContainsString('Developer Mock Personas', $loginBladeContent);

        $this->assertNotFalse($zip->locateName('resources/views/auth/switch_group.blade.php'));
        $switchBladeContent = $zip->getFromName('resources/views/auth/switch_group.blade.php');
        $this->assertStringContainsString('route(\'switch.group\')', $switchBladeContent);

        // 4. Verify routes/web.php contains ums routes pointing to LoginUmsController
        $routesContent = $zip->getFromName('routes/web.php');
        $this->assertStringContainsString('LoginUmsController', $routesContent);
        $this->assertStringContainsString('Route::get(\'/login\', [LoginUmsController::class, \'index\'])', $routesContent);
        $this->assertStringContainsString('switch-group', $routesContent);

        // 5. Verify DatabaseSeeder has dynamic sync and STRICTLY NO SUPERADMIN and NO hardcoded roles
        $this->assertNotFalse($zip->locateName('database/seeders/DatabaseSeeder.php'));
        $seederContent = $zip->getFromName('database/seeders/DatabaseSeeder.php');
        $this->assertStringContainsString('syncRolesFromUms', $seederContent);
        $this->assertStringNotContainsString('superadmin', $seederContent);
        $this->assertStringNotContainsString('434', $seederContent);

        // 6. Verify Roles table migration has gpid, label_en, desc, is_default, is_default_person
        $this->assertNotFalse($zip->locateName('database/migrations/0001_01_01_000000_create_roles_table.php'));
        $rolesMigrationContent = $zip->getFromName('database/migrations/0001_01_01_000000_create_roles_table.php');
        $this->assertStringContainsString('gpid', $rolesMigrationContent);
        $this->assertStringContainsString('label_en', $rolesMigrationContent);
        $this->assertStringContainsString('desc', $rolesMigrationContent);
        $this->assertStringContainsString('is_default', $rolesMigrationContent);
        $this->assertStringContainsString('is_default_person', $rolesMigrationContent);

        // 7. Verify bootstrap/app.php registers 'active' middleware alias
        $this->assertNotFalse($zip->locateName('bootstrap/app.php'));
        $bootstrapAppContent = $zip->getFromName('bootstrap/app.php');
        $this->assertStringContainsString("'active' => \\App\\Http\\Middleware\\EnsureActiveUser::class", $bootstrapAppContent);

        // 8. Verify layouts/app.blade.php has UMS user identity and switch role dropdown
        $this->assertNotFalse($zip->locateName('resources/views/layouts/app.blade.php'));
        $layoutAppContent = $zip->getFromName('resources/views/layouts/app.blade.php');
        $this->assertStringContainsString('userFullNameTH', $layoutAppContent);
        $this->assertStringContainsString('userPermitName', $layoutAppContent);

        // 9. Verify demo/index.blade.php has demo.ums link and webauthn components enabled for UMS BUU
        $this->assertNotFalse($zip->locateName('resources/views/demo/index.blade.php'));
        $demoBladeContent = $zip->getFromName('resources/views/demo/index.blade.php');
        $this->assertStringContainsString('route(\'demo.ums\')', $demoBladeContent);
        $this->assertStringContainsString('webauthn.register.options', $demoBladeContent);
        $this->assertStringContainsString('registerWebauthnBiometric', $demoBladeContent);

        // 10. Verify LoginUmsController handles array aData for personnel info
        $this->assertStringContainsString('$cPSN->aData[0]', $controllerContent);

        // 11. Verify WebAuthn files and biometric button on Login Blade for UMS BUU
        $this->assertNotFalse($zip->locateName('database/migrations/2026_01_01_000004_create_users_credentials_table.php'));
        $this->assertNotFalse($zip->locateName('app/Models/UsersCredentialsModel.php'));
        $this->assertNotFalse($zip->locateName('app/Services/Auth/WebauthnService.php'));
        $this->assertNotFalse($zip->locateName('app/Http/Controllers/Auth/WebauthnController.php'));
        $this->assertStringContainsString('btn-biometric-login', $loginBladeContent);
        $this->assertStringContainsString('loginWithBiometrics', $loginBladeContent);
        $this->assertStringContainsString('webauthn.login.options', $loginBladeContent);

        // 12. Verify routes/web.php contains WebAuthn routes
        $this->assertStringContainsString('WebauthnController', $routesContent);
        $this->assertStringContainsString('Route::prefix(\'webauthn\')', $routesContent);
        $this->assertStringContainsString('loginOptions', $routesContent);
        $this->assertStringContainsString('registerOptions', $routesContent);

        // 13. Verify UmsBuuAuthService filters users_roles to only default roles
        $this->assertStringContainsString('is_default', $serviceContent);
        $this->assertStringContainsString('is_default_person', $serviceContent);

        // 14. Verify composer.json contains spomky-labs/cbor-php for WebAuthn
        $this->assertNotFalse($zip->locateName('composer.json'));
        $composerJsonContent = $zip->getFromName('composer.json');
        $this->assertStringContainsString('spomky-labs/cbor-php', $composerJsonContent);

        // 15. Verify demo/index.blade.php contains Danger buttons
        $this->assertStringContainsString('btn-danger', $demoBladeContent);
        $this->assertStringContainsString('btn-outline-danger', $demoBladeContent);

        // 16. Verify demo/ums.blade.php exists and contains live test connection engine
        $this->assertNotFalse($zip->locateName('resources/views/demo/ums.blade.php'));
        $demoUmsContent = $zip->getFromName('resources/views/demo/ums.blade.php');
        $this->assertStringContainsString('runUmsConnectionTest', $demoUmsContent);
        $this->assertStringContainsString('demo.ums.test', $demoUmsContent);
        $this->assertStringContainsString('demo.ums.test', $routesContent);

        $zip->close();
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    }
}

