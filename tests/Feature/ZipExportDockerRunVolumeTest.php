<?php

namespace Tests\Feature;

use App\Services\Generator\ZipExportService;
use Tests\TestCase;
use ZipArchive;

class ZipExportDockerRunVolumeTest extends TestCase
{
    public function test_docker_run_volume_scripts_and_sftp_config(): void
    {
        $exportService = app(ZipExportService::class);

        $projectConfig = [
            'name' => 'Artisan POS System',
            'slug' => 'artisan-pos-system',
            'docker_image' => 'bucchub/php-apache-dev:8.4',
            'docker_https_port' => 443,
            'docker_ssh_port' => 2222,
            'docker_volume' => 'artisan-pos-system-code',
            'packages' => [],
            'custom_packages' => '',
            'modules' => [],
        ];

        $zipPath = $exportService->generateZip($projectConfig);
        $this->assertFileExists($zipPath);

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($zipPath));

        // 1. docker-run-volume.bat checks
        $volBat = $zip->getFromName('docker-run-volume.bat');
        $this->assertNotFalse($volBat);
        $this->assertStringContainsString("sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config", $volBat);
        $this->assertStringContainsString('docker exec artisan-pos-system-web service ssh start', $volBat);
        $this->assertStringContainsString('base64 -d | sh', $volBat);
        $this->assertStringContainsString('".gitlab"', $volBat);
        $this->assertStringContainsString('"node_modules"', $volBat);

        // 2. docker-run-volume.sh checks
        $volSh = $zip->getFromName('docker-run-volume.sh');
        $this->assertNotFalse($volSh);
        $this->assertStringContainsString("sed -i 's/#PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config", $volSh);
        $this->assertStringContainsString('docker exec artisan-pos-system-web service ssh start', $volSh);
        $this->assertStringContainsString('base64 -d | sh', $volSh);
        $this->assertStringContainsString('".gitlab"', $volSh);

        // 3. docker-run-bind.bat & docker-run-bind.sh checks
        $bindBat = $zip->getFromName('docker-run-bind.bat');
        $this->assertNotFalse($bindBat);
        $this->assertStringContainsString('base64 -d | sh', $bindBat);

        $bindSh = $zip->getFromName('docker-run-bind.sh');
        $this->assertNotFalse($bindSh);
        $this->assertStringContainsString('base64 -d | sh', $bindSh);

        // 4. .vscode/sftp.json checks
        $sftpJson = $zip->getFromName('.vscode/sftp.json');
        $this->assertNotFalse($sftpJson);
        $sftpData = json_decode($sftpJson, true);
        $this->assertIsArray($sftpData);
        $this->assertContains('.gitlab', $sftpData['ignore']);

        // Verify .gitlab appears before node_modules in ignore array
        $gitlabIndex = array_search('.gitlab', $sftpData['ignore'], true);
        $nodeModulesIndex = array_search('node_modules', $sftpData['ignore'], true);
        $this->assertNotFalse($gitlabIndex);
        $this->assertNotFalse($nodeModulesIndex);
        $this->assertLessThan($nodeModulesIndex, $gitlabIndex);

        $zip->close();
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    }
}
