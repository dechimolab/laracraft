<?php

namespace Tests\Feature;

use App\Services\Generator\ZipExportService;
use Tests\TestCase;
use ZipArchive;

class SolarAmberThemePackageTest extends TestCase
{
    public function test_solar_amber_export_contains_pixel_perfect_templates_and_tokens(): void
    {
        $zipService = app(ZipExportService::class);

        $config = [
            'name' => 'Artisan POS & Inventory Hub',
            'slug' => 'artisan-pos-hub',
            'theme_key' => 'solar-amber',
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
        $this->assertNotFalse($zip->locateName('public/css/themes/solar-amber.css'));
        $themeCss = $zip->getFromName('public/css/themes/solar-amber.css');
        $this->assertStringContainsString('--sys-primary: #D97706;', $themeCss);
        $this->assertStringContainsString('--sys-secondary: #B45309;', $themeCss);
        $this->assertStringContainsString('--ap-bg-surface: #FDF9E9;', $themeCss);
        $this->assertStringContainsString('--ap-coffee: #451A03;', $themeCss);

        // 2. Master App Layout
        $this->assertNotFalse($zip->locateName('resources/views/layouts/app.blade.php'));
        $layoutApp = $zip->getFromName('resources/views/layouts/app.blade.php');
        $this->assertStringContainsString('data-bs-theme="light"', $layoutApp);
        $this->assertStringContainsString('data-theme="solar-amber"', $layoutApp);
        $this->assertStringContainsString('css/themes/solar-amber.css', $layoutApp);
        $this->assertStringContainsString('image/favicon-solar-amber.svg', $layoutApp);
        $this->assertStringContainsString('user-executive-capsule', $layoutApp);
        $this->assertStringContainsString('user-profile-dropdown', $layoutApp);
        $this->assertStringContainsString('userFullNameTH', $layoutApp);
        $this->assertStringContainsString('userPermitName', $layoutApp);
        $this->assertStringContainsString('userGroup', $layoutApp);
        $this->assertStringContainsString('switch.group', $layoutApp);

        // 2.1 Theme-Adaptive Favicons (public/image/ and public/)
        $this->assertNotFalse($zip->locateName('public/image/favicon.svg'));
        $this->assertNotFalse($zip->locateName('public/image/favicon.ico'));
        $this->assertNotFalse($zip->locateName('public/image/favicon-solar-amber.svg'));
        $this->assertNotFalse($zip->locateName('public/favicon.svg'));
        $this->assertNotFalse($zip->locateName('public/favicon.ico'));
        $this->assertNotFalse($zip->locateName('public/favicon-solar-amber.svg'));
        $exportedFaviconSvg = $zip->getFromName('public/image/favicon.svg');
        $this->assertStringContainsString('#D97706', $exportedFaviconSvg);

        // 3. Demo Index Showcase
        $this->assertNotFalse($zip->locateName('resources/views/demo/index.blade.php'));
        $demoIndex = $zip->getFromName('resources/views/demo/index.blade.php');
        $this->assertStringContainsString('registerWebauthnBiometric', $demoIndex);
        $this->assertStringContainsString('---เลือก---', $demoIndex);
        $this->assertStringContainsString('btn-solar-primary', $demoIndex);
        $this->assertStringContainsString('solarAmberChart', $demoIndex);

        // 4. Login Portal Card
        $this->assertNotFalse($zip->locateName('resources/views/auth/login.blade.php'));
        $loginBlade = $zip->getFromName('resources/views/auth/login.blade.php');
        $this->assertStringContainsString('btn-biometric-login', $loginBlade);
        $this->assertStringContainsString('simulatePasskey', $loginBlade);
        $this->assertStringContainsString('UMS BUU Protocol', $loginBlade);
        $this->assertStringContainsString('256-Bit TLS', $loginBlade);
        $this->assertStringContainsString('submitAuthBtn', $loginBlade);

        $zip->close();
        if (file_exists($zipPath)) {
            @unlink($zipPath);
        }
    }

    public function test_solar_amber_preview_routes_render_successfully(): void
    {
        $loginResponse = $this->get('/preview-theme/solar-amber/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('SOLAR AMBER & COFFEE');
        $loginResponse->assertSee('UMS BUU Protocol');
        $loginResponse->assertSee('btn-biometric-login');

        $demoResponse = $this->get('/preview-theme/solar-amber/demo');
        $demoResponse->assertStatus(200);
        $demoResponse->assertSee('Solar Amber & Coffee');
        $demoResponse->assertSee('image/favicon-solar-amber.svg');
        $demoResponse->assertSee('user-executive-capsule');
        $demoResponse->assertSee('user-profile-dropdown');
        $demoResponse->assertSee('---เลือก---');
        $demoResponse->assertSee('btn-solar-primary');

        // Test alias route as well
        $aliasResponse = $this->get('/preview-theme/solar-amber-coffee/demo');
        $aliasResponse->assertStatus(200);
        $aliasResponse->assertSee('Solar Amber & Coffee');
    }
}