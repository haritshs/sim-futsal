<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bracket extends Model
{
    protected $fillable = ['teams', 'results'];
    protected $primaryKey = 'id';
}
