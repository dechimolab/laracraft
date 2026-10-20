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
        Schema::create('log_sync', function (Blueprint $table) {
            $table->id('sync_id');
            $table->string('sync_source', 50)->default('packages_api')->comment('Source: packages_api, packagist, npm');
            $table->string('sync_status', 20)->default('pending')->comment('Status: success, warning, failed');
            $table->unsignedInteger('total_packages')->default(0);
            $table->unsignedInteger('synced_count')->default(0);
            $table->unsignedInteger('failed_count')->default(0);
            $table->json('error_details')->nullable()->comment('Detailed error logs for failed packages');
            $table->string('triggered_by', 100)->nullable()->comment('Trigger initiator: web_admin, artisan_cli, cron_scheduler');
            $table->unsignedInteger('duration_ms')->default(0)->comment('Execution time in milliseconds');

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
        Schema::dropIfExists('log_sync');
    }
};
