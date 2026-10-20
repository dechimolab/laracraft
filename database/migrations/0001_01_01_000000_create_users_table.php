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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id')->comment('รหัสผู้ใช้งานหลัก (Primary Key)');
            $table->string('name')->comment('ชื่อ-นามสกุล หรือชื่อแสดงของผู้ใช้งาน');
            $table->string('username', 100)->nullable()->unique()->comment('ชื่อผู้ใช้งาน Active Directory / ระบบ');
            $table->string('email')->unique()->comment('อีเมลของผู้ใช้งาน (ใช้เข้าสู่ระบบ)');
            $table->string('citizen_id', 13)->nullable()->unique()->comment('เลขประจำตัวประชาชน 13 หลัก');
            $table->timestamp('email_verified_at')->nullable()->comment('วันและเวลาที่ยืนยันอีเมลสำเร็จ');
            $table->string('password')->comment('รหัสผ่านที่ผ่านการเข้ารหัส (Hashed Password)');
            $table->rememberToken()->comment('โทเค็นสำหรับจดจำการเข้าสู่ระบบ');
            $table->string('created_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่สร้างรายการ');
            $table->timestamp('created_at')->nullable()->comment('วันและเวลาที่สร้างรายการ');
            $table->string('updated_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่แก้ไขรายการล่าสุด');
            $table->timestamp('updated_at')->nullable()->comment('วันและเวลาที่แก้ไขรายการล่าสุด');
            $table->string('request_uri', 255)->nullable()->comment('URL หรือ Endpoint ของหน้าจอที่ทำรายการ');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('sess_id')->primary()->comment('รหัสประจำเซสชัน (Session ID)');
            $table->foreignId('user_id')->nullable()->index()->comment('รหัสผู้ใช้งานที่เข้าสู่ระบบ');
            $table->string('ip_address', 45)->nullable()->comment('หมายเลข IP Address ของผู้ใช้งาน');
            $table->text('user_agent')->nullable()->comment('ข้อมูลบราวเซอร์และระบบปฏิบัติการ');
            $table->longText('payload')->comment('ข้อมูลสถานะเซสชัน (Serialized Payload)');
            $table->integer('last_activity')->index()->comment('เวลาที่มีกิจกรรมล่าสุด (Unix Timestamp)');
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
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
    }
};
