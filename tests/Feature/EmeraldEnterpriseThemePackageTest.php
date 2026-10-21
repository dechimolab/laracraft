<?php

namespace Tests\Feature;

use App\Services\Generator\ZipExportService;
use Tests\TestCase;
use ZipArchive;

class EmeraldEnterpriseThemePackageTest extends TestCase
{
    public function test_emerald_enterprise_export_contains_pixel_perfect_templates_and_tokens(): void
    {
        $zipService = app(ZipExportService::class);

        $config = [
            'name' => 'Artisan POS & Inventory Hub',
            'slug' => 'artisan-pos-hub',
            'theme_key' => 'emerald-enterprise',
            'theme_mode' => 'light',
            'modules' => [
                'ums_buu' => 1,
            ],
            'packages' => [],
        ];

        $zipPath = $zipService->generateZip($config);

        $this->assertFileExists($zipPath);

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($zipPath));

        // 1. Theme Tokens CSS
        $this->assertNotFalse($zip->locateName('public/css/themes/emerald-enterprise.css'));
        $themeCss = $zip->getFromName('public/css/themes/emerald-enterprise.css');
        $this->assertStringContainsString('--sys-primary: #047857;', $themeCss);
        $this->assertStringContainsString('--sys-bg: #F0FDF4;', $themeCss);
        $this->assertStringContainsString('--sys-on-primary-container: #9ffdd3;', $themeCss);

        // 2. Master App Layout
        $this->assertNotFalse($zip->locateName('resources/views/layouts/app.blade.php'));
        $layoutApp = $zip->getFromName('resources/views/layouts/app.blade.php');
        $this->assertStringContainsString('data-bs-theme="light"', $layoutApp);
        $this->assertStringContainsString('data-theme="emerald-enterprise"', $layoutApp);
        $this->assertStringContainsString('css/themes/emerald-enterprise.css', $layoutApp);
        $this->assertStringContainsString('image/favicon-emerald.svg', $layoutApp);
        $this->assertStringContainsString('user-executive-capsule', $layoutApp);
        $this->assertStringContainsString('userFullNameTH', $layoutApp);
        $this->assertStringContainsString('userPermitName', $layoutApp);
        $this->assertStringContainsString('userGroup', $layoutApp);
        $this->assertStringContainsString('switch.group', $layoutApp);

        // 2.1 Theme-Adaptive Favicons (public/image/ and public/)
        $this->assertNotFalse($zip->locateName('public/image/favicon.svg'));
        $this->assertNotFalse($zip->locateName('public/image/favicon.ico'));
        $this->assertNotFalse($zip->locateName('public/image/favicon-emerald.svg'));
        $this->assertNotFalse($zip->locateName('public/image/favicon-nordic.svg'));
        $this->assertNotFalse($zip->locateName('public/favicon.svg'));
        $this->assertNotFalse($zip->locateName('public/favicon.ico'));
        $this->assertNotFalse($zip->locateName('public/favicon-emerald.svg'));
        $this->assertNotFalse($zip->locateName('public/favicon-nordic.svg'));
        $exportedFaviconSvg = $zip->getFromName('public/image/favicon.svg');
        $this->assertStringContainsString('#047857', $exportedFaviconSvg);

        // 3. Demo Index Showcase
        $this->assertNotFalse($zip->locateName('resources/views/demo/index.blade.php'));
        $demoIndex = $zip->getFromName('resources/views/demo/index.blade.php');
        $this->assertStringContainsString('registerWebauthnBiometric', $demoIndex);
        $this->assertStringContainsString('webauthn.register.options', $demoIndex);
        $this->assertStringContainsString('---เลือก---', $demoIndex);
        $this->assertStringContainsString('btn-danger', $demoIndex);
        $this->assertStringContainsString('btn-outline-danger', $demoIndex);
        $this->assertStringContainsString('route(\'demo.ums\')', $demoIndex);

        // 4. Login Portal Card
        $this->assertNotFalse($zip->locateName('resources/views/auth/login.blade.php'));
        $loginBlade = $zip->getFromName('resources/views/auth/login.blade.php');
        $this->assertStringContainsString('btn-biometric-login', $loginBlade);
        $this->assertStringContainsString('loginWithBiometrics', $loginBlade);
        $this->assertStringContainsString('webauthn.login.options', $loginBlade);
        $this->assertStringContainsString('UMS BUU Protocol', $loginBlade);
        $this->assertStringContainsString('256-Bit TLS', $loginBlade);
        $this->assertStringContainsString('loginBtn', $loginBlade);

        $zip->close();
        if (file_exists($zipPath)) {
            @unlink($zipPath);
        }
    }

    public function test_emerald_enterprise_preview_renders_dedicated_view(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 4,
            'project.slug' => 'artisan-pos-hub',
            'project.name' => 'Artisan POS & Inventory Hub',
            'project.theme_key' => 'emerald-enterprise',
            'project.theme_mode' => 'light',
            'project.modules' => [
                'ums_buu' => 1,
            ],
        ])->get('/generator/preview-ui?view=theme-package');

        $response->assertStatus(200);
        $response->assertSee('EMERALD ENTERPRISE');
        $response->assertSee('Overview Hub');
        $response->assertSee('Point of Sale');
        $response->assertSee('registerWebauthnBiometric');
    }
}
