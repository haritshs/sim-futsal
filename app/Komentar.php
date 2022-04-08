<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $fillable = ['isi', 'pertanyaan_id', 'user_id'];
    protected $table = 'komentars';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function pertanyaan()
    {
        return $this->belongsTo('App\Pertanyaan');
    }
}
