<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stok_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stok_gudang_id')->constrained('stok_gudang')->onDelete('cascade');
            $table->enum('tipe', ['masuk', 'keluar']);
            
            // Data umum
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->decimal('jumlah', 15, 2);
            $table->string('satuan');
            $table->date('tanggal');
            
            // Field khusus stok masuk
            $table->string('supplier')->nullable();
            
            // Field khusus stok keluar
            $table->string('departemen')->nullable();
            $table->string('keperluan')->nullable();
            
            // Field umum untuk kedua tipe
            $table->string('nama_penerima');
            $table->text('keterangan')->nullable();
            
            // Info sistem
            $table->timestamps();
            
            $table->index(['tanggal', 'tipe']);
            $table->index(['kode_barang', 'tanggal']);
            $table->index('supplier');
            $table->index('departemen');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stok_transactions');
    }
};