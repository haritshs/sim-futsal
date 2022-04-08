<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    protected $fillable = ['uang_lembur', 'uang_makan', 'uang_tunjangan', 'created_at', 'updated_at'];
    protected $table = 'pendapatans';
}
