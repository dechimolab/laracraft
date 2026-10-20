<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Framework & Runtime Matrix
    |--------------------------------------------------------------------------
    */
    'default_laravel' => '13.x',
    'default_php'     => '8.4',

    /*
    |--------------------------------------------------------------------------
    | Supported PHP Runtimes (BUCC Dev Hub Standard)
    |--------------------------------------------------------------------------
    */
    'php_versions' => [
        '8.4' => [
            'version'      => '8.4',
            'label'        => 'PHP 8.4 (JIT Enabled - BUCC Recommended)',
            'constraint'   => '^8.4',
            'docker_image' => 'bucchub/php-apache-dev:8.4',
            'cli_workers'  => 4,
            'is_default'   => true,
        ],
        '8.5' => [
            'version'      => '8.5',
            'label'        => 'PHP 8.5 (Next Generation)',
            'constraint'   => '^8.5',
            'docker_image' => 'bucchub/php-apache-dev:8.5',
            'cli_workers'  => 4,
            'is_default'   => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Supported Laravel Framework Generations
    |--------------------------------------------------------------------------
    */
    'laravel_versions' => [
        '13.x' => [
            'version'       => '13.x',
            'major'         => 13,
            'label'         => 'Laravel 13.x (Current Stable)',
            'constraint'    => '^13.0',
            'supported_php' => ['8.4', '8.5'],
            'default_php'   => '8.4',
            'is_default'    => true,
        ],
        '14.x' => [
            'version'       => '14.x',
            'major'         => 14,
            'label'         => 'Laravel 14.x (Upcoming Preview)',
            'constraint'    => '^14.0',
            'supported_php' => ['8.4', '8.5'],
            'default_php'   => '8.5',
            'is_default'    => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Common & Ecosystem Package Constraints
    |--------------------------------------------------------------------------
    | ไลบรารีทั่วไปที่ใช้ร่วมกัน และแพ็กเกจที่ไม่ขึ้นกับเวอร์ชันของ Framework
    */
    'common_packages' => [
        'hashids/hashids'            => '^5.0',
        'yajra/laravel-datatables'   => '^13.0',
        'blade-ui-kit/blade-icons'   => '^1.6',
        'mpdf/mpdf'                  => '^8.2',
        'phpoffice/phpspreadsheet'   => '^5.0',
        'phpoffice/phpword'          => '^1.2',
        'maatwebsite/excel'          => '^4.0',
        'barryvdh/laravel-dompdf'    => '^3.0',
        'spatie/laravel-medialibrary'=> '^11.0',
        'barryvdh/laravel-debugbar'  => '^4.0',
        'pestphp/pest'               => '^4.0',
        'larastan/larastan'          => '^3.0',
        'pestphp/pest-plugin-browser'=> '^4.0',
    ],

    /*
    |--------------------------------------------------------------------------
    | Dynamic Framework-Aligned Packages
    |--------------------------------------------------------------------------
    | แพ็กเกจที่ Major Version วิ่งตาม Laravel Major โดยตรง
    */
    'laravel_aligned_packages' => [
        'yajra/laravel-oci8' => [
            'template' => '^{major}.0',
        ],
        'yajra/laravel-datatables' => [
            'template' => '^{major}.0',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Package Registry & Fallback Metadata (Packagist / GitHub / npm)
    |--------------------------------------------------------------------------
    | ทะเบียนแพ็กเกจสำหรับระบบ Sync สถิติสด และใช้เป็นค่าสำรองเมื่อยังไม่ได้ Sync
    */
    'packages' => [
        // Auth & Security
        'laravel/breeze' => [
            'title'          => 'Laravel Breeze',
            'source'         => 'composer',
            'category'       => 'auth',
            'repo'           => 'laravel/breeze',
            'default_constraint' => '^2.0',
            'fallback_stars' => 14800,
            'is_dev'         => true,
        ],
        'spatie/laravel-permission' => [
            'title'          => 'Spatie Permission',
            'source'         => 'composer',
            'category'       => 'auth',
            'repo'           => 'spatie/laravel-permission',
            'default_constraint' => '^6.0',
            'fallback_stars' => 13500,
            'is_dev'         => false,
        ],
        'laravel/sanctum' => [
            'title'          => 'Laravel Sanctum',
            'source'         => 'composer',
            'category'       => 'auth',
            'repo'           => 'laravel/sanctum',
            'default_constraint' => '^4.0',
            'fallback_stars' => 6200,
            'is_dev'         => false,
        ],
        'hashids/hashids' => [
            'title'          => 'Hashids for PHP',
            'source'         => 'composer',
            'category'       => 'auth',
            'repo'           => 'vinkla/hashids',
            'packagist_name' => 'hashids/hashids',
            'default_constraint' => '^5.0',
            'fallback_stars' => 3900,
            'is_dev'         => false,
        ],

        // UI & Admin
        'twbs/bootstrap' => [
            'title'          => 'Bootstrap 5.3',
            'source'         => 'npm',
            'npm_name'       => 'bootstrap',
            'category'       => 'ui',
            'repo'           => 'twbs/bootstrap',
            'default_constraint' => '5.3.3',
            'fallback_stars' => 163000,
            'is_dev'         => false,
        ],
        'yajra/laravel-datatables' => [
            'title'          => 'Yajra DataTables',
            'source'         => 'composer',
            'category'       => 'ui',
            'repo'           => 'yajra/laravel-datatables',
            'packagist_name' => 'yajra/laravel-datatables',
            'default_constraint' => '^13.0',
            'fallback_stars' => 5100,
            'is_dev'         => false,
        ],
        'sweetalert2/toastr' => [
            'title'          => 'SweetAlert2 Toastr',
            'source'         => 'npm',
            'npm_name'       => 'sweetalert2',
            'category'       => 'ui',
            'repo'           => 'sweetalert2/sweetalert2',
            'default_constraint' => '^11.10',
            'fallback_stars' => 16300,
            'is_dev'         => false,
        ],
        'blade-ui-kit/blade-icons' => [
            'title'          => 'Blade Icons',
            'source'         => 'composer',
            'category'       => 'ui',
            'repo'           => 'blade-ui-kit/blade-icons',
            'default_constraint' => '^1.6',
            'fallback_stars' => 2400,
            'is_dev'         => false,
        ],
        'autonumeric' => [
            'title'          => 'AutoNumeric',
            'source'         => 'npm',
            'npm_name'       => 'autonumeric',
            'category'       => 'ui',
            'repo'           => 'autoNumeric/autoNumeric',
            'default_constraint' => '^4.6',
            'fallback_stars' => 3800,
            'is_dev'         => false,
        ],
        'chart.js' => [
            'title'          => 'Chart.js',
            'source'         => 'npm',
            'npm_name'       => 'chart.js',
            'category'       => 'ui',
            'repo'           => 'chartjs/Chart.js',
            'default_constraint' => '^4.4',
            'fallback_stars' => 64000,
            'is_dev'         => false,
        ],
        'select2' => [
            'title'          => 'Select2',
            'source'         => 'npm',
            'npm_name'       => 'select2',
            'category'       => 'ui',
            'repo'           => 'select2/select2',
            'default_constraint' => '^4.1',
            'fallback_stars' => 26000,
            'is_dev'         => false,
        ],
        'jquery-ui-datepicker' => [
            'title'          => 'jQuery UI Datepicker (พ.ศ.)',
            'source'         => 'npm',
            'npm_name'       => 'jquery-ui',
            'category'       => 'ui',
            'repo'           => 'jquery/jquery-ui',
            'default_constraint' => '^1.13',
            'fallback_stars' => 23000,
            'is_dev'         => false,
        ],
        'dropzone' => [
            'title'          => 'Dropzone.js',
            'source'         => 'npm',
            'npm_name'       => 'dropzone',
            'category'       => 'ui',
            'repo'           => 'dropzone/dropzone',
            'default_constraint' => '^5.9',
            'fallback_stars' => 17800,
            'is_dev'         => false,
        ],
        'datatables-bs5' => [
            'title'          => 'DataTables Bootstrap 5',
            'source'         => 'npm',
            'npm_name'       => 'datatables.net-bs5',
            'category'       => 'ui',
            'repo'           => 'DataTables/Dist-DataTables-Bootstrap5',
            'default_constraint' => '^1.13',
            'fallback_stars' => 5200,
            'is_dev'         => false,
        ],

        // Data Processing & Media Pipelines
        'yajra/laravel-oci8' => [
            'title'          => 'Oracle OCI8 Driver',
            'source'         => 'composer',
            'category'       => 'data',
            'repo'           => 'yajra/laravel-oci8',
            'default_constraint' => '^13.0',
            'fallback_stars' => 1200,
            'is_dev'         => false,
        ],
        'maatwebsite/excel' => [
            'title'          => 'Laravel Excel',
            'source'         => 'composer',
            'category'       => 'data',
            'repo'           => 'SpartnerNL/Laravel-Excel',
            'packagist_name' => 'maatwebsite/excel',
            'default_constraint' => '^4.0',
            'fallback_stars' => 11400,
            'is_dev'         => false,
        ],
        'barryvdh/laravel-dompdf' => [
            'title'          => 'Laravel DomPDF',
            'source'         => 'composer',
            'category'       => 'data',
            'repo'           => 'barryvdh/laravel-dompdf',
            'default_constraint' => '^3.0',
            'fallback_stars' => 6100,
            'is_dev'         => false,
        ],
        'spatie/laravel-medialibrary' => [
            'title'          => 'Spatie MediaLibrary',
            'source'         => 'composer',
            'category'       => 'data',
            'repo'           => 'spatie/laravel-medialibrary',
            'default_constraint' => '^11.0',
            'fallback_stars' => 5900,
            'is_dev'         => false,
        ],
        'mpdf/mpdf' => [
            'title'          => 'mPDF (Thai UTF-8)',
            'source'         => 'composer',
            'category'       => 'data',
            'repo'           => 'mpdf/mpdf',
            'default_constraint' => '^8.2',
            'fallback_stars' => 4800,
            'is_dev'         => false,
        ],
        'phpoffice/phpspreadsheet' => [
            'title'          => 'PhpSpreadsheet',
            'source'         => 'composer',
            'category'       => 'data',
            'repo'           => 'PHPOffice/PhpSpreadsheet',
            'default_constraint' => '^5.0',
            'fallback_stars' => 14200,
            'is_dev'         => false,
        ],
        'phpoffice/phpword' => [
            'title'          => 'PHPWord',
            'source'         => 'composer',
            'category'       => 'data',
            'repo'           => 'PHPOffice/PHPWord',
            'default_constraint' => '^1.2',
            'fallback_stars' => 6800,
            'is_dev'         => false,
        ],

        // DevTools & Quality Control
        'barryvdh/laravel-debugbar' => [
            'title'          => 'Laravel Debugbar',
            'source'         => 'composer',
            'category'       => 'devtools',
            'repo'           => 'barryvdh/laravel-debugbar',
            'default_constraint' => '^4.0',
            'fallback_stars' => 15700,
            'is_dev'         => true,
        ],
        'pestphp/pest' => [
            'title'          => 'Pest PHP',
            'source'         => 'composer',
            'category'       => 'devtools',
            'repo'           => 'pestphp/pest',
            'default_constraint' => '^4.0',
            'fallback_stars' => 8300,
            'is_dev'         => true,
        ],
        'larastan/larastan' => [
            'title'          => 'Larastan',
            'source'         => 'composer',
            'category'       => 'devtools',
            'repo'           => 'larastan/larastan',
            'default_constraint' => '^3.0',
            'fallback_stars' => 5000,
            'is_dev'         => true,
        ],
        'pestphp/pest-plugin-browser' => [
            'title'          => 'Pest Browser Testing',
            'source'         => 'composer',
            'category'       => 'devtools',
            'repo'           => 'pestphp/pest-plugin-browser',
            'default_constraint' => '^4.0',
            'fallback_stars' => 1900,
            'is_dev'         => true,
        ],
    ],
];
