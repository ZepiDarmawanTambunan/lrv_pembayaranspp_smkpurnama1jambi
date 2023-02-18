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
        Schema::create('bank_sekolahs', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('bank_sekolahs');
    }
};
