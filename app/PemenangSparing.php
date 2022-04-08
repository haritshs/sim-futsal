<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PemenangSparing extends Model
{
    protected $fillable = ['tim_id', 'pesan', 'hadiah_pemenang', 'bukti_transfer', 'nama_pengirim', 'sparing_id'];
    protected $table = 'pemenang_sparings';

    public function sparing()
    {
        return $this->belongsTo('App\Sparing');
    }

    public function tim()
    {
        return $this->belongsTo('App\Tim');
    }

    public function getFoto()
    {
        if(!$this->bukti_transfer){
            return asset('template/images/default-photo.jpg');
        }
        return asset('template/images/pemenang/'.$this->bukti_transfer);
    }
}
