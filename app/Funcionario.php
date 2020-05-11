<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable=[
        'id',        
        'usuario_id',
        'empresa_id',
        'endereco_id',
        
    ];
    protected $table = 'funcionarios';
}
