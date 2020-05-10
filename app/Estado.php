<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $fillable=[
        'id',
        'nome',
        'codigo',
        'sigla',
        'pais_id'
    ];
    protected $table = 'estados';
}
