<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $fillable = ['keterangan', 'tanggal', 'karyawan_id'];
    protected $primaryKey = 'id';

    protected $dates = ['tanggal'];

    public function karyawan()
    {
        return $this->belongsTo('App\Karyawan');
    }
}
