<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = ['nama_shift', 'jam_masuk', 'jam_keluar'];
    protected $primaryKey = 'id';

    public function karyawan()
    {
        return $this->hasMany('App\Karyawan');
    }
}
