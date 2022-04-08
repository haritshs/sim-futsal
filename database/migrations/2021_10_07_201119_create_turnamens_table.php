<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurnamensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnamens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('judul');
            $table->longText('deskripsi');
            $table->integer('slot_tim');
            $table->integer('total_hadiah');
            $table->integer('biaya_daftar');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('foto_logo', 255);
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
        Schema::dropIfExists('turnamens');
    }
}
