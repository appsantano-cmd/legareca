<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('screenings', function (Blueprint $table) {
            $table->id();
            
            // Data Pemilik
            $table->string('owner_name');
            $table->integer('pet_count');
            
            // Kontak - digabung menjadi satu field
            $table->string('phone_number'); // format: +6281234567890
            
            // timestamps
            $table->timestamps();
            
            // Index untuk pencarian
            $table->index('owner_name');
            $table->index('phone_number');
        });

        Schema::create('screening_pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('screening_id')->constrained()->onDelete('cascade');
            
            // Data Dasar Anabul
            $table->string('name');
            $table->string('breed');
            $table->enum('sex', ['Jantan', 'Betina']);
            $table->string('age');
            
            // Hasil Screening untuk anabul ini
            $table->enum('vaksin', ['Belum', 'Belum lengkap', 'Sudah lengkap']);
            $table->enum('kutu', ['Negatif', 'Positif', 'Positif 2', 'Positif 3']);
            $table->enum('jamur', ['Negatif', 'Positif', 'Positif 2', 'Positif 3']);
            $table->enum('birahi', ['Negatif', 'Positif']);
            $table->enum('kulit', ['Negatif', 'Positif', 'Positif 2', 'Positif 3']);
            $table->enum('telinga', ['Negatif', 'Positif', 'Positif 2', 'Positif 3']);
            $table->enum('riwayat', ['Sehat', 'Pasca terapi', 'Sedang terapi']);
            
            $table->timestamps();
            
            // Index
            $table->index('screening_id');
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screening_pets');
        Schema::dropIfExists('screenings');
    }
};