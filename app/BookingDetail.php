<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    protected $table = 'detail_bookings';
    //protected $fillable = ['booking_id', 'lapangan_id', 'jam_awal', 'jam_akhir', 'tanggal_main'];
    //protected $primaryKey = 'id';

    public function lapangan(){
      return $this->belongsTo('App\Lapangan');
    }

    public function booking(){
      return $this->belongsTo('App\Booking');
    }
}
