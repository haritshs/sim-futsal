<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sparings', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tgl_main');
            $table->integer('total_hadiah')->nullable();
            $table->enum('status',['tunggu','terima','tolak']);
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('tim_id');
            $table->foreign('tim_id')->references('id')->on('tims');
            //$table->unsignedInteger('booking_id');
            //$table->foreign('booking_id')->references('id')->on('bookings');
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
        Schema::dropIfExists('sparings');
    }
}
