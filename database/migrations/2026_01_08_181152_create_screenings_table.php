<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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

            // Status
            $table->string('status')->default('completed');
        });

        Schema::create('screening_pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('screening_id')->constrained()->onDelete('cascade');

            // Data Dasar Anabul
            $table->string('name');
            $table->string('breed');
            $table->enum('sex', ['Jantan', 'Betina', 'Tidak diketahui']);
            $table->string('age');

            // Hasil Screening untuk anabul ini
            $table->enum('vaksin', ['Belum', 'Belum lengkap', 'Sudah lengkap', '-', 'Tidak diketahui']);
            $table->enum('kutu', ['Negatif', 'Positif', 'Positif 2', 'Positif 3', '-', 'Tidak diketahui']);
            $table->string('kutu_action')->nullable();
            $table->enum('jamur', ['Negatif', 'Positif', 'Positif 2', 'Positif 3', '-', 'Tidak diketahui']);
            $table->enum('birahi', ['Negatif', 'Positif', '-', 'Tidak diketahui']);
            $table->string('birahi_action')->nullable();
            $table->enum('kulit', ['Negatif', 'Positif', 'Positif 2', 'Positif 3', '-', 'Tidak diketahui']);
            $table->enum('telinga', ['Negatif', 'Positif', 'Positif 2', 'Positif 3', '-', 'Tidak diketahui']);
            $table->enum('riwayat', ['Sehat', 'Pasca terapi', 'Sedang terapi', '-', 'Tidak diketahui']);
            $table->string('status')->default('completed');

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