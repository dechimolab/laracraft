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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id('job_id')->comment('รหัสคิวงานหลัก (Primary Key)');
            $table->string('queue')->index()->comment('ชื่อช่องคิวงาน (Queue Name)');
            $table->longText('payload')->comment('ข้อมูลคำสั่งหรือคลาสงาน (Job Payload)');
            $table->unsignedSmallInteger('attempts')->comment('จำนวนครั้งที่ลองประมวลผลงาน');
            $table->unsignedInteger('reserved_at')->nullable()->comment('เวลาที่งานถูกดึงไปประมวลผล (Unix Timestamp)');
            $table->unsignedInteger('available_at')->comment('เวลาที่งานพร้อมให้ประมวลผล (Unix Timestamp)');
            $table->string('created_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่สร้างรายการ');
            $table->unsignedInteger('created_at')->comment('เวลาที่นำงานเข้าสู่คิว (Unix Timestamp)');
            $table->string('updated_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่แก้ไขรายการล่าสุด');
            $table->unsignedInteger('updated_at')->nullable()->comment('เวลาที่แก้ไขรายการล่าสุด (Unix Timestamp)');
            $table->string('request_uri', 255)->nullable()->comment('URL หรือ Endpoint ของหน้าจอที่ทำรายการ');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('btch_id')->primary()->comment('รหัสชุดคิวงาน (Batch ID)');
            $table->string('name')->comment('ชื่อชุดคิวงาน');
            $table->integer('total_jobs')->comment('จำนวนงานทั้งหมดในชุด');
            $table->integer('pending_jobs')->comment('จำนวนงานที่รอการประมวลผล');
            $table->integer('failed_jobs')->comment('จำนวนงานที่ประมวลผลล้มเหลว');
            $table->longText('failed_job_ids')->comment('รายการรหัสงานที่เกิดข้อผิดพลาด');
            $table->mediumText('options')->nullable()->comment('ตัวเลือกการกำหนดค่าของชุดงาน');
            $table->integer('cancelled_at')->nullable()->comment('เวลาที่ยกเลิกชุดงาน (Unix Timestamp)');
            $table->integer('finished_at')->nullable()->comment('เวลาที่ชุดงานเสร็จสิ้น (Unix Timestamp)');
            $table->string('created_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่สร้างรายการ');
            $table->integer('created_at')->comment('เวลาที่สร้างชุดงาน (Unix Timestamp)');
            $table->string('updated_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่แก้ไขรายการล่าสุด');
            $table->integer('updated_at')->nullable()->comment('เวลาที่แก้ไขชุดงานล่าสุด (Unix Timestamp)');
            $table->string('request_uri', 255)->nullable()->comment('URL หรือ Endpoint ของหน้าจอที่ทำรายการ');
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id('fjob_id')->comment('รหัสงานที่ล้มเหลว (Primary Key)');
            $table->string('uuid')->unique()->comment('รหัสสากลจำเพาะของงาน (UUID)');
            $table->string('connection')->comment('ชื่อไดรเวอร์การเชื่อมต่อคิว');
            $table->string('queue')->comment('ชื่อช่องคิวงาน');
            $table->longText('payload')->comment('ข้อมูลคำสั่งหรือคลาสงานที่ล้มเหลว');
            $table->longText('exception')->comment('ข้อความและ Stack Trace ของข้อผิดพลาด');
            $table->timestamp('failed_at')->useCurrent()->comment('วันและเวลาที่งานล้มเหลว');
            $table->string('created_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่สร้างรายการ');
            $table->timestamp('created_at')->nullable()->comment('วันและเวลาที่สร้างรายการ');
            $table->string('updated_by', 100)->nullable()->comment('ชื่อผู้ใช้ที่แก้ไขรายการล่าสุด');
            $table->timestamp('updated_at')->nullable()->comment('วันและเวลาที่แก้ไขรายการล่าสุด');
            $table->string('request_uri', 255)->nullable()->comment('URL หรือ Endpoint ของหน้าจอที่ทำรายการ');

            $table->index(['connection', 'queue', 'failed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
