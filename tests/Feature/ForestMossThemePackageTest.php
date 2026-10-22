<?php

namespace Tests\Feature;

use App\Services\Generator\ZipExportService;
use Tests\TestCase;
use ZipArchive;

class ForestMossThemePackageTest extends TestCase
{
    public function test_forest_moss_export_contains_pixel_perfect_templates_and_tokens(): void
    {
        $zipService = app(ZipExportService::class);

        $config = [
            'name' => 'Artisan POS & Inventory Hub',
            'slug' => 'artisan-pos-hub',
            'theme_key' => 'forest-moss',
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
        $this->assertNotFalse($zip->locateName('public/css/themes/forest-moss.css'));
        $themeCss = $zip->getFromName('public/css/themes/forest-moss.css');
        $this->assertStringContainsString('--sys-primary: #15803D;', $themeCss);
        $this->assertStringContainsString('--sys-secondary: #84CC16;', $themeCss);
        $this->assertStringContainsString('--forest-bg: #F0FDF4;', $themeCss);
        $this->assertStringContainsString('--forest-text-dark: #052E16;', $themeCss);

        // 2. Master App Layout
        $this->assertNotFalse($zip->locateName('resources/views/layouts/app.blade.php'));
        $layoutApp = $zip->getFromName('resources/views/layouts/app.blade.php');
        $this->assertStringContainsString('data-bs-theme="light"', $layoutApp);
        $this->assertStringContainsString('data-theme="forest-moss"', $layoutApp);
        $this->assertStringContainsString('css/themes/forest-moss.css', $layoutApp);
        $this->assertStringContainsString('image/favicon-forest-moss.svg', $layoutApp);
        $this->assertStringContainsString('user-executive-capsule', $layoutApp);
        $this->assertStringContainsString('user-profile-dropdown', $layoutApp);
        $this->assertStringContainsString('userFullNameTH', $layoutApp);
        $this->assertStringContainsString('userPermitName', $layoutApp);
        $this->assertStringContainsString('userGroup', $layoutApp);
        $this->assertStringContainsString('switch.group', $layoutApp);

        // 2.1 Theme-Adaptive Favicons (public/image/ and public/)
        $this->assertNotFalse($zip->locateName('public/image/favicon.svg'));
        $this->assertNotFalse($zip->locateName('public/image/favicon.ico'));
        $this->assertNotFalse($zip->locateName('public/image/favicon-forest-moss.svg'));
        $this->assertNotFalse($zip->locateName('public/favicon.svg'));
        $this->assertNotFalse($zip->locateName('public/favicon.ico'));
        $this->assertNotFalse($zip->locateName('public/favicon-forest-moss.svg'));
        $exportedFaviconSvg = $zip->getFromName('public/image/favicon.svg');
        $this->assertStringContainsString('#15803D', $exportedFaviconSvg);

        // 3. Demo Index Showcase
        $this->assertNotFalse($zip->locateName('resources/views/demo/index.blade.php'));
        $demoIndex = $zip->getFromName('resources/views/demo/index.blade.php');
        $this->assertStringContainsString('registerWebauthnBiometric', $demoIndex);
        $this->assertStringContainsString('---เลือก---', $demoIndex);
        $this->assertStringContainsString('btn-forest-primary', $demoIndex);
        $this->assertStringContainsString('forestMossChart', $demoIndex);

        // 4. Login Portal Card
        $this->assertNotFalse($zip->locateName('resources/views/auth/login.blade.php'));
        $loginBlade = $zip->getFromName('resources/views/auth/login.blade.php');
        $this->assertStringContainsString('btn-biometric-login', $loginBlade);
        $this->assertStringContainsString('loginWithBiometrics', $loginBlade);
        $this->assertStringContainsString('UMS BUU Protocol', $loginBlade);
        $this->assertStringContainsString('256-Bit TLS', $loginBlade);
        $this->assertStringContainsString('submitAuthBtn', $loginBlade);

        $zip->close();
        if (file_exists($zipPath)) {
            @unlink($zipPath);
        }
    }

    public function test_forest_moss_preview_routes_render_successfully(): void
    {
        $loginResponse = $this->get('/preview-theme/forest-moss/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('FOREST MOSS & SAGE');
        $loginResponse->assertSee('UMS BUU Protocol');
        $loginResponse->assertSee('btn-biometric-login');

        $demoResponse = $this->get('/preview-theme/forest-moss/demo');
        $demoResponse->assertStatus(200);
        $demoResponse->assertSee('Forest Moss & Sage');
        $demoResponse->assertSee('image/favicon-forest-moss.svg');
        $demoResponse->assertSee('user-executive-capsule');
        $demoResponse->assertSee('user-profile-dropdown');
        $demoResponse->assertSee('---เลือก---');
        $demoResponse->assertSee('btn-forest-primary');

        // Test alias route as well
        $aliasResponse = $this->get('/preview-theme/forest-moss-sage/demo');
        $aliasResponse->assertStatus(200);
        $aliasResponse->assertSee('Forest Moss & Sage');
    }
}
