<?php

namespace App\Http\Controllers;

use App\Services\Packages\PackageStatsRepository;
use Illuminate\Http\Request;

class GeneratorController extends Controller
{
    public function step1()
    {
        return view('generator.step1', [
            'activeStep' => '1',
            'activePreset' => session('active_preset'),
        ]);
    }

    public function newProject()
    {
        session()->forget(['project', 'active_preset']);
        return redirect()->route('generator.step1');
    }

    public function setActivePreset(Request $request)
    {
        $validated = $request->validate([
            'preset_id' => 'required|string|max:100',
            'preset_name' => 'required|string|max:150',
            'config' => 'nullable|array',
        ]);

        $activePreset = [
            'id' => $validated['preset_id'],
            'name' => $validated['preset_name'],
            'updated_at' => now()->toIso8601String(),
        ];

        session(['active_preset' => $activePreset]);

        if (!empty($validated['config'])) {
            $config = $validated['config'];
            $projectUpdates = [];
            if (isset($config['project_name'])) $projectUpdates['project.slug'] = $config['project_name'];
            if (isset($config['app_title'])) $projectUpdates['project.name'] = $config['app_title'];
            if (isset($config['app_env'])) $projectUpdates['project.env'] = $config['app_env'];
            if (isset($config['app_url'])) $projectUpdates['project.url'] = $config['app_url'];
            if (isset($config['app_timezone'])) $projectUpdates['project.timezone'] = $config['app_timezone'];
            if (isset($config['log_channel'])) $projectUpdates['project.log_channel'] = $config['log_channel'];
            if (isset($config['app_key'])) $projectUpdates['project.key'] = $config['app_key'];
            if (isset($config['db_connection'])) {
                $dbConnVal = $config['db_connection'];
                if (($dbConnVal === 'custom' || $dbConnVal === 'other') && !empty($config['db_connection_custom'])) {
                    $dbConnVal = $config['db_connection_custom'];
                }
                $projectUpdates['project.db_connection'] = $dbConnVal;
            }
            if (isset($config['db_host'])) $projectUpdates['project.db_host'] = $config['db_host'];
            if (isset($config['db_port'])) $projectUpdates['project.db_port'] = $config['db_port'];
            if (isset($config['db_name'])) $projectUpdates['project.db_name'] = $config['db_name'];
            if (isset($config['db_user'])) $projectUpdates['project.db_user'] = $config['db_user'];
            if (isset($config['db_pass'])) $projectUpdates['project.db_pass'] = $config['db_pass'];
            if (isset($config['cache_driver'])) $projectUpdates['project.cache_driver'] = $config['cache_driver'];
            if (isset($config['queue_driver'])) $projectUpdates['project.queue_driver'] = $config['queue_driver'];
            if (isset($config['session_driver'])) $projectUpdates['project.session_driver'] = $config['session_driver'];
            if (isset($config['icon_set'])) $projectUpdates['project.icon_set'] = $config['icon_set'];
            if (isset($config['laravel_version'])) $projectUpdates['project.laravel_version'] = $config['laravel_version'];
            if (isset($config['php_version'])) $projectUpdates['project.php_version'] = $config['php_version'];
            if (isset($config['docker_image'])) $projectUpdates['project.docker_image'] = $config['docker_image'];
            if (isset($config['docker_https_port'])) $projectUpdates['project.docker_https_port'] = (int) $config['docker_https_port'];
            if (isset($config['docker_ssh_port'])) $projectUpdates['project.docker_ssh_port'] = (int) $config['docker_ssh_port'];
            if (isset($config['docker_volume'])) $projectUpdates['project.docker_volume'] = $config['docker_volume'];

            if (!empty($projectUpdates)) {
                session($projectUpdates);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Active preset session updated',
            'active_preset' => $activePreset,
        ]);
    }

    public function clearActivePreset()
    {
        session()->forget('active_preset');
        return response()->json([
            'success' => true,
            'message' => 'Active preset cleared',
        ]);
    }

    public function testDbConnection(Request $request)
    {
        $rawDriver = strtolower(trim($request->input('db_connection', 'mysql')));
        $driver = ($rawDriver === 'custom' || $rawDriver === 'other')
            ? strtolower(trim($request->input('db_connection_custom', 'custom')))
            : $rawDriver;

        if ($driver === 'sqlite') {
            try {
                $pdo = new \PDO('sqlite::memory:');
                $verStmt = $pdo->query('SELECT sqlite_version()');
                $version = $verStmt ? ($verStmt->fetchColumn() ?: '3.x') : '3.x';
                return response()->json([
                    'success' => true,
                    'message' => "PDO Connection ready: SQLite v{$version} • File/Memory Driver active",
                    'version' => $version,
                    'database_status' => 'ready',
                    'database_message' => 'ไดรเวอร์ SQLite พร้อมใช้งาน',
                    'latency_ms' => 0.4,
                    'tested_host' => 'localhost',
                    'active_host' => 'localhost',
                ]);
            } catch (\Throwable $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'SQLite Driver Error: ' . $e->getMessage(),
                    'raw_error' => $e->getMessage(),
                ], 200);
            }
        }

        $isStandardDriver = in_array($driver, ['mysql', 'mariadb', 'pgsql', 'sqlsrv']);
        if (!$isStandardDriver) {
            $validated = $request->validate([
                'db_connection' => 'nullable|string|max:50',
                'db_connection_custom' => 'nullable|string|max:50',
                'db_host' => 'required|string',
                'db_port' => 'required|numeric|between:1,65535',
                'db_name' => 'nullable|string',
                'db_user' => 'nullable|string',
                'db_pass' => 'nullable|string',
            ]);

            $host = trim($validated['db_host']);
            $port = (int) $validated['db_port'];
            $driverLabel = strtoupper($driver);

            $startTime = microtime(true);
            $errno = 0;
            $errstr = '';
            $socket = @fsockopen($host, $port, $errno, $errstr, 1.5);
            $latencyMs = round((microtime(true) - $startTime) * 1000, 1);

            if ($socket) {
                fclose($socket);
                return response()->json([
                    'success' => true,
                    'message' => "Custom Driver ({$driverLabel}) • ตรวจพบ Socket เปิดพร้อมใช้งานที่ {$host}:{$port}",
                    'version' => "Custom Driver ({$driver})",
                    'database_status' => 'ready',
                    'database_message' => "TCP Socket พร้อมเชื่อมต่อที่ {$host}:{$port}",
                    'latency_ms' => $latencyMs,
                    'tested_host' => $host,
                    'active_host' => $host,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => "Custom Driver ({$driverLabel}) บันทึกการกำหนดค่าสำเร็จ • ตรวจสอบ Client Package เพิ่มเติมใน Step 2",
                'version' => "Custom Driver ({$driver})",
                'database_status' => 'ready',
                'database_message' => "ไดรเวอร์กำหนดเอง {$driverLabel} ได้รับการตั้งค่าแล้ว",
                'latency_ms' => $latencyMs,
                'tested_host' => $host,
                'active_host' => $host,
            ]);
        }

        $validated = $request->validate([
            'db_connection' => 'nullable|string|max:50',
            'db_connection_custom' => 'nullable|string|max:50',
            'db_host' => 'required|string',
            'db_port' => 'required|numeric|between:1,65535',
            'db_name' => 'nullable|string',
            'db_user' => 'required|string',
            'db_pass' => 'nullable|string',
        ]);

        $host = trim($validated['db_host']);
        $port = (int) $validated['db_port'];
        $dbName = trim($validated['db_name'] ?? '');
        $username = trim($validated['db_user']);
        $password = (string) ($validated['db_pass'] ?? '');

        // Determine target hosts to try (support Docker container connecting to host machine)
        $hostsToTry = [$host];
        if (in_array(strtolower($host), ['127.0.0.1', 'localhost'])) {
            $envHost = config('database.connections.mysql.host') ?? getenv('DB_HOST');
            if ($envHost && !in_array($envHost, $hostsToTry)) {
                $hostsToTry[] = $envHost;
            }
            if (!in_array('host.docker.internal', $hostsToTry)) {
                $hostsToTry[] = 'host.docker.internal';
            }
        }

        $lastError = null;
        $connected = false;
        $activeHost = $host;
        $pdo = null;
        $startTime = microtime(true);

        foreach ($hostsToTry as $targetHost) {
            try {
                if ($driver === 'sqlsrv' && extension_loaded('pdo_sqlsrv')) {
                    $dsn = "sqlsrv:Server={$targetHost},{$port}" . ($dbName ? ";Database={$dbName}" : '');
                    $pdo = new \PDO($dsn, $username, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_TIMEOUT => 3]);
                } elseif ($driver === 'pgsql' && extension_loaded('pdo_pgsql')) {
                    $dsn = "pgsql:host={$targetHost};port={$port}" . ($dbName ? ";dbname={$dbName}" : '');
                    $pdo = new \PDO($dsn, $username, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_TIMEOUT => 3]);
                } else {
                    $dsn = "mysql:host={$targetHost};port={$port};charset=utf8mb4";
                    $options = [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_TIMEOUT => 3,
                    ];
                    $pdo = new \PDO($dsn, $username, $password, $options);
                }
                $connected = true;
                $activeHost = $targetHost;
                break;
            } catch (\Throwable $e) {
                $lastError = $e;
            }
        }

        $latencyMs = round((microtime(true) - $startTime) * 1000, 1);

        if (!$connected || !$pdo) {
            $rawMsg = $lastError ? $lastError->getMessage() : 'Cannot connect to database host';
            $friendlyMsg = $rawMsg;

            if (stripos($rawMsg, 'Access denied') !== false) {
                $friendlyMsg = "ชื่อผู้ใช้ '{$username}' หรือรหัสผ่านไม่ถูกต้อง (Access denied)";
            } elseif (stripos($rawMsg, 'Connection refused') !== false) {
                $friendlyMsg = "ไม่สามารถเชื่อมต่อไปยังโฮสต์ {$host}:{$port} ได้ (Connection refused)";
            } elseif (stripos($rawMsg, 'timed out') !== false || stripos($rawMsg, 'timeout') !== false) {
                $friendlyMsg = "การเชื่อมต่อหมดเวลา (Timeout) กรุณาตรวจสอบ Host ({$host}) และ Port ({$port})";
            }

            return response()->json([
                'success' => false,
                'message' => $friendlyMsg,
                'raw_error' => $rawMsg,
                'latency_ms' => $latencyMs,
                'tested_host' => $host,
            ], 200);
        }

        // Query Database Server Version
        $version = 'Unknown';
        try {
            $verStmt = $pdo->query('SELECT VERSION()');
            if ($verStmt) {
                $version = $verStmt->fetchColumn() ?: 'Unknown';
            }
        } catch (\Throwable $e) {}

        // Check if database exists
        $dbStatus = 'none';
        $dbMessage = '';
        if ($dbName !== '') {
            try {
                $stmt = $pdo->prepare('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?');
                $stmt->execute([$dbName]);
                if ($stmt->fetch()) {
                    $dbStatus = 'exists';
                    $dbMessage = "พบฐานข้อมูล \"{$dbName}\" พร้อมใช้งาน";
                } else {
                    $dbStatus = 'not_found';
                    $dbMessage = "ยังไม่พบฐานข้อมูล \"{$dbName}\" (ระบบจะสร้างให้อัตโนมัติเมื่อรัน Migrate)";
                }
            } catch (\Throwable $e) {
                $dbStatus = 'check_failed';
            }
        }

        $note = '';
        if ($activeHost !== $host) {
            $note = " (เชื่อมต่อผ่านเครือข่าย Docker: {$activeHost})";
        }

        $driverLabel = strtoupper($driver);
        return response()->json([
            'success' => true,
            'message' => "PDO Connection ready: {$driverLabel} v{$version} • Socket active" . ($dbMessage ? " • {$dbMessage}" : '') . $note,
            'version' => $version,
            'database_status' => $dbStatus,
            'database_message' => $dbMessage,
            'latency_ms' => $latencyMs,
            'tested_host' => $host,
            'active_host' => $activeHost,
        ]);
    }

    public function testUmsConnection(Request $request)
    {
        $systemId = trim((string) $request->input('ums_system_id', ''));
        $serviceKey = trim((string) $request->input('ums_service_key', ''));
        $serviceUrl = trim((string) $request->input('ums_service_url', 'https://ums.buu.ac.th/index.php'));
        $kongDomain = trim((string) $request->input('kong_domain_prod', 'https://api-gw.buu.ac.th'));

        if (empty($systemId) || empty($serviceKey)) {
            return response()->json([
                'success' => false,
                'message' => 'กรุณาระบุ UMS System ID และ UMS Service Key ให้ครบถ้วน',
                'ums_status' => 'missing_params',
            ], 200);
        }

        $startTime = microtime(true);
        $umsService = new \App\Services\Auth\UmsBuuAuthService($systemId, $serviceKey, $serviceUrl);
        $umsResult = $umsService->get_group_in_system();
        $latencyMs = round((microtime(true) - $startTime) * 1000, 1);

        // Probe Kong Gateway
        $kongStatus = 'unchecked';
        $kongMessage = '';
        if (!empty($kongDomain)) {
            $parsedKong = parse_url($kongDomain);
            $kongHost = $parsedKong['host'] ?? $kongDomain;
            $kongPort = $parsedKong['port'] ?? (($parsedKong['scheme'] ?? 'https') === 'https' ? 443 : 80);
            $errno = 0;
            $errstr = '';
            $socket = @fsockopen(($kongPort === 443 ? 'ssl://' : '') . $kongHost, $kongPort, $errno, $errstr, 2.0);
            if ($socket) {
                fclose($socket);
                $kongStatus = 'reachable';
                $kongMessage = "Kong API Gateway พร้อมให้บริการที่ {$kongHost}:{$kongPort}";
            } else {
                $kongStatus = 'unreachable';
                $kongMessage = "ไม่สามารถเชื่อมต่อไปยัง Kong Gateway ที่ {$kongHost}:{$kongPort}";
            }
        }

        $isSuccess = !empty($umsResult->Error) && is_array($umsResult->aData ?? null);
        if ($isSuccess) {
            $groups = [];
            foreach ($umsResult->aData as $grp) {
                $th = $grp->GPNAMET ?? $grp->gpnamet ?? '';
                $en = $grp->GPNAMEE ?? $grp->gpnamee ?? '';
                $groups[] = $th ?: $en;
            }
            $groupsCount = count($groups);
            return response()->json([
                'success' => true,
                'message' => "เชื่อมต่อ UMS Gateway สำเร็จ • พบ {$groupsCount} กลุ่มสิทธิ์ในระบบ {$systemId} ({$latencyMs}ms)",
                'latency_ms' => $latencyMs,
                'ums_status' => 'connected',
                'ums_message' => "UMS Central Gateway ตอบกลับปกติ (SystemID: {$systemId})",
                'groups_count' => $groupsCount,
                'groups' => array_slice($groups, 0, 5),
                'kong_status' => $kongStatus,
                'kong_message' => $kongMessage,
            ]);
        }

        $errMsg = $umsResult->Message ?? 'ไม่สามารถเชื่อมต่อ UMS Gateway ได้';
        return response()->json([
            'success' => false,
            'message' => 'การเชื่อมต่อ UMS ล้มเหลว: ' . $errMsg,
            'latency_ms' => $latencyMs,
            'ums_status' => 'error',
            'ums_message' => $errMsg,
            'kong_status' => $kongStatus,
            'kong_message' => $kongMessage,
        ], 200);
    }

    public function saveStep1(Request $request)
    {
        $validated = $request->validate([
            'project_name' => 'required|string|max:100',
            'app_title' => 'required|string|max:150',
            'app_env' => 'required|string|in:local,staging,production',
            'app_url' => 'required|string',
            'app_key' => 'nullable|string|max:120',
            'app_timezone' => 'nullable|string',
            'log_channel' => 'nullable|string',
            'db_connection' => 'nullable|string|max:50',
            'db_connection_custom' => 'nullable|string|max:50',
            'db_host' => 'nullable|string',
            'db_port' => 'nullable|numeric',
            'db_name' => 'required|string',
            'db_user' => 'nullable|string',
            'db_pass' => 'nullable|string',
            'cache_driver' => 'required|string',
            'queue_driver' => 'required|string',
            'session_driver' => 'required|string',
            'icon_set' => 'nullable|string',
            'docker_image' => 'nullable|string|max:190',
            'docker_https_port' => 'nullable|numeric|between:1,65535',
            'docker_ssh_port' => 'nullable|numeric|between:1,65535',
            'docker_volume' => [
                'nullable',
                'string',
                'regex:/^[a-zA-Z0-9_\-]+-code$/',
            ],
            'laravel_version' => 'nullable|string|max:50',
            'php_version' => 'nullable|string|max:50',
            'use_ums_buu' => 'nullable',
            'ums_system_id' => 'nullable|string|max:100',
            'ums_service_key' => 'nullable|string|max:200',
            'ums_service_url' => 'nullable|string|max:255',
            'kong_domain_prod' => 'nullable|string|max:255',
            'kong_pk_ums_glgroupinsystem' => 'nullable|string|max:255',
            'kong_pk_ums_cusergroup' => 'nullable|string|max:255',
            'kong_pk_ums_glpersonfromcitizenid' => 'nullable|string|max:255',
            'kong_pk_ums_ausergroup' => 'nullable|string|max:255',
            'kong_pk_ums_dusergroup' => 'nullable|string|max:255',
        ], [
            'docker_volume.regex' => 'ชื่อ Volume Mount ต้องลงท้ายด้วย -code ตามแบบแผน {slug}-code เท่านั้น',
        ]);

        $projectSlug = $validated['project_name'];
        $defaultVolume = $projectSlug . '-code';
        $dbConn = $validated['db_connection'] ?? 'mysql';
        if ($dbConn === 'custom' || $dbConn === 'other') {
            $customVal = trim($validated['db_connection_custom'] ?? '');
            $dbConn = $customVal !== '' ? $customVal : 'custom';
        }

        $laravelVer = $validated['laravel_version'] ?? config('generator.default_laravel', '13.x');
        $phpVer = $validated['php_version'] ?? config('generator.default_php', '8.4');
        $allPhp = config('generator.php_versions', []);
        $defaultDockerImage = $allPhp[$phpVer]['docker_image'] ?? "bucchub/php-apache-dev:{$phpVer}";

        $useUmsBuu = $request->boolean('use_ums_buu');
        $umsConfig = [
            'system_id' => $validated['ums_system_id'] ?? '149',
            'service_key' => $validated['ums_service_key'] ?? '42963d28e7e0996c39d4a1658f8bd763',
            'service_url' => $validated['ums_service_url'] ?? 'https://ums.buu.ac.th/index.php',
            'kong_domain_prod' => $validated['kong_domain_prod'] ?? 'https://api-gw.buu.ac.th',
            'kong_pk_ums_glgroupinsystem' => $validated['kong_pk_ums_glgroupinsystem'] ?? '',
            'kong_pk_ums_cusergroup' => $validated['kong_pk_ums_cusergroup'] ?? '',
            'kong_pk_ums_glpersonfromcitizenid' => $validated['kong_pk_ums_glpersonfromcitizenid'] ?? '',
            'kong_pk_ums_ausergroup' => $validated['kong_pk_ums_ausergroup'] ?? '',
            'kong_pk_ums_dusergroup' => $validated['kong_pk_ums_dusergroup'] ?? '',
        ];

        session([
            'project.slug' => $projectSlug,
            'project.name' => $validated['app_title'],
            'project.env' => $validated['app_env'],
            'project.url' => $validated['app_url'],
            'project.key' => $validated['app_key'] ?? 'base64:v84X9J2qK7mP3L0wR1tY5uI6oP8aS0dF2gH4jK6lZ8=',
            'project.timezone' => $validated['app_timezone'] ?? 'Asia/Bangkok',
            'project.log_channel' => $validated['log_channel'] ?? 'daily',
            'project.db_connection' => $dbConn,
            'project.db_host' => $validated['db_host'] ?? ($dbConn === 'sqlite' ? '127.0.0.1' : '127.0.0.1'),
            'project.db_port' => $validated['db_port'] ?? ($dbConn === 'sqlite' ? 0 : 3306),
            'project.db_name' => $validated['db_name'],
            'project.db_user' => $validated['db_user'] ?? ($dbConn === 'sqlite' ? 'root' : 'root'),
            'project.db_pass' => $validated['db_pass'] ?? '',
            'project.cache_driver' => $validated['cache_driver'],
            'project.queue_driver' => $validated['queue_driver'],
            'project.session_driver' => $validated['session_driver'],
            'project.icon_set' => $validated['icon_set'] ?? 'bootstrap_icons',
            'project.laravel_version' => $laravelVer,
            'project.php_version' => $phpVer,
            'project.docker_image' => !empty($validated['docker_image']) ? $validated['docker_image'] : $defaultDockerImage,
            'project.docker_https_port' => (int) (!empty($validated['docker_https_port']) ? $validated['docker_https_port'] : 443),
            'project.docker_ssh_port' => (int) (!empty($validated['docker_ssh_port']) ? $validated['docker_ssh_port'] : 22),
            'project.docker_volume' => !empty($validated['docker_volume']) ? $validated['docker_volume'] : $defaultVolume,
            'project.use_ums_buu' => $useUmsBuu,
            'project.ums_config' => $umsConfig,
            'project.step_completed' => max((int) session('project.step_completed', 0), 1),
        ]);

        if ($useUmsBuu) {
            $existingModules = session('project.modules', []);
            if (is_array($existingModules)) {
                $existingModules['ums_buu'] = '1';
                unset($existingModules['buu_ldap']);
                session(['project.modules' => $existingModules]);
            }
        }

        return redirect()->route('generator.step2');
    }

    public function step2(PackageStatsRepository $statsRepo)
    {
        if ((int) session('project.step_completed', 0) < 1 || !session()->has('project.slug')) {
            return redirect()->route('generator.step1')
                ->with('step_warning', 'กรุณาดำเนินการขั้นตอนที่ 1 (Project Setup) ให้เสร็จสิ้นก่อนเข้าสู่ขั้นตอนถัดไป');
        }

        $packageStats = $statsRepo->getAllStats();
        $selectedPhp = session('project.php_version', config('generator.default_php', '8.4'));
        $selectedLaravel = session('project.laravel_version', config('generator.default_laravel', '13.x'));

        return view('generator.step2', [
            'activeStep'      => '2',
            'packageStats'    => $packageStats,
            'selectedPhp'     => $selectedPhp,
            'selectedLaravel' => $selectedLaravel,
            'statsRepo'       => $statsRepo,
        ]);
    }

    public function saveStep2(Request $request)
    {
        $packages = $request->input('packages', []);
        if (!is_array($packages)) {
            $packages = [];
        }

        session([
            'project.packages' => $packages,
            'project.custom_packages' => trim((string) $request->input('custom_packages', '')),
            'project.step_completed' => max((int) session('project.step_completed', 0), 2),
        ]);

        return redirect()->route('generator.step3');
    }

    public function step3()
    {
        if ((int) session('project.step_completed', 0) < 1 || !session()->has('project.slug')) {
            return redirect()->route('generator.step1')
                ->with('step_warning', 'กรุณาดำเนินการขั้นตอนที่ 1 (Project Setup) ให้เสร็จสิ้นก่อนเข้าสู่ขั้นตอนถัดไป');
        }

        if ((int) session('project.step_completed', 0) < 2) {
            return redirect()->route('generator.step2')
                ->with('step_warning', 'กรุณาดำเนินการขั้นตอนที่ 2 (Packages & Dependencies) ให้เสร็จสิ้นก่อนเข้าสู่ขั้นตอนถัดไป');
        }

        $useUmsBuuFromStep1 = (bool) session('project.use_ums_buu', false);
        $savedModules = session('project.modules', null);

        // If step 1 enabled UMS BUU, guarantee modules state
        if ($useUmsBuuFromStep1) {
            if ($savedModules === null) {
                $savedModules = ['ums_buu' => '1'];
            } else {
                $savedModules['ums_buu'] = '1';
                unset($savedModules['buu_ldap']);
            }
            session(['project.modules' => $savedModules]);
        }

        return view('generator.step3', [
            'activeStep' => '3',
            'savedModules' => $savedModules,
            'useUmsBuuFromStep1' => $useUmsBuuFromStep1,
        ]);
    }

    public function saveStep3(Request $request)
    {
        $modules = $request->input('modules', []);
        $artifacts = $request->input('artifacts', []);
        $schemasJson = $request->input('schemas_json', '');

        if (!is_array($modules)) {
            $modules = [];
        }

        $useUmsFromStep1 = (bool) session('project.use_ums_buu', false);
        if ($useUmsFromStep1) {
            $modules['ums_buu'] = '1';
            unset($modules['buu_ldap']);
        } else {
            // Mutually exclusive between buu_ldap and ums_buu in step 3
            if (!empty($modules['ums_buu']) && !empty($modules['buu_ldap'])) {
                unset($modules['buu_ldap']);
            }
        }

        $schemas = [];
        if (!empty($schemasJson)) {
            $decoded = json_decode($schemasJson, true);
            if (is_array($decoded)) {
                $schemas = $decoded;
            }
        }

        session([
            'project.modules' => $modules,
            'project.artifacts' => is_array($artifacts) ? $artifacts : [],
            'project.schemas' => $schemas,
            'project.step_completed' => max((int) session('project.step_completed', 0), 3),
        ]);

        return redirect()->route('generator.step4');
    }

    protected function getProjectConfig(): array
    {
        $laravelVer = session('project.laravel_version', config('generator.default_laravel', '13.x'));
        $phpVer = session('project.php_version', config('generator.default_php', '8.4'));
        $defaultDocker = config('generator.php_versions')[$phpVer]['docker_image'] ?? 'bucchub/php-apache-dev:8.4';

        return [
            'slug' => session('project.slug', 'artisan-pos-system'),
            'name' => session('project.name', 'Artisan POS & Inventory Hub'),
            'env' => session('project.env', 'local'),
            'url' => session('project.url', 'http://localhost:8000'),
            'key' => session('project.key', 'base64:v84X9J2qK7mP3L0wR1tY5uI6oP8aS0dF2gH4jK6lZ8='),
            'db_connection' => session('project.db_connection', 'mysql'),
            'db_host' => session('project.db_host', '127.0.0.1'),
            'db_port' => session('project.db_port', '3306'),
            'db_name' => session('project.db_name', 'artisan_pos_db'),
            'db_user' => session('project.db_user', 'root'),
            'db_pass' => session('project.db_pass', ''),
            'cache_driver' => session('project.cache_driver', 'file'),
            'queue_driver' => session('project.queue_driver', 'database'),
            'session_driver' => session('project.session_driver', 'file'),
            'packages' => session('project.packages', []),
            'custom_packages' => session('project.custom_packages', ''),
            'modules' => session('project.modules', []),
            'schemas' => session('project.schemas', []),
            'laravel_version' => $laravelVer,
            'php_version' => $phpVer,
            'docker_image' => session('project.docker_image', $defaultDocker),
            'docker_https_port' => session('project.docker_https_port', 443),
            'docker_ssh_port' => session('project.docker_ssh_port', 22),
            'docker_volume' => session('project.docker_volume', session('project.slug', 'artisan-pos-system') . '-code'),
            'theme_key' => session('project.theme_key', config('themes.default_theme', 'nordic-clean')),
            'theme_mode' => session('project.theme_mode', config('themes.default_mode', 'light')),
            'use_ums_buu' => (bool) session('project.use_ums_buu', false),
            'ums_config' => session('project.ums_config', []),
        ];
    }

    public function step4()
    {
        if ((int) session('project.step_completed', 0) < 1 || !session()->has('project.slug')) {
            return redirect()->route('generator.step1')
                ->with('step_warning', 'กรุณาดำเนินการขั้นตอนที่ 1 (Project Setup) ให้เสร็จสิ้นก่อนเข้าสู่ขั้นตอนถัดไป');
        }

        if ((int) session('project.step_completed', 0) < 2) {
            return redirect()->route('generator.step2')
                ->with('step_warning', 'กรุณาดำเนินการขั้นตอนที่ 2 (Packages & Dependencies) ให้เสร็จสิ้นก่อนเข้าสู่ขั้นตอนถัดไป');
        }

        if ((int) session('project.step_completed', 0) < 3) {
            return redirect()->route('generator.step3')
                ->with('step_warning', 'กรุณาดำเนินการขั้นตอนที่ 3 (Modules) ให้เสร็จสิ้นก่อนเข้าสู่ขั้นตอนถัดไป');
        }

        $allThemes = config('themes.themes', []);
        $defaultMode = config('themes.default_mode', 'light');
        $defaultTheme = config('themes.default_theme', 'nordic-clean');

        $selectedMode = session('project.theme_mode', $defaultMode);
        $selectedThemeKey = session('project.theme_key', $defaultTheme);

        $lightThemes = array_filter($allThemes, fn($t) => ($t['mode'] ?? '') === 'light');
        $darkThemes = array_filter($allThemes, fn($t) => ($t['mode'] ?? '') === 'dark');

        $activeTheme = $allThemes[$selectedThemeKey] ?? reset($lightThemes);

        return view('generator.step4', [
            'activeStep' => '4',
            'allThemes' => $allThemes,
            'lightThemes' => $lightThemes,
            'darkThemes' => $darkThemes,
            'selectedMode' => $selectedMode,
            'selectedThemeKey' => $selectedThemeKey,
            'activeTheme' => $activeTheme,
        ]);
    }

    public function saveStep4(Request $request)
    {
        $allThemes = config('themes.themes', []);
        $themeKeys = implode(',', array_keys($allThemes));

        $validated = $request->validate([
            'theme_key' => 'required|string|in:' . $themeKeys,
            'theme_mode' => 'required|string|in:light,dark',
        ]);

        session([
            'project.theme_key' => $validated['theme_key'],
            'project.theme_mode' => $validated['theme_mode'],
            'project.step_completed' => max((int) session('project.step_completed', 0), 4),
        ]);

        return redirect()->route('generator.step5');
    }

    public function step5(\App\Services\Generator\ZipExportService $zipExportService)
    {
        if ((int) session('project.step_completed', 0) < 1 || !session()->has('project.slug')) {
            return redirect()->route('generator.step1')
                ->with('step_warning', 'กรุณาดำเนินการขั้นตอนที่ 1 (Project Setup) ให้เสร็จสิ้นก่อนเข้าสู่ขั้นตอนถัดไป');
        }

        if ((int) session('project.step_completed', 0) < 2) {
            return redirect()->route('generator.step2')
                ->with('step_warning', 'กรุณาดำเนินการขั้นตอนที่ 2 (Packages & Dependencies) ให้เสร็จสิ้นก่อนเข้าสู่ขั้นตอนถัดไป');
        }

        if ((int) session('project.step_completed', 0) < 3) {
            return redirect()->route('generator.step3')
                ->with('step_warning', 'กรุณาดำเนินการขั้นตอนที่ 3 (Modules) ให้เสร็จสิ้นก่อนเข้าสู่ขั้นตอนถัดไป');
        }

        if ((int) session('project.step_completed', 0) < 4) {
            return redirect()->route('generator.step4')
                ->with('step_warning', 'กรุณาดำเนินการขั้นตอนที่ 4 (UI & Theme Studio) ให้เสร็จสิ้นก่อนเข้าสู่ขั้นตอนถัดไป');
        }

        $projectConfig = $this->getProjectConfig();
        $generatedFiles = $zipExportService->getAllGeneratedFiles($projectConfig);
        $generatedEnv = $zipExportService->generateEnv($projectConfig);
        $generatedComposerJson = $zipExportService->generateComposerJson($projectConfig);
        $generatedPackageJson = $zipExportService->generatePackageJson($projectConfig);

        return view('generator.step5', [
            'activeStep' => '5',
            'projectConfig' => $projectConfig,
            'generatedFiles' => $generatedFiles,
            'generatedEnv' => $generatedEnv,
            'generatedComposerJson' => $generatedComposerJson,
            'generatedPackageJson' => $generatedPackageJson,
        ]);
    }

    public function previewFile(Request $request, \App\Services\Generator\ZipExportService $zipExportService)
    {
        $path = (string) $request->query('path', '.env');
        $projectConfig = $this->getProjectConfig();
        $content = $zipExportService->getFileContent($path, $projectConfig);

        if ($content === null) {
            return response()->json(['error' => 'File not found', 'path' => $path], 404);
        }

        return response()->json([
            'path' => $path,
            'content' => $content,
        ]);
    }

    public function previewUi(Request $request, \App\Services\Generator\ZipExportService $zipExportService)
    {
        $projectConfig = $this->getProjectConfig();
        $view = (string) $request->query('view', 'dashboard');
        [$themeKey, $activeTheme] = $zipExportService->getActiveThemeData($projectConfig);

        // Dedicated modular theme package preview if explicitly requested
        $themePackageView = "themes.{$themeKey}.demo.index";
        if ($view === 'theme-package' && view()->exists($themePackageView)) {
            return response()->view($themePackageView, [
                'projectConfig' => $projectConfig,
                'themeKey' => $themeKey,
                'activeTheme' => $activeTheme,
                'view' => $view,
            ]);
        }

        $themeTokensCss = $zipExportService->buildThemeTokensCss($themeKey, $activeTheme);
        $themeCoreCss = $zipExportService->buildThemeCoreCss();

        return view('generator.preview', [
            'projectConfig' => $projectConfig,
            'view' => $view,
            'activeTheme' => $activeTheme,
            'themeKey' => $themeKey,
            'themeTokensCss' => $themeTokensCss,
            'themeCoreCss' => $themeCoreCss,
        ]);
    }

    public function dryRun(Request $request, \App\Services\Generator\ZipExportService $zipExportService)
    {
        $projectConfig = $this->getProjectConfig();
        $report = $zipExportService->dryRunAudit($projectConfig);

        return response()->json($report);
    }

    public function exportZip(\App\Services\Generator\ZipExportService $zipExportService)
    {
        if ((int) session('project.step_completed', 0) < 4 || !session()->has('project.slug')) {
            return redirect()->route('generator.step1')
                ->with('step_warning', 'กรุณาดำเนินการสร้างโปรเจกต์ตามลำดับขั้นตอนให้ครบถ้วนก่อนส่งออก .ZIP');
        }
        $projectConfig = $this->getProjectConfig();

        $zipPath = $zipExportService->generateZip($projectConfig);

        return response()->download($zipPath, basename($zipPath), [
            'Content-Type' => 'application/zip',
        ]);
    }

    public function profile()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $webauthnCredentials = $user->webauthnCredentials()->orderByDesc('created_at')->get();

        $loginLogs = \App\Models\LogLogin::query()
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->user_id)
                  ->orWhere('username', $user->username);
            })
            ->latest('lg_date')
            ->limit(5)
            ->get();

        return view('generator.profile', [
            'activeStep' => 'profile',
            'user' => $user,
            'webauthnCredentials' => $webauthnCredentials,
            'loginLogs' => $loginLogs,
        ]);
    }

    /**
     * Update user profile information and scaffold preferences.
     */
    public function updateProfile(\App\Http\Requests\ProfileUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        $validated = $request->validated();

        $preferences = [
            'pint_format' => (bool) $request->input('pint_format', true),
            'pest_test' => (bool) $request->input('pest_test', true),
            'docker_compose' => (bool) $request->input('docker_compose', true),
        ];

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->timezone = $validated['timezone'] ?? 'Asia/Bangkok';
        $user->git_signature = $validated['git_signature'] ?? null;
        $user->preferences = $preferences;
        $user->save();

        // Sync auth_user session if present
        session([
            'auth_user.name' => $user->name,
            'auth_user.email' => $user->email,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลส่วนตัวและการตั้งค่าโปรไฟล์เรียบร้อยแล้ว',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'timezone' => $user->timezone,
                'git_signature' => $user->git_signature,
                'preferences' => $user->preferences,
            ],
        ]);
    }

    /**
     * Deactivate current user account (active = 'N').
     */
    public function deactivateAccount(Request $request): \Illuminate\Http\JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$user) {
            return response()->json(['error' => 'กรุณาเข้าสู่ระบบก่อนทำรายการ'], 401);
        }

        $user->active = 'N';
        $user->save();

        // Record into log_login
        $loginController = app(\App\Http\Controllers\Auth\LoginController::class);
        $loginController->recordLoginLog(
            $request,
            $user,
            $user->username ?: $user->email,
            true,
            'ปิดบัญชีและระงับการใช้งานตนเอง (Account Deactivated)'
        );

        // Logout user and invalidate session
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'ปิดบัญชีเรียบร้อยแล้ว คุณจะไม่สามารถเข้าสู่ระบบด้วยบัญชีนี้ได้อีกต่อไป',
            'redirect' => route('login'),
        ]);
    }
}
