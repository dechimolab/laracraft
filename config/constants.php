<?php

return [
    'weblayout' => [
        'title' => env('APP_NAME'),
        'titletab' => env('APP_NAME'),
        'description' => '',
        'author' => ''
    ],
    'alertMessageSuccess' => [
        'store' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
        'update' => 'แก้ไขข้อมูลเรียบร้อยแล้ว',
        'destroy' => 'ลบข้อมูลเรียบร้อยแล้ว',
        'cancel' => 'ยกเลิกรายการเรียบร้อยแล้ว',
    ],
    'alertMessageWarning' => [
        'store' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
        'update' => 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล',
        'destroy' => 'เกิดข้อผิดพลาดในการลบข้อมูล',
        'cancel' => 'เกิดข้อผิดพลาดในการยกเลิกรายการ',
        'email' => 'เกิดข้อผิดพลาดในการส่งอีเมล',
    ],
    'alertMessageError' => [

    ],
    'configLdap' => [
        'AD_ENABLED' => env('LDAP_ENABLED', false),
        'AD_SERVER'  => env('LDAP_SERVER', '10.5.1.80'),
        'AD_BASEDN'  => env('LDAP_BASEDN', 'ou=People,dc=buu,dc=ac,dc=th'),
        'AD_FILTER'  => env('LDAP_FILTER', '(cn=XUID)'),
        'AD_DOMAIN'  => env('LDAP_DOMAIN', 'buu.ac.th'),
    ],
    'path' => [
        'storage' => base_path('storage/'),
        'storage_doc' => base_path('storage/upload/document/'),
        'doc_path' => 'storage/upload/document/',
        'storage_image' => base_path('storage/upload/image/'),
        'storage_manual' => base_path('storage/upload/manual/')
    ]
];
