<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    //protected $fillable = ['user_id', 'total_harga', 'status', 'pesan_batal', 'bukti_transfer', 'nama_pengirim'];
    //protected $primaryKey = 'id';

    public function detail()
    {
        return $this->hasMany('App\BookingDetail');
    }

    public function sparing()
    {
        return $this->hasMany('App\Sparing');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
