<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimIdToPendaftaranTurnamensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_turnamens', function (Blueprint $table) {
            $table->unsignedInteger('tim_id');
            $table->foreign('tim_id')->references('id')->on('tims');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftaran_turnamens', function (Blueprint $table) {
            $table->dropColumn('tim_id');
        });
    }
}
