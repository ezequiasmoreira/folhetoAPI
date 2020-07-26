<?php
namespace App\Http\Repository;
use App\Empresa;

class EmpresaRepository
{
    private $empresa;
    public function __construct()  {   
       $this->empresa = new Empresa();   
    }
    public function obterEmpresaPorEndereco($endereco){
        return  Empresa::where('endereco_id',$endereco->id)->first();
    }
    public function obterEmpresaPorUsuario($usuario){
        return  Empresa::where('usuario_id',$usuario->id)->first();
    }
    public function obterPorId($id){
        return $this->empresa->find($id);
    }
   
}