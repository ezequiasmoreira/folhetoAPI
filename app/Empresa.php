<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable=[
        'id',
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'cpf',
        'tipo',
        'logo',
        'endereco_id', 
        'usuario_id'          
    ];
    protected $table = 'empresas';
}
