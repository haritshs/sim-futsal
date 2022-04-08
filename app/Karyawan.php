<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $fillable = ['nama', 'telepon', 'alamat', 'jenkel', 'foto_profil', 'foto_ktp', 'jabatan_id', 'shift_id'];
    protected $primaryKey = 'id';

    public function getFotoProfil()
    {
        if(!$this->foto){
            return asset('front/images/default.jpg');
        }
        return asset('front/images/'.$this->foto);
    }

    public function jabatan()
    {
        return $this->belongsTo('App\Jabatan');
    }

    public function shift()
    {
        return $this->belongsTo('App\Shift');
    }

    public function kehadiran()
    {
        return $this->hasOne('App\Kehadiran');
    }
}
