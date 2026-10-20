<?php

namespace Tests\Feature;

use App\Services\Generator\ZipExportService;
use Tests\TestCase;
use ZipArchive;

class ZipExportFrontendAssetsTest extends TestCase
{
    public function test_zip_export_generates_complete_frontend_assets_with_vite_and_npm_wiring(): void
    {
        $exportService = app(ZipExportService::class);

        $projectConfig = [
            'name' => 'Demo App',
            'slug' => 'demo-app',
            'app_url' => 'https://localhost:7000',
            'docker_image' => 'bucchub/php-apache-dev:8.4',
            'docker_https_port' => 7000,
            'docker_ssh_port' => 7001,
            'docker_volume' => 'demo-app-code',
            'packages' => [
                'autonumeric',
                'sweetalert2/toastr',
            ],
            'custom_packages' => "npm i chart.js\ncomposer require predis/predis",
            'modules' => [],
        ];

        $zipPath = $exportService->generateZip($projectConfig);

        $this->assertFileExists($zipPath);

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($zipPath));

        // 1. package.json checks
        $this->assertNotFalse($zip->locateName('package.json'));
        $pkgJsonContent = $zip->getFromName('package.json');
        $pkgData = json_decode($pkgJsonContent, true);
        $this->assertIsArray($pkgData);
        $this->assertArrayHasKey('devDependencies', $pkgData);
        $this->assertArrayHasKey('bootstrap', $pkgData['devDependencies']);
        $this->assertArrayHasKey('bootstrap-icons', $pkgData['devDependencies']);
        $this->assertArrayHasKey('autonumeric', $pkgData['devDependencies']);
        $this->assertArrayHasKey('sweetalert2', $pkgData['devDependencies']);
        $this->assertArrayHasKey('chart.js', $pkgData['devDependencies']);
        $this->assertArrayHasKey('vite', $pkgData['devDependencies']);

        // 2. vite.config.js checks
        $this->assertNotFalse($zip->locateName('vite.config.js'));
        $viteConfig = $zip->getFromName('vite.config.js');
        $this->assertStringContainsString("input: ['resources/css/app.css', 'resources/js/app.js']", $viteConfig);

        // 3. resources/js/app.js checks
        $this->assertNotFalse($zip->locateName('resources/js/app.js'));
        $appJs = $zip->getFromName('resources/js/app.js');
        $this->assertStringContainsString("import './bootstrap';", $appJs);
        $this->assertStringContainsString("import * as bootstrap from 'bootstrap';", $appJs);
        $this->assertStringContainsString("window.bootstrap = bootstrap;", $appJs);
        $this->assertStringContainsString("import AutoNumeric from 'autonumeric';", $appJs);
        $this->assertStringContainsString("window.AutoNumeric = AutoNumeric;", $appJs);
        $this->assertStringContainsString("import Swal from 'sweetalert2';", $appJs);
        $this->assertStringContainsString("window.Swal = Swal;", $appJs);
        $this->assertStringContainsString("import Chart from 'chart.js/auto';", $appJs);
        $this->assertStringContainsString("window.Chart = Chart;", $appJs);

        // 4. resources/css/app.css checks
        $this->assertNotFalse($zip->locateName('resources/css/app.css'));
        $appCss = $zip->getFromName('resources/css/app.css');
        $this->assertStringContainsString("@import 'bootstrap/dist/css/bootstrap.min.css';", $appCss);
        $this->assertStringContainsString("@import 'bootstrap-icons/font/bootstrap-icons.min.css';", $appCss);

        $this->assertNotFalse($zip->locateName('plugins.manifest.json'));
        $manifestContent = $zip->getFromName('plugins.manifest.json');
        $this->assertStringContainsString('"dest": "bootstrap"', $manifestContent);
        $this->assertStringContainsString('"dest": "autonumeric"', $manifestContent);
        $this->assertStringContainsString('"dest": "sweetalert2"', $manifestContent);

        $this->assertNotFalse($zip->locateName('scripts/copy-plugins.mjs'));
        $copyScript = $zip->getFromName('scripts/copy-plugins.mjs');
        $this->assertStringContainsString('plugins.manifest.json', $copyScript);
        $this->assertStringContainsString('public', $copyScript);
        $this->assertStringContainsString('plugins', $copyScript);

        $this->assertStringContainsString('node scripts/copy-plugins.mjs', $pkgJsonContent);

        // 5. resources/views/layouts/app.blade.php checks
        $this->assertNotFalse($zip->locateName('resources/views/layouts/app.blade.php'));
        $layoutBlade = $zip->getFromName('resources/views/layouts/app.blade.php');
        $this->assertStringNotContainsString('@vite', $layoutBlade);
        $this->assertStringContainsString("asset('plugins/bootstrap/css/bootstrap.min.css')", $layoutBlade);
        $this->assertStringContainsString("asset('plugins/bootstrap/js/bootstrap.bundle.min.js')", $layoutBlade);
        $this->assertStringContainsString("asset('plugins/sweetalert2/sweetalert2.all.min.js')", $layoutBlade);
        $this->assertStringContainsString("asset('plugins/autonumeric/autoNumeric.min.js')", $layoutBlade);
        $this->assertStringNotContainsString('https://cdn.jsdelivr.net', $layoutBlade);

        // 6. docker scripts checks
        $volBat = $zip->getFromName('docker-run-volume.bat');
        $this->assertStringContainsString('apt-get install -y openssh-server nodejs npm', $volBat);
        $this->assertStringContainsString('npm install', $volBat);
        $this->assertStringNotContainsString('npm run build', $volBat);
        $this->assertStringNotContainsString('public\build', $volBat);
        $this->assertStringContainsString('docker cp demo-app-web:/var/www/html/public/plugins/. ./public/plugins/', $volBat);

        $bindBat = $zip->getFromName('docker-run-bind.bat');
        $this->assertStringContainsString('apt-get install -y nodejs npm', $bindBat);
        $this->assertStringContainsString('npm install', $bindBat);
        $this->assertStringNotContainsString('npm run build', $bindBat);

        $zip->close();
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    }

    public function test_zip_export_wires_chartjs_and_select2_npm_packages(): void
    {
        $exportService = app(ZipExportService::class);

        $projectConfig = [
            'name' => 'UI Demo App',
            'slug' => 'ui-demo-app',
            'packages' => [
                'chart.js',
                'select2',
            ],
            'custom_packages' => '',
            'modules' => [],
        ];

        $zipPath = $exportService->generateZip($projectConfig);
        $this->assertFileExists($zipPath);

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($zipPath));

        // 1. package.json contains chart.js, select2, and auto-added jquery
        $pkgJsonContent = $zip->getFromName('package.json');
        $pkgData = json_decode($pkgJsonContent, true);
        $this->assertArrayHasKey('chart.js', $pkgData['devDependencies']);
        $this->assertArrayHasKey('select2', $pkgData['devDependencies']);
        $this->assertArrayHasKey('jquery', $pkgData['devDependencies']);

        // 2. resources/js/app.js imports Chart and Select2 with jQuery
        $appJs = $zip->getFromName('resources/js/app.js');
        $this->assertStringContainsString("import Chart from 'chart.js/auto';", $appJs);
        $this->assertStringContainsString("window.Chart = Chart;", $appJs);
        $this->assertStringContainsString("import $ from 'jquery';", $appJs);
        $this->assertStringContainsString("window.$ = window.jQuery = $;", $appJs);
        $this->assertStringContainsString("import select2 from 'select2';", $appJs);
        $this->assertStringContainsString("select2();", $appJs);

        // 3. resources/css/app.css imports select2 css
        $appCss = $zip->getFromName('resources/css/app.css');
        $this->assertStringContainsString("@import 'select2/dist/css/select2.min.css';", $appCss);

        // 4. home.index blade exists and contains select2 and chart demo
        $homeBlade = $zip->getFromName('resources/views/home/index.blade.php');
        $this->assertStringContainsString('homeTrafficChart', $homeBlade);
        $this->assertStringContainsString('---เลือก---', $homeBlade);

        // 5. layout contains script tags for jquery, select2, and chartjs
        $layoutBlade = $zip->getFromName('resources/views/layouts/app.blade.php');
        $this->assertStringContainsString("asset('plugins/jquery/jquery.min.js')", $layoutBlade);
        $this->assertStringContainsString("asset('plugins/select2/js/select2.min.js')", $layoutBlade);
        $this->assertStringContainsString("asset('plugins/select2/css/select2.min.css')", $layoutBlade);
        $this->assertStringContainsString("asset('plugins/chartjs/chart.umd.js')", $layoutBlade);

        $zip->close();
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    }

    public function test_zip_export_wires_jquery_ui_datepicker_dropzone_and_datatables(): void
    {
        $exportService = app(ZipExportService::class);

        $projectConfig = [
            'name' => 'Full UI Suite App',
            'slug' => 'full-ui-app',
            'packages' => [
                'jquery-ui-datepicker',
                'dropzone',
                'datatables-bs5',
                'select2',
                'autonumeric',
                'sweetalert2/toastr',
                'chart.js',
            ],
            'custom_packages' => '',
            'modules' => [],
        ];

        $zipPath = $exportService->generateZip($projectConfig);
        $this->assertFileExists($zipPath);

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($zipPath));

        // 1. package.json contains all npm dependencies and auto-included jquery
        $pkgJsonContent = $zip->getFromName('package.json');
        $pkgData = json_decode($pkgJsonContent, true);
        $this->assertArrayHasKey('jquery', $pkgData['devDependencies']);
        $this->assertArrayHasKey('jquery-ui', $pkgData['devDependencies']);
        $this->assertArrayHasKey('dropzone', $pkgData['devDependencies']);
        $this->assertArrayHasKey('datatables.net-bs5', $pkgData['devDependencies']);

        // 2. plugins.manifest.json contains entries for jquery-ui, dropzone, datatables
        $manifestContent = $zip->getFromName('plugins.manifest.json');
        $this->assertStringContainsString('"dest": "jquery-ui"', $manifestContent);
        $this->assertStringContainsString('"dest": "dropzone"', $manifestContent);
        $this->assertStringContainsString('"dest": "datatables"', $manifestContent);

        // 3. Pre-bundled plugin template files exist in zip
        $this->assertNotFalse($zip->locateName('public/plugins/jquery-ui/jquery-ui.js'));
        $this->assertNotFalse($zip->locateName('public/plugins/jquery-ui/datepicker.js'));
        $this->assertNotFalse($zip->locateName('public/plugins/jquery-ui/datepicker.css'));
        $this->assertNotFalse($zip->locateName('public/plugins/dropzone/dropzone.min.js'));
        $this->assertNotFalse($zip->locateName('public/plugins/dropzone/dropzone.min.css'));
        $this->assertNotFalse($zip->locateName('public/plugins/datatables/jquery.dataTables.min.js'));
        $this->assertNotFalse($zip->locateName('public/plugins/datatables/dataTables.bootstrap5.min.js'));
        $this->assertNotFalse($zip->locateName('public/plugins/datatables/dataTables.bootstrap5.min.css'));

        // 4. Layout contains script and css links for all 3 plugins in correct order
        $layoutBlade = $zip->getFromName('resources/views/layouts/app.blade.php');
        $this->assertStringContainsString("asset('plugins/jquery-ui/datepicker.css')", $layoutBlade);
        $this->assertStringContainsString("asset('plugins/dropzone/dropzone.min.css')", $layoutBlade);
        $this->assertStringContainsString("asset('plugins/datatables/dataTables.bootstrap5.min.css')", $layoutBlade);

        $this->assertStringContainsString("asset('plugins/jquery/jquery.min.js')", $layoutBlade);
        $this->assertStringContainsString("asset('plugins/jquery-ui/jquery-ui.js')", $layoutBlade);
        $this->assertStringContainsString("asset('plugins/jquery-ui/datepicker.js')", $layoutBlade);
        $this->assertStringContainsString("asset('plugins/dropzone/dropzone.min.js')", $layoutBlade);
        $this->assertStringContainsString("asset('plugins/datatables/jquery.dataTables.min.js')", $layoutBlade);
        $this->assertStringContainsString("asset('plugins/datatables/dataTables.bootstrap5.min.js')", $layoutBlade);

        // 5. home.index blade contains all interactive demo forms
        $homeBlade = $zip->getFromName('resources/views/home/index.blade.php');
        $this->assertStringContainsString('demo-datepicker', $homeBlade);
        $this->assertStringContainsString('datepicker', $homeBlade);
        $this->assertStringContainsString('demo-dropzone', $homeBlade);
        $this->assertStringContainsString('demo-datatable', $homeBlade);
        $this->assertStringContainsString('demo-select2', $homeBlade);
        $this->assertStringContainsString('---เลือก---', $homeBlade);
        $this->assertStringContainsString('demo-autonumeric', $homeBlade);
        $this->assertStringContainsString('homeTrafficChart', $homeBlade);
        $this->assertStringContainsString('triggerSweetAlertDemo', $homeBlade);

        // 6. Scripts in home.index blade initialize datepicker (buddhist), datatable, and dropzone
        $this->assertStringContainsString('initDatePicker', $homeBlade);
        $this->assertStringContainsString('DataTable', $homeBlade);
        $this->assertStringContainsString('Dropzone', $homeBlade);

        // 7. getAllGeneratedFiles also contains the static plugin files
        $allFiles = $exportService->getAllGeneratedFiles($projectConfig);
        $this->assertArrayHasKey('public/plugins/jquery-ui/jquery-ui.js', $allFiles);
        $this->assertArrayHasKey('public/plugins/jquery-ui/datepicker.js', $allFiles);
        $this->assertArrayHasKey('public/plugins/jquery-ui/datepicker.css', $allFiles);
        $this->assertArrayHasKey('public/plugins/dropzone/dropzone.min.js', $allFiles);
        $this->assertArrayHasKey('public/plugins/dropzone/dropzone.min.css', $allFiles);
        $this->assertArrayHasKey('public/plugins/datatables/jquery.dataTables.min.js', $allFiles);
        $this->assertArrayHasKey('public/plugins/datatables/dataTables.bootstrap5.min.js', $allFiles);
        $this->assertArrayHasKey('public/plugins/datatables/dataTables.bootstrap5.min.css', $allFiles);

        $zip->close();
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    }
}
