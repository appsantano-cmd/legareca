<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_keluar');
            $table->enum('department', ['Bar', 'Kitchen', 'Pastry', 'Server', 'Marcom', 'Cleaning Staff']);
            $table->foreignId('barang_id')->constrained('barang')->onDelete('restrict');
            $table->decimal('jumlah_keluar', 10, 5);
            $table->foreignId('satuan_id')->constrained('satuans')->onDelete('restrict');
            $table->text('keperluan');
            $table->string('nama_penerima');
            $table->timestamps();
            $table->softDeletes();
            
            // Index untuk pencarian cepat
            $table->index(['tanggal_keluar', 'department']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_keluar');
    }
};