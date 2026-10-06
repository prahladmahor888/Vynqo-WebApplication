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
        Schema::create('visitor_traffic', function (Blueprint $table) {
            $table->id();
            $table->string('url', 500);
            $table->string('path', 255)->default('/');
            $table->string('method', 10)->default('GET');
            $table->string('ip_address', 45)->nullable();
            $table->string('device_type', 30)->default('Desktop'); // Mobile, Tablet, Desktop, Bot
            $table->string('platform', 50)->nullable(); // Android, iOS, Windows, Mac, Linux
            $table->string('browser', 50)->nullable(); // Chrome, Safari, Firefox, Edge
            $table->text('user_agent')->nullable();
            $table->string('referer', 500)->nullable();
            $table->string('session_id', 100)->nullable();
            $table->timestamps();

            // Indexes for fast analytics queries
            $table->index('path');
            $table->index('device_type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_traffic');
    }
};
