<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stok_rollover_history', function (Blueprint $table) {
            $table->id();
            $table->integer('from_bulan');
            $table->integer('from_tahun');
            $table->integer('to_bulan');
            $table->integer('to_tahun');
            $table->integer('total_barang');
            $table->decimal('total_nilai', 20, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->index(['from_bulan', 'from_tahun']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('stok_rollover_history');
    }
};