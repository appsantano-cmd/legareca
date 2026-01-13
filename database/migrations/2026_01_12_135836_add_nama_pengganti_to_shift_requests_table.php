<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shift_requests', function (Blueprint $table) {
            $table->string('nama_karyawan_pengganti')
                  ->nullable()
                  ->after('sudah_pengganti');
        });
    }

    public function down(): void
    {
        Schema::table('shift_requests', function (Blueprint $table) {
            $table->dropColumn('nama_karyawan_pengganti');
        });
    }
};
