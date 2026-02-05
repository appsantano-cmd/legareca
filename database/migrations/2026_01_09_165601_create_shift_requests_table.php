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
            $table->string('jam_shift_asli');

            // STEP 4 – Shift Tujuan
            $table->date('tanggal_shift_tujuan');
            $table->string('jam_shift_tujuan');

            // STEP 5 – Alasan
            $table->text('alasan');

            // STEP 6 – Pengganti
            $table->enum('sudah_pengganti', ['ya', 'belum']);
            $table->string('nama_karyawan_pengganti')->nullable();
            $table->date('tanggal_shift_pengganti')->nullable();
            $table->string('jam_shift_pengganti')->nullable();

            // Status Proses
            $table->string('status')->default('pending');

            // Kolom untuk user relationship dan tracking
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('user_email')->nullable();

            // Kolom untuk approval/admin
            $table->text('catatan_admin')->nullable();
            $table->string('disetujui_oleh')->nullable();
            $table->timestamp('tanggal_persetujuan')->nullable();

            $table->timestamps();
            
            // Index untuk pencarian yang lebih cepat
            $table->index('status');
            $table->index('user_id');
            $table->index('created_at');
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