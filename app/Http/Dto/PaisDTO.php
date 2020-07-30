<?php
namespace App\Http\Dto;
use App\Pais;

class PaisDTO
{
    public function __construct()  {;
    }
    public function obterPais($pais_id){
        $pais = new Pais();
        $pais =  $pais->find($pais_id);
        $dto =[
            'id'        => $pais->id,
            'nome'      => $pais->nome,
            'codigo'    => $pais->codigo,
            'sigla'     =>  $pais->sigla 
        ];
        return $dto;
    }
}