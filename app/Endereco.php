<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable=[
        'id',
        'rua',
        'numero',
        'bairro',
        'complemento',
        'cep',
        //fk
        'cidade_id'
    ];
    protected $table = 'enderecos';
}
