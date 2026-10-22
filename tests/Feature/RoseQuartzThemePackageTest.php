<?php

namespace Tests\Feature;

use App\Services\Generator\ZipExportService;
use Tests\TestCase;
use ZipArchive;

class RoseQuartzThemePackageTest extends TestCase
{
    public function test_rose_quartz_export_contains_pixel_perfect_templates_and_tokens(): void
    {
        $zipService = app(ZipExportService::class);

        $config = [
            'name' => 'Artisan POS & Inventory Hub',
            'slug' => 'artisan-pos-hub',
            'theme_key' => 'rose-quartz',
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
        $this->assertNotFalse($zip->locateName('public/css/themes/rose-quartz.css'));
        $themeCss = $zip->getFromName('public/css/themes/rose-quartz.css');
        $this->assertStringContainsString('--sys-primary: #95002A;', $themeCss);
        $this->assertStringContainsString('--sys-primary-velvet: #BE123C;', $themeCss);
        $this->assertStringContainsString('--rq-bg-blush: #FFF8F7;', $themeCss);
        $this->assertStringContainsString('--rq-text-wine: #400014;', $themeCss);

        // 2. Master App Layout
        $this->assertNotFalse($zip->locateName('resources/views/layouts/app.blade.php'));
        $layoutApp = $zip->getFromName('resources/views/layouts/app.blade.php');
        $this->assertStringContainsString('data-bs-theme="light"', $layoutApp);
        $this->assertStringContainsString('data-theme="rose-quartz"', $layoutApp);
        $this->assertStringContainsString('css/themes/rose-quartz.css', $layoutApp);
        $this->assertStringContainsString('image/favicon-rose-quartz.svg', $layoutApp);
        $this->assertStringContainsString('user-executive-capsule', $layoutApp);
        $this->assertStringContainsString('user-profile-dropdown', $layoutApp);
        $this->assertStringContainsString('userFullNameTH', $layoutApp);
        $this->assertStringContainsString('userPermitName', $layoutApp);
        $this->assertStringContainsString('userGroup', $layoutApp);
        $this->assertStringContainsString('switch.group', $layoutApp);

        // 2.1 Theme-Adaptive Favicons (public/image/ and public/)
        $this->assertNotFalse($zip->locateName('public/image/favicon.svg'));
        $this->assertNotFalse($zip->locateName('public/image/favicon.ico'));
        $this->assertNotFalse($zip->locateName('public/image/favicon-rose-quartz.svg'));
        $this->assertNotFalse($zip->locateName('public/favicon.svg'));
        $this->assertNotFalse($zip->locateName('public/favicon.ico'));
        $this->assertNotFalse($zip->locateName('public/favicon-rose-quartz.svg'));
        $exportedFaviconSvg = $zip->getFromName('public/image/favicon.svg');
        $this->assertStringContainsString('#BE123C', $exportedFaviconSvg);

        // 3. Demo Index Showcase
        $this->assertNotFalse($zip->locateName('resources/views/demo/index.blade.php'));
        $demoIndex = $zip->getFromName('resources/views/demo/index.blade.php');
        $this->assertStringContainsString('registerWebauthnBiometric', $demoIndex);
        $this->assertStringContainsString('---เลือก---', $demoIndex);
        $this->assertStringContainsString('rq-btn-ruby', $demoIndex);
        $this->assertStringContainsString('roseQuartzChart', $demoIndex);

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

    public function test_rose_quartz_preview_routes_render_successfully(): void
    {
        $loginResponse = $this->get('/preview-theme/rose-quartz/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('ROSE QUARTZ & VELVET');
        $loginResponse->assertSee('UMS BUU Protocol');
        $loginResponse->assertSee('btn-biometric-login');

        $demoResponse = $this->get('/preview-theme/rose-quartz/demo');
        $demoResponse->assertStatus(200);
        $demoResponse->assertSee('Rose Quartz & Velvet');
        $demoResponse->assertSee('image/favicon-rose-quartz.svg');
        $demoResponse->assertSee('user-executive-capsule');
        $demoResponse->assertSee('user-profile-dropdown');
        $demoResponse->assertSee('---เลือก---');
        $demoResponse->assertSee('rq-btn-ruby');

        // Test alias route as well
        $aliasResponse = $this->get('/preview-theme/rose-quartz-velvet/demo');
        $aliasResponse->assertStatus(200);
        $aliasResponse->assertSee('Rose Quartz & Velvet');
    }
}
