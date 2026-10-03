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
        Schema::create('legal_documents', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // 'privacy', 'guidelines', 'terms', 'security'
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->string('version')->default('1.0.0');
            $table->string('effective_date')->default('October 3, 2026');
            $table->text('summary')->nullable();
            $table->longText('content');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_documents');
    }
};
