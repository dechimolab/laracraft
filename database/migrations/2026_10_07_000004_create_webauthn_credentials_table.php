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
        Schema::create('webauthn_credentials', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_0900_ai_ci';

            $table->id('cred_id')->comment('รหัสประจำรายการ Credential (Primary Key)');
            $table->unsignedBigInteger('user_id')->index()->comment('รหัสผู้ใช้งานที่ผูกกับ Credential (FK เชื่อมโยง users.user_id)');
            $table->string('credential_id', 255)->unique()->comment('รหัสอ้างอิง Credential ID (Base64URL encoded)');
            $table->text('public_key')->comment('กุญแจสาธารณะ (Public Key) สำหรับตรวจสอบลายเซ็น WebAuthn');
            $table->string('user_handle', 255)->comment('User Handle สำหรับ WebAuthn Specification');
            $table->unsignedBigInteger('counter')->default(0)->comment('ตัวนับจำนวนครั้งที่เรียกใช้ (Sign Counter) ป้องกัน Replay Attack');
            $table->string('device_name', 100)->nullable()->comment('ชื่อหรือชนิดของอุปกรณ์ เช่น MacBook Touch ID, Windows Hello');
            $table->json('transports')->nullable()->comment('ชนิดช่องทางเชื่อมต่อ เช่น internal, usb, nfc');
            $table->string('aaguid', 36)->nullable()->comment('รหัสจำเพาะผู้ผลิต Authenticator Hardware (AAGUID)');
            $table->dateTime('last_used_at')->nullable()->comment('วันและเวลาที่ใช้งานยืนยันตัวตนล่าสุด');

            // Audit Columns
            $table->string('created_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่สร้างรายการ');
            $table->timestamp('created_at')->nullable()->comment('วันและเวลาที่สร้างรายการ');
            $table->string('updated_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่แก้ไขรายการล่าสุด');
            $table->timestamp('updated_at')->nullable()->comment('วันและเวลาที่แก้ไขรายการล่าสุด');
            $table->string('request_uri', 255)->nullable()->comment('URL หรือ Endpoint ของหน้าจอที่ทำรายการ');

            // Foreign Key Constraint
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webauthn_credentials');
    }
};
