<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bulan');
            $table->string('tahun');
            $table->integer('jml_hadir');
            $table->integer('jml_alfa');
            $table->integer('jml_izin');
            $table->integer('jml_sakit');
            $table->integer('jml_lembur');
            $table->unsignedInteger('karyawan_id');
            $table->foreign('karyawan_id')->references('id')->on('karyawans');

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
        Schema::dropIfExists('absensis');
    }
}
