<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stok_stations_master_kitchen', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('kode_bahan')->unique();
            $table->string('nama_bahan');
            $table->string('nama_satuan');
            $table->decimal('stok_awal', 10, 2);
            $table->decimal('stok_minimum', 10, 2);
            $table->enum('status_stok', ['SAFE', 'REORDER'])->default('SAFE');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stok_stations_master_kitchen');
    }
};