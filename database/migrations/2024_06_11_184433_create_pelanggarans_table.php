<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelanggaransTable extends Migration
{
    public function up()
    {
        Schema::create('pelanggarans', function (Blueprint $table) {
            $table->id('id_pelanggaran');
            // $table->string('nama_santri');
            // $table->string('kelas');
            // $table->string('nama_pelanggaran');
            // $table->integer('level');
            $table->string('jenis')->nullable();
            $table->date('tanggal');
            $table->string('foto')->nullable();

            $table->unsignedBigInteger('id_santri');
            $table->unsignedBigInteger('id_mp')->nullable();

            $table->timestamps();

            $table->foreign('id_santri')->references('id_santri')->on('santris')->onDelete('cascade');
            $table->foreign('id_mp')->references('id_mp')->on('master_pelanggarans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelanggarans');
    }
}
