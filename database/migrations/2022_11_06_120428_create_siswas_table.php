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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->integer('wali_id')->nullable()->index();
            $table->string('wali_status')->nullable();
            $table->string('nama', 255);
            $table->string('nisn', 20)->unique();
            $table->string('jurusan', 20);
            $table->string('kelas', 3);
            $table->integer('angkatan');
            $table->foreignId('user_id');
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
        Schema::dropIfExists('siswas');
    }
};
