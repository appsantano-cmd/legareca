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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('room_type', 100);
            $table->string('room_price', 50);
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('guests');
            $table->integer('rooms');
            $table->string('full_name', 255);
            $table->string('phone', 20);
            $table->string('email', 255);
            $table->text('special_request')->nullable();
            $table->integer('duration_days');
            $table->decimal('total_price', 15, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->string('booking_code', 20)->unique();
            $table->timestamps();
            
            // Index untuk pencarian
            $table->index('booking_code');
            $table->index('email');
            $table->index('phone');
            $table->index('status');
            $table->index(['check_in', 'check_out']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};