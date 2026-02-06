<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('satuan_stations', function (Blueprint $table) {
            $table->id();
            $table->string('nama_satuan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('satuan_stations');
    }
};