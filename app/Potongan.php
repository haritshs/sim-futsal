<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Potongan extends Model
{
    protected $fillable = ['p_alfa', 'p_izin', 'p_sakit', 'p_cuti', 'created_at', 'updated_at'];
    protected $table = 'potongans';
}
