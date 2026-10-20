<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneratorStep2Test extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_access_step2_without_completing_step1(): void
    {
        $response = $this->get('/generator/step2');

        $response->assertRedirect(route('generator.step1'));
        $response->assertSessionHas('step_warning');
    }

    public function test_generator_step2_screen_renders_successfully(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 1,
            'project.slug' => 'demo-app',
        ])->get('/generator/step2');

        $response->assertStatus(200);
        $response->assertSee('Packages &amp; Engine Dependencies', false);
        $response->assertSee('Authentication &amp; Security Shield', false);
        $response->assertSee('laravel/breeze');
        $response->assertSee('spatie/laravel-permission');
        $response->assertSee('laravel/sanctum');
        $response->assertSee('hashids/hashids');
        $response->assertDontSee('vinkla/hashids');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));

        // Assert unticked defaults:
        $html = $response->getContent();
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="laravel\/breeze"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="spatie\/laravel-permission"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="laravel\/sanctum"/', $html);

        // Assert yajra/laravel-oci8 is present and unchecked by default
        $response->assertSee('yajra/laravel-oci8');
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="yajra\/laravel-oci8"/', $html);

        // Assert Data Processing defaults (all unchecked by default):
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="maatwebsite\/excel"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="barryvdh\/laravel-dompdf"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="spatie\/laravel-medialibrary"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="mpdf\/mpdf"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="phpoffice\/phpspreadsheet"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="phpoffice\/phpword"/', $html);

        // Assert the 14 curated UI, DevTools & Security defaults are checked by default:
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="hashids\/hashids"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="yajra\/laravel-datatables"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="sweetalert2\/toastr"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="blade-ui-kit\/blade-icons"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="autonumeric"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="chart\.js"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="select2"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="jquery-ui-datepicker"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="dropzone"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="datatables-bs5"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="barryvdh\/laravel-debugbar"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="pestphp\/pest"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="larastan\/larastan"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="pestphp\/pest-plugin-browser"/', $html);

        // Assert Active Set counter starts with 15 Packages (14 selected + 1 core bootstrap)
        $response->assertSee('15 Packages');
        $response->assertSee('15 PKGS');

        // Assert category pills and exact counts
        $response->assertSee('All (25)', false);
        $response->assertSee('Auth &amp; Security (4)', false);
        $response->assertSee('UI &amp; Admin (10)', false);
        $response->assertSee('Data &amp; Reports (7)', false);
        $response->assertSee('DevTools (4)', false);

        // Assert search bar, shortcut kbd, and empty state
        $response->assertSee('id="pkg-search"', false);
        $response->assertSee('id="clear-search-btn"', false);
        $response->assertSee('id="no-packages-found"', false);

        // Assert custom packages textarea is present
        $response->assertSee('id="custom-packages"', false);
        $response->assertSee('name="custom_packages"', false);
    }

    public function test_user_can_save_step2_packages_and_custom_packages_and_redirect_to_step3(): void
    {
        $selectedPackages = [
            'hashids/hashids',
            'yajra/laravel-oci8',
            'mpdf/mpdf',
        ];

        $customPackages = "composer require predis/predis:^2.0\ncomposer require sentry/sentry-laravel --dev\nnpm i chart.js";

        $response = $this->post('/generator/step2', [
            'packages' => $selectedPackages,
            'custom_packages' => $customPackages,
        ]);

        $response->assertRedirect(route('generator.step3'));
        $this->assertEquals($selectedPackages, session('project.packages'));
        $this->assertEquals($customPackages, session('project.custom_packages'));
    }

    public function test_step2_rehydrates_saved_packages_and_custom_packages_from_session(): void
    {
        session([
            'project.step_completed' => 1,
            'project.slug' => 'demo-app',
            'project.packages' => [
                'laravel/breeze',
                'yajra/laravel-oci8',
            ],
            'project.custom_packages' => 'composer require predis/predis:^2.0',
        ]);

        $response = $this->get('/generator/step2');
        $response->assertStatus(200);

        $html = $response->getContent();
        // Breeze & OCI8 should now be checked because they were saved in session
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="laravel\/breeze"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+checked\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="yajra\/laravel-oci8"/', $html);
        // Sanctum was never checked and remains unchecked
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="laravel\/sanctum"/', $html);
        // Default-on packages that user unchecked (e.g. mPDF, DataTables, Pest) MUST be unchecked
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="mpdf\/mpdf"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="yajra\/laravel-datatables"/', $html);
        $this->assertMatchesRegularExpression('/<input\s+class="sr-only peer pkg-checkbox"\s+name="packages\[\]"\s+value="pestphp\/pest"/', $html);
        // Custom packages rehydrated
        $response->assertSee('composer require predis/predis:^2.0');
    }

    public function test_zip_export_includes_oci8_and_custom_packages_in_composer_json(): void
    {
        $zipExportService = app(\App\Services\Generator\ZipExportService::class);
        $config = [
            'name' => 'Demo App',
            'slug' => 'demo-app',
            'packages' => ['yajra/laravel-oci8', 'mpdf/mpdf'],
            'custom_packages' => "composer require predis/predis:^2.0\ncomposer require sentry/sentry-laravel --dev",
        ];

        $zipPath = $zipExportService->generateZip($config);
        $this->assertFileExists($zipPath);

        $zip = new \ZipArchive();
        $this->assertTrue($zip->open($zipPath));
        $composerJsonContent = $zip->getFromName('composer.json');
        $zip->close();
        @unlink($zipPath);

        $this->assertNotNull($composerJsonContent);
        $composerData = json_decode($composerJsonContent, true);

        $this->assertArrayHasKey('yajra/laravel-oci8', $composerData['require']);
        $this->assertEquals('^13.0', $composerData['require']['yajra/laravel-oci8']);

        $this->assertArrayHasKey('predis/predis', $composerData['require']);
        $this->assertEquals('^2.0', $composerData['require']['predis/predis']);

        $this->assertArrayHasKey('sentry/sentry-laravel', $composerData['require-dev']);
    }

    public function test_step2_and_zip_export_with_laravel_14_and_php_85(): void
    {
        session([
            'project.step_completed' => 1,
            'project.slug' => 'nextgen-project',
            'project.laravel_version' => '14.x',
            'project.php_version' => '8.5',
        ]);

        $response = $this->get('/generator/step2');
        $response->assertStatus(200);
        $response->assertSee('PHP 8.5 Ready');
        $response->assertSee('yajra/laravel-oci8:^14');

        $zipExportService = app(\App\Services\Generator\ZipExportService::class);
        $config = [
            'name' => 'NextGen Project',
            'slug' => 'nextgen-project',
            'laravel_version' => '14.x',
            'php_version' => '8.5',
            'packages' => ['yajra/laravel-oci8'],
        ];

        $zipPath = $zipExportService->generateZip($config);
        $this->assertFileExists($zipPath);

        $zip = new \ZipArchive();
        $this->assertTrue($zip->open($zipPath));
        $composerJsonContent = $zip->getFromName('composer.json');
        $readmeContent = $zip->getFromName('README.md');
        $zip->close();
        @unlink($zipPath);

        $composerData = json_decode($composerJsonContent, true);
        $this->assertEquals('^8.5', $composerData['require']['php']);
        $this->assertEquals('^14.0', $composerData['require']['laravel/framework']);
        $this->assertEquals('^14.0', $composerData['require']['yajra/laravel-oci8']);

        $this->assertStringContainsString('Laravel 14.x', $readmeContent);
        $this->assertStringContainsString('PHP 8.5', $readmeContent);
    }

    public function test_step2_package_versions_sync_with_admin_setting_and_package_stats(): void
    {
        // Seed database package_stats mimicking a sync from /admin/setting
        \App\Models\PackageStat::create([
            'package_name' => 'spatie/laravel-permission',
            'latest_version' => '8.3.0.0',
            'stars' => 13500,
            'source' => 'composer',
            'category' => 'auth',
            'sync_status' => 'success',
        ]);
        \App\Models\PackageStat::create([
            'package_name' => 'twbs/bootstrap',
            'latest_version' => '5.3.8',
            'stars' => 163000,
            'source' => 'npm',
            'category' => 'ui',
            'sync_status' => 'success',
        ]);
        \App\Models\PackageStat::create([
            'package_name' => 'yajra/laravel-datatables',
            'latest_version' => '13.3.1.0',
            'stars' => 6400,
            'source' => 'composer',
            'category' => 'ui',
            'sync_status' => 'success',
        ]);
        \App\Models\PackageStat::create([
            'package_name' => 'pestphp/pest',
            'latest_version' => '5.3.2.0',
            'stars' => 8300,
            'source' => 'composer',
            'category' => 'devtools',
            'sync_status' => 'success',
        ]);

        app(\App\Services\Packages\PackageStatsRepository::class)->clearCache();

        $response = $this->withSession([
            'project.step_completed' => 1,
            'project.slug' => 'synced-app',
        ])->get('/generator/step2');

        $response->assertStatus(200);
        $html = $response->getContent();

        // Check data-version matches the synced major constraints (^x.0)
        $this->assertStringContainsString('data-name="spatie/laravel-permission" data-version="^8.0"', $html);
        $this->assertStringContainsString('data-name="twbs/bootstrap" data-version="5.3.8"', $html);
        $this->assertStringContainsString('data-name="yajra/laravel-datatables" data-version="^13.0"', $html);
        $this->assertStringContainsString('data-name="pestphp/pest" data-version="^5.0"', $html);

        // Check live version badges are rendered with ^x.0
        $this->assertStringContainsString('^8.0', $html);
        $this->assertStringContainsString('5.3.8', $html);
        $this->assertStringContainsString('^13.0', $html);
        $this->assertStringContainsString('^5.0', $html);

        // Check zip export also reflects the synced ^x.0 constraints and allows phpunit 12 || 13
        $zipExportService = app(\App\Services\Generator\ZipExportService::class);
        $config = [
            'name' => 'Synced App',
            'slug' => 'synced-app',
            'packages' => ['spatie/laravel-permission', 'yajra/laravel-datatables', 'pestphp/pest'],
            'laravel_version' => '13.x',
            'php_version' => '8.4',
        ];

        $zipPath = $zipExportService->generateZip($config);
        $this->assertFileExists($zipPath);

        $zip = new \ZipArchive();
        $this->assertTrue($zip->open($zipPath));
        $composerJsonContent = $zip->getFromName('composer.json');
        $packageJsonContent = $zip->getFromName('package.json');
        $zip->close();
        @unlink($zipPath);

        $composerData = json_decode($composerJsonContent, true);
        $this->assertEquals('^8.0', $composerData['require']['spatie/laravel-permission']);
        $this->assertEquals('^13.0', $composerData['require']['yajra/laravel-datatables']);
        $this->assertEquals('^5.0', $composerData['require-dev']['pestphp/pest']);
        $this->assertArrayNotHasKey('phpunit/phpunit', $composerData['require-dev'], 'When pestphp/pest is selected, phpunit/phpunit must be removed per Pest official docs.');

        // Verify that without Pest, phpunit/phpunit remains present
        $configWithoutPest = [
            'name' => 'Without Pest App',
            'slug' => 'without-pest-app',
            'packages' => ['spatie/laravel-permission'],
            'laravel_version' => '13.x',
            'php_version' => '8.4',
        ];
        $zipWithoutPestPath = $zipExportService->generateZip($configWithoutPest);
        $zip2 = new \ZipArchive();
        $this->assertTrue($zip2->open($zipWithoutPestPath));
        $composerWithoutPest = json_decode($zip2->getFromName('composer.json'), true);
        $zip2->close();
        @unlink($zipWithoutPestPath);
        $this->assertEquals('^12.0 || ^13.0', $composerWithoutPest['require-dev']['phpunit/phpunit']);
        $this->assertArrayNotHasKey('pestphp/pest', $composerWithoutPest['require-dev']);

        $packageData = json_decode($packageJsonContent, true);
        $this->assertEquals('^5.3.8', $packageData['devDependencies']['bootstrap']);
    }

    public function test_generator_step2_renders_tabbed_code_inspector_with_composer_and_package_json(): void
    {
        $response = $this->withSession([
            'project.step_completed' => 1,
            'project.slug' => 'demo-app',
        ])->get('/generator/step2');

        $response->assertStatus(200);
        $response->assertSee('id="preview-tab-group"', false);
        $response->assertSee('id="tab-composer-btn"', false);
        $response->assertSee('id="tab-package-btn"', false);
        $response->assertSee('id="pane-composer"', false);
        $response->assertSee('id="pane-package"', false);
        $response->assertSee('id="composer-preview"', false);
        $response->assertSee('id="package-preview"', false);
        $response->assertSee('id="composer-badge"', false);
        $response->assertSee('id="package-badge"', false);
    }
}
