<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            // Tambah kolom user_name dan role_name
            $table->string('user_name')->nullable();
            $table->string('role_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            // Hapus kolom user_name dan role_name
            $table->dropColumn('user_name');
            $table->dropColumn('role_name');
        });
    }
}
