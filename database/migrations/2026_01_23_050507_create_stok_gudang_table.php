<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('stok_gudang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->string('satuan');
            $table->string('departemen');
            $table->string('supplier');
            $table->decimal('stok_awal', 15, 2)->default(0);
            $table->decimal('stok_masuk', 15, 2)->default(0);
            $table->decimal('stok_keluar', 15, 2)->default(0);
            $table->decimal('stok_akhir', 15, 2)->default(0);
            $table->integer('bulan');
            $table->integer('tahun');
            $table->dateTime('tanggal_submit');
            $table->boolean('is_rollover')->default(false);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // BUAT INDEX COMPOSITE UNIK: kode_barang + bulan + tahun
            $table->unique(['kode_barang', 'bulan', 'tahun']);

            $table->index(['bulan', 'tahun']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('stok_gudang');
    }
};