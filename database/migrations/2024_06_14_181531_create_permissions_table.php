<?php
// database/migrations/2024_06_15_000000_create_permissions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_santri');
            $table->string('reason');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->enum('status', ['Belum Kembali', 'Telat', 'Tepat Waktu'])->default('Belum Kembali');
            $table->timestamps();

            $table->foreign('id_santri')->references('id_santri')->on('santris')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
