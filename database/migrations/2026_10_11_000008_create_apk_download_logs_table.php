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
        if (!Schema::hasTable('apk_download_logs')) {
            Schema::create('apk_download_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('release_id')->default(0);
                $table->string('download_token', 64)->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->string('country', 100)->nullable();
                $table->string('country_code', 10)->nullable();
                $table->string('city', 100)->nullable();
                $table->string('region', 100)->nullable();
                $table->string('device_type', 50)->nullable();
                $table->string('platform', 100)->nullable();
                $table->string('browser', 100)->nullable();
                $table->string('session_id', 255)->nullable();
                $table->text('user_agent')->nullable();
                $table->string('status', 50)->default('counted'); // counted, duplicate_token, duplicate_session, duplicate_ip_window, range_chunk
                $table->timestamps();

                $table->index('release_id');
                $table->index('download_token');
                $table->index('ip_address');
                $table->index('country');
                $table->index('status');
                $table->index('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apk_download_logs');
    }
};
