<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $fillable=[
        'id',
        'nome',
        'codigo',
        'estado_id'
    ];
    protected $table = 'cidades';

    public function estado(){
        return $this->belongsTo(Estado::class);
    }
}
