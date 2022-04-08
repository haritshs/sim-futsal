<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $fillable = ['judul', 'isi', 'user_id'];
    protected $table = 'pertanyaans';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function komentar()
    {
        return $this->hasMany('App\Komentar');
    }
}
