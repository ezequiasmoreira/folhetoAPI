<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $fillable=[
        'id',
        'nome',
        'codigo',
        'sigla'
    ];
    protected $table = 'pais';
}
