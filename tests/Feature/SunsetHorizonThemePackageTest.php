<?php

namespace Tests\Feature;

use App\Services\Generator\ZipExportService;
use Tests\TestCase;
use ZipArchive;

class SunsetHorizonThemePackageTest extends TestCase
{
    public function test_sunset_horizon_export_contains_pixel_perfect_templates_and_tokens(): void
    {
        $zipService = app(ZipExportService::class);

        $config = [
            'name' => 'Artisan POS & Inventory Hub',
            'slug' => 'artisan-pos-hub',
            'theme_key' => 'sunset-horizon',
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
        $this->assertNotFalse($zip->locateName('public/css/themes/sunset-horizon.css'));
        $themeCss = $zip->getFromName('public/css/themes/sunset-horizon.css');
        $this->assertStringContainsString('--sys-primary: #EA580C;', $themeCss);
        $this->assertStringContainsString('--sunset-primary: #EA580C;', $themeCss);
        $this->assertStringContainsString('--sunset-bg: #FFFBEB;', $themeCss);

        // 2. Master App Layout
        $this->assertNotFalse($zip->locateName('resources/views/layouts/app.blade.php'));
        $layoutApp = $zip->getFromName('resources/views/layouts/app.blade.php');
        $this->assertStringContainsString('data-bs-theme="light"', $layoutApp);
        $this->assertStringContainsString('data-theme="sunset-horizon"', $layoutApp);
        $this->assertStringContainsString('css/themes/sunset-horizon.css', $layoutApp);
        $this->assertStringContainsString('image/favicon-sunset.svg', $layoutApp);
        $this->assertStringContainsString('user-executive-capsule', $layoutApp);
        $this->assertStringContainsString('user-profile-dropdown', $layoutApp);
        $this->assertStringContainsString('userFullNameTH', $layoutApp);
        $this->assertStringContainsString('userPermitName', $layoutApp);
        $this->assertStringContainsString('userGroup', $layoutApp);
        $this->assertStringContainsString('switch.group', $layoutApp);

        // 2.1 Theme-Adaptive Favicons (public/image/ and public/)
        $this->assertNotFalse($zip->locateName('public/image/favicon.svg'));
        $this->assertNotFalse($zip->locateName('public/image/favicon.ico'));
        $this->assertNotFalse($zip->locateName('public/image/favicon-sunset.svg'));
        $this->assertNotFalse($zip->locateName('public/favicon.svg'));
        $this->assertNotFalse($zip->locateName('public/favicon.ico'));
        $this->assertNotFalse($zip->locateName('public/favicon-sunset.svg'));
        $exportedFaviconSvg = $zip->getFromName('public/image/favicon.svg');
        $this->assertStringContainsString('#EA580C', $exportedFaviconSvg);

        // 3. Demo Index Showcase
        $this->assertNotFalse($zip->locateName('resources/views/demo/index.blade.php'));
        $demoIndex = $zip->getFromName('resources/views/demo/index.blade.php');
        $this->assertStringContainsString('registerWebauthnBiometric', $demoIndex);
        $this->assertStringContainsString('webauthn.register.options', $demoIndex);
        $this->assertStringContainsString('---เลือก---', $demoIndex);
        $this->assertStringContainsString('btn-sunset-primary', $demoIndex);
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

    public function test_sunset_horizon_preview_routes_render_successfully(): void
    {
        $loginResponse = $this->get('/preview-theme/sunset-horizon/login');
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('SUNSET HORIZON');
        $loginResponse->assertSee('UMS BUU Protocol');
        $loginResponse->assertSee('btn-biometric-login');

        $demoResponse = $this->get('/preview-theme/sunset-horizon/demo');
        $demoResponse->assertStatus(200);
        $demoResponse->assertSee('Sunset Horizon');
        $demoResponse->assertSee('image/favicon-sunset.svg');
        $demoResponse->assertSee('user-executive-capsule');
        $demoResponse->assertSee('user-profile-dropdown');
        $demoResponse->assertSee('---เลือก---');
        $demoResponse->assertSee('btn-sunset-primary');
    }
}
