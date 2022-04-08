<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('booking_id');
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->unsignedInteger('lapangan_id');
            $table->foreign('lapangan_id')->references('id')->on('lapangans');
            $table->unsignedInteger('jam_awal');
            $table->unsignedInteger('jam_akhir');
            $table->date('tanggal_main');

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
        Schema::dropIfExists('detail_bookings');
    }
}
