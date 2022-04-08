<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'jenis', 'harga_sewa', 'foto'];
    protected $primaryKey = 'id';
    //protected $table = 'lapangans';

    public function getFoto()
    {
        if(!$this->foto){
            return asset('template/images/default-photo.jpg');
        }
        return asset('template/images/lapangan/'.$this->foto);
    }
}
