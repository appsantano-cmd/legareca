<?php
// database/migrations/2024_01_01_000001_create_kami_daurs_table.php

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
        Schema::create('kami_daurs', function (Blueprint $table) {
            $table->id();
            
            // HANYA PRODUK DAN MATERIAL
            $table->json('products')->nullable();
            $table->json('materials')->nullable();
            
            // Status
            $table->boolean('is_active')->default(false);
            
            $table->timestamps();
            
            // Index for faster queries
            $table->index('is_active');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kami_daurs');
    }
};