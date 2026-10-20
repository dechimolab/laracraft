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
        Schema::table('users', function (Blueprint $table) {
            $table->string('timezone', 50)->default('Asia/Bangkok')->after('email')->comment('ไทม์โซนที่ผู้ใช้งานกำหนด');
            $table->string('git_signature', 255)->nullable()->after('timezone')->comment('ลายเซ็น Git Committer เช่น ชื่อ <อีเมล>');
            $table->json('preferences')->nullable()->after('git_signature')->comment('การตั้งค่าระบบและ Scaffolding Flags ในรูปแบบ JSON');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['timezone', 'git_signature', 'preferences']);
        });
    }
};
