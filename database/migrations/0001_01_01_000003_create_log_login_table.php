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
        Schema::create('log_login', function (Blueprint $table) {
            $table->id('lg_id')->comment('รหัสตาราง log_login');
            $table->string('fac_id', 12)->nullable()->comment('รหัสคณะ');
            $table->string('dep_id', 12)->nullable()->comment('รหัสภาควิชาฝ่าย');
            $table->dateTime('lg_date')->nullable()->comment('วันที่บันทึกข้อมูล');
            $table->string('lg_ip', 100)->nullable()->comment('ip address');
            $table->string('lg_url', 250)->nullable()->comment('url ที่เข้าถึง');
            $table->string('username', 50)->nullable()->comment('user login');
            $table->unsignedBigInteger('user_id')->nullable()->index()->comment('รหัสผู้ใช้งาน (เชื่อมโยง users.user_id)');
            $table->string('psn_id', 20)->nullable()->comment('รหัสบุคลากร (Legacy/BUU)');
            $table->string('lg_user_name', 100)->nullable()->comment('ชื่อผู้ใช้งานระบบ');
            $table->string('lg_authority', 250)->nullable()->comment('สิทธิ์การใช้งานระบบ');
            $table->string('lg_action', 4000)->nullable()->comment('ประวัติการใช้งานระบบ');
            $table->string('lg_browser', 250)->nullable()->comment('บราวเซอร์ที่ใช้งานระบบ');
            $table->string('lg_device', 100)->nullable()->comment('อุปกรณ์ที่ใช้งาน');
            $table->string('lg_os', 100)->nullable()->comment('ระบบปฏิบัติการที่ใช้');

            // Audit Columns
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
        Schema::dropIfExists('log_login');
    }
};
