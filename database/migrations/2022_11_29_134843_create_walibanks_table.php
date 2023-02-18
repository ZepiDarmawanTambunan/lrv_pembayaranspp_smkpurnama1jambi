<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wali_banks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wali_id')->comment('wali id adalah primary key di user id');
            $table->string('kode');
            $table->string('nama_bank');
            $table->string('nama_rekening');
            $table->string('nomor_rekening');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('walibanks');
    }
};
