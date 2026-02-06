<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stok_kitchen', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('shift'); // 1 atau 2
            $table->string('kode_bahan'); // Ambil dari master
            $table->string('nama_bahan'); // Ubah dari master_bahan_id
            $table->string('nama_satuan'); // Ubah dari satuan_id
            $table->decimal('stok_awal', 10, 2);
            $table->decimal('stok_masuk', 10, 2)->default(0);
            $table->decimal('stok_keluar', 10, 2)->default(0);
            $table->decimal('waste', 10, 2)->default(0);
            $table->text('alasan_waste')->nullable();
            $table->decimal('stok_akhir', 10, 2)->virtualAs('stok_awal + stok_masuk - stok_keluar - waste');
            $table->enum('status_stok', ['SAFE', 'REORDER'])->default('SAFE'); // Tambah kolom status stok
            $table->string('pic');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stok_kitchen');
    }
};