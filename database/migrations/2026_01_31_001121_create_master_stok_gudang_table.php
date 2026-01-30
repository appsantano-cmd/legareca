<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('master_stok_gudang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->string('satuan');
            $table->string('departemen');
            $table->string('supplier');
            $table->decimal('stok_awal', 15, 2)->default(0);
            $table->date('tanggal_submit');
            $table->softDeletes();
            $table->timestamps();
            
            $table->index('kode_barang');
            $table->index('nama_barang');
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_stok_gudang');
    }
};