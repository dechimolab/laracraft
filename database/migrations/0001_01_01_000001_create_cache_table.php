<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cache', function (Blueprint $table) {
            $table->string('cach_id')->primary()->comment('คีย์ระบุข้อมูลในแคช');
            $table->mediumText('value')->comment('ค่าข้อมูลที่ถูกจัดเก็บในแคช');
            $table->bigInteger('expiration')->index()->comment('เวลาหมดอายุของแคช (Unix Timestamp)');
            $table->string('created_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่สร้างรายการ');
            $table->timestamp('created_at')->nullable()->comment('วันและเวลาที่สร้างรายการ');
            $table->string('updated_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่แก้ไขรายการล่าสุด');
            $table->timestamp('updated_at')->nullable()->comment('วันและเวลาที่แก้ไขรายการล่าสุด');
            $table->string('request_uri', 255)->nullable()->comment('URL หรือ Endpoint ของหน้าจอที่ทำรายการ');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('lock_id')->primary()->comment('คีย์ระบุการล็อกทรัพยากร');
            $table->string('owner')->comment('เจ้าของหรือโปรเซสที่ถือครองการล็อก');
            $table->bigInteger('expiration')->index()->comment('เวลาหมดอายุของการล็อก (Unix Timestamp)');
            $table->string('created_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่สร้างรายการ');
            $table->timestamp('created_at')->nullable()->comment('วันและเวลาที่สร้างรายการ');
            $table->string('updated_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่แก้ไขรายการล่าสุด');
            $table->timestamp('updated_at')->nullable()->comment('วันและเวลาที่แก้ไขรายการล่าสุด');
            $table->string('request_uri', 255)->nullable()->comment('URL หรือ Endpoint ของหน้าจอที่ทำรายการ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
