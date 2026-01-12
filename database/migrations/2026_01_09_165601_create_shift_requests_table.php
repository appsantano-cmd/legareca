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
        Schema::create('shift_requests', function (Blueprint $table) {
            $table->id();

            // STEP 1 – Data Karyawan
            $table->string('nama_karyawan');
            
            // STEP 2 – Divisi & Jabatan
            $table->string('divisi_jabatan');

            // STEP 3 – Shift Asli
            $table->date('tanggal_shift_asli');
            $table->time('jam_shift_asli');

            // STEP 3 – Shift Tujuan
            $table->date('tanggal_shift_tujuan');
            $table->time('jam_shift_tujuan');

            // STEP 4 – Alasan
            $table->text('alasan');

            // STEP 5 – Pengganti
            $table->enum('sudah_pengganti', ['ya', 'belum']);
            $table->date('tanggal_shift_pengganti')->nullable();
            $table->time('jam_shift_pengganti')->nullable();

            // Status Proses
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_requests');
    }
};
