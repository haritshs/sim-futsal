<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turnamen extends Model
{
    protected $fillable = ['judul', 'deskripsi', 'slot_tim', 'total_hadiah', 'biaya_daftar', 'tanggal_mulai', 'tanggal_selesai', 'foto_logo', 'link_bracket'];
    protected $table = 'turnamens';

    public function pendaftaran()
    {
        return $this->hasMany('App\PendaftaranTurnamen');
    }

    public function getFoto()
    {
        if(!$this->foto_logo){
            return asset('template/images/default-photo.jpg');
        }
        return asset('template/images/turnamen/'.$this->foto_logo);
    }
}
