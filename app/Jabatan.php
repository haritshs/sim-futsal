<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $fillable = ['jabatan', 'gaji_pokok', 'insentif'];
    protected $primaryKey = 'id';

    public function karyawan()
    {
        return $this->hasMany('App\Karyawan');
    }
}
