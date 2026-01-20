<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenueBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('venue_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan');
            $table->string('nomer_wa', 15); // batasi panjang untuk nomor telepon
            $table->string('email');
            $table->string('venue');
            $table->string('jenis_acara');
            $table->date('tanggal_acara')->nullable(); // BISA NULL untuk durasi hari/minggu/bulan
            $table->string('hari_acara')->nullable(); // BISA NULL untuk durasi hari/minggu/bulan
            $table->integer('tahun_acara')->nullable(); // BISA NULL untuk durasi hari/minggu/bulan
            $table->string('jam_acara', 5)->nullable(); // format "HH:mm", BISA NULL untuk durasi hari
            $table->string('durasi_type'); // jam, hari, minggu, bulan
            
            // Durasi fields berdasarkan type
            $table->float('durasi_jam')->nullable(); // untuk durasi type "jam"
            $table->integer('durasi_hari')->nullable(); // untuk durasi type "hari"
            $table->integer('durasi_minggu')->nullable(); // untuk durasi type "minggu"
            $table->integer('durasi_bulan')->nullable(); // untuk durasi type "bulan"
            
            // Tanggal dan waktu untuk durasi yang spesifik
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('jam_mulai', 5)->nullable(); // format "HH:mm"
            $table->string('jam_selesai', 5)->nullable(); // format "HH:mm"
            
            $table->integer('perkiraan_peserta');
            $table->string('status')->default('pending');
            $table->string('booking_code')->unique();
            $table->timestamp('booking_date')->useCurrent(); // otomatis isi timestamp sekarang
            $table->timestamps();
            
            // Optional: tambahkan indexes untuk performa
            $table->index('booking_code');
            $table->index('status');
            $table->index('venue');
            $table->index('tanggal_acara');
        });
    }

    public function down()
    {
        Schema::dropIfExists('venue_bookings');
    }
}