<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique()->index();
            $table->string('nama_barang');
            $table->string('satuan_utama');
            $table->decimal('faktor_konversi', 10, 4)->default(1);
            $table->decimal('stok_awal', 15, 2)->default(0);
            $table->decimal('stok_sekarang', 15, 2)->default(0);
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};