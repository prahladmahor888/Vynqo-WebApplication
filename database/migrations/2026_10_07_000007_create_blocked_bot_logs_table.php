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
        if (!Schema::hasTable('blocked_bot_logs')) {
            Schema::create('blocked_bot_logs', function (Blueprint $table) {
                $table->id();
                $table->string('ip_address', 45)->nullable();
                $table->string('block_reason', 255)->default('Blocked Automated Bot');
                $table->string('category', 50)->default('scraper'); // scraper, exploit_probe, honeypot, rate_limit, blacklisted_ip, bad_user_agent
                $table->string('path', 500)->default('/');
                $table->string('method', 10)->default('GET');
                $table->text('user_agent')->nullable();
                $table->string('country', 100)->nullable();
                $table->string('country_code', 10)->nullable();
                $table->timestamps();

                $table->index('ip_address');
                $table->index('category');
                $table->index('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocked_bot_logs');
    }
};
