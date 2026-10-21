<?php

namespace Tests\Feature;

use App\Services\Generator\ZipExportService;
use Tests\TestCase;
use ZipArchive;

class NordicCleanThemePackageTest extends TestCase
{
    public function test_nordic_clean_export_contains_pixel_perfect_templates_and_tokens(): void
    {
        $zipService = app(ZipExportService::class);

        $config = [
            'name' => 'Artisan POS & Inventory Hub',
            'slug' => 'artisan-pos-hub',
            'theme_key' => 'nordic-clean',
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
        $this->assertNotFalse($zip->locateName('public/css/themes/nordic-clean.css'));
        $themeCss = $zip->getFromName('public/css/themes/nordic-clean.css');
        $this->assertStringContainsString('--sys-primary: #0F172A;', $themeCss);
        $this->assertStringContainsString('--sys-secondary: #3B82F6;', $themeCss);
        $this->assertStringContainsString('--nordic-blue: #3B82F6;', $themeCss);
        $this->assertStringContainsString('--nordic-bg: #F8FAFC;', $themeCss);

        // 2. Master App Layout
        $this->assertNotFalse($zip->locateName('resources/views/layouts/app.blade.php'));
        $layoutApp = $zip->getFromName('resources/views/layouts/app.blade.php');
        $this->assertStringContainsString('data-bs-theme="light"', $layoutApp);
        $this->assertStringContainsString('data-theme="nordic-clean"', $layoutApp);
        $this->assertStringContainsString('css/themes/nordic-clean.css', $layoutApp);
        $this->assertStringContainsString('image/favicon-nordic.svg', $layoutApp);
        $this->assertStringContainsString('user-executive-capsule', $layoutApp);
        $this->assertStringContainsString('user-profile-dropdown', $layoutApp);
        $this->assertStringContainsString('userFullNameTH', $layoutApp);
        $this->assertStringContainsString('userPermitName', $layoutApp);
        $this->assertStringContainsString('userGroup', $layoutApp);
        $this->assertStringContainsString('switch.group', $layoutApp);

        // 2.1 Theme-Adaptive Favicons (public/image/ and public/)
        $this->assertNotFalse($zip->locateName('public/image/favicon.svg'));
        $this->assertNotFalse($zip->locateName('public/image/favicon.ico'));
        $this->assertNotFalse($zip->locateName('public/image/favicon-nordic.svg'));
        $this->assertNotFalse($zip->locateName('public/favicon.svg'));
        $this->assertNotFalse($zip->locateName('public/favicon.ico'));
        $this->assertNotFalse($zip->locateName('public/favicon-nordic.svg'));
        $exportedFaviconSvg = $zip->getFromName('public/image/favicon.svg');
        $this->assertStringContainsString('#3B82F6', $exportedFaviconSvg);

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

    public function test_nordic_clean_preview_renders_dedicated_view(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 4,
            'project.slug' => 'artisan-pos-hub',
            'project.name' => 'Artisan POS & Inventory Hub',
            'project.theme_key' => 'nordic-clean',
            'project.theme_mode' => 'light',
            'project.modules' => [
                'ums_buu' => 1,
            ],
        ])->get('/generator/preview-ui?view=theme-package');

        $response->assertStatus(200);
        $response->assertSee('Nordic Clean');
        $response->assertSee('Overview Hub');
        $response->assertSee('Point of Sale');
        $response->assertSee('registerWebauthnBiometric');
    }
}
