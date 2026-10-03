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
        Schema::create('app_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Camera, Microphone, Location
            $table->string('code')->nullable(); // e.g. android.permission.CAMERA
            $table->string('icon', 50)->default('🔒'); // e.g. 📷, 🎙️, 📁, 📍
            $table->string('category')->default('General'); // Media, Location, Communication
            $table->string('badge')->default('Feature-Based'); // User-Initiated, Feature-Based, Optional
            $table->text('purpose'); // Clear explanation of usage
            $table->boolean('is_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_permissions');
    }
};
