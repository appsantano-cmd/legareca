<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('venue_bookings', function (Blueprint $table) {
            $table->id();

            $table->string('nama_pemesan');
            $table->string('nomer_wa');
            $table->string('email');

            $table->string('venue');
            $table->string('jenis_acara');

            $table->date('tanggal_acara');
            $table->string('hari_acara')->nullable();
            $table->year('tahun_acara')->nullable();
            $table->time('jam_acara');

            $table->enum('durasi_type', ['jam', 'hari', 'minggu', 'bulan']);

            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();

            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->integer('durasi_jam')->nullable();
            $table->integer('durasi_hari')->nullable();
            $table->integer('durasi_minggu')->nullable();
            $table->integer('durasi_bulan')->nullable();

            $table->integer('perkiraan_peserta');

            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venue_bookings');
    }
};
