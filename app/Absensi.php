<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = ['karyawan_id', 'bulan', 'tahun', 'jml_hadir', 'jml_alfa', 'jml_izin', 'jml_sakit', 'jml_lembur'];
    protected $primaryKey = 'id';
}
