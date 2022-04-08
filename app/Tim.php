<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    protected $fillable = ['nama_team', 'nama_kapten', 'deskripsi', 'domisili', 'logo', 'user_id'];
    protected $table = 'tims';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function sparing()
    {
        return $this->hasMany('App\Sparing');
    }

    public function pemenang()
    {
        return $this->hasMany('App\PemenangSparing');
    }

    public function turnamen()
    {
        return $this->hasMany('App\PendaftaranTurnamen');
    }
}
