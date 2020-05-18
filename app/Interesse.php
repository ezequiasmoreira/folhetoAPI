<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interesse extends Model
{
    protected $fillable=[
        'id',
        'codigo',
        'decricao',
        'status',
        'usuario_id'
    ];
    protected $table = 'interesses';
}
