<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['kode', 'tipe', 'nominal_diskon'];
    protected $primaryKey = 'id';

    public static function cariKode($kode)
    {
        return self::where('kode', $kode)->first();
    }

    public function diskon($total)
    {
        
        if($this->tipe == 'nominal')
        {
            return $this->nominal_diskon;
        }
        else if($this->tipe == 'persen')
        {   
            return ($this->nominal_diskon / 100) * $total;
        }
        else {
            return 0;
        }
    }
}
