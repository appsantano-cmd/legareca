<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_masuk');
            $table->string('supplier');
            $table->string('nama_barang');
            $table->integer('jumlah_masuk');
            $table->string('satuan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Index untuk pencarian
            $table->index('tanggal_masuk');
            $table->index('supplier');
            $table->index('nama_barang');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_masuk');
    }
};