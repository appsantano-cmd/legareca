<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daily_cleaning_reports', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->json('departments');
            $table->text('work_completed')->nullable();
            $table->dateTime('membership_datetime')->nullable();
            $table->string('toilet_photo_path')->nullable();
            $table->string('status')->default('step1');
            $table->date('report_date')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_cleaning_reports');
    }
};