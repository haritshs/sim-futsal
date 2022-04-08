<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LawanSparing extends Model
{
    //protected $table = 'lawan_sparings';
    protected $fillable = ['tim_id', 'pesan', 'hadiah_pemenang', 'bukti_transfer', 'nama_pengirim', 'sparing_id'];
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tim()
    {
        return $this->belongsTo('App\Tim');
    }

    public function sparing()
    {
        return $this->belongsTo('App\Sparing');
    }

}
