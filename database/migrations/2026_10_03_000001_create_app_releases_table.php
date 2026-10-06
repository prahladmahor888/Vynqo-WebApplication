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
        Schema::create('app_releases', function (Blueprint $table) {
            $table->id();
            $table->string('version_name');             // e.g. "v1.0.4"
            $table->integer('version_code');            // e.g. 104
            $table->string('apk_file_path');            // e.g. "downloads/sangfy-release.apk"
            $table->string('file_size');                // e.g. "42.8 MB"
            $table->string('sha256_checksum')->nullable();
            $table->text('changelog')->nullable();      // Markdown formatted release notes
            $table->string('min_android_version')->default('Android 8.0 (Oreo)+');
            $table->unsignedBigInteger('download_count')->default(0);
            $table->boolean('is_latest')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_releases');
    }
};
