<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendaftaranTurnamen extends Model
{
    protected $fillable = ['tim_id', 'user_id', 'turnamen_id', 'status'];
    protected $table = 'pendaftaran_turnamens';

    public function turnamen(){
        return $this->belongsTo('App\Turnamen');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tim()
    {
        return $this->belongsTo('App\Tim');
    }
}
