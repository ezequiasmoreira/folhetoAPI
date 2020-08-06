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

    public function funcionarios(){
        return $this->hasMany(Funcionario::class);
    }
    public function usuario(){
        return $this->belongsTo(User::class);
    }
    public function endereco(){
        return $this->belongsTo(Endereco::class);
    }
}
