<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sparing extends Model
{
    protected $fillable = ['tgl_main', 'total_hadiah', 'status', 'user_id', 'tim_id', 'booking_id'];
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tim()
    {
        return $this->belongsTo('App\Tim');
    }

    public function lawan()
    {
        return $this->hasMany('App\LawanSparing');
    }

    public function pemenang()
    {
        return $this->hasMany('App\PemenangSparing');
    }

    public function booking()
    {
        return $this->belongsTo('App\Booking');
    }

}
