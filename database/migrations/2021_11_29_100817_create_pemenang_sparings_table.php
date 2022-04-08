<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemenangSparingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemenang_sparings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tim_id');
            $table->foreign('tim_id')->references('id')->on('tims');
            $table->string('pesan')->nullable();
            $table->enum('hadiah_pemenang',['cash','transfer']);
            $table->string('bukti_transfer')->nullable();
            $table->string('nama_pengirim')->nullable();
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
        Schema::dropIfExists('pemenang_sparings');
    }
}
