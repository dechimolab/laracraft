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
        Schema::create('package_stats', function (Blueprint $table) {
            $table->id('pkst_id');
            $table->string('package_name')->unique()->comment('Packagist or npm package name');
            $table->string('source', 20)->default('composer')->comment('Source registry: composer, npm');
            $table->string('category', 50)->nullable()->comment('Category: auth, ui, data, devtools, custom');
            $table->unsignedInteger('stars')->default(0)->comment('GitHub stars count');
            $table->unsignedBigInteger('downloads_monthly')->default(0)->comment('Monthly downloads count');
            $table->unsignedBigInteger('downloads_total')->default(0)->comment('Total downloads count');
            $table->string('latest_version', 50)->nullable()->comment('Latest release version tag');
            $table->string('php_requirement', 100)->nullable()->comment('PHP constraint requirement');
            $table->string('laravel_requirement', 100)->nullable()->comment('Illuminate constraint requirement');
            $table->boolean('is_abandoned')->default(false)->comment('Flag if package is abandoned');
            $table->string('abandoned_replacement')->nullable()->comment('Replacement suggestion if abandoned');
            $table->boolean('is_archived')->default(false)->comment('Flag if GitHub repo is archived');
            $table->dateTime('last_pushed_at')->nullable()->comment('Last repository push timestamp');
            $table->dateTime('synced_at')->nullable()->comment('Last successful sync timestamp');
            $table->string('sync_status', 20)->default('pending')->comment('Status: pending, success, warning, failed');
            $table->text('sync_error')->nullable()->comment('Error message if sync failed');

            // Audit stamps standard
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('request_uri')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_stats');
    }
};
