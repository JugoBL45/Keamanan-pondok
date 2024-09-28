<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSantrisTable extends Migration
{
    public function up()
    {
        Schema::create('santris', function (Blueprint $table) {
            $table->id('id_santri');
            $table->string('nis');
            $table->string('nama');
            $table->unsignedBigInteger('kelas_id')->nullable(); // Change this line
            $table->string('alamat');
            $table->string('walisantri');
            $table->string('no_wali');
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('kelas_id')->references('id')->on('kelas'); // Add this line
        });
    }

    public function down()
    {
        Schema::dropIfExists('santris');
    }
}
