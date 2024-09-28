<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_pelanggarans', function (Blueprint $table) {
            $table->id('id_mp');
            $table->string('nama');
            $table->integer('level'); // Bobot pelanggaran
            $table->string('denda')->nullable();
            $table->string('hukuman')->nullable();
            $table->string('larangan')->nullable(); // Added Larangan column
            $table->integer('max'); // Batasan sebelum naik level ke pelanggaran berat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_pelanggarans');
    }
};
